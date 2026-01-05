<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pembayaran PPDB Divalidasi</title>
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
      border-top: 4px solid #28a745;
    }
    h2 {
      color: #28a745;
      text-align: center;
    }
    .button {
      display: inline-block;
      padding: 10px 16px;
      background-color: #28a745;
      color: #fff !important;
      border-radius: 6px;
      text-decoration: none;
      margin-top: 10px;
    }
    p {
      line-height: 1.6;
    }
  </style>
</head>
<body>
  @php
    $d = $ppdb->detail ?? [];
    $kode = $ppdb->kode_bayar ?? '-';
    $nama = $d['nama'] ?? '-';
    $bank = \App\Models\Sekolah\PPDBSetting::first()->nama_bank ?? 'Bank Kalbar';
  @endphp

  <div class="email-container">
    <h2>🎉 Pembayaran Kamu Diterima!</h2>
    <p>Halo <strong>{{ $nama }}</strong>,</p>
    <p>
      Kami telah memeriksa pembayaran pendaftaran PPDB kamu dan menyatakan bahwa pembayaran dengan kode:
      <strong>{{ $kode }}</strong> telah <span style="color:green;font-weight:bold;">VALID & DITERIMA</span>.
    </p>

    <p>Terima kasih sudah melakukan pembayaran melalui {{ $bank }}. Kamu sudah resmi terdaftar dalam proses PPDB.</p>

    <p style="text-align:center; margin-top:20px;">
      <a href="{{ url('/kwitansi-ppdb-simuda?kode_bayar=' . $kode) }}" class="button">
        🧾 Lihat Kwitansi
      </a>
    </p>

    <p style="text-align:center; margin-top:20px;">
      <a href="{{ url('/cetak-karu-simuda?kode_bayar=' . $kode) }}" class="button">
        Cetak Kartu Ujian
      </a>
    </p>

    <p style="margin-top:30px; font-size:13px; color:#555;">
      Salam,<br>
      <strong>Panitia PPDB SD Muhammadiyah 2</strong><br>
      Email ini dikirim otomatis, mohon tidak membalas langsung.
    </p>
  </div>
</body>
</html>
