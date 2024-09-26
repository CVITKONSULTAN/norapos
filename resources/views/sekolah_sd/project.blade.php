@extends('layouts.app')
@section('title', "Raport Project Siswa")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Raport Project Siswa</h1>
</section>

<!-- Main content -->

<section class="content">

    <div id="editor_modal_project" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
	                <h4 class="modal-title">
                        Form Data Project
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Project</label>
                        <input class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea rows="5" class="form-control"></textarea>
                    </div>
                    <hr />
                        <h3 class="text-center">Indikator Penilaian</h3>
                    <hr />
                    <div class="indikator_penilaian_container row">
                        <div class="form-group col-sm-6">
                            <label>Indikator 1.</label>
                            <textarea rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Indikator 2.</label>
                            <textarea rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                  </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Raport Project Siswa</a>
                    </li>
                    <li class="">
                        <a href="#ekskul" data-toggle="tab" aria-expanded="true"><i class="fa fa-list" aria-hidden="true"></i> Data Project</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="text-right" style="margin-bottom: 10px;">
                            <a target="_blank" href="{{ route('sekolah_sd.project.create') }}" class="btn btn-primary">Tambah</a>
                        </div>
                        <div class="table-responsive">
                            <table width="100%" class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Fase</th>
                                        <th>Tahun</th>
                                        <th>Nama Projek</th>
                                        <th>Deksripsi Projek</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>1234</td>
                                        <td>Juliani Okta Farida</td>
                                        <td>4A</td>
                                        <td></td>
                                        <td>2024</td>
                                        <td>Membuat tas siaga Bencana</td>
                                        <td>Dengan project ini siswa diharapkan dapat...</td>
                                        <td>
                                            <a 
                                                target="_blank" 
                                                href="{{ route('sekolah_sd.project.create') }}" 
                                                class="btn btn-primary btn-xs"
                                            >
                                                Edit
                                            </a>
                                            <a 
                                                target="_blank" 
                                                href="{{ route('sekolah_sd.project.create') }}" 
                                                class="btn btn-primary btn-xs"
                                            >
                                                Lihat
                                            </a>
                                            {{-- <a 
                                                class="btn btn-danger btn-xs" 
                                                href="#"
                                                target="_blank"
                                            >
                                                Hapus
                                            </a> --}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="ekskul">
                        <div class="text-right" style="margin-bottom: 10px;">
                            <button onclick='$("#editor_modal_project").modal("show")' class="btn btn-primary">Tambah</button>
                        </div>
                        <div class="table-responsive">
                            <table width="100%" class="table table-bordered table-striped ajax_view hide-footer" id="ekskul_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Project</th>
                                        <th>Deskripsi</th>
                                        <th>Indikator Penilaian</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Membuat tas siaga Bencana</td>
                                        <td>Dengan project ini siswa diharapkan dapat...</td>
                                        <td>
                                            <ol>
                                                <li>Indikator penilaian pertama</li>
                                                <li>Indikator penilaian kedua</li>
                                                <li>Indikator penilaian ketiga</li>
                                            </ol>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-primary btn-xs" 
                                                onclick='$("#editor_modal_project").modal("show")'
                                            >
                                                Edit
                                        </button>
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
            $('#ekskul_table').DataTable();
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