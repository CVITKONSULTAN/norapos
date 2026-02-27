@extends('layouts.app')
@section('title', 'Katalog Resep Produk')

@section('content')
<section class="content-header">
    <h1>Katalog Resep Produk
        <small>Daftar produk dan bahan yang digunakan</small>
    </h1>
</section>

<section class="content">
    {{-- Search Box pakai Select2 AJAX --}}
    @component('components.widget', ['class' => 'box-primary'])
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label>Cari Produk</label>
                    <select id="product_search" class="form-control" style="width: 100%">
                        @if($selected_product)
                            <option value="{{ $selected_product->id }}" selected>{{ $selected_product->name }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <a href="{{ action('ProductRecipeController@catalog') }}" class="btn btn-default">
                        <i class="fa fa-times"></i> Reset / Tampilkan Semua
                    </a>
                </div>
            </div>
        </div>
    @endcomponent

    {{-- Hasil --}}
    <div id="recipe_results">
        @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $products->count() > 0 : $products->count() > 0)
            @foreach($products as $product)
            @component('components.widget', ['class' => 'box-success'])
                @slot('title')
                    <h4 class="box-title">
                        <i class="fa fa-utensils"></i> {{ $product->name }}
                        <a href="{{ action('ProductRecipeController@index', [$product->id]) }}" class="btn btn-xs btn-primary pull-right" title="Edit Resep">
                            <i class="fa fa-edit"></i> Edit Resep
                        </a>
                    </h4>
                @endslot

                @if($product->recipes->count() > 0)
                <table class="table table-condensed table-bordered">
                    <thead>
                        <tr class="bg-gray">
                            <th width="5%">No</th>
                            <th width="50%">Bahan Baku</th>
                            <th width="25%" class="text-right">Qty per Porsi</th>
                            <th width="20%">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->recipes as $i => $recipe)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <strong>{{ $recipe->ingredient->name ?? '-' }}</strong>
                            </td>
                            <td class="text-right">{{ number_format($recipe->qty_per_unit, 4) }}</td>
                            <td>{{ $recipe->unit->short_name ?? ($recipe->ingredient->unit->short_name ?? '-') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-muted text-center">Belum ada resep untuk produk ini.</p>
                @endif
            @endcomponent
            @endforeach

            {{-- Pagination (hanya jika tampil semua) --}}
            @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="text-center">
                {{ $products->links() }}
            </div>
            @endif
        @else
            @component('components.widget', ['class' => 'box-warning'])
                <p class="text-center text-muted">
                    Belum ada produk dengan resep. Silakan <a href="{{ action('ProductController@index') }}">tambahkan resep</a> di halaman produk.
                </p>
            @endcomponent
        @endif
    </div>
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('#product_search').select2({
        placeholder: 'Ketik nama produk untuk mencari...',
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            url: '{{ action("IngredientController@searchProducts") }}',
            dataType: 'json',
            delay: 300,
            data: function(params) {
                return { term: params.term };
            },
            processResults: function(data) {
                return { results: data.results };
            },
            cache: true
        }
    });

    // Saat pilih produk, redirect ke halaman dengan filter
    $('#product_search').on('select2:select', function(e) {
        var product_id = e.params.data.id;
        window.location.href = '{{ action("ProductRecipeController@catalog") }}?product_id=' + product_id;
    });

    // Saat clear, tampilkan semua
    $('#product_search').on('select2:unselect', function(e) {
        window.location.href = '{{ action("ProductRecipeController@catalog") }}';
    });
});
</script>
@endsection
