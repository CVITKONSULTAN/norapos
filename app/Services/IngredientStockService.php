<?php

namespace App\Services;

use App\Ingredient;
use App\IngredientStock;
use App\IngredientStockLog;
use App\ProductRecipe;
use App\Transaction;
use App\User;
use App\Mail\IngredientStockAlertMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class IngredientStockService
{
    /**
     * Kurangi stok bahan berdasarkan sell lines dari transaksi.
     * Dipanggil setelah sell lines disimpan (store & update).
     */
    public function deductForTransaction(Transaction $transaction)
    {
        try {
            $transaction->load('sell_lines');
            $businessId = $transaction->business_id;
            $locationId = $transaction->location_id;
            $userId = auth()->id();

            // Hapus log lama untuk transaksi ini (supaya update/edit tidak dobel)
            IngredientStockLog::where('transaction_id', $transaction->id)
                ->where('ref_type', 'sale')
                ->delete();

            // Rebuild stok: hitung ulang dari recipe × qty sell line
            $alertIngredients = [];

            foreach ($transaction->sell_lines as $line) {
                // Skip modifier lines (child lines)
                if (!empty($line->parent_sell_line_id)) {
                    continue;
                }

                $recipes = ProductRecipe::where('product_id', $line->product_id)
                    ->where(function ($q) use ($line) {
                        $q->whereNull('variation_id')
                          ->orWhere('variation_id', $line->variation_id);
                    })
                    ->get();

                foreach ($recipes as $recipe) {
                    $qtyUsed = $recipe->qty_per_unit * $line->quantity;

                    // Update stok
                    $stock = IngredientStock::firstOrCreate(
                        [
                            'ingredient_id' => $recipe->ingredient_id,
                            'location_id' => $locationId,
                        ],
                        [
                            'business_id' => $businessId,
                            'current_qty' => 0,
                        ]
                    );

                    $stock->current_qty -= $qtyUsed;
                    $stock->updated_at = now();
                    $stock->save();

                    // Simpan log
                    IngredientStockLog::create([
                        'ingredient_id' => $recipe->ingredient_id,
                        'business_id' => $businessId,
                        'location_id' => $locationId,
                        'transaction_id' => $transaction->id,
                        'transaction_sell_line_id' => $line->id,
                        'qty_change' => -$qtyUsed,
                        'ref_type' => 'sale',
                        'ref_id' => $transaction->id,
                        'notes' => 'Auto deduct dari penjualan #' . $transaction->invoice_no,
                        'created_by' => $userId,
                        'created_at' => now(),
                    ]);

                    // Cek stok minus
                    if ($stock->current_qty < 0) {
                        $alertIngredients[$recipe->ingredient_id] = [
                            'ingredient' => $stock->ingredient,
                            'current_qty' => $stock->current_qty,
                            'location_id' => $locationId,
                        ];
                    }
                }
            }

            // Kirim email alert jika ada stok minus
            if (!empty($alertIngredients)) {
                $this->sendStockAlert($businessId, $alertIngredients, $transaction);
            }
        } catch (\Exception $e) {
            Log::error('IngredientStockService::deductForTransaction error: ' . $e->getMessage(), [
                'transaction_id' => $transaction->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Recalculate stok bahan saat transaksi di-update.
     * Mengembalikan stok lama lalu deduct ulang.
     */
    public function recalculateForTransaction(Transaction $transaction)
    {
        $businessId = $transaction->business_id;
        $locationId = $transaction->location_id;

        // Kembalikan stok dari log lama
        $oldLogs = IngredientStockLog::where('transaction_id', $transaction->id)
            ->where('ref_type', 'sale')
            ->get();

        foreach ($oldLogs as $log) {
            $stock = IngredientStock::where('ingredient_id', $log->ingredient_id)
                ->where('location_id', $log->location_id)
                ->first();

            if ($stock) {
                // qty_change negatif, jadi kita tambah kembali (kurangi negatif = tambah)
                $stock->current_qty -= $log->qty_change; // -= (-x) = += x
                $stock->updated_at = now();
                $stock->save();
            }
        }

        // Hapus log lama
        IngredientStockLog::where('transaction_id', $transaction->id)
            ->where('ref_type', 'sale')
            ->delete();

        // Deduct ulang
        $this->deductForTransaction($transaction);
    }

    /**
     * Kirim email alert stok minus ke admin.
     */
    protected function sendStockAlert($businessId, $alertIngredients, $transaction)
    {
        try {
            $admins = User::where('business_id', $businessId)
                ->whereHas('roles', function ($q) use ($businessId) {
                    $q->where('name', 'Admin#' . $businessId);
                })
                ->whereNotNull('email')
                ->get();

            if ($admins->isEmpty()) {
                return;
            }

            foreach ($admins as $admin) {
                Mail::to($admin->email)
                    ->queue(new IngredientStockAlertMail($alertIngredients, $transaction, $admin));
            }
        } catch (\Exception $e) {
            Log::error('IngredientStockService::sendStockAlert error: ' . $e->getMessage());
        }
    }

    /**
     * Tambah stok bahan (untuk pembelian/adjustment manual).
     */
    public function addStock($ingredientId, $businessId, $locationId, $qty, $refType = 'manual', $notes = '', $userId = null)
    {
        $stock = IngredientStock::firstOrCreate(
            [
                'ingredient_id' => $ingredientId,
                'location_id' => $locationId,
            ],
            [
                'business_id' => $businessId,
                'current_qty' => 0,
            ]
        );

        $stock->current_qty += $qty;
        $stock->updated_at = now();
        $stock->save();

        IngredientStockLog::create([
            'ingredient_id' => $ingredientId,
            'business_id' => $businessId,
            'location_id' => $locationId,
            'qty_change' => $qty,
            'ref_type' => $refType,
            'notes' => $notes,
            'created_by' => $userId ?? auth()->id(),
            'created_at' => now(),
        ]);

        return $stock;
    }
}
