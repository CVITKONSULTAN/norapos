<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pendaftaran PPDB Baru</title>
  <style>
    body {
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      background-color: #f8f9fa;
      color: #333;
      padding: 30px;
    }
    .email-container {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      max-width: 650px;
      margin: auto;
      padding: 30px 40px;
      border-top: 4px solid #007bff;
    }
    h2 {
      margin-top: 0;
      color: #007bff;
      font-weight: bold;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    td {
      padding: 6px 4px;
      vertical-align: top;
    }
    .label {
      width: 180px;
      font-weight: bold;
      color: #444;
    }
    .status {
      color: #c33;
      font-weight: bold;
      border: 2px dashed #c33;
      display: inline-block;
      padding: 4px 10px;
      border-radius: 6px;
      background-color: #fff6f6;
    }
    .footer {
      margin-top: 25px;
      text-align: center;
      font-size: 13px;
      color: #777;
    }
    .button {
      display: inline-block;
      padding: 10px 16px;
      background-color: #007bff;
      color: #fff !important;
      border-radius: 6px;
      text-decoration: none;
      margin-top: 10px;
    }
    .divider {
      border-top: 1px solid #ddd;
      margin: 25px 0;
    }
  </style>
</head>
<body>

  @php
    $d = $ppdb->detail ?? [];
    $kode = $ppdb->kode_bayar ?? '-';
    $nama = $d['nama'] ?? '-';
    $jk = $d['jenis-kelamin'] ?? '-';
    $ttl = ($d['tempat-lahir'] ?? '-') . ', ' . (\Carbon\Carbon::parse($d['tanggal-lahir'] ?? '')->translatedFormat('d F Y') ?? '-');
    $tglDaftar = $ppdb->created_at->translatedFormat('d F Y');
    $total = number_format($d['total_bayar'] ?? 0, 0, ',', '.');
    $status = strtoupper($ppdb->status_bayar ?? 'BELUM DIBAYAR');
    $setting = \App\Models\Sekolah\PPDBSetting::first();
    $bank = $setting->nama_bank ?? 'Bank Kalbar';
    $rek = $setting->no_rek ?? '00000';
    $atasNama = $setting->atas_nama ?? 'SD Muhammadiyah 2';
  @endphp

  <div class="email-container">
    <h2>Pendaftaran PPDB Baru</h2>

    <table>
      <tr>
        <td class="label">Kode Bayar</td>
        <td>: <strong>{{ $kode }}</strong></td>
      </tr>
      <tr>
        <td class="label">Nama Calon Siswa</td>
        <td>: {{ $nama }}</td>
      </tr>
      <tr>
        <td class="label">Jenis Kelamin</td>
        <td>: {{ $jk }}</td>
      </tr>
      <tr>
        <td class="label">Tempat, Tanggal Lahir</td>
        <td>: {{ $ttl }}</td>
      </tr>
      <tr>
        <td class="label">Tanggal Daftar</td>
        <td>: {{ $tglDaftar }}</td>
      </tr>
      <tr>
        <td class="label">Total Pembayaran</td>
        <td>: Rp {{ $total }},-</td>
      </tr>
      <tr>
        <td class="label">Status Pembayaran</td>
        <td><div class="status">{{ $status }}</div></td>
      </tr>
    </table>

    <div class="divider"></div>

    <p>
      Mohon segera melakukan pembayaran biaya pendaftaran ke rekening berikut:<br>
      <strong>{{ $bank }}</strong> – No. Rekening <strong>{{ $rek }}</strong><br>
      a.n. <strong>{{ $atasNama }}</strong><br>
      Setelah transfer, silakan unggah bukti pembayaran melalui portal pendaftaran.
    </p>

    <div style="text-align:center; margin-top:20px;">
      <a href="{{ url('/kwitansi-ppdb-simuda?kode_bayar=' . $kode) }}" class="button">
        🧾 Lihat Kwitansi
      </a>
      <br>
      <a href="{{ url('/ppdb-simuda?upload_pembayaran=1&kode_bayar=' . $kode) }}" class="button" style="background:#28a745;">
        📤 Upload Bukti Pembayaran
      </a>
    </div>

    <div class="footer">
      <p>Terima kasih telah mendaftar di <strong>SD Muhammadiyah 2</strong>.</p>
      <p>Email ini dikirim otomatis oleh sistem PPDB — mohon tidak membalas.</p>
    </div>
  </div>
</body>
</html>
