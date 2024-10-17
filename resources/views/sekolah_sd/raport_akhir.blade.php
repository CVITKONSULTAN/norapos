@extends('layouts.app')
@section('title', "Raport Akhir Semester")

@section('css')
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
                                <select class="form-control" name="tahun_ajaran">
                                    @foreach ($tahun_ajaran as $item)
                                        <option>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Semester</label>
                                <select class="form-control" name="tahun_ajaran">
                                    @foreach ($semester as $item)
                                        <option>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Kelas</label>
                                <select class="form-control" name="kelas">
                                    @foreach ($nama_kelas as $item)
                                        <option>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Cari NISN/Nama Siswa</label>
                                <input type="search" placeholder="Tulis disini..." class="form-control" name="cari" placeholder="" />
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
                                                placeholder="Tulis catatan disini..."></textarea>
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
                                                placeholder="Tulis catatan disini..."></textarea>
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
    <script type="text/javascript">
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
