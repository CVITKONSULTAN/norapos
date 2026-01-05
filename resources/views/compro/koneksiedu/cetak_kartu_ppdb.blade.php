<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kartu Tes PPDB - SD Muhammadiyah 2 Pontianak</title>
  <style>
    @page { size: A4; margin: 10mm; }
    body {
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      background: #fff;
      color: #000;
      font-size: 12px;
      margin: 0;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    .noprint {
      margin-bottom: 10px;
    }
    .card {
      width: 90%;
      max-width: 650px;
      border: 1px solid #000;
      border-radius: 8px;
      padding: 25px 25px 15px;
      box-sizing: border-box;
      position: relative;
    }
    .header {
      text-align: center;
      border-bottom: 1px solid #000;
      margin-bottom: 8px;
      padding-bottom: 4px;
      position: relative;
    }
    .header img.logo {
      height: 60px;
      margin-bottom: 4px;
    }
    .header h2 {
      margin: 4px 0 0;
      font-size: 17px;
      text-transform: uppercase;
    }
    .header small {
      display: block;
      font-size: 11px;
      margin-top: 2px;
    }
    .qr {
      position: absolute;
      top: 20px;
      left: 25px;
    }
    .qr img {
      width: 40px;
      height: 40px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
      margin-top: 6px;
    }
    td {
      padding: 2px 4px;
      vertical-align: top;
    }
    .tes {
      border-top: 1px dashed #999;
      margin-top: 8px;
      padding-top: 6px;
      font-size: 12.5px;
    }
    .catatan {
      font-size: 11.5px;
      margin-top: 10px;
      padding-top: 4px;
      border-top: 1px dashed #aaa;
    }
    .bottom-section {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-top: 20px;
    }
    .foto {
      width: 85px;
      height: 110px;
      border: 1px solid #000;
      text-align: center;
      font-size: 10px;
      line-height: 110px;
      color: #777;
      background: #f9f9f9;
    }
    .footer {
      text-align: right;
      font-size: 12px;
      flex-grow: 1;
    }
    .footer p {
      margin: 0;
    }
    .footer .sign {
      margin-top: 35px;
      border-top: 1px solid #000;
      display: inline-block;
      padding-top: 4px;
      font-size: 11px;
    }
    @media print {
      body {
        margin: 0;
        padding: 0;
        display: block;
      }
      .noprint { display: none; }
      .card {
        margin: 0 auto 15px;
        page-break-after: always;
      }
    }
  </style>
</head>
<body>

  <div class="noprint">
    <button onclick="window.print()">🖨 Cetak Kartu Tes</button>
  </div>

  <div class="card">

    <!-- QR CODE -->
    <div class="qr">
      <img id="qrcode" src="https://api.qrserver.com/v1/create-qr-code/?size=40x40&data={{ $ppdb->kode_bayar }}" alt="QR">
    </div>

    <!-- HEADER -->
    <div class="header">
      <img src="/img/svg/sdm2_logo.svg" class="logo" alt="Logo Sekolah">
      <h2>SD MUHAMMADIYAH 2 PONTIANAK</h2>
      <small>Jl. Ahmad Yani No.9, Pontianak Selatan, Kalimantan Barat</small>
      <small>Kartu Tes Seleksi Penerimaan Murid Baru (SPMB)</small>
      <small>Tahun Pelajaran {{$setting->tahun_ajaran ?? ""}}</small>
    </div>

    <!-- BIODATA -->
    <table>
      <tr><td width="40%">Nomor Urut</td><td>: {{ $ppdb->id }}-EDU</td></tr>
      <tr><td>Nama Lengkap</td><td>: {{ $ppdb->nama }}</td></tr>
      <tr><td>Jenis Kelamin</td><td>: {{ $ppdb->detail['jenis-kelamin'] ?? '-' }}</td></tr>
      <tr><td>Kode Bayar</td><td>: {{ $ppdb->kode_bayar }}</td></tr>
      <tr><td>Tgl Pendaftaran</td><td>: {{ $ppdb->created_at->format('d/m/Y H:i:s') }}</td></tr>
    </table>

    <!-- JADWAL TES -->
    <table class="tes">
      <tr>
        <td colspan="2"><b>Jadwal Tes Psikotes</b></td>
      </tr>
      <tr>
        <td width="35%">Tanggal</td>
        <td>:
          {{ $schedule && $schedule->iq_date 
              ? \Carbon\Carbon::parse($schedule->iq_date)->translatedFormat('d F Y') 
              : '-' }}
        </td>
      </tr>
      <tr>
        <td>Waktu</td>
        <td>:
          @if($schedule && $schedule->iq_start_time)
            {{ \Carbon\Carbon::parse($schedule->iq_start_time)->format('H:i') }}
            -
            {{ \Carbon\Carbon::parse($schedule->iq_end_time)->format('H:i') }}
          @else
            -
          @endif
        </td>
      </tr>

      <tr><td colspan="2" style="height: 8px;"></td></tr>

      <tr>
        <td colspan="2"><b>Jadwal Tes Pemetaan</b></td>
      </tr>
      <tr>
        <td>Tanggal</td>
        <td>:
          {{ $schedule && $schedule->map_date
              ? \Carbon\Carbon::parse($schedule->map_date)->translatedFormat('d F Y')
              : '-' }}
        </td>
      </tr>
      <tr>
        <td>Waktu</td>
        <td>:
          @if($schedule && $schedule->map_start_time)
            {{ \Carbon\Carbon::parse($schedule->map_start_time)->format('H:i') }}
            -
            {{ \Carbon\Carbon::parse($schedule->map_end_time)->format('H:i') }}
          @else
            -
          @endif
        </td>
      </tr>
    </table>

    <!-- CATATAN -->
    <div class="catatan">
      <b>Catatan:</b>
      <ol style="margin:4px 0 0 16px; padding:0;">
        <li>Peserta wajib membawa kartu tes ini saat ujian.</li>
        <li>Datang 30 menit sebelum tes dimulai.</li>
        <li>Berpakaian sopan dan rapi.</li>
      </ol>
    </div>

    <!-- TTD -->
    <div class="bottom-section">
      <div class="foto">Tempel Foto 3x4</div>
      <div class="footer">
        <p>Pontianak, {{ \Carbon\Carbon::parse($ppdb->validated_at)->translatedFormat('d F Y') }}</p>
        <div class="sign">Hj. Yumi Pariyanti, S.Pd<br><small>Kepala Sekolah</small></div>
      </div>
    </div>
  </div>

  <script>
    window.onload = function() {
      setTimeout(() => window.print(), 600);
    };
  </script>

</body>
</html>
