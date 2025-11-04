<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>PPDB - Bukti Pembayaran Baru - {{ $data->kode_bayar }}</title>
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
      border-top: 4px solid #17a2b8;
    }
    h2 {
      margin-top: 0;
      color: #17a2b8;
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
      background-color: #17a2b8;
      color: #fff !important;
      border-radius: 6px;
      text-decoration: none;
      margin-top: 10px;
    }
    .button-secondary {
      background-color: #007bff;
    }
    .bukti-link {
      margin-top: 10px;
      display: inline-block;
      background-color: #e9ecef;
      padding: 6px 12px;
      border-radius: 4px;
      font-size: 14px;
      color: #333;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <div class="email-container">
    <h2>💳 Bukti Pembayaran Baru Diterima</h2>

    <p>Halo Admin,</p>
    <p>Seorang pendaftar telah mengunggah bukti pembayaran formulir pendaftaran PPDB. Berikut detailnya:</p>

    <table>
      <tr>
        <td class="label">Kode Bayar</td>
        <td>: <strong>{{ $data->kode_bayar }}</strong></td>
      </tr>
      <tr>
        <td class="label">Nama Calon Siswa</td>
        <td>: {{ $data->nama }}</td>
      </tr>
      <tr>
        <td class="label">Tanggal Upload</td>
        <td>: {{ $data->updated_at->translatedFormat('d F Y H:i') }} WIB</td>
      </tr>
      <tr>
        <td class="label">Total Pembayaran</td>
        <td>: Rp {{ number_format($data->total_bayar, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">Kode Unik</td>
        <td>: {{ $data->kode_unik }}</td>
      </tr>
      <tr>
        <td class="label">Status Pembayaran</td>
        <td><div class="status">MENUNGGU VALIDASI</div></td>
      </tr>
    </table>

    <p style="margin-top:15px;">
      Silakan login ke dashboard admin untuk memverifikasi bukti pembayaran ini.
    </p>

    <div style="text-align:center; margin-top:25px;">
      <a href="{{ route('sekolah_sd.peserta_didik_baru') }}" class="button">🔑 Buka Dashboard Admin</a><br>
      <a href="{{ url('/kwitansi-ppdb-simuda?kode_bayar=' . $data->kode_bayar) }}" class="button button-secondary">🧾 Lihat Kwitansi</a><br>
      <a href="{{ $data->bukti_pembayaran }}" class="bukti-link" target="_blank">📎 Lihat Bukti Pembayaran</a>
    </div>

    <div class="footer">
      <p>Email ini dikirim otomatis oleh sistem PPDB SD Muhammadiyah 2 Pontianak.<br>
      Mohon tidak membalas email ini.</p>
    </div>
  </div>

</body>
</html>
