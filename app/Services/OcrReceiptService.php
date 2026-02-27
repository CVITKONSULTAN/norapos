<?php

namespace App\Services;

use App\Ingredient;
use App\IngredientAlias;
use Illuminate\Support\Facades\Log;

class OcrReceiptService
{
    /**
     * Process uploaded file (PDF or image) and extract purchase data
     */
    public function processFile($filePath, $businessId)
    {
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $pageTexts = ($ext === 'pdf')
            ? $this->ocrPdf($filePath)
            : [$this->ocrImage($filePath)];

        $parsed = $this->parseReceipt($pageTexts);

        // Match parsed items to existing ingredients in DB
        $parsed['items'] = $this->matchIngredients($parsed['items'], $businessId);

        return $parsed;
    }

    /**
     * Convert PDF pages to images and OCR each page
     */
    private function ocrPdf($pdfPath)
    {
        $tempDir = storage_path('app/ocr_temp/' . uniqid('pdf_'));
        if (!@mkdir($tempDir, 0777, true) && !is_dir($tempDir)) {
            Log::error('OCR: Cannot create temp dir: ' . $tempDir);
            return [''];
        }
        chmod($tempDir, 0777);

        $cmd = "pdftoppm -png -r 300 " . escapeshellarg($pdfPath) . " " . escapeshellarg($tempDir . '/page') . " 2>&1";
        $output = [];
        $returnCode = 0;
        exec($cmd, $output, $returnCode);

        if ($returnCode !== 0) {
            Log::error('OCR pdftoppm failed: code=' . $returnCode . ' output=' . implode(' ', $output));
        }

        $pages = glob($tempDir . '/page-*.png');
        if (empty($pages)) {
            // Try alternate naming pattern (some versions use page-01 etc.)
            $pages = glob($tempDir . '/page*.png');
        }
        sort($pages);

        Log::info('OCR: Found ' . count($pages) . ' pages in ' . $tempDir);

        $texts = [];
        foreach ($pages as $page) {
            $outBase = $page . '_ocr';
            $tCmd = "tesseract " . escapeshellarg($page) . " " . escapeshellarg($outBase) . " -l ind+eng --psm 6 2>&1";
            $tOutput = [];
            $tCode = 0;
            exec($tCmd, $tOutput, $tCode);

            if ($tCode !== 0) {
                Log::error('OCR tesseract failed: code=' . $tCode . ' output=' . implode(' ', $tOutput));
            }

            $textFile = $outBase . '.txt';
            if (file_exists($textFile)) {
                $content = file_get_contents($textFile);
                Log::info('OCR page text length: ' . strlen($content));
                $texts[] = $content;
            } else {
                Log::error('OCR: text file not found: ' . $textFile);
                $texts[] = '';
            }
        }

        // Cleanup
        $files = glob($tempDir . '/*');
        if ($files) {
            array_map('unlink', $files);
        }
        @rmdir($tempDir);

        return $texts;
    }

    /**
     * OCR a single image file
     */
    private function ocrImage($imagePath)
    {
        $tempDir = storage_path('app/ocr_temp/' . uniqid('img_'));
        @mkdir($tempDir, 0755, true);

        $outBase = $tempDir . '/result';
        exec("tesseract " . escapeshellarg($imagePath) . " " . escapeshellarg($outBase) . " -l ind+eng --psm 6 2>&1");

        $textFile = $outBase . '.txt';
        $text = file_exists($textFile) ? file_get_contents($textFile) : '';

        $files = glob($tempDir . '/*');
        if ($files) {
            array_map('unlink', $files);
        }
        @rmdir($tempDir);

        return $text;
    }

    /**
     * Parse receipt text from one or more OCR pages
     */
    private function parseReceipt($pageTexts)
    {
        $fullText = implode("\n", $pageTexts);

        $result = [
            'supplier_name' => '',
            'date' => null,
            'ref_no' => '',
            'payment_status' => 'unpaid',
            'total' => 0,
            'items' => [],
            'raw_text' => $fullText,
        ];

        // --- Detect supplier ---
        if (stripos($fullText, 'INDOGROSIR') !== false) {
            $result['supplier_name'] = 'INDOGROSIR';
        }

        // --- Extract date (DD/MM/YYYY or DD-MM-YY format) ---
        if (preg_match('/(\d{2})[\/\-](\d{2})[\/\-](\d{2,4})\s+\d{2}:\d{2}/', $fullText, $m)) {
            $day = $m[1];
            $month = $m[2];
            $year = strlen($m[3]) == 2 ? '20' . $m[3] : $m[3];
            $result['date'] = $year . '-' . $month . '-' . $day;
        }

        // --- Extract ref number ---
        if (preg_match('/No\.\s*(S\d+)/i', $fullText, $m)) {
            $result['ref_no'] = $m[1];
        } elseif (preg_match('/Struk\s*:\s*[\d\/]+\s*[\-]\s*([\d.]+)/i', $fullText, $m)) {
            $result['ref_no'] = $m[1];
        }

        // --- Payment method ---
        if (preg_match('/PEMBAYARAN\s+(KREDIT|TUNAI|CASH|TRANSFER)/i', $fullText, $m)) {
            $result['payment_status'] = (strtoupper($m[1]) === 'KREDIT') ? 'unpaid' : 'paid';
        }

        // --- Total amount ---
        if (preg_match('/TOTAL\s+BELANJA[^0-9]*([\d.,]+)/i', $fullText, $m)) {
            $result['total'] = $this->parseNumber($m[1]);
        }

        // --- Parse items from each page ---
        $strukItems = $this->parseStruk($pageTexts[0] ?? '');
        $tandaTerimaItems = (count($pageTexts) > 1) ? $this->parseTandaTerima($pageTexts[1]) : [];

        Log::info('OCR Parse: struk_items=' . count($strukItems) . ', tanda_terima_items=' . count($tandaTerimaItems));
        if (empty($strukItems)) {
            Log::info('OCR Page1 text: ' . substr($pageTexts[0] ?? '', 0, 500));
        }
        if (count($pageTexts) > 1 && empty($tandaTerimaItems)) {
            Log::info('OCR Page2 text: ' . substr($pageTexts[1] ?? '', 0, 500));
        }

        // Merge: prefer tanda terima names (cleaner), add prices from struk
        if (!empty($tandaTerimaItems) && !empty($strukItems)) {
            foreach ($tandaTerimaItems as &$ttItem) {
                foreach ($strukItems as $sItem) {
                    if ($this->itemsMatch($ttItem, $sItem)) {
                        $ttItem['unit_price'] = $sItem['unit_price'];
                        $ttItem['total_price'] = $sItem['total_price'];
                        if (empty($ttItem['quantity']) && !empty($sItem['quantity'])) {
                            $ttItem['quantity'] = $sItem['quantity'];
                        }
                        break;
                    }
                }
            }
            unset($ttItem);
            $result['items'] = $tandaTerimaItems;
        } elseif (!empty($tandaTerimaItems)) {
            $result['items'] = $tandaTerimaItems;
        } else {
            $result['items'] = $strukItems;
        }

        return $result;
    }

    /**
     * Parse tanda terima / delivery note (page 2) — cleaner table format
     * Row pattern: NO  ITEM_NAME  PLU  UNIT/n  QTY  AMBIL  SISA
     * Example: "1 BIMOLI MINYAK GORENG (REFILL) PCH 2000mL 0346281 PCS/1 4 0"
     */
    private function parseTandaTerima($text)
    {
        $items = [];
        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            $line = trim($line);

            // Match numbered rows with PLU (6-8 digit code)
            if (preg_match('/^(\d{1,3})\s+(.+?)\s+(\d{6,8})\s+\S+\/\d+\s+(\d+)\s+\d+/', $line, $m)) {
                $name = trim($m[2]);

                // Remove trailing unit specs like "PCH 2000mL", "PCS", "KG" etc.
                $name = preg_replace('/\s+(PCH|PCS|BTL|KLG|DUS|SAK|KG|GR|ML|LTR|BOX|CTN|LSN|PACK|SET|ROLL|GAL)\s+\d+\s*(mL|ML|G|g|KG|kg|L|l|GR|gr)?\s*$/i', '', $name);
                $name = preg_replace('/\s+(PCH|PCS|BTL|KLG|DUS|SAK|KG|GR|ML|LTR|BOX|CTN|LSN|PACK|SET|ROLL|GAL)\s*$/i', '', $name);

                $items[] = [
                    'name' => $name,
                    'plu' => $m[3],
                    'quantity' => intval($m[4]),
                    'unit_price' => 0,
                    'total_price' => 0,
                ];
            }
        }

        return $items;
    }

    /**
     * Parse struk / receipt (page 1) — has prices but noisier OCR
     * Pattern per item:
     *   Line 1: ITEM NAME (PLU_CODE)
     *   Line 2: QTY  UNIT_PRICE  TOTAL  (with OCR noise)
     *   Optional: Potongan lines (discounts)
     */
    private function parseStruk($text)
    {
        $items = [];
        $lines = explode("\n", $text);

        $inItems = false;
        $currentItem = null;

        foreach ($lines as $line) {
            $line = trim($line);

            // Detect start of items section
            if (preg_match('/NAMA\s+BARANG/i', $line) || preg_match('/H[\.\s]*SATUAN/i', $line)) {
                $inItems = true;
                continue;
            }

            // Detect end of items section
            if ($inItems && preg_match('/TOTAL\s+BELANJA/i', $line)) {
                if ($currentItem && $currentItem['quantity'] > 0) {
                    $items[] = $currentItem;
                }
                break;
            }

            if (!$inItems) continue;
            if (strlen($line) < 3) continue;

            // Skip discount / potongan lines
            if (preg_match('/potongan/i', $line)) continue;

            // Clean leading OCR noise (— / . etc.)
            $cleanLine = preg_replace('/^[\s\/\.\-—\|]+/', '', $line);
            if (strlen($cleanLine) < 3) continue;

            // Extract numbers from line for analysis
            $numbersOnly = preg_replace('/[^0-9,.\s]/', ' ', $line);
            $numbersOnly = preg_replace('/\s+/', ' ', trim($numbersOnly));

            $numbers = [];
            if (preg_match_all('/(\d[\d,.]*\d|\d+)/', $numbersOnly, $numMatches)) {
                foreach ($numMatches[1] as $num) {
                    $parsed = $this->parseNumber($num);
                    if ($parsed > 0) {
                        $numbers[] = $parsed;
                    }
                }
            }

            // PRICE LINE check: 3+ numbers where total ≈ qty × unit_price
            if (count($numbers) >= 3 && $currentItem) {
                $qty = $numbers[0];
                $price = $numbers[1];
                $total = $numbers[2];
                // Validate: qty should be reasonable, and total ≈ qty × price
                if ($qty > 0 && $qty < 10000 && $price > 0 && $total > 0
                    && abs($total - ($qty * $price)) <= $total * 0.15) {
                    $currentItem['quantity'] = $qty;
                    $currentItem['unit_price'] = $price;
                    $currentItem['total_price'] = $total;
                    $items[] = $currentItem;
                    $currentItem = null;
                    continue;
                }
            }

            // ITEM NAME LINE check: has 4+ uppercase letters
            $upperCount = preg_match_all('/[A-Z]/', $cleanLine);
            if ($upperCount >= 4) {
                // Save previous item if it had data
                if ($currentItem && $currentItem['quantity'] > 0) {
                    $items[] = $currentItem;
                }

                // Extract PLU code from parentheses
                $plu = null;
                $nameLine = $cleanLine;
                if (preg_match('/\((\d{6,8})\)/', $nameLine, $pluMatch)) {
                    $plu = $pluMatch[1];
                    $nameLine = str_replace($pluMatch[0], '', $nameLine);
                }

                // Clean the item name
                $name = preg_replace('/[^A-Za-z0-9\s.\-\/]/', ' ', $nameLine);
                $name = preg_replace('/\s+/', ' ', trim($name));

                if (strlen($name) >= 3) {
                    $currentItem = [
                        'name' => $name,
                        'plu' => $plu,
                        'quantity' => 0,
                        'unit_price' => 0,
                        'total_price' => 0,
                    ];
                }
            }
        }

        return $items;
    }

    /**
     * Match parsed items to existing ingredients in database.
     * Priority: 1) Exact alias match, 2) Fuzzy name similarity
     */
    private function matchIngredients($items, $businessId)
    {
        $ingredients = Ingredient::where('business_id', $businessId)
            ->where('is_active', true)
            ->get(['id', 'name']);

        foreach ($items as &$item) {
            $item['ocr_name'] = $item['name']; // Keep original OCR name

            // 1) Try exact alias match first (previous OCR names that were mapped)
            $alias = IngredientAlias::findByAlias($item['name'], $businessId);
            if ($alias && $alias->ingredient) {
                $item['ingredient_id'] = $alias->ingredient->id;
                $item['ingredient_name'] = $alias->ingredient->name;
                $item['match_score'] = 100;
                $item['match_type'] = 'alias';
                continue;
            }

            // 2) Fuzzy name similarity
            $bestMatch = null;
            $bestScore = 0;

            foreach ($ingredients as $ingredient) {
                $score = $this->calcSimilarity($item['name'], $ingredient->name);
                if ($score > $bestScore && $score >= 40) {
                    $bestScore = $score;
                    $bestMatch = $ingredient;
                }
            }

            $item['ingredient_id'] = $bestMatch ? $bestMatch->id : null;
            $item['ingredient_name'] = $bestMatch ? $bestMatch->name : null;
            $item['match_score'] = round($bestScore);
            $item['match_type'] = $bestMatch ? 'fuzzy' : 'none';
        }
        unset($item);

        return $items;
    }

    /**
     * Calculate similarity between an OCR item name and an ingredient name.
     * Uses both character-level similarity and word-level matching.
     */
    private function calcSimilarity($ocrName, $ingredientName)
    {
        $ocr = strtoupper(trim($ocrName));
        $ing = strtoupper(trim($ingredientName));

        // Character-level similarity
        similar_text($ocr, $ing, $charPercent);

        // Word-level matching
        $ocrWords = preg_split('/[\s\-\/\.]+/', $ocr);
        $ingWords = preg_split('/[\s\-\/\.]+/', $ing);

        $ocrWords = array_filter($ocrWords, fn($w) => strlen($w) >= 2);
        $ingWords = array_filter($ingWords, fn($w) => strlen($w) >= 2);

        $wordScore = 0;
        if (!empty($ingWords)) {
            $matchCount = 0;
            foreach ($ingWords as $ingWord) {
                foreach ($ocrWords as $ocrWord) {
                    // Check if one word contains the other (partial match)
                    if (strpos($ocrWord, $ingWord) !== false || strpos($ingWord, $ocrWord) !== false) {
                        $matchCount++;
                        break;
                    }
                }
            }
            $wordScore = ($matchCount / count($ingWords)) * 100;
        }

        return max($charPercent, $wordScore);
    }

    /**
     * Check if two items from different pages match (by PLU or name similarity)
     */
    private function itemsMatch($item1, $item2)
    {
        // Match by PLU code first
        if (!empty($item1['plu']) && !empty($item2['plu']) && $item1['plu'] === $item2['plu']) {
            return true;
        }

        // Fall back to name similarity
        return $this->calcSimilarity($item1['name'], $item2['name']) >= 50;
    }

    /**
     * Parse a number string by removing thousand separators (period/comma)
     * Indonesian receipts use period or comma as thousand separator, no decimals for Rupiah.
     */
    private function parseNumber($str)
    {
        $clean = preg_replace('/[^\d]/', '', $str);
        return floatval($clean);
    }
}
