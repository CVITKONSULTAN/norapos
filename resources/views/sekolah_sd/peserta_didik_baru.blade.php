@extends('layouts.app')
@section('title', "Peserta Didik Baru")

@section('css')
<style>
    .table_profile_dashboard_sekolah {
        border-collapse: collapse;
        border: 1px solid black;
        border-radius: 5px;
    }
    .table_profile_dashboard_sekolah tr {
        border: 1px solid black;
    }
    .table_profile_dashboard_sekolah tr td {
        padding: 10px;
    }
</style>
@endsection

@section('content')

<!-- 🔹 Modal Validasi Bukti Bayar -->
<div class="modal fade" id="modal_validasi_ppdb" tabindex="-1" role="dialog" aria-labelledby="validasiModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-white" id="validasiModalLabel">Validasi Bukti Pembayaran</h4>
      </div>

      <div class="modal-body">
        <div class="row">

          <!-- Kolom kiri: preview bukti bayar -->
          <div class="col-md-12 text-center" style="border-right:1px solid #ddd;">
            <div id="preview_bukti_bayar" style="padding:10px;">
              <p class="text-muted">Tampilkan foto bukti bayar</p>
              <a href="#" id="link_bukti" target="_blank">
                  <img id="bukti_bayar_img" src="" class="img-responsive center-block" style="display:none;">
              </a>
            </div>
            <div class="text-center" style="margin-top:15px;">
              <button id="btn_tidak_sesuai" type="button" class="btn btn-default">Tidak</button>
              <button id="btn_sesuai" type="button" class="btn btn-success">Sesuai</button>
            </div>
          </div>

          <!-- Kolom kanan: form alasan -->
          <div class="col-md-12">
            <div id="form_tanggapan" style="display:none; padding:10px;">
              <label for="alasan_tolak" style="font-weight:bold;">
                Tambahkan catatan / penjelasan kenapa bukti pembayaran yg diupload tidak bisa divalidasi
              </label>
              <textarea id="alasan_tolak" class="form-control" rows="6" placeholder="Ketik di sini..."></textarea>
              <button id="btn_kirim_tanggapan" type="button" class="btn" style="background-color:#f39c12; color:white; margin-top:10px;">
                Kirim Tanggapan
              </button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Peserta Didik Baru</h1>
</section>

<!-- Main content -->
<section class="content">

    {{-- 🔹 Informasi Pengaturan PPDB --}}
    @if(isset($ppdb_setting))
    <div class="alert alert-warning">
        <h4>Informasi PPDB {{ $ppdb_setting->tahun_ajaran }}</h4>
        <p>
            <strong>Status:</strong> 
            @if($ppdb_setting->close_ppdb)
                <span class="label label-danger">Ditutup</span>
            @else
                <span class="label label-success">Dibuka</span>
            @endif
            <br>
            <strong>Tanggal Penerimaan:</strong> {{ \Carbon\Carbon::parse($ppdb_setting->tgl_penerimaan)->translatedFormat('d F Y') }}<br>
            <strong>Biaya Pendaftaran:</strong> Rp {{ number_format($ppdb_setting->jumlah_tagihan, 0, ',', '.') }}<br>
            <strong>Rekening:</strong> {{ $ppdb_setting->nama_bank }} - {{ $ppdb_setting->no_rek }} a.n {{ $ppdb_setting->atas_nama }}
        </p>
    </div>
    @endif

     {{-- 🔹 Statistik PPDB --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $visitorCount }}</h3>
                    <p>Kunjungan ke Halaman PPDB (30 Hari Terakhir)</p>
                </div>
                <div class="icon">
                    <i class="fa fa-eye"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $pendaftarCount }}</h3>
                    <p>Pendaftar Baru (30 Hari Terakhir)</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-plus"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 Modal Detail Data --}}
    <div id="detail_ppdb_popup" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
	                <h4 class="modal-title">Detail PPDB</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table_profile_dashboard_sekolah" id="data_detail_table"></table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 DataTable --}}
    <div class="row">
        <div class="col-md-12">
           <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true">
                            <i class="fa fa-users" aria-hidden="true"></i> Semua Data
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="text-right mb-2">
                            <a href="{{ route('sekolah_sd.ppdb.export') }}" class="btn btn-primary">
                                <i class="fa fa-upload"></i> Ekspor
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>Kode Bayar</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat / Tgl Lahir</th>
                                        <th>Total Bayar</th>
                                        <th>Status Bayar</th>
                                        <th>Keterangan</th>
                                        <th>Validasi Oleh</th>
                                        <th>Tanggal Validasi</th>
                                        <th>Tanggal Registrasi</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>

</section>
@endsection

@section('javascript')

<script type="text/javascript">
    const HitungTglLahir = (tgl_lahir) => {
        if(!tgl_lahir) return '-';
        const birthDate = moment(tgl_lahir, 'YYYY-MM-DD');
        const currentDate = moment();
        const years = currentDate.diff(birthDate, 'years');
        const months = currentDate.diff(birthDate.add(years, 'years'), 'months');
        return `${years} tahun ${months} bulan`;
    }

    const detailData = (id) => {
        const image_attribute_list = ['bukti_bayar_ppdb','kartu_keluarga','akta_lahir','pas_foto','link_kartu_keluarga','link_akta_lahir','link_kartu_anak'];
        $("#data_detail_table").html(`<tr><td colspan="3" class="text-center text-muted">Memuat data...</td></tr>`);
        $.ajax({
            url:`/sekolah_sd/ppdb/${id}`,
            success:(response)=>{
                $("#data_detail_table").empty();
                if(!response.status) return toastr.error(response.message);
                if(response.data.detail){
                    for(const k in response.data.detail){
                        const val = response.data.detail[k];
                        if(typeof val === 'object') continue;
                        let str = val ?? '-';
                        if(image_attribute_list.includes(k)) str = `<img class="img-responsive" src="${val}" style="max-width:150px; border-radius:5px;" />`;
                        if(k == 'tanggal_lahir'){
                            const hitung = HitungTglLahir(val);
                            str = `${val} (${hitung})`
                        }
                        const template = `<tr><td style="width:35%;font-weight:600">${k.replace(/_/g,' ').toUpperCase()}</td><td>:</td><td>${str}</td></tr>`;
                        $("#data_detail_table").append(template);
                    }
                }
            }
        });
        $("#detail_ppdb_popup").modal('show');
    }

    let currentValidasiId = null;

    const validasiBayar = (id) => {
        currentValidasiId = id;
        $("#modal_validasi_ppdb").modal('show');
        $("#form_tanggapan").hide();
        $("#alasan_tolak").val('');

        // 🔹 Ambil data bukti bayar
        $.ajax({
            url: `/sekolah_sd/ppdb/${id}`,
            method: 'GET',
            success: function(res) {
                if (res.status && res.data.bukti_pembayaran) {
                    $("#bukti_bayar_img")
                        .attr('src', res.data.bukti_pembayaran)
                        .show();
                    $("#link_bukti").attr('href',res.data.bukti_pembayaran);
                } else {
                    $("#bukti_bayar_img").hide();
                    $("#preview_bukti_bayar p").text("Tidak ada bukti bayar yang diupload.");
                }
            }
        });
    };

    // ✅ Klik tombol “Sesuai”
    $("#btn_sesuai").on("click", function() {
        if (!currentValidasiId) return;
        swal({
            title: "Konfirmasi Validasi",
            text: "Yakin ingin menyetujui bukti pembayaran ini?",
            icon: "info",
            buttons: true,
        }).then(ok => {
            if (ok) {
                $.post(`/sekolah_sd/ppdb/${currentValidasiId}`, { validasi: 1 }, function(res) {
                    if (res.status) {
                        toastr.success(res.message);
                        $("#modal_validasi_ppdb").modal('hide');
                        product_table.ajax.reload();
                    } else {
                        toastr.error(res.message);
                    }
                });
            }
        });
    });


    // 🔸 Klik “Tidak”
    $("#btn_tidak_sesuai").on("click", function() {
        $("#form_tanggapan").slideDown();
    });

    // ❌ Klik tombol “Kirim Tanggapan”
    $("#btn_kirim_tanggapan").on("click", function() {
        const alasan = $("#alasan_tolak").val().trim();
        if (alasan === '') {
            return toastr.warning("Silakan isi alasan terlebih dahulu!");
        }

        $.ajax({
            url: `/sekolah_sd/ppdb/${currentValidasiId}`,
            method: 'POST',
            data: { tanggapan: 1, alasan },
            success: function(res) {
                if (res.status) {
                    toastr.success(res.message);
                    $("#modal_validasi_ppdb").modal('hide');
                    product_table.ajax.reload();
                } else {
                    toastr.error(res.message);
                }
            }
        });
    });


    const deleteData = (id) => {
        swal({
            title: LANG.sure,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: "POST",
                    url: `/sekolah_sd/ppdb/${id}`,
                    data:{delete:1},
                    dataType: "json",
                    success: function(response){
                        if(response.status){
                            product_table.ajax.reload();
                        }
                    }
                });
            }
        });
    }

    const cetakData = (id) => {
        const url = `/ppdb-simuda/print/${id}`;
        window.open(url, '_blank');
    }

    $(document).ready(function(){
        // 🔹 Tambahkan filter status di atas tabel
        const filterContainer = `
            <div class="mb-3">
                <label for="filter_status" style="font-weight:600;">Filter Status Pembayaran:</label>
                <select id="filter_status" class="form-control" style="width:200px; display:inline-block; margin-left:10px;">
                    <option value="">Semua</option>
                    <option value="upload" selected>Upload</option>
                    <option value="sudah">Sudah</option>
                    <option value="belum">Belum</option>
                </select>
            </div>
        `;
        $("#product_table").before(filterContainer);

        // 🔹 Inisialisasi DataTable
        product_table = $('#product_table').DataTable({
            processing: true,
            serverSide: true,
            order:[],
            dom: 'Bfrtip',
            buttons: [],
            ajax: { 
                url: "{{ route('sekolah_sd.ppdb.data') }}",
                data: function(d){
                    d.status_bayar = $('#filter_status').val(); // kirim parameter ke backend
                }
            },
            columns: [
                {
                    data:'kode_bayar',
                },
                {
                    data:'id',
                    render:(data,type,row)=> row.detail.nama ?? '-'
                },
                {
                    data:'id',
                    render:(data,type,row)=> row.detail['jenis-kelamin'] ?? '-'
                },
                {
                    data:'id',
                    render:(data,type,row)=>{
                        const tempat = row.detail['tempat-lahir'] ?? '-';
                        const tgl = row.detail['tanggal-lahir']
                            ? moment(row.detail['tanggal-lahir']).format('D/M/Y')
                            : '-';
                        const umur = row.detail['tanggal-lahir']
                            ? HitungTglLahir(row.detail['tanggal-lahir'])
                            : '';
                        return `${tempat}, ${tgl} (${umur})`;
                    }
                },
                {
                    data:'id',
                    render:(data,type,row)=>{
                        const total = row.detail.total_bayar ?? 0;
                        return `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
                    }
                },
                {
                    data:'status_bayar',
                    render:(data)=>{
                        const color = data === 'sudah' ? 'green' : (data === 'upload' ? 'orange' : 'red');
                        const label = data ? data.toUpperCase() : 'BELUM';
                        return `<span style="color:${color}; font-weight:bold;">${label}</span>`;
                    }
                },
                {
                    data:'keterangan'
                },
                {
                    data:'validator',
                    render:(data,type,row)=> row.validator?.name ?? '-'
                },
                {
                    data:'validated_at',
                    render:(data)=>{
                        return data ? moment(data).format('DD/MM/YYYY HH:mm') : '-';
                    }
                },
                {
                    data:'created_at',
                    render:(data)=>{
                        return data ? moment(data).format('DD/MM/YYYY HH:mm') : '-';
                    }
                },
                {
                    data:'id',
                    className:"text-center",
                    render:(data,type,row)=>{
                        const validBtn = row.status_bayar === 'upload'
                            ? `<button class="btn btn-success btn-xs" title="Validasi" onclick="validasiBayar(${data})"><i class="fa fa-check"></i></button>`
                            : '';
                        return `
                            ${validBtn}
                            <button class="btn btn-primary btn-xs" title="Cetak" onclick="cetakData(${data})"><i class="fa fa-print"></i></button>
                            <button class="btn btn-info btn-xs" title="Detail" onclick="detailData(${data})"><i class="fa fa-eye"></i></button>
                            <button class="btn btn-danger btn-xs" title="Hapus" onclick="deleteData(${data})"><i class="fa fa-trash"></i></button>
                        `;
                    }
                }
            ]
        });

        // 🔹 Reload data ketika filter berubah
        $('#filter_status').on('change', function(){
            product_table.ajax.reload();
        });
    });
</script>
@endsection

