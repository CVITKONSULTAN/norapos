<?php

namespace App\Http\Controllers;

use App\IngredientPurchase;
use App\IngredientPurchaseLine;
use App\Ingredient;
use App\IngredientAlias;
use App\Contact;
use App\BusinessLocation;
use App\Services\IngredientStockService;
use App\Services\OcrReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class IngredientPurchaseController extends Controller
{
    protected $ingredientStockService;

    public function __construct(IngredientStockService $ingredientStockService)
    {
        $this->ingredientStockService = $ingredientStockService;
    }

    /**
     * Daftar pembelian bahan
     */
    public function index()
    {
        if (!auth()->user()->can('purchase.view') && !auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        if (request()->ajax()) {
            $purchases = IngredientPurchase::where('business_id', $business_id)
                ->with(['supplier', 'location', 'createdBy'])
                ->select('ingredient_purchases.*');

            return DataTables::of($purchases)
                ->addColumn('supplier_name', function ($row) {
                    return $row->supplier->name ?? '-';
                })
                ->addColumn('location_name', function ($row) {
                    return $row->location->name ?? '-';
                })
                ->addColumn('created_by_name', function ($row) {
                    return $row->createdBy->first_name ?? '-';
                })
                ->addColumn('total_items', function ($row) {
                    return $row->lines->count() . ' bahan';
                })
                ->addColumn('total_cost', function ($row) {
                    $total = $row->total_amount > 0 ? $row->total_amount : $row->lines->sum('total_price');
                    return 'Rp ' . number_format($total, 0, ',', '.');
                })
                ->addColumn('payment_status_label', function ($row) {
                    $status = $row->payment_status ?? 'unpaid';
                    $labels = [
                        'paid' => '<span class="label label-success">Lunas</span>',
                        'partial' => '<span class="label label-warning">Sebagian</span>',
                        'unpaid' => '<span class="label label-danger">Belum Bayar</span>',
                    ];
                    $badge = $labels[$status] ?? $labels['unpaid'];
                    if ($status !== 'paid' && $row->total_amount > 0) {
                        $remaining = $row->total_amount - ($row->paid_amount ?? 0);
                        $badge .= '<br><small class="text-muted">Sisa: Rp ' . number_format($remaining, 0, ',', '.') . '</small>';
                    }
                    return $badge;
                })
                ->editColumn('purchase_date', function ($row) {
                    return \Carbon\Carbon::parse($row->purchase_date)->format('d/m/Y');
                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                            ' . __('messages.actions') . ' <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a href="' . action('IngredientPurchaseController@show', [$row->id]) . '"><i class="fa fa-eye"></i> Lihat Detail</a></li>';

                    $paymentStatus = $row->payment_status ?? 'unpaid';
                    if ($paymentStatus !== 'paid') {
                        $html .= '<li><a href="#" class="btn-pay-purchase" data-id="' . $row->id . '" data-total="' . ($row->total_amount ?? 0) . '" data-paid="' . ($row->paid_amount ?? 0) . '" data-ref="' . ($row->ref_no ?? $row->id) . '"><i class="fa fa-money"></i> Bayar</a></li>';
                    }

                    $html .= '<li><a href="#" class="delete-purchase" data-href="' . action('IngredientPurchaseController@destroy', [$row->id]) . '"><i class="fa fa-trash"></i> ' . __('messages.delete') . '</a></li>
                        </ul>
                    </div>';
                    return $html;
                })
                ->rawColumns(['action', 'payment_status_label'])
                ->make(true);
        }

        return view('ingredient.purchase.index');
    }

    /**
     * Form tambah pembelian batch
     */
    public function create()
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $suppliers = Contact::suppliersDropdown($business_id);
        $locations = BusinessLocation::forDropdown($business_id);
        $ingredients = Ingredient::where('business_id', $business_id)
            ->where('is_active', true)
            ->with('unit')
            ->orderBy('name')
            ->get();

        return view('ingredient.purchase.create', compact('suppliers', 'locations', 'ingredients'));
    }

    /**
     * Simpan pembelian batch
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $business_id = request()->session()->get('user.business_id');

            $purchase = IngredientPurchase::create([
                'business_id' => $business_id,
                'location_id' => $request->input('location_id'),
                'contact_id' => $request->input('contact_id') ?: null,
                'ref_no' => $request->input('ref_no'),
                'purchase_date' => $request->input('purchase_date'),
                'notes' => $request->input('notes'),
                'status' => 'received',
                'total_amount' => 0,
                'paid_amount' => 0,
                'payment_status' => 'unpaid',
                'created_by' => auth()->id(),
            ]);

            $ingredients = $request->input('ingredients', []);
            $totalAmount = 0;
            foreach ($ingredients as $item) {
                if (empty($item['quantity']) || $item['quantity'] <= 0) {
                    continue;
                }

                $ingredientId = $item['ingredient_id'] ?? null;
                $notaName = $item['nota_name'] ?? null;
                $isNew = !empty($item['is_new']) && $item['is_new'] == '1';

                // Auto-create new ingredient if flagged
                if (($isNew || empty($ingredientId)) && !empty($notaName)) {
                    $newIngredient = Ingredient::create([
                        'business_id' => $business_id,
                        'name' => $notaName,
                        'is_active' => true,
                        'created_by' => auth()->id(),
                    ]);
                    $ingredientId = $newIngredient->id;
                }

                if (empty($ingredientId)) {
                    continue;
                }

                $qty = floatval($item['quantity']);
                $unit_price = floatval($item['unit_price'] ?? 0);
                $lineTotal = $qty * $unit_price;
                $totalAmount += $lineTotal;

                IngredientPurchaseLine::create([
                    'ingredient_purchase_id' => $purchase->id,
                    'ingredient_id' => $ingredientId,
                    'nota_name' => $notaName,
                    'quantity' => $qty,
                    'unit_price' => $unit_price,
                    'total_price' => $lineTotal,
                ]);

                // Save alias mapping (nota_name → ingredient) for future OCR auto-match
                if (!empty($notaName)) {
                    try {
                        IngredientAlias::saveAlias($notaName, $ingredientId, $business_id);
                    } catch (\Exception $e) {
                        // Alias might already exist for different ingredient, skip
                    }
                }

                // Tambah stok bahan
                $this->ingredientStockService->addStock(
                    $ingredientId,
                    $business_id,
                    $purchase->location_id,
                    $qty,
                    'purchase',
                    'Pembelian #' . ($purchase->ref_no ?? $purchase->id),
                    auth()->id()
                );
            }

            // Update total dan status pembayaran
            $paidAmount = floatval($request->input('paid_amount', 0));
            if ($paidAmount > $totalAmount) {
                $paidAmount = $totalAmount;
            }

            $paymentStatus = 'unpaid';
            if ($paidAmount > 0 && $paidAmount >= $totalAmount) {
                $paymentStatus = 'paid';
            } elseif ($paidAmount > 0) {
                $paymentStatus = 'partial';
            }

            $purchase->update([
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'payment_status' => $paymentStatus,
            ]);

            DB::commit();

            $output = ['success' => true, 'msg' => 'Pembelian bahan berhasil disimpan'];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = ['success' => false, 'msg' => __('messages.something_went_wrong')];
        }

        return redirect()->action('IngredientPurchaseController@index')->with('status', $output);
    }

    /**
     * Detail pembelian
     */
    public function show($id)
    {
        if (!auth()->user()->can('purchase.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $purchase = IngredientPurchase::where('business_id', $business_id)
            ->with(['supplier', 'location', 'createdBy', 'lines.ingredient.unit'])
            ->findOrFail($id);

        return view('ingredient.purchase.show', compact('purchase'));
    }

    /**
     * Hapus pembelian (dan kembalikan stok)
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $business_id = request()->session()->get('user.business_id');
            $purchase = IngredientPurchase::where('business_id', $business_id)
                ->with('lines')
                ->findOrFail($id);

            // Kembalikan stok
            foreach ($purchase->lines as $line) {
                $this->ingredientStockService->addStock(
                    $line->ingredient_id,
                    $business_id,
                    $purchase->location_id,
                    -$line->quantity, // negatif = kurangi
                    'purchase_delete',
                    'Hapus pembelian #' . ($purchase->ref_no ?? $purchase->id),
                    auth()->id()
                );
            }

            $purchase->delete();

            DB::commit();
            $output = ['success' => true, 'msg' => 'Pembelian berhasil dihapus dan stok dikembalikan'];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = ['success' => false, 'msg' => __('messages.something_went_wrong')];
        }

        return $output;
    }

    /**
     * Catat pembayaran untuk pembelian
     */
    public function recordPayment(Request $request, $id)
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            $purchase = IngredientPurchase::where('business_id', $business_id)->findOrFail($id);

            $amount = floatval($request->input('amount', 0));
            if ($amount <= 0) {
                return ['success' => false, 'msg' => 'Jumlah pembayaran harus lebih dari 0'];
            }

            $newPaid = ($purchase->paid_amount ?? 0) + $amount;
            $total = $purchase->total_amount ?? 0;

            if ($newPaid > $total && $total > 0) {
                $newPaid = $total;
            }

            $paymentStatus = 'unpaid';
            if ($newPaid > 0 && $total > 0 && $newPaid >= $total) {
                $paymentStatus = 'paid';
            } elseif ($newPaid > 0) {
                $paymentStatus = 'partial';
            }

            $purchase->update([
                'paid_amount' => $newPaid,
                'payment_status' => $paymentStatus,
            ]);

            return ['success' => true, 'msg' => 'Pembayaran berhasil dicatat. Status: ' . ($paymentStatus === 'paid' ? 'Lunas' : 'Sebagian')];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return ['success' => false, 'msg' => __('messages.something_went_wrong')];
        }
    }

    /**
     * Process uploaded receipt file via OCR
     */
    public function processOcr(Request $request)
    {
        if (!auth()->user()->can('purchase.create')) {
            return response()->json(['success' => false, 'msg' => 'Unauthorized'], 403);
        }

        $request->validate([
            'receipt_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        try {
            $file = $request->file('receipt_file');

            // Store with original extension so OCR can detect file type
            $originalExt = $file->getClientOriginalExtension();
            $filename = uniqid('receipt_') . '.' . $originalExt;

            // Ensure ocr_temp directory exists with proper permissions
            $ocrTempDir = storage_path('app/ocr_temp');
            if (!is_dir($ocrTempDir)) {
                mkdir($ocrTempDir, 0777, true);
            }

            // Use move instead of storeAs for more reliable file saving
            $fullPath = $ocrTempDir . '/' . $filename;
            $file->move($ocrTempDir, $filename);

            if (!file_exists($fullPath)) {
                \Log::error('OCR: File upload failed - file not found at ' . $fullPath);
                return response()->json(['success' => false, 'msg' => 'Gagal menyimpan file yang diupload. Periksa permission folder storage.']);
            }

            \Log::info('OCR: File uploaded to ' . $fullPath . ' (ext: ' . $originalExt . ', size: ' . filesize($fullPath) . ')');

            $business_id = request()->session()->get('user.business_id');

            $ocrService = new OcrReceiptService();
            $result = $ocrService->processFile($fullPath, $business_id);

            \Log::info('OCR: Result - items=' . count($result['items']) . ', supplier=' . ($result['supplier_name'] ?? 'none') . ', total=' . ($result['total'] ?? 0));

            // Clean up temp file
            @unlink($fullPath);

            // Try to match supplier name to existing contact
            $supplierId = null;
            if (!empty($result['supplier_name'])) {
                $supplier = Contact::where('business_id', $business_id)
                    ->whereIn('type', ['supplier', 'both'])
                    ->where(function ($q) use ($result) {
                        $q->where('first_name', 'LIKE', '%' . $result['supplier_name'] . '%')
                          ->orWhere('supplier_business_name', 'LIKE', '%' . $result['supplier_name'] . '%');
                    })
                    ->first();
                if ($supplier) {
                    $supplierId = $supplier->id;
                }
            }
            $result['supplier_id'] = $supplierId;

            return response()->json(['success' => true, 'data' => $result]);
        } catch (\Exception $e) {
            \Log::emergency("OCR Error: " . $e->getFile() . ":" . $e->getLine() . " - " . $e->getMessage());
            return response()->json(['success' => false, 'msg' => 'Gagal memproses file: ' . $e->getMessage()]);
        }
    }
}
