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
            position: relative;
            width: 210mm;
            min-height: 297mm;
            padding: 0mm 20mm;
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
            /* margin-bottom: 10px; */
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
        h1{
            font-size: 13pt;
            margin: 0px;
        }
        h2{
            font-size: 12pt;
        }
        h3{
            margin: 0px;
            font-size: 12pt;
        }
        ol {
            margin: 0px;
            margin-bottom: 10px;
        }
        .bingkai_cover{
            background-image: url('/img/bingkai_buku_induk.png');
            background-size:     cover;
            background-repeat:   no-repeat;
            background-position: center center; 
            height: 297mm;
        }
        .bg_bingkai{
            height: 100%;
            width: 80%;
            position: absolute;
        }
        table.tabel_no_seri tr td{
            padding: 3px 10px;
        }
        table.tabel_no_seri tr{
            border: 1px solid black;
        }
        table.tabel_no_seri{
            border: 1px solid black;
            border-collapse: collapse;
        }
        .cover_head_table{
            position: absolute;
            right: 70px;
        }
        div.cover_container {
            padding: 70px;
            position: relative;
        }
        table.detail_sekolah tr td{
            padding: 10px 3px;
        }
        table.detail_sekolah{
            font-weight: bold;
            font-size: 12pt;
            margin-top: 50px;
            width: 100%;
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
                position: relative;
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
            .bg_bingkai{
                width: 80%;
                position: absolute;
                height: 330mm;
            }
        }
    </style>
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
        }
        .header .info {
            margin-top: 10px;
            font-size: 14px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .content {
            width: 70%;
        }
        .photo {
            width: 25%;
            border: 1px solid #333;
            height: 150px;
            text-align: center;
            line-height: 150px;
            margin-left: auto;
        }
        div.identitas table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        div.identitas td {
            vertical-align: top;
            padding: 5px;
        }
        div.identitas td:first-child {
            width: 3%;
        }
        div.identitas td:nth-child(2) {
            width: 30%;
        }
        div.identitas td:nth-child(3) {
            width: 2%;
            text-align: center;
        }
        div.identitas td:nth-child(4) {
            width: 65%;
        }
        div.identitas .section-title {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
    <body>
        <div class="book">
            <div class="page">
                <img
                    src="{{url('/img/bingkai_buku_induk.png')}}"
                    class="bg_bingkai"
                />
                <div class="cover_container">
                    <div class="cover_head_table">
                        <table class="tabel_no_seri">
                            <tr>
                                <td>No. Seri Buku Induk</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>NIS</td>
                                <td>:</td>
                                <td>............ s/d ............</td>
                            </tr>
                        </table>
                    </div>
                    <div style="text-align: center;margin-top:80px;">
                        <img
                            width="200" 
                            src="{{url('/img/logo_dikbud.png')}}"
                        />
                        <div style="margin-top: 20px;">
                            <h1 style="font-size: 18pt;">BUKU INDUK</h1>
                            <h3 style="font-size: 14pt;">PESERTA DIDIK SEKOLAH DASAR<br />KURIKULUM MERDEKA</h3>
                        </div>
                        <div style="text-align: center;">
                            <table class="detail_sekolah">
                                <tr>
                                    <td>NAMA SEKOLAH</td>
                                    <td>:</td>
                                    <td>SD Muhammadiyah 2 Pontianak</td>
                                </tr>
                                <tr>
                                    <td>NPSN</td>
                                    <td>:</td>
                                    <td>30105255</td>
                                </tr>
                                <tr>
                                    <td>STATUS SEKOLAH</td>
                                    <td>:</td>
                                    <td>Negeri</td>
                                </tr>
                                <tr>
                                    <td>ALAMAT SEKOLAH</td>
                                    <td>:</td>
                                    <td>Jalan Jenderal Ahmad Yani</td>
                                </tr>
                                <tr>
                                    <td>DESA/KELURAHAN</td>
                                    <td>:</td>
                                    <td>Akcaya</td>
                                </tr>
                                <tr>
                                    <td>KECAMATAN</td>
                                    <td>:</td>
                                    <td>Pontianak Selatan</td>
                                </tr>
                                <tr>
                                    <td>KABUPATEN/KOTA</td>
                                    <td>:</td>
                                    <td>Pontianak</td>
                                </tr>
                                <tr>
                                    <td>PROVINSI</td>
                                    <td>:</td>
                                    <td>Kalimantan Barat</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page">  
                <h1 style="text-align: center;">PETUNJUK PENGISIAN BUKU INDUK PESERTA DIDIK SEKOLAH DASAR</h1>
                <h2 style="margin-bottom: 0px;">UMUM</h2>
                <ol>
                    <li>Buku Induk peserta didik ini adalah buku yang berisi data tentang diri peserta didik selama mengikuti pendidikan di suatu sekolah dan berlaku sejak yang bersangkutan diterima di kelas I (satu) atau sejak dia diterima di sekolah yang bersangkutan.</li>
                    <li>Buku Induk peserta didik ini diisi pada saat diterima dan selanjutnya diikuti pendataan perkembangan peserta didik sesuai dengan butir-butir dalam lembaran buku ini.</li>
                    <li>Pengisian dilakukan dengan menggunakan huruf balok dan tinta hitam.</li>
                    <li>Data yang diisikan adalah data atau informasi yang benar yang dapat dijamin kebenarannya.</li>
                    <li>Pengelolaan buku Induk ini tanggung jawab Kepala Sekolah.</li>
                </ol>

                <h2 style="margin-bottom: 0px;">KHUSUS LEMBAR BUKU INDUK PESERTA DIDIK</h2>
                <h3>A. Keterangan Tentang Diri Peserta Didik</h3>
                <ol>
                    <li>Nama lengkap peserta didik diisi sesuai dengan Akta Kelahiran peserta didik. Contoh: I PUTU PARYA SANJAYA.</li>
                    <li>Coret yang tidak perlu.</li>
                    <li>Diisi lengkap: Kabupaten/Kota/Kotif dan Tanggal, Bulan, Tahun lahir sesuai dengan STTB/Ijazah di bawahnya atau sesuai dengan Akta Kelahiran peserta didik.</li>
                    <li>Diisi dengan Agama yang diikuti.</li>
                    <li>Diisi dengan kewarganegaraan, misal: Indonesia, India, dan lain-lain.</li>
                    <li>Diisi dengan pertama, kedua, dan seterusnya.</li>
                    <li>Diisi dengan angka sesuai dengan jumlah saudara kandung (saudara seayah dan seibu) di luar yang bersangkutan.</li>
                    <li>Saudara seayah atau seibu.</li>
                    <li>Cukup jelas.</li>
                    <li>Cukup jelas.</li>
                </ol>
                <div style="display: flex; flex-direction:row;">
                    <div style="width: 50%;">
                        <h3>B. Keterangan Tempat Tinggal</h3>
                        <ol>
                            <li>Diisi lengkap: Jalan, Gang, Nomor rumah, RT, RW, Desa/Kelurahan, Kecamatan, Kabupaten/Kota/Kotif dan Kode Pos.</li>
                            <li>Cukup jelas.</li>
                            <li>Diisi dengan Orang tua/saudara/kost dsb.</li>
                            <li>Cukup jelas.</li>
                        </ol>
        
                        <h3>C. Keterangan Tentang Kesehatan</h3>
                        <ol>
                            <li>Cukup jelas.</li>
                            <li>Tulis sesuai penyakit yang pernah diderita.</li>
                            <li>Cukup jelas.</li>
                            <li>Cukup jelas.</li>
                        </ol>
        
                        <h3>D. Keterangan Tentang Pendidikan</h3>
                        <ol>
                            <li>Cukup jelas.</li>
                            <li>Hanya diisi peserta didik pindahan.</li>
                            <li>Cukup jelas.</li>
                        </ol>
        
                        <h3>E. Keterangan Tentang Ayah Kandung</h3>
                        <ol>
                            <li>Diisi dengan menggunakan huruf balok.</li>
                            <li>Cukup jelas.</li>
                            <li>Cukup jelas.</li>
                            <li>Diisi dengan pendidikan terakhir.</li>
                            <li>Cukup jelas.</li>
                            <li>Diisi lengkap: Jalan, Gang, Nomor rumah, RT, RW, Desa/Kelurahan, Kecamatan, Kabupaten/Kota/Kotif dan Kode Pos.</li>
                            <li>Tulis sesuai dengan jawaban yang dipilih.</li>
                        </ol>
                    </div>
                    <div style="width: 50%;">
                        <h3>F. Keterangan Tentang Ibu Kandung</h3>
                        <ol>
                            <li>Diisi dengan menggunakan huruf balok.</li>
                            <li>Cukup jelas.</li>
                            <li>Cukup jelas.</li>
                            <li>Diisi dengan pendidikan terakhir.</li>
                            <li>Cukup jelas.</li>
                        </ol>
        
                        <h3>G. Keterangan Tentang Wali</h3>
                        <ol>
                            <li>Cukup jelas.</li>
                            <li>Cukup jelas.</li>
                            <li>Diisi dengan pendidikan terakhir.</li>
                            <li>Cukup jelas.</li>
                        </ol>
        
                        <h3>H. Keterangan Perkembangan Peserta Didik</h3>
                        <ol>
                            <li>Diisi dengan tahun, tingkat/kelas dan Lembaga/Yayasan pemberi Bea Peserta didik.</li>
                            <li>Diisi untuk peserta didik yang pindah atau keluar sebelum tamat.</li>
                            <li>Cukup jelas.</li>
                        </ol>
        
                        <p><b>Penempatan Pas Foto diusahakan agar tidak menumpuk pada suatu tempat.</b></p>
                        <p><b>Pas foto ditempatkan pada tempat yang disesuaikan sesuai dengan angka satuan nomor induk.</b></p>
                    </div>
                </div>
            </div>
            <div class="page">
                <div class="header">
                    <h1>IDENTITAS PESERTA DIDIK</h1>
                    <div class="info">
                        <p>NIS : 7418</p>
                        <p>NISN : 0135452195</p>
                    </div>
                </div>
            
                <div class="container identitas">
                    <div class="content">
                        <p class="section-title">A. KETERANGAN TENTANG DIRI PESERTA DIDIK</p>
                        <table>
                            <tr>
                                <td>1</td>
                                <td>Nama Lengkap Peserta Didik</td>
                                <td>:</td>
                                <td>ACHMAD GARDAN ALARIC PRIAWAN</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td>Laki-Laki</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Tempat dan Tanggal Lahir</td>
                                <td>:</td>
                                <td>Pontianak, 11/10/2013</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Agama</td>
                                <td>:</td>
                                <td>Islam</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Kewarganegaraan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Anak Keberapa</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Jumlah Saudara Kandung</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Bahasa Sehari-hari di Keluarga</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>
            
                        <p class="section-title">B. KETERANGAN TEMPAT TINGGAL</p>
                        <table>
                            <tr>
                                <td>11</td>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>Jl. Danau Sentarum Gg. Persatuan No. 14</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>Nomor Telepon / HP</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>
            
                        <p class="section-title">C. KETERANGAN TENTANG KESEHATAN</p>
                        <table>
                            <tr>
                                <td>15</td>
                                <td>Golongan Darah</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>19</td>
                                <td>Tinggi Badan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>
            
                        <p class="section-title">D. KETERANGAN TENTANG PENDIDIKAN</p>
                        <table>
                            <tr>
                                <td>20</td>
                                <td>Pendidikan Sebelumnya</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>
            
                        <p class="section-title">E. KETERANGAN TENTANG AYAH KANDUNG</p>
                        <table>
                            <tr>
                                <td>23</td>
                                <td>Nama</td>
                                <td>:</td>
                                <td>Destu Wendi Priawan, SH.</td>
                            </tr>
                            <tr>
                                <td>26</td>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>

                        <p class="section-title">F. KETERANGAN TENTANG IBU KANDUNG</p>
                        <table>
                            <tr>
                                <td>29</td>
                                <td>Nama</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>30</td>
                                <td>Tahun Lahir</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>34</td>
                                <td>Agama</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>36</td>
                                <td>Pendidikan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>37</td>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>

                        <p class="section-title">G. KETERANGAN TENTANG WALI</p>
                        <table>
                            <tr>
                                <td>41</td>
                                <td>Nama</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>42</td>
                                <td>Tahun Lahir</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>43</td>
                                <td>Agama</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>45</td>
                                <td>Pendidikan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>46</td>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>48</td>
                                <td>Alamat Rumah</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>49</td>
                                <td>Hubungan Keluarga</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>

                        <p class="section-title">H. KETERANGAN PERKEMBANGAN PESERTA DIDIK</p>
                        <table>
                            <tr>
                                <td>50</td>
                                <td>Menerima Beasiswa</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Tahun Dari</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>51</td>
                                <td>Meninggalkan Sekolah</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>a. Tanggal Meninggalkan Sekolah</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>b. Kelas yang Ditinggalkan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>c. Alasan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>d. Sekolah yang Dituju</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>e. Kecamatan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>f. Kabupaten/Kota</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>g. Provinsi</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>52</td>
                                <td>Akhir Pendidikan</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>a. Tamat Belajar / Lulus Tahun</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>b. Nomor Ijazah / STL</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>c. Akan Melanjutkan ke</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>

                    </div>
            
                    <div class="photo">
                        Foto
                    </div>
                </div>
            </div>  
            <div class="page">  

                <table class="table_kop">
                    <tr>
                        <td>
                            <img
                                width="100" 
                                src="{{url('/img/logo_dikbud.png')}}"
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
                                src="{{url('/img/sd_muhamamdiyah_2.png')}}"
                            />
                        </td>
                    </tr>
                </table>

                <table width="100%">
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
                                    <td>{{ $item->mapel->nama ?? "" }}</td>
                                    <td class="text-center">{{ $item->nilai_rapor }}</td>
                                    <td style="padding:0px;">
                                        @if(!empty($item->catatan_max_tp))
                                        <div style="
                                        @if(!empty($item->catatan_min_tp))
                                        border-bottom: 1px solid black;
                                        @endif
                                        padding: 3px 5px;
                                        text-align:justify;
                                        ">{{ $item->catatan_max_tp }}</div>
                                        @endif
                                        @if(!empty($item->catatan_min_tp))
                                        <div style="
                                        padding: 3px 5px;
                                        text-align:justify;
                                        ">{{ $item->catatan_min_tp }}</div>
                                        @endif
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
                        @foreach ($ekskul_siswa as $key => $item)    
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td>{{ $item->ekskul->nama }}</td>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                        @endforeach
                        {{-- <tr>
                            <td class="text-center">2</td>
                            <td>Renang</td>
                            <td>Kurang aktif mengikuti kegiatan Ekstrakurikuler</td>
                        </tr> --}}
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
                                {!! $kelas_siswa->catatan_akhir ?? "<br />" !!}
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
                                {!! $kelas_siswa->kesimpulan ?? "<br />" !!}
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
                            <td>{{$kelas_siswa->sakit ?? 0}} hari</td>
                        </tr>
                        <tr>
                            <td>Izin</td>
                            <td>:</td>
                            <td>{{$kelas_siswa->izin ?? 0}} hari</td>
                        </tr>
                        <tr>
                            <td>Tanpa Keterangan</td>
                            <td>:</td>
                            <td>{{$kelas_siswa->tanpa_keterangan ?? 0}} hari</td>
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
        <script>
            window.onload = function() { window.print(); }
        </script>
    </body>
</html>