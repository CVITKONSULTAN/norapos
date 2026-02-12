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
        width: 216mm;
        min-height: 356mm;
        padding: 20mm;
        margin: 10px auto;
        background: white;
        box-shadow: 0 0 5px rgba(0,0,0,0.3);
    }

    @page {
        size: legal;
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
        width: 65%;
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
    width: 216mm;
    min-height: 356mm;
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
    font-size: 12pt;
    font-weight: bold;
}

.kop-subtitle {
    font-size: 16pt;
    font-weight: 900;
    margin-top: 2px;
    line-height: 1.2;
}

.kop-alamat {
    font-size: 10pt;
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
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}

.tabel_custom_head tr td {
    padding: 1px 10px;
}

/* td pertama pada setiap baris */
.tabel_custom_head tr td:first-child {
    padding-left: 0;
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

@if($pengajuan['tipe'] == 'SLF' || $pengajuan['tipe'] == 'PBG/SLF')
<div class="page">

    <h2 style="text-align:center;">DAFTAR SIMAK PEMERIKSAAN KELAIKAN FUNGSI BANGUNAN GEDUNG</h2>

    <table class="no-border">
        <tr><td width="25%">Nama Pemohon</td><td>: {{ $pengajuan['nama_pemohon'] ?? '-' }}</td></tr>
        <tr><td>Fungsi Bangunan</td><td>: {{ $pengajuan['fungsi_bangunan'] ?? '-' }}</td></tr>
        <tr><td>Lokasi Bangunan</td><td>: {{ $pengajuan['alamat'] ?? '-' }}</td></tr>
    </table>

    {{-- =========================
        LOOP SECTION LEVEL 1
    ========================== --}}
    @foreach($inspectionResults as $section)

        <div class="section-title">
            {{ $section['caption'] }}
        </div>

        {{-- ===========================
            TABLE LEVEL 1
        ============================ --}}
        @if(!empty($section['rows']))
            <table>
                <thead>
                    <tr>
                        <th width="70%">Uraian</th>
                        <th width="15%">Ya / Ada / Sesuai</th>
                        <th width="15%">Tidak / Tidak Ada</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($section['rows'] as $row)
                        <tr>
                            <td>{{ $row['question'] }}</td>

                            <td class="check">
                                {{ in_array($row['answer'], ['Ya','Ada','Sesuai']) ? '☑' : '' }}
                            </td>

                            <td class="check">
                                {{ in_array($row['answer'], ['Tidak','Tidak Ada','Tidak Sesuai']) ? '☑' : '' }}
                            </td>
                        </tr>

                        {{-- === VISUAL (LEVEL 1) === --}}
                        @if(!empty($row['visual']))
                        <tr>
                            <td colspan="3" style="padding-left:25px; font-style:italic; color:#444;">
                                Hasil Pengamatan Visual: <b>{{ $row['visual'] }}</b>
                            </td>
                        </tr>
                        @endif

                    @endforeach
                </tbody>
            </table>
        @endif


        {{-- ===========================
            TABLE LEVEL 2
        ============================ --}}
        @foreach($section['child'] as $child1)

            <div class="sub-title" style="margin-top:10px;">
                {{ $child1['caption'] }}
            </div>

            @if(!empty($child1['rows']))
                <table>
                    <thead>
                        <tr>
                            <th width="70%">Uraian</th>
                            <th width="15%">Ya / Ada / Sesuai</th>
                            <th width="15%">Tidak / Tidak Ada</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($child1['rows'] as $row)
                            <tr>
                                <td style="padding-left:20px;">
                                    {{ $row['question'] }}
                                </td>

                                <td class="check">
                                    {{ in_array($row['answer'], ['Ya','Ada','Sesuai']) ? '☑' : '' }}
                                </td>

                                <td class="check">
                                    {{ in_array($row['answer'], ['Tidak','Tidak Ada','Tidak Sesuai']) ? '☑' : '' }}
                                </td>
                            </tr>

                            {{-- === VISUAL (LEVEL 2) === --}}
                            @if(!empty($row['visual']))
                            <tr>
                                <td colspan="3" style="padding-left:45px; font-style:italic; color:#444;">
                                    Hasil Pengamatan Visual: <b>{{ $row['visual'] }}</b>
                                </td>
                            </tr>
                            @endif

                        @endforeach
                    </tbody>
                </table>
            @endif


            {{-- ===========================
                TABLE LEVEL 3
            ============================ --}}
            @foreach($child1['child'] as $child2)

                <div class="sub-title-2" style="margin-top:5px;">
                    {{ $child2['caption'] }}
                </div>

                <table>
                    <thead>
                        <tr>
                            <th width="70%">Uraian</th>
                            <th width="15%">Ya / Ada / Sesuai</th>
                            <th width="15%">Tidak / Tidak Ada</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($child2['rows'] as $row)
                            <tr>
                                <td style="padding-left:35px;">
                                    {{ $row['question'] }}
                                </td>

                                <td class="check">
                                    {{ in_array($row['answer'], ['Ya','Ada','Sesuai']) ? '☑' : '' }}
                                </td>

                                <td class="check">
                                    {{ in_array($row['answer'], ['Tidak','Tidak Ada','Tidak Sesuai']) ? '☑' : '' }}
                                </td>
                            </tr>

                            {{-- === VISUAL (LEVEL 3) === --}}
                            @if(!empty($row['visual']))
                            <tr>
                                <td colspan="3" style="padding-left:65px; font-style:italic; color:#444;">
                                    Hasil Pengamatan Visual: <b>{{ $row['visual'] }}</b>
                                </td>
                            </tr>
                            @endif

                        @endforeach
                    </tbody>
                </table>

            @endforeach

        @endforeach

    @endforeach

    <!-- ======================
        6.11 TTD
    ======================= -->
    <br><br>
    <table class="no-border">
        <tr>
            <td width="50%" style="text-align:center;">
                Mengetahui,<br>Pemilik Bangunan<br><br><br><br>
                <u>{{ $pengajuan['nama_pemohon'] }}</u>
            </td>
            <td style="text-align:center;">
                Kubu Raya, 01-08-2025<br>Pemeriksa Teknis<br><br><br><br>
                <u>{{ $pengajuan['petugas_lapangan']['nama'] ?? '-' }}</u>
            </td>
        </tr>
    </table>

</div>
@endif


<div class="page">
    <div class="page-dokumentasi">

        <div class="left-panel">
            <div class="judul-vertical">DOKUMENTASI VISUAL LAPANGAN</div>

            <div class="info-box">
                <p><strong>NAMA PEMOHON</strong><br>{{ $pengajuan['nama_pemohon'] ?? '-' }}</p>
                <p><strong>FUNGSI BANGUNAN</strong><br>{{ $pengajuan['fungsi_bangunan'] ?? '-' }}</p>
                <p><strong>LOKASI BANGUNAN</strong><br>{{ $pengajuan['alamat'] ?? '-' }}</p>
            </div>
        </div>

        <div class="right-panel">

            <div class="foto-grid">

                @foreach($inspectionResults as $sec)

                    @php
                        preg_match('/^(\d+)/', $sec['caption'], $m);
                        $secNum = $m[1] ?? null;

                        $fotos = $sectionPhotos[$secNum] ?? [];
                    @endphp

                    @foreach($fotos as $foto)
                        <div class="foto-item">
                            <div class="foto-frame">
                                <img src="{{ $foto['url'] }}">
                            </div>
                            <div class="foto-label">{{ $foto['caption'] }}</div>
                        </div>
                    @endforeach

                @endforeach

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
