@extends('layouts.app')
@section('title', 'Resep - ' . $product->name)

@section('content')
<section class="content-header">
    <h1>Resep Bahan: {{ $product->name }}
        <small>Komposisi bahan baku per porsi</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ action('ProductController@index') }}">Produk</a></li>
        <li class="active">Resep</li>
    </ol>
</section>

<section class="content">
    {{-- Form tambah/edit resep --}}
    @component('components.widget', ['class' => 'box-success', 'title' => 'Tambah Bahan ke Resep'])
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Bahan Baku *</label>
                    <select id="recipe_ingredient_id" class="form-control select2" required>
                        <option value="">Pilih bahan</option>
                        @foreach($ingredients as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Qty per Porsi *</label>
                    <input type="number" id="recipe_qty" class="form-control" step="0.0001" min="0" required placeholder="Contoh: 0.25">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Satuan (opsional)</label>
                    <select id="recipe_unit_id" class="form-control select2">
                        <option value="">Satuan bahan</option>
                        @foreach($units as $uid => $uname)
                            <option value="{{ $uid }}">{{ $uname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <button type="button" class="btn btn-success btn-block" id="btn_add_recipe">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </div>
        </div>
        <input type="hidden" id="edit_recipe_id" value="">
    @endcomponent

    {{-- Tabel resep --}}
    @component('components.widget', ['class' => 'box-primary', 'title' => 'Daftar Bahan dalam Resep'])
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="recipe_table">
                <thead>
                    <tr>
                        <th>Bahan</th>
                        <th>Qty per Porsi</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent
</section>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        var recipe_table = $('#recipe_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ action("ProductRecipeController@index", [$product->id]) }}',
            columns: [
                { data: 'ingredient_name', name: 'ingredient_name' },
                { data: 'qty_per_unit', name: 'qty_per_unit' },
                { data: 'unit_name', name: 'unit_name', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
        });

        // Tambah resep
        $('#btn_add_recipe').click(function() {
            var edit_id = $('#edit_recipe_id').val();
            var data = {
                product_id: '{{ $product->id }}',
                ingredient_id: $('#recipe_ingredient_id').val(),
                qty_per_unit: $('#recipe_qty').val(),
                unit_id: $('#recipe_unit_id').val() || null,
            };

            if (!data.ingredient_id || !data.qty_per_unit) {
                toastr.error('Pilih bahan dan isi qty');
                return;
            }

            var url, method;
            if (edit_id) {
                url = '{{ url("product-recipes") }}/' + edit_id;
                method = 'PUT';
            } else {
                url = '{{ action("ProductRecipeController@store") }}';
                method = 'POST';
            }

            $.ajax({
                method: method,
                url: url,
                data: data,
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        toastr.success(result.msg);
                        recipe_table.ajax.reload();
                        // Reset form
                        $('#recipe_ingredient_id').val('').trigger('change');
                        $('#recipe_qty').val('');
                        $('#recipe_unit_id').val('').trigger('change');
                        $('#edit_recipe_id').val('');
                        $('#btn_add_recipe').html('<i class="fa fa-plus"></i> Tambah');
                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
        });

        // Edit resep
        $(document).on('click', '.edit-recipe', function() {
            var id = $(this).data('id');
            var ingredient_id = $(this).data('ingredient_id');
            var qty = $(this).data('qty');
            var unit_id = $(this).data('unit_id');

            $('#edit_recipe_id').val(id);
            $('#recipe_ingredient_id').val(ingredient_id).trigger('change');
            $('#recipe_qty').val(qty);
            $('#recipe_unit_id').val(unit_id).trigger('change');
            $('#btn_add_recipe').html('<i class="fa fa-save"></i> Update');
        });

        // Hapus resep
        $(document).on('click', '.delete-recipe', function(e) {
            e.preventDefault();
            swal({
                title: LANG.sure,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var href = $(this).data('href');
                    $.ajax({
                        method: "DELETE",
                        url: href,
                        dataType: "json",
                        success: function(result) {
                            if (result.success) {
                                toastr.success(result.msg);
                                recipe_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
