@php
    $d = $ppdb->detail ?? [];
    $kode = $ppdb->kode_bayar ?? '-';
    $nama = $d['nama'] ?? '-';
    $jk = $d['jenis-kelamin'] ?? '-';
    $ttl = ($d['tempat-lahir'] ?? '-') . ', ' . (\Carbon\Carbon::parse($d['tanggal-lahir'] ?? '')->translatedFormat('d F Y') ?? '-');
    $tglDaftar = $ppdb->created_at->translatedFormat('d F Y');
    $total = number_format($d['total_bayar'] ?? 0, 0, ',', '.');
    $kodeUnik = $d['kode_unik'] ?? '-';
    $status = strtoupper($ppdb->status_bayar ?? 'BELUM DIBAYAR');
  @endphp
  
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>PPDB - {{ $nama }} - {{$kode}}</title>
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
  </style>
</head>
<body>

  <div class="email-container">
    <h2>🆕 Pendaftaran PPDB Baru Masuk</h2>

    <p>Halo Admin,</p>
    <p>Telah ada pendaftar baru melalui portal PPDB. Berikut data lengkapnya:</p>

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
        <td class="label">Kode Unik</td>
        <td>: {{ $kodeUnik }}</td>
      </tr>
      <tr>
        <td class="label">Status Pembayaran</td>
        <td><div class="status">{{ $status }}</div></td>
      </tr>
    </table>

    <p style="margin-top:15px;">
      Silakan login ke dashboard admin untuk memverifikasi pendaftaran atau melihat kwitansi.
    </p>

    <div style="text-align:center; margin-top:20px;">
      <a href="{{ route('sekolah_sd.peserta_didik_baru') }}" class="button">🔑 Buka Dashboard Admin</a><br>
      <a href="{{ url('/kwitansi-ppdb-simuda?kode_bayar=' . $kode) }}" class="button button-secondary">🧾 Lihat Kwitansi</a>
    </div>

    <div class="footer">
      <p>Email ini dikirim otomatis oleh sistem PPDB.</p>
    </div>
  </div>

</body>
</html>
