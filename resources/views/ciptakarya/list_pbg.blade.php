@extends('layouts.app')
@section('title', 'Data Pemohon / Pengajuan')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
<style>
    #dropzone_pengajuan .dz-message {
        display: block !important;
        opacity: 0.6;
        text-align: center;
        padding: 40px 0;
    }
    .timeline {
        position: relative;
        margin: 40px 0;
        padding-left: 80px;
    }

    .timeline:before {
        content: "";
        position: absolute;
        left: 110px;
        top: 0;
        width: 4px;
        height: 100%;
        background: #f4c542; /* warna kuning */
    }

    .timeline-item {
        position: relative;
        margin-bottom: 40px;
        display: flex;
        align-items: flex-start;
    }

    .timeline-year {
        width: 60px;
        font-size: 22px;
        font-weight: bold;
        color: #333;
        margin-right: 40px;
        text-align: right;
    }

    .timeline-icon {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: white;
        border: 4px solid #f4c542;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 25px;
        position: relative;
        z-index: 10;
    }

    .timeline-icon.active {
        background: #f4c542;
    }

    .timeline-icon img {
        width: 28px;
        height: 28px;
        filter: invert(15%) sepia(5%) saturate(10%) hue-rotate(0deg) brightness(20%);
    }

    .timeline-content {
        max-width: 450px;
    }

    .timeline-content h3 {
        font-size: 18px;
        margin: 0 0 4px;
    }

    .timeline-content p {
        margin: 0;
        color: #444;
    }

</style>
@endsection


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Data Pemohon / Pengajuan</h1>
</section>

<!-- UNIVERSAL MODAL RETRIBUSI -->
<div id="modal_retribusi" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-calculator"></i> Input Nilai Retribusi</h4>
            </div>

            <div class="modal-body">

                <input type="hidden" id="ret_id" value="">

                <!-- NILAI RETRIBUSI -->
                <div class="form-group">
                    <label><b>Nilai Retribusi (Rp)</b></label>
                    <input type="text" id="nilai_retribusi" class="form-control" 
                        placeholder="Masukkan nilai retribusi" required>
                </div>

                <!-- UPLOAD FILE EXCEL -->
                <div class="form-group">
                    <label><b>Upload File Excel Retribusi</b></label>
                    <input type="file" id="excel_retribusi" class="form-control" 
                        accept=".xls,.xlsx" required>
                    <small class="text-muted">Format wajib: .xls atau .xlsx</small>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" id="btn_simpan_retribusi">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>


<div id="modal_pilih_petugas" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Petugas Lapangan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="pengajuan_id_target" value="">
                <div class="form-group">
                    <label>Pilih Petugas:</label>
                    <select id="select_petugas" class="form-control" style="width:100%"></select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btn_simpan_petugas">Simpan</button>
                <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

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
                        {{-- <input name="fungsi_bangunan" class="form-control" /> --}}
                            <select name="fungsi_bangunan" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Khusus">Khusus </option>
                                <option value="Sosial Budaya">Sosial Budaya</option>
                                <option value="Hunian">Hunian </option>
                                <option value="Usaha">Usaha </option>
                                <option value="Keagamaan">Keagamaan </option>
                            </select>
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
                        <label class="col-sm-3 col-form-label">Ketinggian Bangunan :</label>
                        <div class="col-sm-9">
                        <input name="ketinggian_bangunan" class="form-control" />
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
                        <label class="col-sm-3 col-form-label">Koefisien Lantai Bangunan (KLB) maksimum :</label>
                        <div class="col-sm-9">
                        <input name="koefisiensi_lantai" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Koordinat Bangunan:</label>
                        <div class="col-sm-9">
                        <input name="koordinat_bangunan" class="form-control" />
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

<!-- MODAL RIWAYAT -->
<div id="modal_timeline" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Riwayat Proses Pengajuan</h4>
            </div>

            <div class="modal-body">
                <div id="timeline_container">
                    <!-- timeline akan di-inject via JS -->
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>


<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => ""])
    @if( auth()->user()->checkRole('admin') )
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
    @endif
    @endcomponent
    @component('components.widget', ['class' => 'box-primary', 'title' => "Daftar Pemohon PBG dan SLF"])
            <p>Filter Data :</p>
            <div class="row">
                <div class="form-group col-md-2">
                    <select id="filter_tahun" class="form-control" required>
                        <option value="">-- Semua Tahun --</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select id="filter_kategori" class="form-control" required>
                        <option value="">-- Semua Kategori Permohonan --</option>
                        <option value="Khusus">Khusus </option>
                        <option value="Sosial Budaya">Sosial Budaya</option>
                        <option value="Hunian">Hunian </option>
                        <option value="Usaha">Usaha </option>
                        <option value="Keagamaan">Keagamaan </option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select id="filter_jenis" class="form-control" required>
                        <option value="">-- Semua Jenis Izin --</option>
                        <option value="PBG">PBG</option>
                        <option value="SLF">SLF</option>
                        <option value="PBG/SLF">PBG/SLF</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <select id="filter_status" class="form-control" required>
                        <option value="">-- Semua Status --</option>
                        <option selected value="proses">PROSES</option>
                        <option value="gagal">GAGAL</option>
                        <option value="terbit">TERBIT</option>
                    </select>
                </div>
                <div class="form-group">
                    <button onclick="filteringData()" class="btn btn-primary">Tampilkan Data</button>
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
                            <th>Nilai Retribusi</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>

    <!-- Localization HARUS ditaruh SETELAH jquery.validate.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_id.min.js"></script>

    <script>

        const product_table = $('#product_table').DataTable({
            processing: true,
            serverSide: true,
            dom: 'lBfrtip',
            paging: true,
            order: [], // ✅ Nonaktifkan sorting default!
            lengthMenu: [[-1, 10, 25, 50], ["Semua", 10, 25, 50]],
            pageLength: 10,
            ajax: {
                url: '{{ route("ciptakarya.list_data_pbg_datatables") }}', // Ganti dengan route pengajuan kamu
                data: function(d) {
                    d = __datatable_ajax_callback(d);
                    d.tahun = $('#filter_tahun').val();
                    d.kategori = $('#filter_kategori').val();
                    d.jenis = $('#filter_jenis').val();
                    d.status = $('#filter_status').val();
                }
            },
            columns: [
                { data: 'created_at', render: (data) => data || '-' },
                { data: 'no_permohonan', render: (data) => data || '-' },
                { data: 'nama_pemohon', render: (data) => data || '-' },
                { data: 'tipe', render: (data) =>{
                    let status = "gray";
                    if(data == "PBG") status = "blue"
                    if(data == "SLF") status = "yellow"
                    if(data == "PBG/SLF") status = "green"
                    return `<span class="badge bg-${status}">${data || '-'}</span>`
                }
                },
                { data: 'fungsi_bangunan', render: (data) => data || '-' },
                { 
                    data: 'created_at',
                    render: (data) => moment(data).format('DD/MM/YYYY HH:mm') 
                },
                { 
                    data: 'status', 
                    render: (data) => {
                        if(data == 'pending') data = "PROSES";
                        let label = data ? data.toUpperCase() : 'PROSES';
                        let color = data === 'terbit' ? 'green' : (data === 'gagal' ? 'red' : 'blue');
                        return `<span class="badge bg-${color}">${label}</span>`;
                    } 
                },
                {
                    data: 'nilai_retribusi',
                    render: (data,_,row) => {
                        let str = formatRupiah(data);
                        if(row.excel_retribusi){
                            str += `<br /><br /><a target="_blank" href="${'/uploads/'+row.excel_retribusi}""><i class="fa fa-file"></i> Download file retribusi</a>`
                        }
                        return str;
                    }
                },
                { data: 'petugas', render: (data,_,row) => {
                    let nama = data?.nama ?? '';
                    if(row.tgl_penugasan){
                        const tgl = moment(row.tgl_penugasan).format('DD/MM/YYYY HH:mm') 
                        nama += ` (${tgl})`;
                    }
                    return nama;
                }},
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {

                        if(row.status.toLowerCase() == 'terbit'){
                            return `<a href="print/${data}" class="btn btn-sm btn-success">
                                    <i class="fa fa-print"></i> Cetak
                                </a>
                                <button data-id="${data}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-history"></i> Riwayat
                                </button>`;
                        }

                        return `
                            @if(auth()->user()->checkRole('pemeriksa'))
                                <a href="print/${data}" class="btn btn-sm btn-success">
                                    <i class="fa fa-print"></i> Cetak
                                </a>
                                <button data-id="${data}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-history"></i> Riwayat
                                </button>
                                <a href="detail/${data}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-list"></i> Detail
                                </a>
                            @elseif(auth()->user()->checkRole('admin'))
                                <a href="print/${data}" class="btn btn-sm btn-success">
                                    <i class="fa fa-print"></i> Cetak
                                </a>
                                <button data-id="${data}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-history"></i> Riwayat
                                </button>
                                <a href="detail/${data}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-list"></i> Detail
                                </a>
                                <button data-id="${data}" class="btn btn-sm btn-warning hitung_retribusi">
                                    <i class="fa fa-calculator"></i> Retribusi
                                </button>
                                <button data-id="${data}" class="btn btn-sm btn-info pilih_petugas">
                                    <i class="fa fa-user"></i> Petugas
                                </button>
                                <button data-id="${data}" class="btn btn-sm btn-primary edit_pengajuan">
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                                <button data-id="${data}" class="btn btn-sm btn-danger delete_pengajuan">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            @elseif(auth()->user()->checkRole('retribusi'))
                                <button data-id="${data}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-history"></i> Riwayat
                                </button>
                                <a href="detail/${data}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-list"></i> Detail
                                </a>
                                <button data-id="${data}" class="btn btn-sm btn-warning hitung_retribusi">
                                    <i class="fa fa-calculator"></i> Retribusi
                                </button>
                                <button data-id="${data}" class="btn btn-sm btn-primary edit_pengajuan">
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                            @else
                                <!-- USER LAINNYA -->
                                <a href="print/${data}" class="btn btn-sm btn-success">
                                    <i class="fa fa-print"></i> Cetak
                                </a>
                                <button data-id="${data}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-history"></i> Riwayat
                                </button>
                                <a href="detail/${data}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-list"></i> Detail
                                </a>
                            @endif
                        `;
                    }
                }
            ]
        });

        $('#filter_tahun, #filter_kategori, #filter_jenis, #filter_status').on('change', function () {
            product_table.ajax.reload();
        });

        const filteringData = () => {
            product_table.ajax.reload();
        }

        $(document).on('click', 'button.delete_pengajuan', function(){
            swal({
                title: LANG.sure,
                text: "Data petugas akan dihapus. Lanjutkan?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    const href = "{{ route('ciptakarya.store_pbg') }}"; // route yang sama seperti add/update
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

        const addPengajuan = (tipe) => {
            uploadedFiles = [];

            const modals = $("#editor_modal_pengajuan");

            // ✅ Update Title Modal
            modals.find('.modal-title').html(`Tambah Data Pengajuan <b>${tipe}</b>`);

            // ✅ Reset hanya input & textarea biasa (jaga hidden)
            modals.find('input:not([type=hidden])').val("");
            modals.find('textarea').val("");

            // ✅ Atur state hidden input
            modals.find('input[name=tipe]').val(tipe);
            modals.find('input[name=insert]').val(1);
            modals.find('input[name=update]').val(0);
            modals.find('input[name=id]').val(0);

            // ✅ Kosongkan list file manual
            $('#list_uploaded_file').html('');

            // ✅ Reset Dropzone
            if (dzPengajuan) {
                dzPengajuan.removeAllFiles(true);
            }

            // ✅ Pastikan pesan dropzone muncul lagi
            $('#dropzone_pengajuan .dz-message').show();

            modals.modal('show');
        };

        $(document).on('click', '.edit_pengajuan', function () {
            const id = $(this).data('id');
            const url = `{{ route('ciptakarya.list_data_pbg') }}/${id}/detail`;

            $.get(url, function(res) {
                if (res.status) {
                    fillFormForEdit(res.data);
                } else {
                    swal("Gagal", "Data tidak ditemukan", "error");
                }
            });
        });

        function fillFormForEdit(data) {
            const modals = $("#editor_modal_pengajuan");

            // Ubah title modal
            modals.find('.modal-title').html(`Edit Data Pengajuan <b>${data.tipe}</b>`);

            // Set state
            modals.find('input[name=tipe]').val(data.tipe);
            modals.find('input[name=insert]').val(0);
            modals.find('input[name=update]').val(1);
            modals.find('input[name=id]').val(data.id);

            // Isi form field
            modals.find('input[name=no_permohonan]').val(data.no_permohonan);
            modals.find('input[name=no_krk]').val(data.no_krk);
            modals.find('input[name=nama_pemohon]').val(data.nama_pemohon);
            modals.find('input[name=nik]').val(data.nik);
            modals.find('textarea[name=alamat]').val(data.alamat);
            modals.find('select[name=fungsi_bangunan]').val(data.fungsi_bangunan);
            modals.find('input[name=nama_bangunan]').val(data.nama_bangunan);
            modals.find('input[name=jumlah_bangunan]').val(data.jumlah_bangunan);
            modals.find('input[name=jumlah_lantai]').val(data.jumlah_lantai);
            modals.find('input[name=luas_bangunan]').val(data.luas_bangunan);
            modals.find('textarea[name=lokasi_bangunan]').val(data.lokasi_bangunan);
            modals.find('input[name=no_persil]').val(data.no_persil);
            modals.find('input[name=luas_tanah]').val(data.luas_tanah);
            modals.find('input[name=pemilik_tanah]').val(data.pemilik_tanah);
            modals.find('input[name=gbs_min]').val(data.gbs_min);
            modals.find('input[name=kdh_min]').val(data.kdh_min);
            modals.find('input[name=kdb_max]').val(data.kdb_max);

            // Reset Dropzone & file list
            dzPengajuan.removeAllFiles(true);
            uploadedFiles = [];
            $('#list_uploaded_file').html('');

            // Jika ada file lama
            if (data.uploaded_files && data.uploaded_files.length > 0) {
                data.uploaded_files.forEach((fileUrl) => {
                    uploadedFiles.push(fileUrl);
                    addFileToList(fileUrl.split('/').pop(), fileUrl);
                });
            }

            // Show modal
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

        // ===================== PILIH PETUGAS =====================
        $(document).on('click', '.pilih_petugas', function () {
            const id = $(this).data('id');
            $('#pengajuan_id_target').val(id);
            $('#modal_pilih_petugas').modal('show');
        });

        $(document).ready(function() {
            // Inisialisasi Select2 dengan AJAX search
            $('#select_petugas').select2({
                dropdownParent: $('#modal_pilih_petugas'), // 👈 ini WAJIB kalau di dalam modal
                placeholder: "Ketik nama atau email petugas...",
                allowClear: true,
                ajax: {
                    url: "{{ route('ciptakarya.search_petugas') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term }; // kirim keyword
                    },
                    processResults: function (data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                },
                width: '100%'
            });
    
            $('#modal_pilih_petugas').on('shown.bs.modal', function () {
                console.log('cek');
                $('#select_petugas').select2('open');
            });
        });


        // Tombol Simpan Petugas
        $('#btn_simpan_petugas').click(function() {
            const buttonDom = $(this);
            const pengajuanId = $('#pengajuan_id_target').val();
            const petugasId = $('#select_petugas').val();

            if (!petugasId) {
                return alert("Silakan pilih petugas terlebih dahulu.");
            }

            $.ajax({
                url: "{{ route('ciptakarya.update_petugas') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: pengajuanId,
                    petugas_id: petugasId
                },
                beforeSend:function(){
                    buttonDom.attr('disabled',true);
                    buttonDom.text('Loading...');
                },
                complete:function(){
                    buttonDom.removeAttr('disabled');
                    buttonDom.text('Simpan');
                },
                success: function(res) {
                    if (res.status) {
                        toastr.success(res.message);
                        $('#modal_pilih_petugas').modal('hide');
                        product_table.ajax.reload();
                    } else {
                        toastr.warning(res.message);
                    }
                },
                error: function() {
                    toastr.error("Gagal menyimpan data petugas!");
                }
            });
        });

        function renderTimeline(step) {

            const steps = [
                {title: "Admin", desc: "Input data permohonan & penentuan jenis izin", icon: "🚀"},
                {title: "Petugas Lapangan", desc: "Verifikasi gambar teknis & survey lokasi", icon: "📍"},
                {title: "Pemeriksa", desc: "Pemeriksaan dokumen teknis", icon: "🧭"},
                {title: "Admin Retribusi", desc: "Perhitungan retribusi & rekom teknis", icon: "💰"},
                {title: "Koordinator", desc: "Verifikasi keseluruhan data", icon: "📊"},
                {title: "Kabid", desc: "Validasi teknis lanjutan", icon: "📑"},
                {title: "Kadis", desc: "Persetujuan akhir permohonan", icon: "✔️"},
            ];

            let html = `<div class="timeline">`;

            steps.forEach((item, index) => {
                const number = index + 1;
                const active = number <= step ? "active" : "";

                html += `
                    <div class="timeline-item">
                        <div class="timeline-year">${number}</div>

                        <div class="timeline-icon ${active}">
                            <span style="font-size:22px">${item.icon}</span>
                        </div>

                        <div class="timeline-content">
                            <h3><strong>${item.title}</strong></h3>
                            <p>${item.desc}</p>
                        </div>
                    </div>
                `;
            });

            html += `</div>`;

            return html;
        }

        $(document).on('click', '.btn-primary:has(.fa-history)', function() {

            const id = $(this).data('id');

            // URL controller timeline
            const url = `{{ route('ciptakarya.timeline', ':id') }}`.replace(':id', id);

            $.get(url, function(res) {

                if (!res.status) {
                    toastr.error("Gagal memuat timeline!");
                    return;
                }

                const flow = res.timeline; 
                $('#timeline_container').html(renderFullTimeline(flow));

                $('#modal_timeline').modal('show');
            });
        });


        $(document).on('click', '.hitung_retribusi', function () {

            let id = $(this).data('id');

            // Simpan id di hidden input
            $('#ret_id').val(id);

            // GET detail data pengajuan
            $.get(`{{ route('ciptakarya.list_data_pbg') }}/${id}/detail`, function(res){

                if (!res.status) {
                    return toastr.error("Data tidak ditemukan");
                }

                const d = res.data;

                $('#ret_luas').val(d.luas_bangunan ?? 0);
                $('#ret_fungsi').val(d.fungsi_bangunan ?? '-');

                hitungRetribusi();

                $('#modal_retribusi').modal('show');
            });
        });

        $('#ret_luas, #ret_tarif').on('input', hitungRetribusi);

        function hitungRetribusi() {
            let luas = parseFloat($('#ret_luas').val()) || 0;
            let tarif = parseFloat($('#ret_tarif').val()) || 0;

            let total = luas * tarif;

            $('#ret_total').val(new Intl.NumberFormat().format(total));
        }

        $('#btn_simpan_retribusi').on('click', function () {

            let btn = $(this);
            let id  = $('#ret_id').val();
            let excelFile = $('#excel_retribusi')[0].files[0];

            let nilaiFormatted = $('#nilai_retribusi').val();
            let nilaiBersih = nilaiFormatted.replace(/\./g, ""); // VALUE ASLI

            if (!nilaiBersih) {
                toastr.error('Nilai retribusi belum diisi.');
                return;
            }
            if (!excelFile) {
                toastr.error('File Excel Retribusi belum diisi.');
                return;
            }

            let formData = new FormData();
            formData.append('id', id);
            formData.append('nilai_retribusi', nilaiBersih);

            if (excelFile) {
                formData.append('excel_retribusi', excelFile);
            }

            // === BUTTON LOADING ===
            btn.prop('disabled', true);
            let oldHtml = btn.html();
            btn.html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

            $.ajax({
                url: "{{ url('/ciptakarya/update-retribusi') }}/" + id,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {

                    toastr.success('Data berhasil disimpan.');

                    $('#modal_retribusi').modal('hide');
                },
                error: function (err) {

                    toastr.error('Gagal menyimpan data.');
                    console.log(err);
                },
                complete: function () {
                    // === RESET BUTTON ===
                    btn.prop('disabled', false);
                    btn.html(oldHtml);
                }
            });

        });


        // MASKING FORMAT RIBUAN UNTUK INPUT NILAI RETRIBUSI
        document.getElementById("nilai_retribusi").addEventListener("input", function (e) {

            // Ambil nilai asli tanpa titik
            let raw = this.value.replace(/\./g, "");

            // Hapus semua karakter kecuali digit
            raw = raw.replace(/\D/g, "");

            // Format ulang menjadi ribuan
            let formatted = raw.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            this.value = formatted;
        });



        function formatRupiah(angka) {
            if (!angka) return "0";

            // Ubah string ke float dulu supaya angka valid
            let number = parseFloat(angka);

            if (isNaN(number)) return "0";

            // Bulatkan tanpa decimal
            number = Math.floor(number);

            // Format dengan separator ribuan
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function renderFullTimeline(flow) {

    let html = `<div class="timeline">`;

    flow.forEach((step, index) => {

        // gunakan warna dari backend: green / red
        const bg = step.color === 'green' ? '#4CAF50' : '#FF5252';
        const textColor = 'white';

        html += `
            <div class="timeline-item">
                <div class="timeline-year">${index + 1}</div>

                <div class="timeline-icon" style="
                    background: ${bg};
                    color: ${textColor};
                    border-color: ${bg};
                ">
                    <span style="font-size:22px">✔️</span>
                </div>

                <div class="timeline-content">
                    <h3><strong>${step.label}</strong></h3>
                    <p>${step.desc}</p>
                    
                    <p style="margin-top:4px;">
                        <b>Status:</b> ${step.status.toUpperCase()} <br>
                        <b>Catatan:</b> ${step.catatan ?? '-'} <br>
                        <b>Tanggal:</b> ${step.verified_at ? moment(step.verified_at).format("DD MMMM YYYY HH:mm") : '-'} <br>
                        <b>User:</b> ${step.user ?? '-'}
                    </p>
                </div>
            </div>
        `;
    });

    html += `</div>`;

    return html;
}





    </script>
@endsection
