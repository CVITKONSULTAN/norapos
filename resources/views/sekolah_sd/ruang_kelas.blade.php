@extends('layouts.app')
@section('title', "Tabel Kelas/Siswa")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Tabel Kelas/Siswa</h1>
</section>

<!-- Main content -->

<section class="content">
<div class="row">
    <div class="col-md-12">
    @component('components.filters', ['title' => __('report.filters')])
    
        <div class="col-md-3">
            <div class="form-group">
                <label>Kelas</label>
                <input name="kelas" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Tahun Ajaran</label>
                <input name="tahun" type="text" class="form-control" />
            </div>
        </div>
        <div class="col-md-3">
            <div style="margin-top: 2.5rem;">
                <button class="btn btn-primary" id="cari"><i class="fa fa-search"></i> CARI</button>
                <button class="btn btn-primary" id="reset">RESET</button>
            </div>
        </div>

       
    @endcomponent
    </div>
</div>


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
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>NAMA LENGKAP</td>
                                        <td>KELAS</td>
                                        <td>TAHUN AJARAN</td>
                                        <td>NISN</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
                pageLength: -1,
                processing: true,
                serverSide: true,
                aaSorting: [[3, 'asc']],
                "ajax": {
                    "url": "/reservasi/data",
                    "data": function ( d ) {
                        d.datatable = 1;
                        d.date = $("#tanggal_filter").val();

                        d = __datatable_ajax_callback(d);
                    }
                },
                columnDefs: [ {
                    "targets": [0],
                    "orderable": false,
                    "searchable": false
                } ],
                columns: [
                    { data: 'ID'  },
                    { data: 'HARGA'  },
                    { data: 'OTA'  },
                    { data: 'CID'  },
                    { data: 'NAMA'  }
                ]
            });
            // Array to track the ids of the details displayed rows
            var detailRows = [];

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

            $(document).on('click', '#delete-selected', function(e){
                e.preventDefault();
                var selected_rows = getSelectedRows();
                
                if(selected_rows.length > 0){
                    $('input#selected_rows').val(selected_rows);
                    swal({
                        title: LANG.sure,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $('form#mass_delete_form').submit();
                        }
                    });
                } else{
                    $('input#selected_rows').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            });

            $("#reset").click(()=>{
                $("#tanggal_filter").val("").trigger('change');
            })

            $(document).on('change', 
                '#tanggal_filter', 
                function() {
                    product_table.ajax.reload();
            });


        });

        function getSelectedRows() {
            var selected_rows = [];
            var i = 0;
            $('.row-select:checked').each(function () {
                selected_rows[i++] = $(this).val();
            });

            return selected_rows; 
        }

    </script>
@endsection