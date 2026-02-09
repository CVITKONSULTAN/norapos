<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengingat Pengajuan Harian</title>

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
            background: #f4c542;
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

        .pengajuan-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .pengajuan-table th {
            background: #f1f3f7;
            padding: 10px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
        }

        .pengajuan-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-warning {
            background: #ffc107;
            color: #333;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .badge-info {
            background: #17a2b8;
            color: white;
        }

        .btn {
            display: inline-block;
            background: #f4c542;
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
            background: #f9f9f9;
        }

        .alert-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <h2>📋 Pengingat Pengajuan Harian</h2>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <h3>Halo {{ $userName }},</h3>

            <p>
                Berikut adalah daftar pengajuan yang <b>masih menunggu tindakan Anda</b> sebagai <b>{{ $userRole }}</b>:
            </p>

            @if(count($pengajuanList) > 0)
                <table class="pengajuan-table">
                    <thead>
                        <tr>
                            <th>No. Permohonan</th>
                            <th>Nama Pemohon</th>
                            <th>Jenis Izin</th>
                            <th>Hari Ke-</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuanList as $item)
                            <tr>
                                <td>{{ $item['no_permohonan'] }}</td>
                                <td>{{ $item['nama_pemohon'] }}</td>
                                <td>{{ $item['tipe'] }}</td>
                                <td>
                                    @if($item['hari_kerja'] > 15)
                                        <span class="badge badge-danger">Hari ke-{{ $item['hari_kerja'] }}</span>
                                    @elseif($item['hari_kerja'] > 10)
                                        <span class="badge badge-warning">Hari ke-{{ $item['hari_kerja'] }}</span>
                                    @else
                                        <span class="badge badge-info">Hari ke-{{ $item['hari_kerja'] }}</span>
                                    @endif
                                </td>
                                <td>{{ strtoupper($item['current_step']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="alert-box">
                    <strong>⚠️ Perhatian:</strong> Berkas yang melebihi <b>15 hari kerja</b> harus segera ditindaklanjuti!
                </div>

                <a href="{{ url('/ciptakarya/list-data-pbg') }}" class="btn">Lihat Detail Pengajuan</a>
            @else
                <p>Tidak ada pengajuan yang menunggu tindakan Anda saat ini.</p>
            @endif
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>Email otomatis dari Sistem SIMBG Kartika</p>
            <p>Jangan balas email ini.</p>
        </div>

    </div>
</body>
</html>
