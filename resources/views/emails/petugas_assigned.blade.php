<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Penugasan Pemeriksaan</title>

    <style>
        body {
            background: #f5f6fa;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .header {
            background: #2b7cff;
            padding: 20px;
            text-align: center;
            color: white;
        }

        .header h2 {
            margin: 0;
            font-weight: 600;
        }

        .content {
            padding: 25px;
            color: #333333;
            line-height: 1.6;
        }

        .content h3 {
            margin-top: 0;
            font-size: 20px;
            color: #2b2b2b;
        }

        .details-box {
            background: #f1f3f7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }

        .details-box p {
            margin: 6px 0;
            font-size: 15px;
        }

        .btn {
            display: inline-block;
            background: #2b7cff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 10px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 15px;
            font-size: 13px;
            color: #777777;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <h2>Penugasan Pemeriksaan Lapangan</h2>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <h3>Halo {{ $petugas->nama }},</h3>

            <p>
                Anda telah <b>ditugaskan sebagai Petugas Lapangan</b> untuk melakukan pemeriksaan terhadap pengajuan berikut:
            </p>

            <div class="details-box">
                <p><strong>ID Pengajuan:</strong> {{ $pengajuan->id }}</p>
                <p><strong>No Pemohon:</strong> {{ $pengajuan->no_pemohon ?? '-' }}</p>
                <p><strong>Nama Pemohon:</strong> {{ $pengajuan->nama_pemohon ?? '-' }}</p>
                <p><strong>Alamat Bangunan:</strong> {{ $pengajuan->alamat ?? '-' }}</p>
                <p><strong>Tanggal Penugasan:</strong> {{ now()->format('d M Y') }}</p>
            </div>

            <p>
                Silakan masuk ke aplikasi PBG/SLF untuk melihat detail lengkap penugasan dan mengisi hasil pemeriksaan.
            </p>

            {{-- <center>
                <a href="{{ url('/login') }}" class="btn">Buka Aplikasi</a>
            </center> --}}

            <p>Jika Anda merasa tidak sesuai atau ada kesalahan, segera hubungi administrator.</p>

            <p>Terima kasih,<br>
                <strong>Tim PBG / SLF</strong>
            </p>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            Email ini dikirim otomatis, mohon tidak membalas langsung.
        </div>
    </div>
</body>
</html>
