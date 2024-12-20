@extends('sekolah_sd.prints.layout')

@section('main')

    <h5 class="text-center" style="margin: 5px auto;">
        <u>RAPOR TENGAH SEMESTER {{ $kelas_siswa->kelas->semester ?? "" }}</u>
    </h5>
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
                    {!! $kelas_siswa->catatan_akhir ?? "<br />" !!}
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
@endsection