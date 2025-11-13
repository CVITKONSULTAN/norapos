@extends('layouts.app')
@section('title', 'Detail Pengajuan PBG / SLF')

@section('css')
<style>
    .detail-box {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
        background: #fff;
    }

    .detail-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #eee;
    }

    .detail-item {
        margin-bottom: 10px;
    }

    .detail-item b {
        width: 220px;
        display: inline-block;
    }

    .foto-item {
        width: 220px;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .timeline-box {
        background: #fafafa;
        border-left: 4px solid #f4c542;
        padding: 12px 18px;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .detail-box textarea {
        border-radius: 6px;
    }

    .detail-box input[type=radio] {
        transform: scale(1.2);
        margin-right: 5px;
    }

    #btn_simpan_verifikasi {
        background: linear-gradient(45deg, #28a745, #1e8f3f);
        box-shadow: 0 4px 12px rgba(0, 150, 60, 0.4);
        border: none;
        transition: 0.2s;
    }

    #btn_simpan_verifikasi:hover {
        background: linear-gradient(45deg, #2fd150, #25a440);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 150, 60, 0.6);
    }


</style>
@endsection

@section('content')

<section class="content-header">
    <h1>Detail Pengajuan</h1>
</section>

<section class="content">

    <div class="detail-box">
        <div class="detail-title">Verifikasi Berkas</div>

        <div class="form-group detail-item">
            <b>Keterangan / Catatan:</b>
            <textarea id="catatan_verifikasi" class="form-control" 
            rows="3"
            placeholder="Tuliskan catatan atau keterangan pemeriksaan..."></textarea>
        </div>

        <div class="form-group detail-item">
            <b>Hasil Verifikasi:</b><br>

            <label style="margin-right:20px;">
                <input type="radio" name="hasil_verifikasi" value="sesuai">
                <span class="text-success"><b>Sesuai</b></span>
            </label>

            <label>
                <input type="radio" name="hasil_verifikasi" value="tidak_sesuai">
                <span class="text-danger"><b>Tidak Sesuai</b></span>
            </label>
        </div>

        <!-- 🔥 TOMBOL SIMPAN BARU -->
        <div class="text-right mt-3">
            <button id="btn_simpan_verifikasi" class="btn btn-lg btn-success"
                style="padding: 12px 30px; font-size: 18px; font-weight:bold; border-radius:10px;">
                <i class="fa fa-save"></i> SIMPAN VERIFIKASI
            </button>
        </div>
    </div>



<div class="detail-box">
    <div class="detail-title">Informasi Umum</div>

    <div class="detail-item"><b>No. Permohonan:</b> {{ $pengajuan['no_permohonan'] }}</div>
    <div class="detail-item"><b>Jenis Izin:</b> {{ $pengajuan['tipe'] }}</div>
    <div class="detail-item"><b>Status:</b> 
        @php
            $color = $pengajuan['status'] == 'terbit' ? 'green' : ($pengajuan['status'] == 'gagal' ? 'red' : 'blue');
        @endphp
        <span class="badge bg-{{ $color }}">{{ strtoupper($pengajuan['status']) }}</span>
    </div>
    <div class="detail-item"><b>Tanggal Input:</b> {{ $pengajuan['created_at'] }}</div>
    <div class="detail-item"><b>Petugas Lapangan:</b> 
        {{ $pengajuan['petugas_lapangan']['nama'] ?? '-' }}
    </div>
</div>


<div class="detail-box">
    <div class="detail-title">Data Pemohon</div>

    <div class="detail-item"><b>Nama Pemohon:</b> {{ $pengajuan['nama_pemohon'] }}</div>
    <div class="detail-item"><b>NIK:</b> {{ $pengajuan['nik'] }}</div>
    <div class="detail-item"><b>Alamat Pemohon:</b> {{ $pengajuan['alamat'] }}</div>
</div>


<div class="detail-box">
    <div class="detail-title">Data Bangunan</div>

    <div class="detail-item"><b>Nama Bangunan:</b> {{ $pengajuan['nama_bangunan'] }}</div>
    <div class="detail-item"><b>Fungsi:</b> {{ $pengajuan['fungsi_bangunan'] }}</div>
    <div class="detail-item"><b>Jumlah Bangunan:</b> {{ $pengajuan['jumlah_bangunan'] }}</div>
    <div class="detail-item"><b>Jumlah Lantai:</b> {{ $pengajuan['jumlah_lantai'] }}</div>
    <div class="detail-item"><b>Luas Bangunan:</b> {{ $pengajuan['luas_bangunan'] }}</div>
    <div class="detail-item"><b>Ketinggian:</b> {{ $pengajuan['ketinggian_bangunan'] }}</div>
    <div class="detail-item"><b>Lokasi Bangunan:</b> {{ $pengajuan['lokasi_bangunan'] }}</div>

    <hr>

    <div class="detail-item"><b>No. Persil:</b> {{ $pengajuan['no_persil'] }}</div>
    <div class="detail-item"><b>Luas Tanah:</b> {{ $pengajuan['luas_tanah'] }}</div>
    <div class="detail-item"><b>Pemilik Tanah:</b> {{ $pengajuan['pemilik_tanah'] }}</div>
    <div class="detail-item"><b>KDB Maksimum:</b> {{ $pengajuan['kdb_max'] }}</div>
    <div class="detail-item"><b>KDH Minimum:</b> {{ $pengajuan['kdh_min'] }}</div>
    <div class="detail-item"><b>GBS Minimum:</b> {{ $pengajuan['gbs_min'] }}</div>
    <div class="detail-item"><b>Koordinat:</b> {{ $pengajuan['koordinat_bangunan'] }}</div>
</div>


<div class="detail-box">
    <div class="detail-title">Foto Lapangan</div>

    @php
        $fotos = json_decode($pengajuan['list_foto'], true);
    @endphp

    @if($fotos)
        @foreach ($fotos as $foto)
            <div class="foto-item">
                <img src="{{ $foto['url'] }}" class="img-thumbnail">
                <small>{{ $foto['caption'] }}</small>
            </div>
        @endforeach
    @else
        <div>Tidak ada foto.</div>
    @endif
</div>


<div class="detail-box">
    <div class="detail-title">Dokumen Terunggah</div>

    @if(!empty($pengajuan['uploaded_files']))
        <ul>
            @foreach ($pengajuan['uploaded_files'] as $file)
                <li><a href="{{ $file }}" target="_blank">{{ basename($file) }}</a></li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada dokumen</p>
    @endif
</div>


<div class="detail-box">
    <div class="detail-title">Hasil Pemeriksaan (Ringkas)</div>

    @php
        $answers = json_decode($pengajuan['answers'], true);
    @endphp

    @foreach ($answers as $caption => $item)
        <div class="timeline-box">
            <b>{{ $caption }}</b> :
            @if($item['value'] == 1)
                <span class="text-success">Ya</span>
            @elseif($item['value'] == -2)
                <span class="text-danger">Tidak</span>
            @else
                <span>{{ $item['value'] }}</span>
            @endif
        </div>
    @endforeach
</div>

</section>

@endsection

@section('javascript')
<script>
    $('#btn_simpan_verifikasi').click(function() {
        const catatan = $('#catatan_verifikasi').val();
        const hasil = $('input[name="hasil_verifikasi"]:checked').val();

        if (!hasil) {
            return toastr.warning("Pilih hasil verifikasi terlebih dahulu!");
        }

        toastr.success("Verifikasi tersimpan sementara!");
    });
</script>
@endsection
