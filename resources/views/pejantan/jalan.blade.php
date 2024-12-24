@extends('layouts.app')
@section('title', 'Data Jalan')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Data Jalan
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
                                    <th>Nama Jalan</th>
                                    <th>Status</th>
                                    <th>Kecamatan</th>
                                    <th>Kelas Jalan</th>
                                    <th>Panjang (km)</th>
                                    <th>Lebar (m)</th>
                                    <th>Hotmix</th>
                                    <th>Lapen</th>
                                    <th>Perkerasan Beton</th>
                                    <th>Telford/Kerikil</th>
                                    <th>Tanah</th>
                                    <th>Baik (km)</th>
                                    <th>Baik (%)</th>
                                    <th>Sedang (km)</th>
                                    <th>Sedang (%)</th>
                                    <th>Rusak Ringan (km)</th>
                                    <th>Rusak Ringan (%)</th>
                                    <th>Rusak Berat (km)</th>
                                    <th>Rusak Berat (%)</th>
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
                    "url": "{{route('pejantan.jalan.api')}}"
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
                    { data: 'RUAS_SK_BARU'},
                    { data: 'KODE_STATUS'},
                    { data: 'KECAMATAN'},
                    { data: 'KELAS_JALAN'},
                    { data: 'PANJANG'},
                    { data: 'LEBAR'},
                    { data: 'HOTMIX'},
                    { data: 'LAPEN'},
                    { data: 'PERKERASAN_BETON'},
                    { data: 'TELFORD/KERIKIL'},
                    { data: 'TANAH'},
                    { data: 'BAIK_KM'},
                    { data: 'BAIK_%'},
                    { data: 'SEDANG_KM'},
                    { data: 'SEDANG_%'},
                    { data: 'RUSAK_RINGAN_KM'},
                    { data: 'RUSAK_RINGAN_%'},
                    { data: 'RUSAK_BERAT_KM'},
                    { data: 'RUSAK_BERAT_%'},
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