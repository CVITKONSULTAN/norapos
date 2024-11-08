@extends('layouts.app')
@section('title', "Raport Akhir Semester")

@section('css')
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
/>
    <style>
        table.head_table tr td{
            padding: 5px 10px;
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
    </style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Raport Akhir Semester</h1>
</section>

<!-- Main content -->

<section class="content">

    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> 
                            Raport Akhir Semester (Individu)
                        </a>
                    </li>
                    <li class="">
                        <a href="#ekskul" data-toggle="tab" aria-expanded="true"><i class="fa fa-list" aria-hidden="true"></i>
                            Cetak Raport Akhir Semester (Perkelas)
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <form class="row">
                            <div class="form-group col-md-2">
                                <label>Tahun Ajaran</label>
                                <select id="filter_tahun_ajaran" class="form-control" name="tahun_ajaran">
                                    @foreach ($tahun_ajaran as $item)
                                        <option>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Semester</label>
                                <select id="filter_semester" class="form-control" name="semester">
                                    @foreach ($semester as $item)
                                        <option>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Kelas</label>
                                <select id="filter_kelas" class="form-control" name="kelas">
                                    @foreach ($nama_kelas as $item)
                                        <option>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Cari NISN/Nama Siswa</label>
                                {{-- <input type="search" placeholder="Tulis disini..." class="form-control" name="cari" placeholder="" /> --}}
                                <select name="kelas_id" class="siswa_selection"></select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" style="margin-top:25px;"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </form>
                        <hr />
                        <div id="printableArea" class="row">
                            <div class="col-md-6">
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
                            </div>
                            <div class="col-md-6">
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
                            </div>
                            <div class="col-md-12">
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
                                        @foreach ($nilai_list as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key+1 }}</td>
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
{{-- 
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td>Pendidikan Agama Pancasila</td>
                                            <td class="text-center">83</td>
                                            <td>
                                                <ol>
                                                    <li>Catatan TP pertama</li>
                                                    <li>Catatan TP kedua</li>
                                                    <li>Catatan TP ketiga</li>
                                                </ol>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td>Matematika</td>
                                            <td class="text-center">83</td>
                                            <td>
                                                <ol>
                                                    <li>Catatan TP pertama</li>
                                                    <li>Catatan TP kedua</li>
                                                    <li>Catatan TP ketiga</li>
                                                </ol>
                                            </td>
                                        </tr>
  --}}
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
                                            <th colspan="3">Ketidakhadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sakit</td>
                                            <td>:</td>
                                            <td>{{$kelas_siswa->kelas->sakit ?? 0}} hari</td>
                                        </tr>
                                        <tr>
                                            <td>Izin</td>
                                            <td>:</td>
                                            <td>{{$kelas_siswa->kelas->izin ?? 0}} hari</td>
                                        </tr>
                                        <tr>
                                            <td>Tanpa Keterangan</td>
                                            <td>:</td>
                                            <td>{{$kelas_siswa->kelas->tanpa_keterangan ?? 0}} hari</td>
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
                                                <textarea 
                                                    rows="5"
                                                    class="form-control" 
                                                    placeholder="Tulis catatan disini..."
                                                >
                                                {{$kelas_siswa->kelas->catatan_akhir}}
                                                </textarea>
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
                                                <textarea 
                                                    rows="5"
                                                    class="form-control" 
                                                    placeholder="Tulis catatan disini..."
                                                >
                                                {{$kelas_siswa->kelas->kesimpulan}}
                                                </textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="text-center" style="margin-top:10px;">
                            <button type="button" class="btn btn-primary">Simpan</button>
                            {{-- <button type="button" class="btn btn-warning">Ubah</button> --}}
                            {{-- <button onclick="printDiv('printableArea')" type="button" class="btn btn-success">Cetak</button> --}}
                            <a href="{{ route('sekolah_sd.raport_akhir.print', $kelas_siswa->id ) }}" type="button" class="btn btn-success">Cetak</a>
                        </div>
                    </div>
                    <div class="tab-pane" id="ekskul">
                        
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Kelas</label>
                                <select class="form-control">
                                    <option>4 A</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tahun Pelajaran</label>
                                <select class="form-control">
                                    <option>2024/2025</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Semester</label>
                                <select class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-block">Cetak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    ></script>
    <script type="text/javascript">
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        let selectizeInstanceSiswa;

        $(function () {
            selectizeInstanceSiswa = $(".siswa_selection").selectize({
                placeholder: 'Cari disini...',
                maxItems: 1,
                create: false,
                valueField: 'id',         // Field to use as the value
                labelField: 'name',       // Field to use as the label
                searchField: 'name',      // Field to use for searching
                load: function(query, callback) {
                    if (!query.length) return callback();
                    const tahun_ajaran = $("#filter_tahun_ajaran").val();
                    const semester = $("#filter_semester").val();
                    const kelas = $("#filter_kelas").val();
                    const url = '/sekolah_sd/kelas-siswa/data?draw=30&columns%5B0%5D%5Bdata%5D=id&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=siswa.nisn&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=siswa.nama&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=kelas.nama_kelas&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=kelas.tahun_ajaran&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B5%5D%5Bdata%5D=id&columns%5B5%5D%5Bname%5D=&columns%5B5%5D%5Bsearchable%5D=true&columns%5B5%5D%5Borderable%5D=true&columns%5B5%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B5%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&start=0&length=25&search%5Bvalue%5D='+query+
                        '&filter_tahun_ajaran='+tahun_ajaran+
                        '&filter_semester='+semester+
                        '&filter_kelas='+kelas;
                    // console.log("url",url)
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            selectizeInstanceSiswa[0].selectize.clearOptions();
                        },
                        error: function(error) {
                            console.log(error)
                            callback();
                        },
                        success: function(res) {
                            const results = res.data.map(item => ({
                                id: item.id,
                                name: `${item.siswa.nama} (${item.siswa.nisn})`
                            }));
                            // console.log(results)
                            callback(results);
                        }
                    });
                }
            })

            const clearSelectize = () => {
                selectizeInstanceSiswa[0].selectize.setValue(null);
                selectizeInstanceSiswa[0].selectize.clearOptions();
            }

            $("#filter_tahun_ajaran").change(clearSelectize);
            $("#filter_semester").change(clearSelectize);
            $("#filter_kelas").change(clearSelectize);

        })
    </script>
@endsection
