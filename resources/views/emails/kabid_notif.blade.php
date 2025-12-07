<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notifikasi Kepala Bidang</title>

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }
        .card {
            max-width: 650px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        }
        .header {
            background: #0b3b8c;
            padding: 20px;
            color: #ffffff;
            text-align: center;
        }
        .body {
            padding: 25px;
            color: #333333;
            line-height: 1.6;
        }
        .box {
            background: #eef2ff;
            padding: 15px;
            border-radius: 6px;
            margin: 18px 0;
            border-left: 4px solid #0b3b8c;
        }
        .btn {
            display: inline-block;
            background: #0b3b8c;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="header">
            <h2>Konfirmasi Permohonan</h2>
        </div>

        <div class="body">
            <p>Yth. <strong>Kepala Bidang</strong>,</p>

            <p>
                Terdapat permohonan yang memerlukan verifikasi dan tindak lanjut dari Bapak/Ibu selaku Kepala Bidang.
                Berikut detail informasi permohonannya:
            </p>

            <div class="box">
                <p><strong>ID Pengajuan:</strong> {{ $pengajuan->id }}</p>
                <p><strong>No. Permohonan:</strong> {{ $pengajuan->no_permohonan }}</p>
                <p><strong>Tipe Permohonan:</strong> {{ $pengajuan->tipe }}</p>
                <p><strong>Nama Pemohon:</strong> {{ $pengajuan->nama_pemohon }}</p>
                <p><strong>Nama Bangunan:</strong> {{ $pengajuan->nama_bangunan ?? '-' }}</p>
                <p><strong>Lokasi Bangunan:</strong> {{ $pengajuan->lokasi_bangunan ?? '-' }}</p>

                <p>
                    <strong>Nilai Retribusi:</strong>
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
                Silakan membuka aplikasi untuk melakukan proses konfirmasi atau langkah yang diperlukan.
            </p>

            <p style="text-align:center;">
                <a href="{{ url('/ciptakarya/list-data-pbg?pengajuan='.$pengajuan->id) }}" class="btn">Lihat Detail Pengajuan</a>
            </p>

            <p style="margin-top: 20px;">
                Terima kasih,<br>
                <strong>Tim PBG / SLF</strong>
            </p>
        </div>

        <div class="footer">
            Email ini dikirim otomatis oleh sistem — harap tidak membalas email ini.
        </div>
    </div>
</body>
</html>
