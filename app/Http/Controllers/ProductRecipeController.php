<?php

namespace App\Http\Controllers;

use App\ProductRecipe;
use App\Product;
use App\Ingredient;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductRecipeController extends Controller
{
    /**
     * Katalog resep: Daftar semua produk dan bahan yang digunakan
     */
    public function catalog(Request $request)
    {
        if (!auth()->user()->can('purchase.view') && !auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $product_id = $request->input('product_id', null);

        $products = collect();
        $selected_product = null;

        if (!empty($product_id)) {
            // Tampilkan satu produk spesifik (dengan atau tanpa resep)
            $products = Product::where('products.business_id', $business_id)
                ->where('products.id', $product_id)
                ->with(['recipes' => function($q) {
                    $q->with(['ingredient.unit', 'unit']);
                }])
                ->get();

            $selected_product = $products->first();
        } else {
            // Tampilkan semua produk yang punya resep
            $products = Product::where('products.business_id', $business_id)
                ->whereHas('recipes')
                ->with(['recipes' => function($q) {
                    $q->with(['ingredient.unit', 'unit']);
                }])
                ->orderBy('products.name')
                ->paginate(20);
        }

        return view('ingredient.recipe_catalog', compact('products', 'product_id', 'selected_product'));
    }

    /**
     * Halaman daftar semua resep (search produk & bahan) - kept for backward compatibility
     */
    public function all()
    {
        if (!auth()->user()->can('purchase.view') && !auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        if (request()->ajax()) {
            $recipes = ProductRecipe::join('products', 'products.id', '=', 'product_recipes.product_id')
                ->join('ingredients', 'ingredients.id', '=', 'product_recipes.ingredient_id')
                ->leftJoin('units', 'units.id', '=', DB::raw('COALESCE(product_recipes.unit_id, ingredients.unit_id)'))
                ->where('products.business_id', $business_id)
                ->select(
                    'product_recipes.id',
                    'product_recipes.product_id',
                    'products.name as product_name',
                    'ingredients.name as ingredient_name',
                    'product_recipes.qty_per_unit',
                    'units.actual_name as unit_name',
                    'units.short_name as unit_short'
                );

            return DataTables::of($recipes)
                ->addColumn('action', function ($row) {
                    return '<a href="' . action('ProductRecipeController@index', [$row->product_id]) . '" class="btn btn-xs btn-info" title="Edit Resep"><i class="fa fa-edit"></i> Edit Resep</a>';
                })
                ->editColumn('qty_per_unit', function ($row) {
                    return number_format($row->qty_per_unit, 4);
                })
                ->addColumn('unit_display', function ($row) {
                    return $row->unit_short ?? $row->unit_name ?? '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $ingredients = Ingredient::forDropdown($business_id);

        return view('ingredient.recipe_all', compact('ingredients'));
    }

    /**
     * Daftar resep per produk
     */
    public function index($product_id)
    {
        if (!auth()->user()->can('purchase.view') && !auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $product = Product::where('business_id', $business_id)->findOrFail($product_id);

        if (request()->ajax()) {
            $recipes = ProductRecipe::where('product_id', $product_id)
                ->with(['ingredient', 'ingredient.unit', 'unit'])
                ->select('product_recipes.*');

            return DataTables::of($recipes)
                ->addColumn('ingredient_name', function ($row) {
                    return $row->ingredient->name ?? '-';
                })
                ->addColumn('unit_name', function ($row) {
                    return $row->unit->actual_name ?? ($row->ingredient->unit->actual_name ?? '-');
                })
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-xs btn-primary edit-recipe" data-id="' . $row->id . '" data-ingredient_id="' . $row->ingredient_id . '" data-qty="' . $row->qty_per_unit . '" data-unit_id="' . $row->unit_id . '"><i class="glyphicon glyphicon-edit"></i></button>
                    <button class="btn btn-xs btn-danger delete-recipe" data-href="' . action('ProductRecipeController@destroy', [$row->id]) . '"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $ingredients = Ingredient::forDropdown($business_id);
        $units = Unit::forDropdown($business_id, true);

        return view('ingredient.recipe', compact('product', 'ingredients', 'units'));
    }

    /**
     * Simpan resep baru
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['product_id', 'ingredient_id', 'qty_per_unit', 'unit_id', 'variation_id']);
            if (empty($input['unit_id'])) $input['unit_id'] = null;
            if (empty($input['variation_id'])) $input['variation_id'] = null;

            ProductRecipe::create($input);

            $output = [
                'success' => true,
                'msg' => 'Resep berhasil ditambahkan',
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Update resep
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $recipe = ProductRecipe::findOrFail($id);
            $input = $request->only(['ingredient_id', 'qty_per_unit', 'unit_id']);
            if (empty($input['unit_id'])) $input['unit_id'] = null;

            $recipe->update($input);

            $output = [
                'success' => true,
                'msg' => 'Resep berhasil diupdate',
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
     * Hapus resep
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            ProductRecipe::findOrFail($id)->delete();
            $output = ['success' => true, 'msg' => 'Resep berhasil dihapus'];
        } catch (\Exception $e) {
            $output = ['success' => false, 'msg' => __('messages.something_went_wrong')];
        }

        return $output;
    }
}
