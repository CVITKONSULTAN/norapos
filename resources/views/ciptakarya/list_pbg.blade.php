@extends('layouts.app')
@section('title', 'Data Pemohon / Pengajuan')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" referrerpolicy="no-referrer" />
<style>
    #dropzone_pengajuan .dz-message {
        display: block !important;
        opacity: 0.6;
        text-align: center;
        padding: 40px 0;
    }
</style>
@endsection


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Data Pemohon / Pengajuan</h1>
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
            action="{{route('ciptakarya.store_pbg')}}"
            >
                @csrf
                <input type="hidden" name="tipe" value="PBG" />
                <input type="hidden" name="insert" value="1" />
                <input type="hidden" name="update" value="0" />
                <input type="hidden" name="id" value="0" />
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nomor Permohonan :</label>
                        <div class="col-sm-9">
                        <input name="no_permohonan" class="form-control" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nomor KRK / KKPR :</label>
                        <div class="col-sm-9">
                        <input name="no_krk" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Pemohon :</label>
                        <div class="col-sm-9">
                        <input name="nama_pemohon" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIK :</label>
                        <div class="col-sm-9">
                        <input name="nik" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alamat :</label>
                        <div class="col-sm-9">
                        <textarea name="alamat" rows="3" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Fungsi Bangunan :</label>
                        <div class="col-sm-9">
                        <input name="fungsi_bangunan" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Bangunan :</label>
                        <div class="col-sm-9">
                        <input name="nama_bangunan" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jumlah Bangunan :</label>
                        <div class="col-sm-9">
                        <input name="jumlah_bangunan" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jumlah Lantai :</label>
                        <div class="col-sm-9">
                        <input name="jumlah_lantai" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Luas Bangunan :</label>
                        <div class="col-sm-9">
                        <input name="luas_bangunan" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Lokasi Bangunan :</label>
                        <div class="col-sm-9">
                        <textarea name="lokasi_bangunan" rows="3" class="form-control"></textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Di atas tanah No. Persil :</label>
                        <div class="col-sm-9">
                        <input name="no_persil" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Luas Tanah :</label>
                        <div class="col-sm-9">
                        <input name="luas_tanah" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Atas nama / pemilik tanah :</label>
                        <div class="col-sm-9">
                        <input name="pemilik_tanah" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Garis Sempadan Bangunan (GBS) minimum :</label>
                        <div class="col-sm-9">
                        <input name="gbs_min" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Koefisien Daerah Hijau (KDH) minimum :</label>
                        <div class="col-sm-9">
                        <input name="kdh_min" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Koefisien Dasar Bangunan (KDB) maksimum :</label>
                        <div class="col-sm-9">
                        <input name="kdb_max" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Upload Dokumen :</label>
                        <div class="col-sm-9">
                            <div id="dropzone_pengajuan" class="dropzone border rounded p-3">
                                <div class="dz-message">Tarik & lepaskan file di sini atau klik untuk unggah</div>
                            </div>
                            <small class="text-muted">Format: PDF, JPG, PNG — Max 5MB per file</small>

                            <!-- List file hasil upload -->
                            <ul id="list_uploaded_file" class="mt-3"></ul>
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
            <div class="col-sm-4">
                <button onclick="addPengajuan('PBG')" class="btn btn-success btn-block btn-lg"><i class="fa fa-plus-circle" aria-hidden="true"></i> Pengajuan PBG</button>
            </div>
            <div class="col-sm-4">
                <button onclick="addPengajuan('SLF')" class="btn btn-danger btn-block btn-lg"><i class="fa fa-plus-circle" aria-hidden="true"></i> Pengajuan SLF</button>
            </div>
            <div class="col-sm-4">
                <button onclick="addPengajuan('PBG/SLF')" class="btn btn-primary btn-block btn-lg"><i class="fa fa-plus-circle" aria-hidden="true"></i> Pengajuan PBG & SLF</button>
            </div>
        </div>
    @endcomponent
    @component('components.widget', ['class' => 'box-primary', 'title' => "Daftar Pemohon PBG dan SLF"])
            <p>Filter Data :</p>
            <div class="row">
                <div class="form-group col-md-2">
                    <select class="form-control" required>
                        <option>-- Pilih Tahun --</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" required>
                        <option>-- Pilih Kategori Permohonan --</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" required>
                        <option>-- Pilih Jenis Izin --</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control" required>
                        <option>-- Pilih Status --</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Tampilkan Data</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="product_table">
                    <thead>
                        <tr>
                            <th>Tgl Input</th>
                            <th>No. Permohonan</th>
                            <th>Nama Pemohon</th>
                            <th>Jenis Izin</th>
                            <th>Jenis / Kategori</th>
                            <th>Tgl Pengajuan</th>
                            <th>Status</th>
                            <th>Petugas</th>
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
                url: '{{ route("ciptakarya.list_data_pbg_datatables") }}', // Ganti dengan route pengajuan kamu
                data: function(d) {
                    // Tambahkan filter jika ada, contoh:
                    // d.status = $("#filter_status").val();
                    d = __datatable_ajax_callback(d);
                }
            },
            columns: [
                { data: 'created_at', render: (data) => data || '-' },
                { data: 'no_permohonan', render: (data) => data || '-' },
                { data: 'nama_pemohon', render: (data) => data || '-' },
                { data: 'tipe', render: (data) => `<span class="badge badge-info">${data || '-'}</span>` },
                { data: 'fungsi_bangunan', render: (data) => data || '-' },
                { 
                    data: 'created_at',
                    render: (data) => moment(data).format('DD/MM/YYYY HH:mm') 
                },
                { 
                    data: 'status', 
                    render: (data) => {
                        let label = data ? data.toUpperCase() : 'PENDING';
                        let color = data === 'approved' ? 'success' : (data === 'rejected' ? 'danger' : 'warning');
                        return `<span class="badge badge-${color}">${label}</span>`;
                    } 
                },
                { data: 'petugas', render: (data) => data || '-' },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: (data, type, row) => {
                        return `
                            <button data-id="${data}" class="btn btn-sm btn-primary edit_pengajuan">Edit</button>
                            <button data-id="${data}" class="btn btn-sm btn-danger delete_pengajuan">Hapus</button>
                        `;
                    }
                }
            ]
        });



        $(document).on('click', 'button.delete_user_button', function(){
            swal({
            title: LANG.sure,
            text: LANG.confirm_delete_user,
            icon: "warning",
            buttons: true,
            dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    const href = "{{ route('absensi.store') }}";
                    const id = $(this).data('id');
                    $.ajax({
                        method: "POST",
                        url: href,
                        dataType: "json",
                        data: {delete:1,id:id},
                        success: function(result){
                            if(result.status){
                                toastr.success(result.message);
                                product_table.ajax.reload();
                            } else {
                                toastr.error(result.message);
                            }
                        }
                    });
                }
            });
        });

        const addPengajuan = (tipe) =>{
            uploadedFiles = [];
            // Kosongkan list file manual
            $('#list_uploaded_file').html('');
            const modals = $("#editor_modal_pengajuan")
            modals.find('input[type!=hidden]').val("");
            modals.modal('show');
        }

        Dropzone.autoDiscover = false;

        let uploadedFiles = [];

        var dzPengajuan = new Dropzone("#dropzone_pengajuan", {
            url: "{{ route('upload') }}", // Ganti ke route upload kamu
            paramName: "file_data",
            maxFilesize: 5, 
            acceptedFiles: ".pdf,.jpg,.jpeg,.png",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            uploadMultiple: false, // upload per file
            parallelUploads: 5, // allow multiple queued
            addRemoveLinks: false, // ❌ Matikan tombol hapus default
            previewTemplate: `<span></span>`, // ❌ Nonaktifkan tampilan preview kartu bawaan Dropzone
            dictRemoveFile: "Hapus",
            init: function () {
                this.on("success", function (file, response) {
                    console.log(response);
                    if (response.status === true && response.data) {
                        response.data = `/uploads/media/${response.data}`
                        uploadedFiles.push(response.data); // SIMPAN URL KE ARRAY
                        addFileToList(file.name, response.data); // file.name = nama asli, response.data = URL file
                        console.log("uploadedFiles",uploadedFiles);
                    }
                });

                this.on("removedfile", function (file) {
                    // Bisa tambahkan request delete ke backend kalau mau
                    console.log("File dihapus dari dropzone: ", file.name);
                    uploadedFiles = uploadedFiles.filter(url => url !== file.upload?.url);
                });
                this.on("error", function (file, message) {
                    // Hapus file dari dropzone
                    this.removeFile(file);
                    alert("Upload gagal: " + message);
                });
            }
        });

        dzPengajuan.on("success", function() {
            $('#dropzone_pengajuan .dz-message').show();
        });

        dzPengajuan.on("removedfile", function() {
            if (uploadedFiles.length === 0) {
                $('#dropzone_pengajuan .dz-message').show();
            }
        });

        // Fungsi untuk generate DOM file list
        function addFileToList(name, url) {
            $('#list_uploaded_file').append(`
                <li class="d-flex justify-content-between align-items-center border-bottom py-1">
                    <a href="${url}" target="_blank">${name}</a>
                    <input type="hidden" name="uploaded_files[]" value="${url}">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-file" data-url="${url}">Hapus</button>
                </li>
            `);
        }

        // Event hapus file dari list (opsional kirim ke backend)
        $(document).on('click', '.btn-remove-file', function () {
            const url = $(this).data('url');
            $(this).closest('li').remove();

            // optional: panggil ajax untuk hapus file di server
            /*
            $.post('/hapus-file', { url: url, _token: $('meta[name="csrf-token"]').attr('content') });
            */
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

                // Tambahkan hasil Dropzone
                formData.uploaded_files = uploadedFiles;

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
