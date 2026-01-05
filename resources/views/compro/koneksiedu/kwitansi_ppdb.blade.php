<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kwitansi PPDB - {{ $ppdb->status_bayar }}</title>
  <style>
    body {
      font-family: "Times New Roman", serif;
      margin: 40px;
      background-color: #fdfdfd;
      color: #333;
    }
    .kwitansi-container {
      position: relative;
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
    .status.lunas {
      border-color: #1b873f;
      color: #1b873f;
      background-color: #f4fff6;
    }
    .status.upload {
      border-color: #1b5387;
      color: #1b5387;
      background-color: #f4fff6;
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
    .qrcode {
      position: absolute;
      top: 20px;
      right: 20px;
    }
    @media print {
      .no-print { display: none; }
      body { margin: 0; }
    }
  </style>
</head>
<body>
  <div class="kwitansi-container">

    <img src="/img/svg/sdm2_logo.svg" alt="Logo SD Muhammadiyah 2 Pontianak"> <br />
    <button class="no-print" onclick="window.print()">🖨 Cetak Kwitansi</button>
    <!-- QR Code -->
    <div id="qrcode" class="qrcode"></div>

    <h2>Kwitansi Pendaftaran PPDB</h2>
    <div class="subtitle">Tahun Ajaran 2025 / 2026</div>

    @php
      $detail = $ppdb->detail ?? [];
    @endphp

    <table>
      <tr>
        <td class="label">Kode Bayar</td>
        <td>: <strong id="kodeBayar">{{ $ppdb->kode_bayar }}</strong></td>
      </tr>
      <tr>
        <td class="label">Nama Calon Siswa</td>
        <td>: {{ $detail['nama'] ?? '-' }}</td>
      </tr>
      <tr>
        <td class="label">Jenis Kelamin</td>
        <td>: {{ $detail['jenis-kelamin'] ?? '-' }}</td>
      </tr>
      <tr>
        <td class="label">Tempat, Tanggal Lahir</td>
        <td>: {{ $detail['tempat-lahir'] ?? '-' }}, 
          {{ \Carbon\Carbon::parse($detail['tanggal-lahir'])->translatedFormat('d F Y') ?? '-' }}</td>
      </tr>
      <tr>
        <td class="label">Tanggal Daftar</td>
        <td>: {{ \Carbon\Carbon::parse($ppdb->created_at)->translatedFormat('d F Y') }}</td>
      </tr>
      <tr>
        <td class="label">Total Pembayaran</td>
        <td>: Rp {{ number_format($detail['total_bayar'] ?? 0, 0, ',', '.') }},-</td>
      </tr>
      <tr>
        <td class="label">Status Pembayaran</td>
        <td>
          <div class="status {{ $ppdb->status_bayar == 'sudah' ? 'lunas' : '' }} {{ $ppdb->status_bayar }}">
            {{ strtoupper($ppdb->status_bayar) }}
          </div>
        </td>
      </tr>
    </table>

    @if($ppdb->status_bayar == 'belum')
      <p>
        Mohon segera melakukan pembayaran biaya pendaftaran ke rekening berikut:<br>
        <strong>{{ $ppdb->bank_pembayaran['nama_bank'] ?? "-" }}</strong> – No. Rekening <strong>{{ $ppdb->bank_pembayaran['no_rek'] ?? "-" }}</strong><br>
        a.n. <strong>{{ $ppdb->bank_pembayaran['atas_nama'] ?? "-" }}</strong><br>
        Setelah transfer, silakan unggah bukti pembayaran melalui portal pendaftaran.
      </p>
    @endif
    @if($ppdb->status_bayar == 'upload')
      <p>
        Pembayaran anda pada nomor rekening dibawah sedang <b>menunggu proses verifikasi Admin </b> :<br>
        <strong>{{ $ppdb->bank_pembayaran['nama_bank'] ?? "-" }}</strong> – No. Rekening <strong>{{ $ppdb->bank_pembayaran['no_rek'] ?? "-" }}</strong><br>
        a.n. <strong>{{ $ppdb->bank_pembayaran['atas_nama'] ?? "-" }}</strong><br>
      </p>
    @endif
    @if($ppdb->status_bayar == 'sudah')
      <p style="color:#1b873f;">
        Terima kasih, pembayaran Anda telah kami terima.  
        Mohon simpan kwitansi ini sebagai bukti sah pendaftaran PPDB SD Muhammadiyah 2 Pontianak.
      </p>
    @endif

    <table style="width:100%; margin-top:40px; text-align:center;">
      <tr>
        <td style="width:50%; vertical-align:bottom;">
          Pontianak, {{ \Carbon\Carbon::parse($ppdb->updated_at)->translatedFormat('d F Y') }}
        </td>
        <td style="width:50%; vertical-align:bottom;">
          Calon Siswa
        </td>
      </tr>
      <tr><td colspan="2" style="height:60px;"></td></tr>
      <tr>
        <td style="text-align:center;">
          <span style="border-top:1px solid #555; padding-top:4px; display:inline-block; width:200px;">
            ...
          </span>
        </td>
        <td style="text-align:center;">
          <span style="border-top:1px solid #555; padding-top:4px; display:inline-block; width:200px;">
            {{ $detail['nama'] ?? '-' }}
          </span>
        </td>
      </tr>
    </table>

  </div>

  <!-- QR Code Generator -->
  <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const kodeBayar = document.getElementById("kodeBayar").textContent.trim();

      // Generate QR Code ke link kwitansi online
      new QRCode(document.getElementById("qrcode"), {
        text: "{{ route('sekolah.kwitansi_ppdb', ['kode_bayar' => $ppdb->kode_bayar]) }}",
        width: 90,
        height: 90,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
      });

      // 🖨 Auto print saat halaman dibuka
      setTimeout(() => window.print(), 600);
    });
  </script>
</body>
</html>
