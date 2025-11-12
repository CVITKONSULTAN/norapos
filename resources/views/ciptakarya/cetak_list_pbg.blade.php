<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cetak Pemeriksaan Bangunan</title>

<style>
    /* =======================
       GLOBAL STYLE
    ======================== */
    body {
        font-family: Arial, sans-serif;
        font-size: 12pt;
        margin: 0;
        padding: 0;
        background: #f2f2f2;
    }

    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10px auto;
        background: white;
        box-shadow: 0 0 5px rgba(0,0,0,0.3);
    }

    @page {
        size: A4;
        margin: 15mm;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        border: 1px solid #000;
        padding: 6px 8px;
        vertical-align: top;
    }

    th {
        background: #f5da8b;
    }

    .section-title {
        font-weight: bold;
        font-size: 12pt;
        margin: 18px 0 8px;
    }

    .no-border td, .no-border th {
        border: none !important;
    }

    .check { font-size: 12pt; }

    /* =======================
       PRINT BUTTON
    ======================== */

    .print-btn {
        display: inline-block;
        background: #007bff;
        color: white;
        padding: 10px 18px;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        margin: 15px 0;
    }

    .print-btn:hover {
        background: #0056b3;
    }

    .tabel_head {
        width: 40%;
    }
    .tabel_head tr td {
        border: 0px;
    }

    .tabel_surat_pernyataan {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        border-width: 0px;
    }

    /* Kolom */
    .tabel_surat_pernyataan td {
        padding: 6px;
        vertical-align: top;
        border: 0px ;   /* kalau mau tanpa garis ubah jadi border:0 */
        font-size: 12pt;
    }

    /* Kolom kiri (judul) */
    .tabel_surat_pernyataan td:first-child {
        width: 260px;
        font-weight: bold;
    }

    .ttd-container {
        font-family: Arial, sans-serif;
    }

    .ttd-container .jabatan {
        /* margin-bottom: 60px; ruang besar untuk tanda tangan */
        font-size: 12pt;
    }

    .ttd-container .nama-pejabat {
        font-size: 12pt;
    }

    .ttd-container img {
        width: 200px;
        display: block;
        margin-right: 0;
    }

    .page-dokumentasi {
    width: 210mm;
    min-height: 297mm;
    padding: 20mm;
    box-sizing: border-box;
    display: flex;
    flex-direction: row;
    font-family: Arial, sans-serif;
}

/* ================= LEFT PANEL ================= */
.left-panel {
    width: 30%;
    border: 2px solid #000;
    padding: 10px;
    box-sizing: border-box;
}

.judul-vertical {
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 40px;
}

.info-box p {
    font-size: 12px;
    margin-bottom: 12px;
}

/* ================= RIGHT PANEL ================= */
.right-panel {
    width: 70%;
    padding-left: 20px;
    box-sizing: border-box;
}

.foto-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}

.foto-item {
    text-align: center;
}

.foto-frame {
    border: 2px solid #000;
    padding: 6px;
    width: 100%;
    aspect-ratio: 1/1; /* membuat kotak foto proporsional */
    display: flex;
    justify-content: center;
    align-items: center;
    background: #fff;
}

.foto-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.foto-label {
    margin-top: 6px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
}

.kop-surat {
    display: flex;
    align-items: center;
    gap: 15px;
    padding-bottom: 10px;
}

.kop-logo img {
    width: 70px; /* sesuaikan ukuran */
}

.kop-text {
    text-align: center;
    flex: 1;
    font-family: Arial, sans-serif;
}

.kop-title {
    font-size: 18px;
    font-weight: bold;
}

.kop-subtitle {
    font-size: 18px;
    font-weight: 900;
    margin-top: 2px;
    line-height: 1.2;
}

.kop-alamat {
    font-size: 13px;
    margin-top: 6px;
}

.kop-alamat a {
    color: #007bff;
    text-decoration: none;
}

.kop-line {
    border: 0;
    height: 4px;
    background: #000;
    margin-top: 5px;
}


    /* Sembunyikan tombol print saat dicetak */
    @media print {
        .print-area {
            display: none !important;
        }
        body {
            background: white;
        }
        .page {
            margin: 0;
            box-shadow: none;
            padding: 0;
            page-break-after: always;
        }
    }

</style>

<script>
    // Auto print ketika halaman selesai dimuat
    // window.onload = function() {
    //     setTimeout(function() {
    //         window.print();
    //     }, 500);
    // };
</script>

</head>
<body>

<!-- =======================
      PRINT BUTTON (TOP)
======================= -->
<div class="print-area" style="text-align:center;">
    <a href="#" onclick="window.print()" class="print-btn">🖨 CETAK HALAMAN</a>
</div>

<div class="page">
    <div class="kop-surat">
        <div class="kop-logo">
            <img src="/img/logo-kkr.png" alt="Logo" />
        </div>

        <div class="kop-text">
            <div class="kop-title">PEMERINTAH KABUPATEN KUBU RAYA</div>
            <div class="kop-subtitle">DINAS PEKERJAAN UMUM DAN PENATAAN RUANG,<br>
            PERUMAHAN RAKYAT DAN KAWASAN PERMUKIMAN</div>
            <div class="kop-alamat">
                Jalan Angkasa Pura II, Sungai Raya Kubu Raya 78391  
                Telepon (0561) 6718384<br>
                Laman <a href="http://www.pupr.kuburaya.go.id" target="_blank">www.pupr.kuburaya.go.id</a>
            </div>
        </div>
    </div>

    <hr class="kop-line">

    <p style="text-align: right;">Sungai Raya, ..........</p>
    <table class="tabel_head">
        <tr>
            <td>Nomor</td>
            <td>:</td>
            <td>600.1.15.1/...../SIMBG/DPUPRPRKP-CK/2025</td>
        </tr>
        <tr>
            <td>Sifat</td>
            <td>:</td>
            <td>Biasa</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>1 (satu) Berkas</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td><b>Pernyataan Pemenuhan Standar Teknis Bangunan Gedung</b></td>
        </tr>
    </table>

    <p>Yth. Kepala DPMPTSP Kab. Kuburaya</p>
    <p>di -</p>
    <p>Sungai Raya</p>

    <p style="text-align: justify;">
        Dengan hormat,<br />
        Berdasarkan hasil pemeriksaan kesesuaian dokumen rencana teknis yang disampaikan dan dengan memperhatikan berita acara konsultansi oleh TPA/TPT, bersama ini kami menyatakan bahwa dokumen rencana teknis telah memenuhi standar teknis dengan data sebagai berikut :
    </p>

    <table class="tabel_surat_pernyataan">
        <tr>
            <td><strong>Nomor Permohonan</strong></td>
            <td>611201-01092025-011</td>
        </tr>
        <tr>
            <td><strong>Nomor KRK / KKPR</strong></td>
            <td>600.3.3.2/167/DPUPRPKP-TR/2025</td>
        </tr>
        <tr>
            <td><strong>Nama Pemohon</strong></td>
            <td>SUSANTO<br>an. PT. Cemerlang Interplast Nusantara</td>
        </tr>
        <tr>
            <td><strong>NIK</strong></td>
            <td>6102071812860001</td>
        </tr>
        <tr>
            <td><strong>Alamat</strong></td>
            <td>
            Jl. Sungai Raya Dalam, Komplek Sungai Raya Lestari 2,<br>
            RT.012/RW.001, Desa Sungai Raya Dalam, Kecamatan Sungai Raya,<br>
            Kabupaten Kubu Raya, Provinsi Kalimantan Barat
            </td>
        </tr>
        <tr>
            <td><strong>Fungsi Bangunan</strong></td>
            <td>Usaha</td>
        </tr>
        <tr>
            <td><strong>Nama Bangunan</strong></td>
            <td>Gudang</td>
        </tr>
        <tr>
            <td><strong>Jumlah Bangunan</strong></td>
            <td>1 (satu) Unit</td>
        </tr>
        <tr>
            <td><strong>Jumlah Lantai</strong></td>
            <td>1 (satu) Lantai</td>
        </tr>
        <tr>
            <td><strong>Luas Bangunan</strong></td>
            <td>Bangunan Induk = 321,00 m²</td>
        </tr>
        <tr>
            <td><strong>Ketinggian Bangunan</strong></td>
            <td>8,90 m</td>
        </tr>
        <tr>
            <td><strong>Lokasi Bangunan</strong></td>
            <td>
            Jl. Sungai Raya Dalam, Desa Sungai Raya Dalam,<br>
            Kecamatan Sungai Raya, Kabupaten Kubu Raya,<br>
            Provinsi Kalimantan Barat
            </td>
        </tr>
        <tr>
            <td><strong>Di Atas Tanah No. Persil</strong></td>
            <td>
            SHM No. 48084, Tanggal Penerbitan Sertipikat 18 Juli 2018<br>
            SHM No. 48083, Tanggal Penerbitan Sertipikat 16 Desember 2015
            </td>
        </tr>
        <tr>
            <td><strong>Luas Tanah</strong></td>
            <td>653 m², 141 m²</td>
        </tr>
        <tr>
            <td><strong>Atas Nama/Pemilik Tanah</strong></td>
            <td>Masing-masing an. Susanto</td>
        </tr>
        <tr>
            <td><strong>Garis Sempadan Bangunan (GSB) Minimum</strong></td>
            <td>Depan 15.00 m, Samping 2.00 m</td>
        </tr>
        <tr>
            <td><strong>Koefisien Daerah Hijau (KDH) Minimum</strong></td>
            <td>-</td>
        </tr>
        <tr>
            <td><strong>Koefisien Dasar Bangunan (KDB) Maksimum</strong></td>
            <td>-</td>
        </tr>
        <tr>
            <td><strong>Koefisien Lantai Bangunan (KLB) Maksimum</strong></td>
            <td>-</td>
        </tr>
        <tr>
            <td><strong>Koordinat Bangunan</strong></td>
            <td>-</td>
        </tr>
    </table>
    <p>Dengan demikian permohonan Persetujuan Bangunan Gedung (PBG) dan Sertifikat Laik Fungsi (SLF) dapat disetujui dan diterbitkan.<br />
    Demikian surat pernyataan ini kami sampaikan, atas perhatiannya diucapkan terima kasih.</p>

    <div class="ttd-container" style="margin-left:450px;">
        <div class="jabatan" style="margin-bottom:0px;">
            Plt. Kepala Dinas Pekerjaan Umum dan<br>
            Penataan Ruang, Perumahan Rakyat<br>
            dan Kawasan Permukiman,
        </div>

        <img style="height: 80px;width:80px;" src="/img/ttd_kadis.png" />

        <div class="nama-pejabat">
            <strong>Supratmansyah, S.T.</strong><br>
            Pembina (IV/a)<br>
            NIP 1973080620080201001
        </div>
    </div>
</div>

{{-- <div class="page">
    <p>Dengan demikian permohonan Persetujuan Bangunan Gedung (PBG) dan Sertifikat Laik Fungsi (SLF) dapat disetujui dan diterbitkan.<br />
    Demikian surat pernyataan ini kami sampaikan, atas perhatiannya diucapkan terima kasih.</p>

    <div class="ttd-container">
        <div class="jabatan" style="margin-bottom:0px;">
            Plt. Kepala Dinas Pekerjaan Umum dan<br>
            Penataan Ruang, Perumahan Rakyat<br>
            dan Kawasan Permukiman,
        </div>

        <img style="height: 80px;width:80px;" src="/img/ttd_kadis.png" />

        <div class="nama-pejabat">
            <strong>Supratmansyah, S.T.</strong><br>
            Pembina (IV/a)<br>
            NIP 1973080620080201001
        </div>
    </div>
</div> --}}

<div class="page">

    <h2 style="text-align:center;">DAFTAR SIMAK PEMERIKSAAN KELAIKAN FUNGSI BANGUNAN GEDUNG</h2>

    <table class="no-border">
        <tr><td width="25%">Nama Pemohon</td><td>: SUSANTO</td></tr>
        <tr><td>Fungsi Bangunan</td><td>: Gudang 1 Lantai</td></tr>
        <tr><td>Lokasi Bangunan</td><td>: Jl. Sungai Raya Dalam, Desa Sungai Raya Dalam</td></tr>
    </table>

    <!-- ======================
        1. IDENTITAS PEMILIK
    ======================= -->
    <div class="section-title">1. Identitas Pemilik</div>

    <table>
        <tr>
            <th>Identitas Pemilik</th>
            <th width="15%">Ada</th>
            <th width="15%">Tidak Ada</th>
        </tr>
        <tr>
            <td>Identitas Pemilik</td>
            <td class="check">☑</td>
            <td class="check">☐</td>
        </tr>
    </table>

    <!-- ======================
        2. DOKUMEN PBG
    ======================= -->
    <div class="section-title">2. Dokumen PBG</div>

    <table>
        <tr>
            <th width="5%">No.</th>
            <th>Dokumen PBG</th>
            <th width="15%">Ya</th>
            <th width="15%">Tidak</th>
        </tr>
        <tr><td>1</td><td>Dokumen PBG tersedia</td><td>☑</td><td></td></tr>
        <tr><td>2</td><td>Fungsi Bangunan sesuai dokumen</td><td></td><td>☑</td></tr>
        <tr><td>3</td><td>Luas Bangunan sesuai dokumen</td><td></td><td>☑</td></tr>
        <tr><td>4</td><td>Ketinggian Bangunan sesuai dokumen</td><td></td><td>☑</td></tr>
        <tr><td>5</td><td>Jumlah Lantai sesuai dokumen</td><td></td><td>☑</td></tr>
    </table>

    <!-- ======================
        3. GAMBAR TERBANGUN
    ======================= -->
    <div class="section-title">3. Dokumen Rencana Teknis / Gambar Terbangun</div>

    <table>
        <tr>
            <th>No.</th>
            <th>Dokumen Rencana Teknis</th>
            <th>Ya</th>
            <th>Tidak</th>
        </tr>
        <tr><td>1</td><td>Dokumen tersedia</td><td>☑</td><td></td></tr>
        <tr><td>2</td><td>Fungsi sesuai dokumen</td><td>☑</td><td></td></tr>
        <tr><td>3</td><td>Luas sesuai dokumen</td><td>☑</td><td></td></tr>
        <tr><td>4</td><td>Ketinggian sesuai dokumen</td><td>☑</td><td></td></tr>
        <tr><td>5</td><td>Jumlah lantai sesuai dokumen</td><td></td><td></td></tr>
        <tr><td>6</td><td>Kondisi struktur sesuai dokumen</td><td></td><td></td></tr>
        <tr><td>7</td><td>Kondisi arsitektur sesuai dokumen</td><td>☑</td><td></td></tr>
    </table>

    <!-- ======================
        4. KONDISI GEDUNG
    ======================= -->
    <div class="section-title">4. Kondisi Bangunan Gedung</div>

    <table>
        <tr>
            <th>No.</th>
            <th>Kondisi Bangunan</th>
            <th>Ya</th>
            <th>Tidak</th>
        </tr>
        <tr><td>1</td><td>Miring / deformasi</td><td></td><td>☑</td></tr>
        <tr><td>2</td><td>Kerusakan ringan</td><td></td><td>☑</td></tr>
        <tr><td>3</td><td>Kerusakan sedang</td><td></td><td>☑</td></tr>
        <tr><td>4</td><td>Kerusakan berat</td><td></td><td></td></tr>
        <tr><td>5</td><td>Bangunan terawat</td><td></td><td></td></tr>
    </table>

    <!-- ======================
        5. PENILAIAN NILAI
    ======================= -->
    <div class="section-title">5. Pemeriksaan Kesesuaian Dokumen & Visual</div>

    <table>
        <tr><th>Jenis</th><th>Hasil</th></tr>
        <tr><td>Fungsi Bangunan</td><td>Gudang</td></tr>
        <tr><td>Pemanfaatan Ruang</td><td>M/L/M + N</td></tr>
        <tr><td>Luas Dasar</td><td>457.50</td></tr>
        <tr><td>Luas Lantai</td><td>462.60</td></tr>
        <tr><td>Jumlah Lantai</td><td>1</td></tr>
        <tr><td>Ketinggian</td><td>3.90</td></tr>
    </table>

    <!-- ======================
        6. STRUKTUR
    ======================= -->
    <div class="section-title">6. Pemeriksaan Sistem Struktur</div>

    <table>
        <tr>
            <th>Elemen Struktur</th>
            <th>Pengamatan Visual</th>
            <th>Ada</th><th>Tidak</th>
        </tr>

        <tr><td>Kolom</td><td>Retak, honeycomb</td><td>☑</td><td></td></tr>
        <tr><td>Balok</td><td>Pecah, korosi</td><td></td><td>☑</td></tr>
        <tr><td>Pelat</td><td>Lendutan ringan</td><td>☑</td><td></td></tr>
        <tr><td>Rangka Atap</td><td>Korosi</td><td></td><td>☑</td></tr>
    </table>

    <!-- ======================
        6.2 KEBAKARAN
    ======================= -->
    <div class="section-title">6.2 Proteksi Kebakaran</div>

    <table>
        <tr><th>Jenis Pemeriksaan</th><th>Kondisi</th><th>Kesesuaian</th></tr>
        <tr><td>Hidran</td><td>Ada</td><td>☑ Sesuai</td></tr>
        <tr><td>APAR</td><td>Ada</td><td>☑ Sesuai</td></tr>
    </table>

    <!-- ======================
        6.11 TTD
    ======================= -->
    <br><br>
    <table class="no-border">
        <tr>
            <td width="50%" style="text-align:center;">
                Mengetahui,<br>Pemilik Bangunan<br><br><br><br>
                <u>SUSANTO</u>
            </td>
            <td style="text-align:center;">
                Kubu Raya, 01-08-2025<br>Pemeriksa Teknis<br><br><br><br>
                <u>MARANATHA YOHANES SINAGA, S.ST</u>
            </td>
        </tr>
    </table>

</div>


<div class="page">
    <div class="page-dokumentasi">

        <div class="left-panel">
            <div class="judul-vertical">DOKUMENTASI VISUAL LAPANGAN</div>

            <div class="info-box">
                <p><strong>NAMA PEMOHON</strong><br>SUSANTO / PT. CEMERLANG INTERPLAST NUSANTARA</p>
                <p><strong>FUNGSI BANGUNAN</strong><br>Gudang</p>
                <p><strong>LOKASI BANGUNAN</strong><br>Jl. Sungai Raya Dalam, Desa Sungai Raya Dalam</p>
            </div>
        </div>

        <div class="right-panel">

            <div class="foto-grid">

                <!-- FOTO 1 -->
                <div class="foto-item">
                    <div class="foto-frame">
                        <img src="https://www.suaraindo.id/wp-content/uploads/2025/05/1-45.jpeg" alt="">
                    </div>
                    <div class="foto-label">KONDISI LANTAI</div>
                </div>

                <!-- FOTO 2 -->
                <div class="foto-item">
                    <div class="foto-frame">
                        <img src="https://www.suaraindo.id/wp-content/uploads/2025/05/1-45.jpeg" alt="">
                    </div>
                    <div class="foto-label">KONDISI DINDING</div>
                </div>

                <!-- FOTO 3 -->
                <div class="foto-item">
                    <div class="foto-frame">
                        <img src="https://www.suaraindo.id/wp-content/uploads/2025/05/1-45.jpeg" alt="">
                    </div>
                    <div class="foto-label">KONDISI BANGUNAN LUAR</div>
                </div>

                <!-- FOTO 4 -->
                <div class="foto-item">
                    <div class="foto-frame">
                        <img src="https://www.suaraindo.id/wp-content/uploads/2025/05/1-45.jpeg" alt="">
                    </div>
                    <div class="foto-label">KONDISI RANGKA ATAP</div>
                </div>

            </div>

        </div>

    </div>
</div>

<!-- =======================
      PRINT BUTTON (BOTTOM)
======================= -->
<div class="print-area" style="text-align:center;">
    <a href="#" onclick="window.print()" class="print-btn">🖨 CETAK HALAMAN</a>
</div>

</body>
</html>
