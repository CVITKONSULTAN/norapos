<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Notifikasi Kepala Dinas</title>

    <style>
        body { background:#f3f4f6; font-family:Arial,Helvetica,sans-serif; margin:0; padding:0; }
        .card {
            max-width:700px; margin:32px auto; background:#fff; border-radius:10px;
            overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,0.08);
        }
        .header {
            background:#0d4c92; padding:22px; color:#fff; text-align:center;
        }
        .header h2 { margin:0; font-size:22px; font-weight:600; }
        .body { padding:26px; color:#1f2937; line-height:1.6; }
        .box {
            background:#eef2ff; padding:16px; border-left:5px solid #0d4c92;
            border-radius:6px; margin:20px 0;
        }
        .btn {
            background:#0d4c92; color:#fff; padding:12px 26px;
            text-decoration:none; border-radius:7px; font-weight:600;
            display:inline-block; margin-top:10px;
        }
        .footer {
            text-align:center; padding:16px; font-size:13px; color:#6b7280;
        }
    </style>
</head>

<body>
<div class="card">

    <div class="header">
        <h2>Pemberitahuan Proses Permohonan</h2>
    </div>

    <div class="body">
        <p>Yth. <strong>Kepala Dinas</strong>,</p>

        <p>
            Sistem menyampaikan bahwa terdapat permohonan yang memerlukan perhatian 
            dan persetujuan dari Bapak/Ibu sebagai Kepala Dinas. Berikut ringkasan informasi
            dari permohonan tersebut:
        </p>

        <div class="box">
            <p><strong>ID Pengajuan:</strong> {{ $pengajuan->id }}</p>
            <p><strong>No. Permohonan:</strong> {{ $pengajuan->no_permohonan }}</p>
            <p><strong>Tipe Permohonan:</strong> {{ $pengajuan->tipe }}</p>
            <p><strong>Nama Pemohon:</strong> {{ $pengajuan->nama_pemohon }}</p>
            <p><strong>Nama Bangunan:</strong> {{ $pengajuan->nama_bangunan ?? '-' }}</p>
            <p><strong>Lokasi Bangunan:</strong> {{ $pengajuan->lokasi_bangunan ?? '-' }}</p>

            <p><strong>Nilai Retribusi:</strong>
                @if($pengajuan->nilai_retribusi)
                    Rp {{ number_format($pengajuan->nilai_retribusi, 0, ',', '.') }}
                @else
                    -
                @endif
            </p>

            <p><strong>Status Saat Ini:</strong> {{ $pengajuan->status }}</p>

            <p><strong>Petugas Penanggung Jawab:</strong>
                {{ $pengajuan->petugas->nama ?? '-' }}
            </p>
        </div>

        <p>
            Bapak/Ibu dapat membuka sistem melalui tombol berikut untuk melakukan 
            validasi atau tindakan lanjutan sesuai prosedur operasional:
        </p>

        <p style="text-align:center;">
            <a href="{{ url('/ciptakarya/list-data-pbg?pengajuan=' . $pengajuan->id) }}"
               class="btn">
                Lihat Detail Pengajuan
            </a>
        </p>

        <p style="margin-top:22px;">
            Hormat kami,<br>
            <strong>Tim PBG / SLF</strong>
        </p>
    </div>

    <div class="footer">
        Email ini dikirim otomatis oleh sistem — jangan membalas email ini.
    </div>
</div>
</body>
</html>
