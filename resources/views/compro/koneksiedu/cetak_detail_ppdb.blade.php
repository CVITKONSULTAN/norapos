<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lembar Data PPDB - Heru</title>
  <style>
    @page {
      size: A4 portrait;
      margin: 20mm;
    }
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background-color: #fff;
      color: #000;
      margin: 0;
      padding: 0;
    }

    /* ===== CONTAINER ===== */
    .container {
      width: 100%;
      max-width: 800px;
      margin: auto;
      border: 1px solid #ccc;
      padding: 30px 40px;
      border-radius: 10px;
      position: relative;
      page-break-inside: avoid;
    }

    /* ===== HEADER ===== */
    .qrcode {
      position: absolute;
      top: 0px;
      left: 25px;
      width: 40px;
      height: 40px;
      border: 1px solid #ccc;
      border-radius: 6px;
      background: #fff;
      padding: 2px;
    }
    h1, h2 {
      text-align: center;
      margin: 0;
    }
    h1 {
      font-size: 22px;
      text-transform: uppercase;
    }
    h2 {
      font-size: 16px;
      font-weight: normal;
      margin-top: 5px;
    }
    .divider {
      border-bottom: 2px solid #000;
      margin: 15px 0;
    }

    /* ===== TABEL DATA ===== */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    td {
      padding: 6px 8px;
      vertical-align: top;
    }
    .label {
      width: 35%;
      font-weight: bold;
    }
    .value {
      width: 65%;
    }

    /* ===== TTD PANITIA ===== */
    .ttd {
      margin-top: 40px;
      margin-right: 50px;
      text-align: right;
      page-break-inside: avoid;
    }
    .ttd p {
      margin: 4px 0;
      font-size: 14px;
    }
    .ttd .nama {
      margin-top: 60px;
      font-weight: bold;
      text-decoration: underline;
    }

    /* ===== LAMPIRAN ===== */
    .lampiran-title {
      margin-top: 50px;
      font-size: 18px;
      font-weight: bold;
      text-align: center;
      text-transform: uppercase;
      border-top: 2px solid #000;
      padding-top: 10px;
      page-break-inside: avoid;
    }
    .lampiran-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10mm;
      margin-top: 20px;
      page-break-inside: avoid;
    }
    .image-box {
      width: 60%;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
      box-sizing: border-box;
      page-break-inside: avoid;
    }
    .image-box img {
      width: 100%;
      height: auto;
      max-height: 13cm;
      border-radius: 5px;
      object-fit: contain;
    }
    .label-img {
      margin-top: 8px;
      font-size: 14px;
      font-weight: bold;
      text-transform: uppercase;
    }

    @media print {
      body {
        padding: 0;
      }
      .container {
        border: none;
        padding: 0 20px;
      }
      .ttd {
        page-break-inside: avoid;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- QR Code kecil kiri atas -->
    <img class="qrcode" src="https://api.qrserver.com/v1/create-qr-code/?size=70x70&data=ABC" alt="QR ABC">

    <h1>Formulir Data Pendaftaran PPDB</h1>
    <h2>SD Muhammadiyah 2 Pontianak</h2>
    <div class="divider"></div>

    <!-- DATA PENDAFTAR -->
    <table>
      <tr>
        <td class="label">Kode Pembayaran</td>
        <td class="value">{{ $data->kode_bayar }}</td>
      </tr>
      <tr>
        <td class="label">Status Pembayaran</td>
        <td class="value">{{ $data->status }}</td>
      </tr>
      <tr>
        <td class="label">Nama Lengkap</td>
        <td class="value">{{ $data->nama }}</td>
      </tr>
      <tr>
        <td class="label">Jenis Kelamin</td>
        <td class="value">{{ $data->detail['jenis-kelamin'] ?? '-' }}</td>
      </tr>
      <tr>
        <td class="label">Tempat, Tanggal Lahir</td>
        <td class="value">{{ $data->detail['tempat-lahir'] ?? '-' }}, {{ \Carbon\Carbon::parse($data->detail['tanggal-lahir'])->translatedFormat('d F Y') ?? '-' }}</td>
      </tr>
      <tr>
        <td class="label">Email Pendaftar</td>
        <td class="value">{{ $data->detail['email'] ?? '-' }}</td>
      </tr>
      <tr>
        <td class="label">Total Pembayaran</td>
        <td class="value">Rp {{ number_format($detail['total_bayar'] ?? 0, 0, ',', '.') }},-</td>
      </tr>
      <tr>
        <td class="label">Kode Unik</td>
        <td class="value">{{ $data->detail['kode_unik'] }}</td>
      </tr>
      <tr>
        <td class="label">Rekening Pembayaran</td>
        <td class="value">
          <b>{{ $data->bank_pembayaran['nama_bank'] ?? "-" }}</b><br>
          No. Rekening: {{ $data->bank_pembayaran['no_rek'] ?? "-" }}<br>
          a.n. {{ $data->bank_pembayaran['atas_nama'] ?? "-" }}
        </td>
      </tr>
    </table>

    <!-- TTD PANITIA -->
    <div class="ttd">
      <p>Pontianak, {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</p>
      <p><b>Panitia PPDB</b></p>
      <p class="nama">__________________________</p>
    </div>

    <!-- LAMPIRAN -->
    {{-- <div class="lampiran-title">Lampiran Dokumen</div> --}}
    <div class="lampiran-container">
      <div class="image-box">
        <img src="{{ $data->bukti_pembayaran ?? "-" }}" alt="Bukti Pembayaran">
        <div class="label-img">Bukti Pembayaran</div>
      </div>
      <div class="image-box">
        <img src="{{ $data->detail['link_kartu_keluarga'] ?? '-' }}" alt="Kartu Keluarga">
        <div class="label-img">Kartu Keluarga</div>
      </div>
      <div class="image-box">
        <img src="{{ $data->detail['link_akta_lahir'] ?? '-' }}" alt="Akta Lahir">
        <div class="label-img">Akta Lahir</div>
      </div>
      <div class="image-box">
        <img src="{{ $data->detail['link_kartu_anak'] ?? '-' }}" alt="Kartu Anak">
        <div class="label-img">Kartu Anak</div>
      </div>
    </div>
  </div>

  <script>
    // Tunggu semua gambar selesai dimuat, lalu buka dialog print otomatis
    window.addEventListener('load', () => {
      const imgs = document.images;
      let loaded = 0;
      if (imgs.length === 0) {
        window.print();
        return;
      }
      for (let img of imgs) {
        if (img.complete) {
          loaded++;
          if (loaded === imgs.length) window.print();
        } else {
          img.addEventListener('load', () => {
            loaded++;
            if (loaded === imgs.length) window.print();
          });
          img.addEventListener('error', () => {
            loaded++;
            if (loaded === imgs.length) window.print();
          });
        }
      }
    });
  </script>
</body>
</html>
