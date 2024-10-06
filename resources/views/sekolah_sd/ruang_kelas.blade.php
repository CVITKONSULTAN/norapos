@extends('layouts.app')
@section('title', "Tabel Kelas/Siswa")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Tabel Kelas/Siswa</h1>
</section>

<!-- Main content -->
<div id="editor_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_kelas" method="POST" action="{{route('sekolah_sd.kelas_repo.store')}}">
                @csrf
                <input value="1" type="hidden" name="insert" />
                <input value="0" type="hidden" name="update" />
                <input value="0" type="hidden" name="id" />
                <div class="modal-header">
                    <h4 class="modal-title">
                        Kelas / Tahun Ajaran
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" required class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <input type="text" name="semester" required class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="nama_kelas" required class="form-control" />
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

<div id="editor_kelas_siswa_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_kelas_siswa" method="POST" action="{{route('sekolah_sd.kelas_repo.store')}}">
                @csrf
                <input value="1" type="hidden" name="insert" />
                <input value="0" type="hidden" name="update" />
                <input value="0" type="hidden" name="id" />
                <div class="modal-header">
                    <h4 class="modal-title">
                        Kelas / Tahun Ajaran
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" required class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <input type="text" name="semester" required class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="nama_kelas" required class="form-control" />
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
                    <li>
                        <a href="#kelas_ajar_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list" aria-hidden="true"></i> Kelas / Tahun Ajaran</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="text-right" style="margin-bottom: 10px;">
                            <button onclick="tambahKelasSiswa()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>NISN</td>
                                        <td>NAMA LENGKAP</td>
                                        <td>KELAS</td>
                                        <td>TAHUN AJARAN</td>
                                        <td>Tindakan</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="kelas_ajar_list_tab">
                        <div class="text-right" style="margin-bottom: 10px;">
                            <button onclick="tambahKelas()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
                        </div>
                        <div class="table-responsive">
                            <table width="100%" class="table table-bordered table-striped ajax_view hide-footer" id="kelas_table">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>TAHUN AJARAN</td>
                                        <td>SEMESTER</td>
                                        <td>NAMA KELAS</td>
                                        <td>Tindakan</td>
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
    <script type="text/javascript">

        const tambahKelasSiswa = () => {
            const modals_dom = $("#editor_modal");
            modals_dom.find('input:not([type=hidden])').val("");
            modals_dom.find('input[name=insert]').val(1);
            modals_dom.find('input[name=update]').val(0);
            modals_dom.find('input[name=id]').val(0);
            modals_dom.modal('show');
        }

        $(document).ready( function(){
            product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{route('sekolah_sd.kelas.data')}}",
                    // "data": function ( d ) {
                    //     d.datatable = 1;
                    //     d.date = $("#tanggal_filter").val();

                    //     d = __datatable_ajax_callback(d);
                    // }
                },
                columns: [
                    { data: 'id'  },
                    { data: 'siswa.nisn'  },
                    { data: 'siswa.nama'  },
                    { data: 'kelas.nama_kelas'  },
                    { data: 'kelas.tahun_ajaran'  },
                    { 
                        data: 'id',
                        className:"text-center",
                        render:(data)=> {
                            const template = `
                                <button 
                                    class="btn btn-primary btn-xs" 
                                    onclick="editKelas(${data})"
                                >
                                    Edit
                                </button>
                                <a 
                                    class="btn btn-danger btn-xs delete-product" 
                                    href="{{ route('sekolah_sd.kelas_repo.store') }}"
                                    data-id="${data}"
                                    target="_blank"
                                >
                                    Hapus
                                </a>
                            `
                            return template;
                        }
                    },
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

        const tambahKelas = () => {
            const modals_dom = $("#editor_modal");
            modals_dom.find('input:not([type=hidden])').val("");
            modals_dom.find('input[name=insert]').val(1);
            modals_dom.find('input[name=update]').val(0);
            modals_dom.find('input[name=id]').val(0);
            modals_dom.modal('show');
        }

        const editKelas = (id) => {
            const modals_dom = $("#editor_modal");
            const href = "{{route('sekolah_sd.kelas_repo.store')}}";
            $.ajax({
                method: "POST",
                url: href,
                data: {
                    show:1,
                    id:id
                },
                dataType: "json",
                beforeSend: () => {
                    modals_dom.find('input:not([type=hidden])').attr('disabled');
                    modals_dom.find('button').attr('disabled');
                },
                complete: () => {
                    modals_dom.find('input:not([type=hidden])').removeAttr('disabled');
                    modals_dom.find('button').removeAttr('disabled');
                },
                success: function(result){
                    const {data} = result;
                    if(!data) return;
                    modals_dom.find('input[name=tahun_ajaran]').val( data.tahun_ajaran );
                    modals_dom.find('input[name=semester]').val( data.semester );
                    modals_dom.find('input[name=nama_kelas]').val( data.nama_kelas );
                }
            })
            
            modals_dom.find('input[name=insert]').val(0);
            modals_dom.find('input[name=update]').val(1);
            modals_dom.find('input[name=id]').val(id);
            modals_dom.modal('show');
        }

        $("#form_kelas").on('submit', (function(e) {
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
                    kelas_table.ajax.reload();
                } else {
                    toastr.error(result.msg);
                }
                $("#form_kelas").trigger("reset"); // to reset form input fields
                $("#editor_modal").modal("hide");
            },
            error: function(e) {
                console.log(e);
            }
            });
        }));

        let kelas_table;

        $(document).ready( function(){
            kelas_table = $('#kelas_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('sekolah_sd.kelas_repo.data') }}",
                },
                columns: [
                    { data: 'id'  },
                    { data: 'tahun_ajaran'  },
                    { data: 'semester'  },
                    { data: 'nama_kelas'  },
                    { 
                        data: 'id',
                        className:"text-center",
                        render:(data)=> {
                            const template = `
                                <button 
                                    class="btn btn-primary btn-xs" 
                                    onclick="editKelas(${data})"
                                >
                                    Edit
                                </button>
                                <a 
                                    class="btn btn-danger btn-xs delete-product" 
                                    href="{{ route('sekolah_sd.kelas_repo.store') }}"
                                    data-id="${data}"
                                    target="_blank"
                                >
                                    Hapus
                                </a>
                            `
                            return template;
                        }
                    },
                ]
            });

            $('table#kelas_table tbody').on('click', 'a.delete-product', function(e){
                e.preventDefault();
                const id = $(this).data('id')
                swal({
                  title: LANG.sure,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: "POST",
                            url: href,
                            data: {
                                delete:1,
                                id:id
                            },
                            dataType: "json",
                            success: function(result){
                                if(result.success == true){
                                    toastr.success(result.msg);
                                    kelas_table.ajax.reload();
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