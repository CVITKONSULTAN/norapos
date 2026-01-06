<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengajuan Baru dari SIMBG</title>

    <style>
        body {
            background: #f5f6fa;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 650px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .header {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            padding: 25px;
            text-align: center;
            color: white;
        }

        .header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 24px;
        }

        .header p {
            margin: 8px 0 0 0;
            opacity: 0.95;
        }

        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.7;
        }

        .greeting {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .info-box {
            background: #fff3cd;
            border-left: 4px solid #f39c12;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .info-box strong {
            color: #856404;
        }

        .pengajuan-list {
            margin: 25px 0;
        }

        .pengajuan-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
        }

        .pengajuan-item h4 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 16px;
        }

        .pengajuan-item p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 8px;
        }

        .badge-pbg {
            background: #3498db;
            color: white;
        }

        .badge-slf {
            background: #f39c12;
            color: white;
        }

        .btn {
            display: inline-block;
            background: #f39c12;
            color: white;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 15px;
            font-weight: bold;
            text-align: center;
        }

        .btn:hover {
            background: #e67e22;
        }

        .footer {
            background: #f8f9fa;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }

        .timestamp {
            font-size: 13px;
            color: #6c757d;
            margin-top: 20px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>🔔 Pengajuan Baru dari SIMBG</h2>
            <p>Sinkronisasi Data Otomatis</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p class="greeting">Halo <strong>{{ $recipient->name }}</strong>,</p>

            <div class="info-box">
                Terdapat <strong>{{ $count }} pengajuan baru</strong> yang telah berhasil di-sync dari sistem SIMBG dan perlu ditindaklanjuti.
            </div>

            <p>Berikut adalah daftar pengajuan yang baru masuk:</p>

            <!-- List Pengajuan -->
            <div class="pengajuan-list">
                @foreach($pengajuanList as $index => $pengajuan)
                <div class="pengajuan-item">
                    <h4>
                        {{ $index + 1 }}. {{ $pengajuan->nama_pemohon ?? '-' }}
                        <span class="badge badge-{{ strtolower($pengajuan->tipe) }}">{{ $pengajuan->tipe }}</span>
                    </h4>
                    <p><strong>No. Permohonan:</strong> {{ $pengajuan->no_permohonan ?? '-' }}</p>
                    <p><strong>Fungsi Bangunan:</strong> {{ $pengajuan->fungsi_bangunan ?? '-' }}</p>
                    <p><strong>Alamat:</strong> {{ $pengajuan->alamat ?? '-' }}</p>
                    @if($pengajuan->luas_bangunan)
                    <p><strong>Luas Bangunan:</strong> {{ $pengajuan->luas_bangunan }} m²</p>
                    @endif
                </div>
                @endforeach
            </div>

            <p>Silakan segera cek dan tindaklanjuti pengajuan tersebut di sistem:</p>

            <center>
                <a href="{{ url('/ciptakarya/list_pbg') }}" class="btn">
                    📋 Lihat Daftar Pengajuan
                </a>
            </center>

            <p class="timestamp">
                <em>Email ini dikirim secara otomatis pada {{ now()->format('d F Y, H:i') }} WIB</em>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} Sistem Informasi Cipta Karya</p>
            <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
