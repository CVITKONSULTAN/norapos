@extends('layouts.app')
@section('title', 'Bahan Baku')

@section('content')
<section class="content-header">
    <h1>Bahan Baku
        <small>Kelola bahan baku resto</small>
    </h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        @slot('tool')
            <div class="box-tools">
                <a class="btn btn-block btn-primary" href="{{ action('IngredientController@create') }}">
                    <i class="fa fa-plus"></i> @lang('messages.add')
                </a>
            </div>
        @endslot

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="ingredient_table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>SKU</th>
                        <th>Satuan</th>
                        <th>Min Stok</th>
                        <th>Stok per Lokasi</th>
                        <th>Status</th>
                        <th>@lang('messages.action')</th>
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
        var ingredient_table = $('#ingredient_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ action("IngredientController@index") }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'sku', name: 'sku' },
                { data: 'unit_name', name: 'unit_name', orderable: false, searchable: false },
                { data: 'min_stock', name: 'min_stock' },
                { data: 'stock_info', name: 'stock_info', orderable: false, searchable: false },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
        });

        $(document).on('click', '.delete-ingredient', function(e) {
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
                                ingredient_table.ajax.reload();
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
