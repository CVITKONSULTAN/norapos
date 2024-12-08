@extends('sekolah_sd.prints.layout')

@section('cover_page')
<style>
    div.cover_container {
        padding: 70px;
        position: relative;
    }
    .bg_bingkai{
        height: 100%;
        width: 80%;
        position: absolute;
    }
    @media print {
        .bg_bingkai{
            width: 80%;
            position: absolute;
            height: 330mm;
        }
    }
</style>
{{-- <div class="page" style="position: relative;">
    <img
        src="{{url('/img/bingkai_buku_induk.png')}}"
        class="bg_bingkai"
    />
    <div class="cover_container">
        <div style="text-align: center;margin-top:80px;">
            <img
                width="150" 
                src="{{url('/img/logo_dikbud.png')}}"
            />
        </div>
        <div style="margin-top: 30px;">
            <h1 style="text-align:center;font-size: 18pt;">RAPOR</h1>
            <h3 style="text-align:center;font-size: 14pt;">PESERTA DIDIK SEKOLAH DASAR (SD)<br />KURIKULUM MERDEKA</h3>
        </div>
        <div style="text-align: center;margin-top:0px;">
            <img 
                width="300" 
                src="{{url('/img/sd_muhamamdiyah_2.png')}}"
            />
        </div>
        <div style="margin-top: 30px;">
            <h3 style="text-align:center;font-size: 14pt;">NAMA PESERTA DIDIK :<br />{{ $kelas_siswa->siswa->nama }}</h3>
            <h3 style="text-align:center;font-size: 14pt;">NISN/NIS:<br />{{ $kelas_siswa->siswa->nisn }}</h3>
        </div>
    </div>
</div> --}}
    
@endsection

@section('main')

    <h3 style="text-align: center;">LAPORAN HASIL BELAJAR</h3>

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
                        <td>{{ $fase }}</td>
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
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ekskul_siswa as $key => $item)    
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td>{{ $item->ekskul->nama }}</td>
                    <td style="text-align: center;">{{ $item->nilai }}</td>
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

    {{-- <table class="tabel_penilaian">
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
    </table> --}}

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
            <td style="text-align: center;">
                {{-- {{dd()}} --}}
                <p>
                    Mengetahui,<br />
                    Wali Kelas
                </p>
                <br />
                <p class="ttd">{{$kelas_siswa->kelas->nama_wali_kelas}}</p>
                <p style="margin:0px;">NBM. {{$kelas_siswa->kelas->nbm_wali_kelas}}</p>
            </td>
            <td style="text-align: center;">
                <p>
                    Mengetahui,<br />
                    Orangtua/Wali
                </p>
                <br />
                {{-- <p class="ttd">{{$kelas_siswa->siswa->detail['nama_ayah'] ?? ''}}</p> --}}
                <p class="ttd">.................................</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <p>
                    <br />
                    Kepala Sekolah
                </p>
                <br />
                <p class="ttd">Yumi Pariyanti,S.Pd</p>
                <p style="margin:0px;">NBM. 833 488</p>
            </td>
        </tr>
    </table>
@endsection