@extends('layouts.app')
@section('title', "Rekap Absen Siswa")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Rekap Absen Siswa</h1>
</section>

<!-- Main content -->
<div id="editor_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Form Rekap
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Cari NISN/Nama Siswa</label>
                    <input class="form-control" placeholder="Cari disini..." />
                </div>
                <div class="form-group">
                    <label>NISN</label>
                    <input readonly class="form-control" />
                </div>
                <div class="form-group">
                    <label>Nama Siswa</label>
                    <input readonly class="form-control" />
                </div>
                <div class="form-group">
                    <label>Sakit</label>
                    <input type="number" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Izin</label>
                    <input type="number" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Tanpa Keterangan</label>
                    <input type="number" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
              </div>
        </div>
    </div>
</div>

<section class="content">

    <div class="row">
        <div class="col-md-12">
        @component('components.filters', ['title' => __('report.filters')])
        
            <div class="col-md-3">
                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas" type="text" class="form-control">
                        <option>4 A</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tahun Ajaran</label>
                    <select name="kelas" type="text" class="form-control">
                        <option>2024/2025 (Semester 1)</option>
                        <option>2024/2025 (Semester 2)</option>
                    </select>
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
                    <li>
                        <a 
                            href="#"
                            onclick='$("#editor_modal").modal("show")'
                        >
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>Sakit</th>
                                        <th>Izin</th>
                                        <th>Tanpa Keterangan</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>123</td>
                                        <td>Juliani Okta Farida</td>
                                        <td>13</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>
                                            <a 
                                                class="btn btn-primary btn-xs" 
                                                href="#"
                                                onclick='$("#editor_modal").modal("show")'
                                            >
                                                Edit
                                            </a>
                                            <a 
                                                class="btn btn-danger btn-xs" 
                                                href="#"
                                                target="_blank"
                                            >
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
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
                columnDefs: [ {
                    "targets": [0],
                    "orderable": false,
                    "searchable": false
                } ],
                // processing: true,
                // serverSide: true,
                // "ajax": {
                //     "url": "/reservasi/data",
                //     "data": function ( d ) {
                //         d.datatable = 1;
                //         d.date = $("#tanggal_filter").val();

                //         d = __datatable_ajax_callback(d);
                //     }
                // },
                // columns: [
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                // ]
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