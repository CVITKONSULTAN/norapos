@extends('layouts.app')
@section('title', 'Rincian Retribusi - Full Table')

@section('css')
<style>
  @page { size: 216mm 330mm; margin: 8mm; }
  body { font-family: Arial, sans-serif; font-size:12px; margin:0; padding:0; color:#000; }
  .wrap { padding:6mm; box-sizing:border-box; }

  /* single big table style */
  table.full { width:100%; border-collapse:collapse; table-layout:fixed; }
  table.full td, table.full th {
    padding:4px 6px;
    vertical-align: top;
    border: 1px solid #000;
    font-size:12px;
    word-wrap:break-word;
  }

  .no-border td { border:none !important; padding:0; }
  .header-block { border:none; }
  .big-number { font-size:18px; font-weight:700; text-align:right; }
  .title { font-weight:700; font-size:15px; text-align:center; line-height:1.1; }
  .subtitle { text-align:center; font-size:11px; }
  .section { background:#efefef; font-weight:700; }
  .center { text-align:center; }
  .right { text-align:right; }
  .bold { font-weight:700; }
  .no-top { border-top:none; }
  .no-bottom { border-bottom:none; }
  .no-left { border-left:none; }
  .no-right { border-right:none; }

  /* make inputs invisible in print if used later */
  @media print {
    button { display:none; }
  }

  /* small helpers */
  .small { font-size:11px; }
</style>
@endsection

@section('content')
<div class="wrap">

  <p style="text-align:right; margin:0 0 6px 0;"><button onclick="window.print()">🖨 Cetak</button></p>

  <!-- ONE BIG TABLE: adjust colspan/rowspan to mimic merged Excel cells -->
  <table class="full" aria-label="Rincian Retribusi Full Table">
    <!-- HEADER ROWS (logo - titles - no.retribusi) -->
    <tr class="no-border">
      <td colspan="6" class="header-block" style="width:18%; text-align:center; border:none;">
        <!-- logo placeholder -->
        <img src="/img/logo-kkr.png" alt="logo" style="width:64px; height:auto;">
      </td>

      <td colspan="14" class="header-block" style="border:none;">
        <div class="title">PEMERINTAH KABUPATEN KUBU RAYA</div>
        <div class="title">DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</div>
        <div class="title">PERUMAHAN RAKYAT DAN KAWASAN PERMUKIMAN</div>
        <div class="subtitle small">Jalan Angkasa Pura II, Sungai Raya Kubu Raya 78391 Telepon (0561) 6718384</div>
        <div class="subtitle small">Laman www.pupr.kuburaya.go.id</div>
      </td>

      <td colspan="4" class="header-block" style="border:1px solid #000; padding:8px;">
        <div class="bold">RINCIAN RETRIBUSI</div>
        <div style="margin-top:6px;">No.Retribusi :</div>
        <div class="big-number">276</div>
      </td>
    </tr>

    <!-- spacer row -->
    <tr><td colspan="24" style="border:none; padding:6px 0;"></td></tr>

    <!-- IDENTITAS PEMOHON -->
    <tr>
      <td colspan="4" class="section">Nama Pemohon</td>
      <td colspan="10">HERLINA</td>
      <td colspan="3" class="section">Pekerjaan</td>
      <td colspan="7">Mengurus Rumah Tangga</td>
    </tr>

    <tr>
      <td colspan="4" class="section">Alamat Pemohon</td>
      <td colspan="10">Jl. Kom Yos Sudarso, Gg. Jambu, RT.001/RW.012, Kelurahan Sungai Jawi Luar, Kecamatan Pontianak Barat, Kota Pontianak, Provinsi Kalimantan Barat</td>
      <td colspan="3" class="section">NIK</td>
      <td colspan="7">6171014107860108</td>
    </tr>

    <!-- spacer -->
    <tr><td colspan="24" style="border:none; height:6px;"></td></tr>

    <!-- A. RINCIAN BANGUNAN GEDUNG -->
    <tr>
      <td colspan="24" class="section">A. RINCIAN BANGUNAN GEDUNG</td>
    </tr>

    <tr>
      <td colspan="4" class="bold">Nama Bangunan</td>
      <td colspan="8">CEK</td>
      <td colspan="3" class="bold">Luas Bangunan</td>
      <td colspan="9">360,00 m2</td>
    </tr>

    <tr>
      <td colspan="4" class="bold">Alamat Bangunan</td>
      <td colspan="8">Jl. Raya Desa Kapur, Gg. Ahmad, Desa Mekar Baru, Kecamatan Sungai Raya, Kabupaten Kubu Raya, Provinsi Kalimantan Barat</td>
      <td colspan="3" class="bold">Koordinat</td>
      <td colspan="9">UTM 0322164, 9991162</td>
    </tr>

    <tr>
      <td colspan="4" class="bold">Fungsi Bangunan</td>
      <td colspan="8">Hunian (&lt;100 m² dan &lt; 2 Lantai)</td>
      <td colspan="3" class="bold">Jumlah Lantai</td>
      <td colspan="9">2 Lantai</td>
    </tr>

    <tr>
      <td colspan="4" class="bold">Keterbangunan</td>
      <td colspan="20">Bangunan Gedung Baru</td>
    </tr>

    <!-- spacer -->
    <tr><td colspan="24" style="border:none; height:6px;"></td></tr>

    <!-- PERHITUNGAN INDEKS TERINTEGRASI (grid block) -->
    <tr>
      <td colspan="24" class="section">PERHITUNGAN INDEKS TERINTEGRASI</td>
    </tr>

    <!-- header of grid -->
    <tr class="bold center">
      <td colspan="4">Fungsi Bangunan (If)</td>
      <td colspan="4">Klasifikasi</td>
      <td colspan="6">Parameter</td>
      <td colspan="3">Bobot Parameter (bp)</td>
      <td colspan="3">Indeks Parameter (Ip)</td>
      <td colspan="4">Faktor Kepemilikan (Fm)</td>
    </tr>

    <!-- three parameter rows -->
    <tr>
      <td colspan="4" rowspan="3">Usaha (UMKM–Prototype)</td>
      <td colspan="4">Kompleksitas</td>
      <td colspan="6">Tidak Sederhana</td>
      <td colspan="3" class="center">0,3</td>
      <td colspan="3" class="center">0,600</td>
      <td colspan="4" rowspan="3" class="center">Perorangan</td>
    </tr>

    <tr>
      <td colspan="4">Permanensi</td>
      <td colspan="6">Permanen</td>
      <td colspan="3" class="center">0,2</td>
      <td colspan="3" class="center">0,400</td>
    </tr>

    <tr>
      <td colspan="4">Ketinggian</td>
      <td colspan="6">2</td>
      <td colspan="3" class="center">0,5</td>
      <td colspan="3" class="center">1,09</td>
    </tr>

    <tr>
      <td colspan="4" class="right bold">Indeks Parameter Total Σ (bp × Ip)</td>
      <td colspan="11" class="center bold">1,545</td>
      <td colspan="9" class="center bold">1,00</td>
    </tr>

    <tr>
      <td colspan="24" class="bold">Indeks Terintegrasi (It) = If × Σ (bp × Ip) × Fm = <span class="bold">0,773</span></td>
    </tr>

    <!-- spacer -->
    <tr><td colspan="24" style="border:none; height:6px;"></td></tr>

    <!-- PERHITUNGAN RETRIBUSI BANGUNAN GEDUNG -->
    <tr>
      <td colspan="24" class="section">PERHITUNGAN RETRIBUSI BANGUNAN GEDUNG</td>
    </tr>

    <!-- header -->
    <tr class="center bold">
      <td colspan="2">No.</td>
      <td colspan="7">Nama Bangunan</td>
      <td colspan="3">Nilai Retribusi Bangunan (Rp.)</td>
      <td colspan="2">Luas Lantai Total (LLt) (m²)</td>
      <td colspan="1">Unit</td>
      <td colspan="2">Indeks Lokalitas (Ilo)</td>
      <td colspan="3">Standar Harga Satuan (SHST)</td>
      <td colspan="2">Indeks Terintegrasi (It)</td>
      <td colspan="2">Indeks BG Terbangun (Ibg)</td>
    </tr>

    <!-- row 1 -->
    <tr>
      <td class="center" colspan="2">1</td>
      <td colspan="7">- bangunan Induk (Lt.1)</td>
      <td colspan="3" class="right">6.176.270,00</td>
      <td colspan="2" class="center">235,00</td>
      <td class="center">1</td>
      <td colspan="2" class="center">0,50</td>
      <td colspan="3" class="right">6.800.000,00</td>
      <td colspan="2" class="center">0,773</td>
      <td colspan="2" class="center">1,000</td>
    </tr>

    <!-- total building -->
    <tr>
      <td colspan="9" class="bold">Nilai Total Retribusi Bangunan</td>
      <td colspan="15" class="bold right">Rp. 9.461.600,00</td>
    </tr>

    <!-- spacer -->
    <tr><td colspan="24" style="border:none; height:6px;"></td></tr>

    <!-- B. RINCIAN PRASARANA -->
    <tr><td colspan="24" class="section">B. RINCIAN PRASARANA BANGUNAN GEDUNG</td></tr>

    <!-- header prasarana -->
    <tr class="center bold">
      <td colspan="2">No.</td>
      <td colspan="7">Jenis Prasarana BG</td>
      <td colspan="3">Nilai Retribusi Prasarana (Nr) (Rp.)</td>
      <td colspan="3">Luas/Tinggi/Volume (V)</td>
      <td colspan="2">Jumlah</td>
      <td colspan="2">Indeks Prasarana (I)</td>
      <td colspan="2">Indeks BG Terbangun (Ibg)</td>
      <td colspan="3">Harga Satuan Retribusi BG (HSPbg) (Rp.)</td>
    </tr>

    <!-- sample rows -->
    <tr>
      <td class="center" colspan="2">1</td>
      <td colspan="7">Teras Depan</td>
      <td colspan="3" class="center">172,00 m²</td>
      <td colspan="3" class="center">1</td>
      <td colspan="3" class="center">-</td>
      <td colspan="3" class="center">-</td>
      <td colspan="3" class="right">3.000,00 / m²</td>
    </tr>

    <tr>
      <td class="center" colspan="2">2</td>
      <td colspan="7">Teras Belakang</td>
      <td colspan="3" class="center">3,00 m²</td>
      <td colspan="3" class="center">1</td>
      <td colspan="3" class="center">-</td>
      <td colspan="3" class="center">-</td>
      <td colspan="3" class="right">3.000,00 / m²</td>
    </tr>

    <tr>
      <td class="center" colspan="2">3</td>
      <td colspan="7">Balkon</td>
      <td colspan="3" class="center">23,50 m²</td>
      <td colspan="3" class="center">1</td>
      <td colspan="3" class="center">-</td>
      <td colspan="3" class="center">-</td>
      <td colspan="3" class="right">3.000,00 / m²</td>
    </tr>

    <tr>
      <td class="center" colspan="2">4</td>
      <td colspan="7">Dak Terbuka</td>
      <td colspan="3" class="center">110,00 m²</td>
      <td colspan="3" class="center">1</td>
      <td colspan="3" class="center">-</td>
      <td colspan="3" class="center">-</td>
      <td colspan="3" class="right">3.000,00 / m²</td>
    </tr>

    <tr>
      <td class="center" colspan="2">5</td>
      <td colspan="7">Septictank</td>
      <td colspan="3" class="center">6,84 m³</td>
      <td colspan="3" class="center">1</td>
      <td colspan="3" class="center">-</td>
      <td colspan="3" class="center">-</td>
      <td colspan="3" class="right">3.000,00 / m³</td>
    </tr>

    <tr>
      <td colspan="11" class="bold">Nilai Total Retribusi Prasarana</td>
      <td colspan="13" class="bold right">Rp. -</td>
    </tr>

    <!-- spacer -->
    <tr><td colspan="24" style="border:none; height:6px;"></td></tr>

    <!-- C. RETRIBUSI TOTAL -->
    <tr>
      <td colspan="16" class="bold">C. RETRIBUSI TOTAL</td>
      <td colspan="4" class="bold right">- Retribusi Bangunan</td>
      <td colspan="4" class="right">Rp. 9.461.600,00</td>
    </tr>

    <tr>
      <td colspan="16"></td>
      <td colspan="4" class="bold right">- Retribusi Prasarana</td>
      <td colspan="4" class="right">Rp. -</td>
    </tr>

    <tr>
      <td colspan="16" class="bold">NILAI TOTAL RETRIBUSI</td>
      <td colspan="8" class="bold right">Rp. 9.461.600,00</td>
    </tr>

    <tr>
      <td colspan="24" style="border:none; padding-top:4px; font-style:italic;">
        Terbilang: Sembilan Juta Empat Ratus Enam Puluh Satu Ribu Enam Ratus Rupiah
      </td>
    </tr>

    <!-- spacer -->
    <tr><td colspan="24" style="border:none; height:12px;"></td></tr>

    <!-- signatures area (no grid lines ideal; but we keep thin borders around if needed) -->
    <tr>
      <td colspan="8" class="no-border center">
        diperiksa oleh,<br><br><br>
        <span class="bold">KHATIM ASY'ARI, S.T., M.T.</span><br>
        NIP 198104172006041011
      </td>

      <td colspan="8" class="no-border center">
        dibuat oleh,<br><br><br>
        <span class="bold">AIDIL BUSYRA, S.T., M.Sc</span><br>
        NIP 197709142003121005
      </td>

      <td colspan="8" class="no-border center">
        disetujui oleh,<br><br><br>
        <span class="bold">SUPRATMANSYAH, S.T.</span><br>
        NIP 197308062008021001
      </td>
    </tr>

    <tr>
      <td colspan="24" style="border:none; padding-top:6px;" class="small">
        Keterangan: 1. Lembar Ke 1 : (Asli) untuk penyetor &nbsp; &nbsp; 2. Lembar Ke 2 : Bendahara Penerima &nbsp; &nbsp; 3. Lembar Ke 3 : DPMPTSP &nbsp; &nbsp; 4. Lembar Ke 4 : Arsip
      </td>
    </tr>

  </table>

</div>
@endsection