<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial; background:#f7f7f7; padding:20px; }
        .box { background:white; padding:20px; border-radius:8px; }
        .title { font-size:18px; font-weight:bold; }
        .btn {
            background:#28a745; color:white; padding:10px 20px;
            text-decoration:none; border-radius:6px; display:inline-block; margin-top:10px;
        }
    </style>
</head>
<body>
    <div class="box">
        <p class="title">Notifikasi Retribusi Telah Diinput</p>

        <p>Koordinator yang terhormat,</p>

        <p>Retribusi untuk pengajuan berikut sudah diinput:</p>

        <p><b>No Permohonan:</b> {{ $pengajuan->no_permohonan }}</p>
        <p><b>Nama Pemohon:</b> {{ $pengajuan->nama_pemohon }}</p>
        <p><b>Alamat Bangunan:</b> {{ $pengajuan->alamat }}</p>

        <p>Silakan melakukan validasi atau tindak lanjut sesuai prosedur.</p>

        <a class="btn" href="{{ url('/ciptakarya/list-data-pbg?pengajuan='.$pengajuan->id) }}">
            Lihat Pengajuan
        </a>

        <p style="margin-top:20px;">Terima kasih,<br><b>Tim PBG / SLF</b></p>
    </div>
</body>
</html>
