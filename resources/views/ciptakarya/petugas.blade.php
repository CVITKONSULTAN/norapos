@extends('layouts.app')
@section('title', 'Data Petugas Lapangan')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Data Petugas Lapangan</h1>
</section>


<div id="editor_modal_pengajuan" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Input Data Pengajuan
                </h4>
            </div>
            <form id="form_pengajuan" method="POST" 
            action="{{route('ciptakarya.store_petugas_lapangan')}}"
            >
                @csrf
                <input type="hidden" name="tipe" value="PBG" />
                <input type="hidden" name="insert" value="1" />
                <input type="hidden" name="update" value="0" />
                <input type="hidden" name="id" value="0" />
                <div class="modal-body">
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Petugas :</label>
                        <div class="col-sm-9">
                            <input name="nama" class="form-control" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email :</label>
                        <div class="col-sm-9">
                            <input name="email" type="email" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bidang :</label>
                        <div class="col-sm-9">
                            <input name="bidang" class="form-control" value="ciptakarya" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jabatan :</label>
                        <div class="col-sm-9">
                            <input name="jabatan" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIP :</label>
                        <div class="col-sm-9">
                            <input name="nip" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIK :</label>
                        <div class="col-sm-9">
                            <input name="nik" class="form-control" />
                        </div>
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

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => ""])
        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
                <button onclick="addData()" class="btn btn-success btn-block btn-lg"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data Petugas Baru</button>
            </div>
        </div>
    @endcomponent
    @component('components.widget', ['class' => 'box-primary', 'title' => "Daftar Petugas"])
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="product_table">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Bidang</th>
                            <th>Jabatan / Golongan</th>
                            <th>NIP</th>
                            <th>NIK</th>
                            <th>Created At</th>
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
    @endcomponent
</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <!-- Localization HARUS ditaruh SETELAH jquery.validate.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_id.min.js"></script>
    <script>
        const product_table = $('#product_table').DataTable({
            processing: true,
            serverSide: true,
            dom: 'lBfrtip',
            paging: true,
            order: [], // ✅ Nonaktifkan sorting default!
            // buttons: [
            //     {
            //         extend: 'excelHtml5',
            //         text: 'Export ke Excel',
            //         title: 'Data Pengajuan',
            //         className: 'btn btn-success'
            //     }
            // ],
            lengthMenu: [[-1, 10, 25, 50], ["Semua", 10, 25, 50]],
            pageLength: 10,
            ajax: {
                url: '{{ route("ciptakarya.list_data_petugas_datatables") }}', // Ganti dengan route pengajuan kamu
                data: function(d) {
                    // Tambahkan filter jika ada, contoh:
                    // d.status = $("#filter_status").val();
                    d = __datatable_ajax_callback(d);
                }
            },
            columns: [
                { data: 'nama', render: data => data || '-' },
                { data: 'email', render: data => data || '-' },
                { data: 'bidang', render: data => `<span class="badge badge-info">${data}</span>` },
                { data: 'jabatan', render: data => data || '-' },
                { data: 'nip', render: data => data || '-' },
                { data: 'nik', render: data => data || '-' },
                { 
                    data: 'created_at',
                    render: data => moment(data).format('DD/MM/YYYY HH:mm')
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row) => {
                        return `
                            <button data-id="${data}" class="btn btn-sm btn-primary edit_petugas">Edit</button>
                            <button data-id="${data}" class="btn btn-sm btn-danger delete_petugas">Hapus</button>
                        `;
                    }
                }
            ]
        });


        $(document).on('click', 'button.delete_petugas', function(){
            swal({
                title: LANG.sure,
                text: "Data petugas akan dihapus. Lanjutkan?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    const href = "{{ route('ciptakarya.store_petugas_lapangan') }}"; // route yang sama seperti add/update
                    const id = $(this).data('id');

                    $.ajax({
                        method: "POST",
                        url: href,
                        dataType: "json",
                        data: {
                            delete: 1,
                            id: id,
                            _token: "{{ csrf_token() }}" // keamanan laravel
                        },
                        success: function(result){
                            if(result.status){
                                toastr.success(result.message);
                                product_table.ajax.reload();
                            } else {
                                toastr.error(result.message);
                            }
                        },
                        error: function(){
                            toastr.error("Gagal menghapus data!");
                        }
                    });
                }
            });
        });


        const addData = () =>{
            const modals = $("#editor_modal_pengajuan");
            modals.find('.modal-title').text('Input Data Petugas'); // reset title
            modals.find('form')[0].reset(); // reset semua input
            modals.find('input[name=insert]').val("1");
            modals.find('input[name=update]').val("0");
            modals.find('input[name=id]').val("0");
            modals.find('input[name=bidang]').val("ciptakarya");
            modals.modal('show');
        }

        // Trigger click edit dari tombol
        $(document).on('click', '.edit_petugas', function () {
            const id = $(this).data('id');
            
            // Ambil data row dari DataTables (langsung dari data yang sudah ada, tanpa AJAX baru)
            const data = product_table.row($(this).parents('tr')).data();
            
            const modals = $("#editor_modal_pengajuan");
            modals.find('.modal-title').text('Edit Data Petugas');

            // Set form ke mode EDIT
            modals.find('input[name=insert]').val("0"); 
            modals.find('input[name=update]').val("1"); 
            modals.find('input[name=id]').val(id);

            // Isi data form
            modals.find('input[name=nama]').val(data.nama);
            modals.find('input[name=email]').val(data.email);
            modals.find('input[name=bidang]').val(data.bidang);
            modals.find('input[name=jabatan]').val(data.jabatan);
            modals.find('input[name=nip]').val(data.nip);
            modals.find('input[name=nik]').val(data.nik);

            // Tampilkan modal
            modals.modal('show');
        });

        $("#form_pengajuan").validate({
            ignore: [],
            submitHandler: function(form) {
                // Ambil semua input jadi JSON
                let formData = {};
                $("#form_pengajuan").serializeArray().forEach((item) => {
                    // Handle multiple value array seperti "uploaded_files[]"
                    if (formData[item.name]) {
                        if (!Array.isArray(formData[item.name])) {
                            formData[item.name] = [formData[item.name]];
                        }
                        formData[item.name].push(item.value);
                    } else {
                        formData[item.name] = item.value;
                    }
                });

                // Kirim via AJAX
                $.ajax({
                    url: form.action, // GANTI dengan rute submit kamu
                    method: form.method,
                    data: JSON.stringify(formData),
                    contentType: "application/json",
                    success: function (res) {
                        if (res.status) {
                            swal({
                                icon: 'success',
                                title: "Berhasil!",
                                text: res.message,
                                timer: 1500,
                                buttons: false
                            }).then(() => {
                                $('#editor_modal_pengajuan').modal('hide');
                            });
                            product_table.ajax.reload();
                        } else {
                            swal({
                                icon: 'warning',
                                title: "Peringatan!",
                                text: res.message,
                                button: "OK"
                            });
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        swal({
                            icon: "error",
                            title: "Kesalahan Server!",
                            text: "Terjadi kesalahan, silakan coba lagi.",
                            button: "OK"
                        });
                    }
                });

                return false; // Hentikan submit normal
            }
        });
    </script>
@endsection
