@extends('layouts.app')
@section('title', 'Data Jembatan')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Data Jembatan
        <small></small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Semua Data</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active table-responsive" id="product_list_tab">
                        <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                            <thead>
                                <tr>
                                    <th>Tindakan</th>
                                    <th>Nama Jembatan</th>
                                    <th>Kecamatan</th>
                                    <th>Tipe</th>
                                    <th>Panjang (km)</th>
                                    <th>Lebar (m)</th>
                                    <th>Pada Ruas Jalan</th>
                                    <th>STA</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).ready( function(){

            product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{route('pejantan.jembatan.api')}}"
                },
                columns: [
                    { 
                        searchable: false,
                        orderable:false,
                        data: 'id',
                        className:"text-center",
                        render:(data)=> {
                            const template = `
                                <a 
                                    class="btn btn-primary btn-xs" 
                                    href="#"
                                >
                                    Edit
                                </a>
                                <a 
                                    class="btn btn-danger btn-xs" 
                                    href="#"
                                >
                                    Hapus
                                </a>
                            `
                            return template;
                        }
                    },
                    { data: 'Nama_Jembatan'},
                    { data: 'Kecamatan'},
                    { data: 'Tipe'},
                    { data: 'Panjang'},
                    { data: 'Lebar'},
                    { data: 'Pada Ruas Jalan'},
                    { data: 'STA'}
                ]
            });

            $('table#product_table tbody').on('click', 'a.delete-product', function(e){
                e.preventDefault();
                swal({
                  title: LANG.sure,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: "DELETE",
                            url: href,
                            dataType: "json",
                            success: function(result){
                                if(result.success == true){
                                    toastr.success(result.msg);
                                    product_table.ajax.reload();
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