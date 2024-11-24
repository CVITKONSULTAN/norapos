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
        .head_table{
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
    <body>
        <div class="book">
            <div class="page">
                <img
                    src="{{url('/img/bingkai_buku_induk.png')}}"
                    class="bg_bingkai"
                />
                <div class="cover_container">
                    <div class="head_table">
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
{{-- 
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
  --}}
            </div>
        </div>
        <script>
            // window.onload = function() { window.print(); }
        </script>
    </body>
</html>