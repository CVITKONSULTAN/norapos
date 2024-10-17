<html>
    <title>Raport</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            /* font: 12pt "Tahoma"; */
            font: 12pt "Times New Roman";
        }
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .subpage {
            padding: 1cm;
            border: 5px red solid;
            height: 257mm;
            outline: 2cm #FFEAEA solid;
        }
        table.head_table tr td{
            padding: 2.5px 5px;
            vertical-align: top;
        }
        table.tabel_penilaian{
            margin-top: 10px;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }
        table.tabel_penilaian tr td {
            border: 1px solid black;
            padding: 5px 10px;
            /* vertical-align: top; */
        }
        table.tabel_penilaian tr th
        {
            background-color: rgb(199, 199, 199);
            color: black;
            border: 1px solid black;
            text-align: center;
            padding: 5px 10px;
        }
        .text-center{
            text-align: center;
        }
        td.kop_detail p {
            margin: 0;
            text-align: center;
        }
        table.table_kop{
            border-bottom: 2.5px solid black;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .tulisan_rangkai{
            font-family: "Great Vibes", cursive;
            font-weight: bold;
            font-size: 14pt;
        }
        p.ttd{
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 0px;
        }
        table.table_ttd{
            width: 100%;
            margin-top: 10px;
        }
        table.table_ttd td{
            vertical-align: top;
        }
        table.tabel_kehadiran{
            width: 35%;
        }
        table.tabel_kehadiran tr td{
            padding: 2px 5px;
            border: 0px;
            border-bottom: 1px solid black;
        }
        
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;        
            }
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
    <body>
        <div class="book">
            <div class="page">  
                <table class="table_kop">
                    <tr>
                        <td>
                            <img
                                width="100" 
                                src="/img/logo_dikbud.png"
                            />
                        </td>
                        <td class="kop_detail">
                            <p>PEMERINTAH KOTA PONTIANAK</p>
                            <p>KOORDINATOR WILAYAH DIKPORA KECAMATAN PONTIANAK SELATAN</p>
                            <p>SD MUHAMMADIYAH 2 PONTIANAK</p>
                            <p>Jalan Jendral Ahmad Yani</p>
                            <p>Telp. (0561) 733539</p>
                        </td>
                        <td>
                            <img 
                                width="130" 
                                src="/img/sd_muhamamdiyah_2.png"
                            />
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="vertical-align:top;">
                            <table class="head_table">
                                <tr>
                                    <td>NISN</td>
                                    <td>:</td>
                                    <td>{{ $kelas_siswa->siswa->nisn ?? "" }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Peserta Didik</td>
                                    <td>:</td>
                                    <td>{{ $kelas_siswa->siswa->nama ?? "" }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Sekolah</td>
                                    <td>:</td>
                                    <td>{{ $business->name }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top">Alamat Sekolah</td>
                                    <td style="vertical-align: top">:</td>
                                    <td>{!! $alamat !!}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="vertical-align:top;">
                            <table class="head_table">
                                <tr>
                                    <td>Kelas</td>
                                    <td>:</td>
                                    <td>{{ $kelas_siswa->kelas->nama_kelas ?? "" }}</td>
                                </tr>
                                <tr>
                                    <td>Fase</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Semester</td>
                                    <td>:</td>
                                    <td>{{ $kelas_siswa->kelas->semester ?? "" }}</td>
                                </tr>
                                <tr>
                                    <td>Tahun Pelajaran</td>
                                    <td>:</td>
                                    <td>{{ $kelas_siswa->kelas->tahun_ajaran ?? "" }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table class="tabel_penilaian">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>Nilai Akhir</th>
                            <th>Capaian Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @for ($i = 0; $i < 10; $i++)     --}}
                            @foreach ($nilai_list as $key => $item)    
                                <tr>
                                    <td class="text-center">{{ $key+1 }}</td>
                                    {{-- <td class="text-center">{{ $i+1 }}</td> --}}
                                    <td>{{ $item->mapel->nama }}</td>
                                    <td class="text-center">{{ $item->nilai_rapor }}</td>
                                    <td>
                                        <ol>
                                            <li>{{ $item->catatan_max_tp }}</li>
                                            <li>{{ $item->catatan_min_tp }}</li>
                                        </ol>
                                    </td>
                                </tr>
                            @endforeach
                        {{-- @endfor --}}
                    </tbody>
                </table>

                <table class="tabel_penilaian">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ekstrakurikuler</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Hizbul Wathan</td>
                            <td>Kurang aktif mengikuti kegiatan Ekstrakurikuler</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Renang</td>
                            <td>Kurang aktif mengikuti kegiatan Ekstrakurikuler</td>
                        </tr>
                    </tbody>
                </table>

                <table class="tabel_penilaian">
                    <thead>
                        <tr>
                            <th>Catatan Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Catatan guru
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="tabel_penilaian">
                    <thead>
                        <tr>
                            <th>Kesimpulan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Kesimpulan
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="tabel_penilaian tabel_kehadiran">
                    <thead>
                        <tr>
                            <th colspan="3">Ketidakhadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sakit</td>
                            <td>:</td>
                            <td>12 hari</td>
                        </tr>
                        <tr>
                            <td>Izin</td>
                            <td>:</td>
                            <td>1 hari</td>
                        </tr>
                        <tr>
                            <td>Tanpa Keterangan</td>
                            <td>:</td>
                            <td>- hari</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table_ttd">
                    <tr>
                        <td>
                            <p>
                                Mengetahui,<br />
                                Orangtua/Wali
                            </p>
                            <br />
                            <p class="ttd">Nama Orang tua</p>
                        </td>
                        <td>
                            <p>
                                <br />
                                Kepala Sekolah
                            </p>
                            <br />
                            <p class="ttd">Nama Kepala Sekolah</p>
                            <p style="margin:0px;">NBM. 123</p>
                        </td>
                        <td>
                            <p>
                                Mengetahui,<br />
                                Orangtua/Wali
                            </p>
                            <br />
                            <p class="ttd">Nama Orang tua</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>