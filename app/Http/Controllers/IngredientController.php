<?php

namespace App\Http\Controllers;

use App\Ingredient;
use App\IngredientStock;
use App\IngredientStockLog;
use App\ProductRecipe;
use App\Product;
use App\Unit;
use App\BusinessLocation;
use App\Services\IngredientStockService;
use App\Utils\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class IngredientController extends Controller
{
    protected $ingredientStockService;

    public function __construct(IngredientStockService $ingredientStockService)
    {
        $this->ingredientStockService = $ingredientStockService;
    }

    /**
     * Daftar bahan baku
     */
    public function index()
    {
        if (
            !auth()->user()->can('ingredient.view') &&
            !auth()->user()->can('ingredient.create') &&
            !auth()->user()->can('ingredient.update') &&
            !auth()->user()->can('ingredient.delete')
        ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        if (request()->ajax()) {
            $ingredients = Ingredient::where('business_id', $business_id)
                ->with(['unit'])
                ->select('ingredients.*');

            return DataTables::of($ingredients)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                            ' . __('messages.actions') . ' <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a href="' . action('IngredientController@edit', [$row->id]) . '"><i class="glyphicon glyphicon-edit"></i> ' . __('messages.edit') . '</a></li>
                            <li><a href="' . action('IngredientController@adjustStock', [$row->id]) . '"><i class="fa fa-exchange"></i> Adjust Stok</a></li>
                            <li><a href="' . action('IngredientController@stockLog', [$row->id]) . '"><i class="fa fa-history"></i> Log Stok</a></li>
                            <li><a href="#" class="delete-ingredient" data-href="' . action('IngredientController@destroy', [$row->id]) . '"><i class="glyphicon glyphicon-trash"></i> ' . __('messages.delete') . '</a></li>
                        </ul>
                    </div>';
                    return $html;
                })
                ->addColumn('unit_name', function ($row) {
                    return $row->unit->actual_name ?? '-';
                })
                ->editColumn('min_stock', function ($row) {
                    $unit_label = $row->unit->actual_name ?? '';
                    $formatted_qty = number_format((float) $row->min_stock, 2);

                    return trim($formatted_qty . ' ' . $unit_label);
                })
                ->addColumn('stock_info', function ($row) {
                    $stocks = IngredientStock::where('ingredient_id', $row->id)
                        ->with('location')
                        ->get();
                    if ($stocks->isEmpty()) return '<span class="text-muted">Belum ada stok</span>';

                    $unit_label = $row->unit->actual_name ?? '';
                    $html = '';
                    foreach ($stocks as $s) {
                        $class = $s->current_qty < 0 ? 'text-danger' : ($s->current_qty <= $row->min_stock ? 'text-warning' : 'text-success');
                        $qty_with_unit = trim(number_format((float) $s->current_qty, 2) . ' ' . $unit_label);
                        $html .= '<span class="' . $class . '">' . ($s->location->name ?? '-') . ': ' . $qty_with_unit . '</span><br>';
                    }
                    return $html;
                })
                ->addColumn('status', function ($row) {
                    return $row->is_active
                        ? '<span class="label label-success">Aktif</span>'
                        : '<span class="label label-danger">Nonaktif</span>';
                })
                ->rawColumns(['action', 'stock_info', 'status'])
                ->make(true);
        }

        return view('ingredient.index');
    }

    /**
     * Form tambah bahan baku
     */
    public function create()
    {
        if (!auth()->user()->can('ingredient.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $units = Unit::forDropdown($business_id, true);

        return view('ingredient.create', compact('units'));
    }

    /**
     * Simpan bahan baku baru
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('ingredient.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');

            $input = $request->only(['name', 'sku', 'unit_id', 'min_stock']);
            $input['business_id'] = $business_id;
            $input['created_by'] = auth()->id();
            $input['is_active'] = $request->has('is_active') ? 1 : 0;

            if (empty($input['unit_id'])) {
                $input['unit_id'] = null;
            }

            $ingredient = Ingredient::create($input);

            $output = [
                'success' => true,
                'msg' => 'Bahan baku berhasil ditambahkan',
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()->action('IngredientController@index')->with('status', $output);
    }

    /**
     * Form edit bahan baku
     */
    public function edit($id)
    {
        if (!auth()->user()->can('ingredient.update')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $ingredient = Ingredient::where('business_id', $business_id)->findOrFail($id);
        $units = Unit::forDropdown($business_id, true);

        return view('ingredient.edit', compact('ingredient', 'units'));
    }

    /**
     * Update bahan baku
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('ingredient.update')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            $ingredient = Ingredient::where('business_id', $business_id)->findOrFail($id);

            $input = $request->only(['name', 'sku', 'unit_id', 'min_stock']);
            $input['is_active'] = $request->has('is_active') ? 1 : 0;
            if (empty($input['unit_id'])) {
                $input['unit_id'] = null;
            }

            $ingredient->update($input);

            $output = [
                'success' => true,
                'msg' => 'Bahan baku berhasil diupdate',
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()->action('IngredientController@index')->with('status', $output);
    }

    /**
     * Hapus bahan baku
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('ingredient.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            Ingredient::where('business_id', $business_id)->where('id', $id)->delete();

            $output = [
                'success' => true,
                'msg' => 'Bahan baku berhasil dihapus',
            ];
        } catch (\Exception $e) {
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Log stok bahan
     */
    public function stockLog($id)
    {
        if (
            !auth()->user()->can('ingredient.view') &&
            !auth()->user()->can('ingredient.create') &&
            !auth()->user()->can('ingredient.update') &&
            !auth()->user()->can('ingredient.delete')
        ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $ingredient = Ingredient::where('business_id', $business_id)->with('unit')->findOrFail($id);

        if (request()->ajax()) {
            $logs = IngredientStockLog::where('ingredient_id', $id)
                ->where('business_id', $business_id)
                ->with(['location', 'creator'])
                ->orderBy('created_at', 'desc');

            return DataTables::of($logs)
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y H:i') : '-';
                })
                ->addColumn('location_name', function ($row) {
                    return $row->location->name ?? '-';
                })
                ->addColumn('created_by_name', function ($row) {
                    return $row->creator->first_name ?? '-';
                })
                ->editColumn('qty_change', function ($row) {
                    $class = $row->qty_change < 0 ? 'text-danger' : 'text-success';
                    $sign = $row->qty_change > 0 ? '+' : '';
                    return '<span class="' . $class . '">' . $sign . number_format($row->qty_change, 2) . '</span>';
                })
                ->rawColumns(['qty_change'])
                ->make(true);
        }

        return view('ingredient.stock_log', compact('ingredient'));
    }

    /**
     * Form tambah/kurangi stok manual
     */
    public function adjustStock(Request $request, $id)
    {
        if (!auth()->user()->can('ingredient.update')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $ingredient = Ingredient::where('business_id', $business_id)->findOrFail($id);

        if ($request->isMethod('post')) {
            try {
                $request->validate([
                    'location_id' => 'required|integer',
                    'stock_in' => 'required|numeric|min:0',
                    'stock_out' => 'required|numeric|min:0',
                ]);

                $stock_in = round((float) $request->input('stock_in', 0), 2);
                $stock_out = round((float) $request->input('stock_out', 0), 2);
                $qty = round($stock_in - $stock_out, 2);

                if ((float) $qty == 0.0) {
                    $output = [
                        'success' => false,
                        'msg' => 'Nilai Stok Masuk/Keluar tidak boleh sama (netto 0).',
                    ];

                    return redirect()->back()->withInput()->with('status', $output);
                }

                $location_id = $request->input('location_id');
                $notes = $request->input('notes', '');

                $this->ingredientStockService->addStock(
                    $id, $business_id, $location_id, $qty, 'adjustment', $notes
                );

                $output = [
                    'success' => true,
                    'msg' => 'Stok bahan berhasil diupdate',
                ];

                return redirect()->action('IngredientController@index')->with('status', $output);
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                $output = [
                    'success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
                return redirect()->back()->with('status', $output);
            }
        }

        $locations = BusinessLocation::forDropdown($business_id);
        $stocks = IngredientStock::where('ingredient_id', $id)->with('location')->get();

        return view('ingredient.adjust_stock', compact('ingredient', 'locations', 'stocks'));
    }

    /**
     * Laporan pemakaian bahan baku
     */
    public function usageReport(Request $request)
    {
        if (!auth()->user()->can('ingredient.view') && !auth()->user()->can('ingredient.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $locations = BusinessLocation::forDropdown($business_id);

        // Default hari ini
        $start_date = $request->input('start_date', date('Y-m-d'));
        $end_date = $request->input('end_date', date('Y-m-d'));
        $location_id = $request->input('location_id', null);

        $usage_data = [];
        $sale_summary = [];

        $venue_summary = [];

        if ($request->has('start_date')) {
            // Base query untuk semua jenis pemakaian (POS + venue booking)
            $baseQuery = IngredientStockLog::where('ingredient_stock_logs.business_id', $business_id)
                ->whereIn('ref_type', ['sale', 'venue_booking'])
                ->whereDate('ingredient_stock_logs.created_at', '>=', $start_date)
                ->whereDate('ingredient_stock_logs.created_at', '<=', $end_date);

            if (!empty($location_id)) {
                $baseQuery->where('ingredient_stock_logs.location_id', $location_id);
            }

            // Ringkasan pemakaian per bahan (gabungan POS + event)
            $usage_data = (clone $baseQuery)
                ->join('ingredients', 'ingredients.id', '=', 'ingredient_stock_logs.ingredient_id')
                ->leftJoin('units', 'units.id', '=', 'ingredients.unit_id')
                ->select(
                    'ingredients.id',
                    'ingredients.name as ingredient_name',
                    'units.actual_name as unit_name',
                    'units.short_name as unit_short',
                    DB::raw('SUM(ABS(ingredient_stock_logs.qty_change)) as total_used')
                )
                ->groupBy('ingredients.id', 'ingredients.name', 'units.actual_name', 'units.short_name')
                ->orderBy('ingredients.name')
                ->get();

            // Ringkasan per transaksi penjualan POS
            $saleQuery = IngredientStockLog::where('ingredient_stock_logs.business_id', $business_id)
                ->where('ref_type', 'sale')
                ->whereDate('ingredient_stock_logs.created_at', '>=', $start_date)
                ->whereDate('ingredient_stock_logs.created_at', '<=', $end_date);
            if (!empty($location_id)) {
                $saleQuery->where('ingredient_stock_logs.location_id', $location_id);
            }
            $sale_summary = $saleQuery
                ->join('ingredients', 'ingredients.id', '=', 'ingredient_stock_logs.ingredient_id')
                ->leftJoin('units', 'units.id', '=', 'ingredients.unit_id')
                ->leftJoin('transactions', 'transactions.id', '=', 'ingredient_stock_logs.transaction_id')
                ->leftJoin('transaction_sell_lines', 'transaction_sell_lines.id', '=', 'ingredient_stock_logs.transaction_sell_line_id')
                ->leftJoin('products', 'products.id', '=', 'transaction_sell_lines.product_id')
                ->leftJoin('business_locations', 'business_locations.id', '=', 'ingredient_stock_logs.location_id')
                ->select(
                    'transactions.invoice_no',
                    'transactions.transaction_date',
                    'products.name as product_name',
                    'transaction_sell_lines.quantity as qty_sold',
                    'ingredients.name as ingredient_name',
                    'units.short_name as unit_short',
                    DB::raw('ABS(ingredient_stock_logs.qty_change) as qty_used'),
                    'business_locations.name as location_name'
                )
                ->orderBy('transactions.transaction_date', 'desc')
                ->orderBy('transactions.invoice_no')
                ->get();

            // Ringkasan per booking venue / event
            $venueQuery = IngredientStockLog::where('ingredient_stock_logs.business_id', $business_id)
                ->where('ref_type', 'venue_booking')
                ->whereDate('ingredient_stock_logs.created_at', '>=', $start_date)
                ->whereDate('ingredient_stock_logs.created_at', '<=', $end_date);
            if (!empty($location_id)) {
                $venueQuery->where('ingredient_stock_logs.location_id', $location_id);
            }
            $venue_summary = $venueQuery
                ->join('ingredients', 'ingredients.id', '=', 'ingredient_stock_logs.ingredient_id')
                ->leftJoin('units', 'units.id', '=', 'ingredients.unit_id')
                ->leftJoin('venue_bookings', 'venue_bookings.id', '=', 'ingredient_stock_logs.ref_id')
                ->leftJoin('business_locations', 'business_locations.id', '=', 'ingredient_stock_logs.location_id')
                ->select(
                    'venue_bookings.booking_ref',
                    'venue_bookings.event_date',
                    'venue_bookings.event_name',
                    'ingredients.name as ingredient_name',
                    'units.short_name as unit_short',
                    DB::raw('ABS(ingredient_stock_logs.qty_change) as qty_used'),
                    'business_locations.name as location_name',
                    'ingredient_stock_logs.created_at as deducted_at'
                )
                ->orderBy('ingredient_stock_logs.created_at', 'desc')
                ->get();
        }

        return view('ingredient.usage_report', compact(
            'locations', 'start_date', 'end_date', 'location_id',
            'usage_data', 'sale_summary', 'venue_summary'
        ));
    }

    /**
     * API search produk (untuk select2 ajax di katalog resep)
     */
    public function searchProducts(Request $request)
    {
        if (!auth()->user()->can('ingredient.view') && !auth()->user()->can('ingredient.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $term = $request->input('term', '');

        $products = Product::where('business_id', $business_id)
            ->where(function($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                  ->orWhere('sku', 'like', '%' . $term . '%');
            })
            ->select('id', 'name', 'sku')
            ->orderBy('name')
            ->limit(25)
            ->get();

        $results = $products->map(function($p) {
            return [
                'id' => $p->id,
                'text' => $p->name . ($p->sku ? ' (' . $p->sku . ')' : ''),
            ];
        });

        return response()->json(['results' => $results]);
    }
}
