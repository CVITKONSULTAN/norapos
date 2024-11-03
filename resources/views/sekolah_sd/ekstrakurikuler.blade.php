@extends('layouts.app')
@section('title', "Ekstrakurikuler")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Ekstrakurikuler</h1>
</section>

<!-- Main content -->

<section class="content">

    <div id="editor_modal_ekskul" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
	                <h4 class="modal-title">
                        Form Ekstrakurikuler
                    </h4>
                </div>
                <form id="form_ekskul" method="POST" action="{{route('sekolah_sd.ekskul.store')}}">
                    @csrf
                    <input type="hidden" name="insert" value="1" />
                    <input type="hidden" name="update" value="0" />
                    <input type="hidden" name="id" value="0" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Ekstrakurikuler</label>
                            <input name="nama" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select required name="kategori" class="form-control">
                                <option value="wajib">Wajib</option>
                                <option value="pilihan">Pilihan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Ekstrakurikuler Siswa</a>
                    </li>
                    <li class="">
                        <a href="#ekskul" data-toggle="tab" aria-expanded="true"><i class="fa fa-list" aria-hidden="true"></i> Data Ekstrakurikuler</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="text-right" style="margin-bottom: 10px;">
                            <a target="_blank" href="{{ route('sekolah_sd.ekskul.create') }}" class="btn btn-primary">Tambah</a>
                        </div>
                        <div class="table-responsive">
                            <table width="100%" class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>Ekstrakurikuler</th>
                                        <th>Kategori</th>
                                        <th>Keterangan</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>1234</td>
                                        <td>Juliani Okta Farida</td>
                                        <td>Pramuka</td>
                                        <td>Wajib</td>
                                        <td></td>
                                        <td>
                                            <a 
                                                target="_blank" 
                                                href="{{ route('sekolah_sd.ekskul.create') }}" 
                                                class="btn btn-primary btn-xs"
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
                    <div class="tab-pane" id="ekskul">
                        <div class="text-right" style="margin-bottom: 10px;">
                            <button onclick='addEkskul()' class="btn btn-primary">Tambah</button>
                        </div>
                        <div class="table-responsive">
                            <table width="100%" class="table table-bordered table-striped ajax_view hide-footer" id="ekskul_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ekstrakurikuler</th>
                                        <th>Kategori</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Pramuka</td>
                                        <td>Wajib</td>
                                        <td>
                                            <button
                                                class="btn btn-primary btn-xs" 
                                                onclick='$("#editor_modal_ekskul").modal("show")'
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

        $("#form_ekskul").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    console.log("result",result);
                    if(result.success == true){
                        toastr.success(result.msg);
                        ekskul_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                    $("#form_ekskul").trigger("reset");
                    $("#editor_modal_ekskul").modal("hide");
                },
                error: function(e) {
                    console.log(e);
                },
                complete:()=>{
                    $(this).find('button').removeAttr('disabled')
                }
            });
        }));

        const addEkskul = () => {
            const modals_dom = $("#editor_modal_ekskul");
            modals_dom.find('input[name=insert]').val(1);
            modals_dom.find('input[name=update]').val(0);
            modals_dom.find('input[name=id]').val(0);
            modals_dom.find('input[name=nama]').val("");
            modals_dom.find('select[name=kategori]').val("");
            modals_dom.modal('show');
        }

        const editEkskul = (id,nama,kategori) => {
            const modals_dom = $("#editor_modal_ekskul");
            modals_dom.find('input[name=insert]').val(0);
            modals_dom.find('input[name=update]').val(1);
            modals_dom.find('input[name=id]').val(id);
            modals_dom.find('input[name=nama]').val(nama);
            modals_dom.find('select[name=kategori]').val(kategori);
            modals_dom.modal('show');
        }

        let ekskul_table;

        $(document).ready( function(){

            ekskul_table = $('#ekskul_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('sekolah_sd.ekskul.data') }}"
                },
                columns: [
                    {data:'id'},
                    {data:'nama'},
                    {data:'kategori'},
                    {
                        searchable: false,
                        data: 'id',
                        className:"text-center",
                        render:(data,type,row)=> {
                            const template = `
                                <button 
                                    class="btn btn-primary btn-xs" 
                                    onclick="editEkskul(${data},'${row.nama}','${row.kategori}')"
                                >
                                    Edit
                                </button>
                                <a 
                                    class="btn btn-danger btn-xs delete-product" 
                                    href="{{ route('sekolah_sd.ekskul.store') }}/${data}"
                                    data-id="${data}"
                                >
                                    Hapus
                                </a>
                            `
                            return template;
                        }
                    }
                ]
            });
            
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

            $('table#ekskul_table tbody').on('click', 'a.delete-product', function(e){
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
                                    ekskul_table.ajax.reload();
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