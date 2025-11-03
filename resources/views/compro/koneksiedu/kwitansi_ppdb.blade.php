<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kwitansi PPDB - Belum Bayar</title>
  <style>
    body {
      font-family: "Times New Roman", serif;
      margin: 40px;
      background-color: #fdfdfd;
      color: #333;
    }
    .kwitansi-container {
      border: 1px solid #aaa;
      border-radius: 8px;
      padding: 24px 32px;
      max-width: 700px;
      margin: 0 auto;
      background: white;
    }
    h2 {
      text-align: center;
      margin-bottom: 0;
    }
    .subtitle {
      text-align: center;
      font-size: 14px;
      color: #777;
      margin-bottom: 24px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 24px;
    }
    td {
      padding: 6px 4px;
      vertical-align: top;
    }
    .label {
      width: 160px;
      font-weight: bold;
    }
    .status {
      text-align: center;
      border: 2px dashed #c33;
      color: #c33;
      padding: 8px;
      font-size: 18px;
      font-weight: bold;
      border-radius: 6px;
      background-color: #fff6f6;
    }
    .footer {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
    }
    .footer div {
      width: 45%;
      text-align: center;
    }
    .sign-box {
      border-top: 1px solid #555;
      margin-top: 60px;
      padding-top: 4px;
      font-size: 13px;
    }
    @media print {
      .no-print { display: none; }
      body { margin: 0; }
    }
  </style>
</head>
<body>
  <div class="kwitansi-container">
    <h2>Kwitansi Pendaftaran PPDB</h2>
    <div class="subtitle">Tahun Ajaran 2025 / 2026</div>

    <table>
      <tr>
        <td class="label">Kode Bayar</td>
        <td>: <strong>PPDB-AB1234</strong></td>
      </tr>
      <tr>
        <td class="label">Nama Calon Siswa</td>
        <td>: Muhammad Fadlan</td>
      </tr>
      <tr>
        <td class="label">Asal Sekolah</td>
        <td>: SD Negeri 12 Pontianak</td>
      </tr>
      <tr>
        <td class="label">Tanggal Daftar</td>
        <td>: 03 November 2025</td>
      </tr>
      <tr>
        <td class="label">Total Pembayaran</td>
        <td>: Rp 350.000,-</td>
      </tr>
      <tr>
        <td class="label">Status Pembayaran</td>
        <td><div class="status">BELUM DIBAYAR</div></td>
      </tr>
    </table>

    <p>
      Mohon segera melakukan pembayaran biaya pendaftaran ke rekening berikut:<br>
      <strong>Bank BRI</strong> – No. Rekening <strong>1234 5678 9012</strong><br>
      a.n. <strong>SMK HN Corporation</strong><br>
      Setelah transfer, silakan unggah bukti pembayaran melalui portal pendaftaran.
    </p>

    <div class="footer">
      <div>
        <p>Pontianak, 03 November 2025</p>
        <div class="sign-box">Petugas PPDB</div>
      </div>
      <div>
        <p>Calon Siswa</p>
        <div class="sign-box">Muhammad Fadlan</div>
      </div>
    </div>

    <button class="no-print" onclick="window.print()">🖨 Cetak Kwitansi</button>
  </div>
</body>
</html>