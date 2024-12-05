@extends('sekolah_sd.prints.layout')
    
@section('main')

    <h3 style="text-align: center;">RAPOR PROJEK PENGUATAN PROFIL PELAJAR PANCASILA</h3>

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
        div.container_deskripsi{
            border: 1px solid black;
            padding: 5px;
        }
        p.head_keterangan_nilai{
            font-weight: bold;
        }
        p.sub_ket_nilai{
            font-style: italic;
        }
        table.keterangan_table{
            margin-top: 10px;
        }
        table.keterangan_table tr td{
            vertical-align: middle;
        }
        table.tabel_projek {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.tabel_projek tr th{
            border: 1px solid black;
            padding: 2.5px 5px;
            text-align: center;
        }
        table.tabel_projek tr td{
            border: 1px solid black;
            padding: 2.5px 5px;
        }
        #printableArea{
            color: #000;
        }
        .dimensi_head{
            font-weight:bold;
            background: rgb(103, 172, 225);
            padding: 2.5px 10px;
        }
    </style>

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
                        <td>{{$fase}}</td>
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
    <div>
        @php
            $list_dimensi = [];
        @endphp
        @foreach ($kelas_siswa->nilai_projek ?? [] as $i => $item)
            @php
                $project = \App\Models\Sekolah\RaporProjek::find($item['projek_id']);
                if(empty($project)) continue;
                foreach ($item['dimensi'] ?? [] as $key => $value) {
                    $list_dimensi[$value['id']] = $value['nama'];
                }
            @endphp
            <h4>Projek {{$i+1}} | {{ $item['projek_nama'] }}</h4>
            <div class="container_deskripsi">
                {{$project->deskripsi ?? ""}}
            </div>
        @endforeach
        <table class="keterangan_table" width="100%" style="margin-top:30px; margin-bottom:30px;">
            <tr>
                <td>
                    <p class="head_keterangan_nilai">BB. Belum Berkembang</p>
                </td>
                <td>
                    <p class="head_keterangan_nilai">MB. Mulai Berkembang</p>
                </td>
                <td>
                    <p class="head_keterangan_nilai">BSH. Berkembang Sesuai Harapan</p>
                </td>
                <td>
                    <p class="head_keterangan_nilai">SB. Sangat Berkembang</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="sub_ket_nilai">Siswa masih membutuhkan
                        bimbingan dalam
                        mengembangkan kemampuan</p>
                </td>
                <td>
                    <p class="sub_ket_nilai">Siswa mulai
                        mengembangkan
                        kemampuan namun masih
                        belum ajek</p>
                </td>
                <td>
                    <p class="sub_ket_nilai">Siswa telah mengembangkan
                        kemampuan hingga berada
                        dalam tahap ajek</p>
                </td>
                <td>
                    <p class="sub_ket_nilai">Siswa mengembangkan
                        kemampuannya melampaui
                        harapan</p>
                </td>
            </tr>
        </table>
        
        @foreach ($kelas_siswa->kelas->dimensi_list ?? [] as $i => $item)

            @php
                $nilai_projek = $kelas_siswa->nilai_projek ?? [];
                if(count($nilai_projek) <= 0) continue;
                $nilai_p = collect($nilai_projek)->where('projek_id',$item['id'] ?? 0)->first();
                if(empty($nilai_p)) continue;
                // dd($nilai_p);
            @endphp
            @if(count($item['dimensi'] ?? []) > 0)
                <table class="tabel_projek">
                    <thead>
                        <tr>
                            <th width="200">Projek Kelas {{ $kelas_siswa->kelas->nama_kelas ?? "" }}</th>
                            @foreach ($item['dimensi'] ?? [] as $v)
                                <th>{{ $v['dimensi_text'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{ $item['nama'] }}</td>
                                @foreach ($item['dimensi'] ?? [] as $j => $val)
                                    @php
                                        $nilai = $nilai_p['dimensi'][$j]['nilai'] ?? "";
                                    @endphp
                                    <td class="text-center">{{$nilai}}</td>
                                @endforeach
                            </tr>
                    </tbody>
                </table>
            @endif
        @endforeach

    </div>

@endsection

@section('page')
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
        @php
            $dimensi_list = $kelas_siswa->kelas->dimensi_list ?? [];
            $nilai_projek = $kelas_siswa->nilai_projek ?? []
        @endphp
        @foreach ($nilai_projek ?? [] as $i => $item)
            @if(count($item['dimensi'] ?? []) > 0)
                <table style="margin-top: 20px;" class="tabel_projek">
                    <thead>
                        <tr>
                            <th style="text-align: left;">{{ $item['projek_nama'] ?? "" }}</th>
                            <th>BB</th>
                            <th>MB</th>
                            <th>BSH</th>
                            <th>SB</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item['dimensi'] ?? [] as $j => $value)
                        @php
                            // dd($dimensi_list[$i]['dimensi'][$j]);
                            // dd($dimensi_list[$i],$item['dimensi']);
                            $subelemen_fase = $dimensi_list[$i]['dimensi'][$j]['subelemen_fase'] ?? [];
                        @endphp
                        <tr>
                            <td class="dimensi_head" colspan="5">{{ $value['nama'] }}</td>
                        </tr>
                        @foreach ($value['subelemen'] ?? [] as $k => $val)
                            {{-- {{dd($val['nilai'])}} --}}
                            <tr>
                                <td>
                                    <p style="font-weight: bold;">{{$subelemen_fase[$k]['text'] ?? ""}}</p>
                                    <p>{{$subelemen_fase[$k]['target'] ?? ""}}</p>
                                </td>
                                <td class="text-center">{{ $val['nilai'] == 'BB' ? 'V' : '' }}</td>
                                <td class="text-center">{{ $val['nilai'] == 'MB' ? 'V' : '' }}</td>
                                <td class="text-center">{{ $val['nilai'] == 'BSH' ? 'V' : '' }}</td>
                                <td class="text-center">{{ $val['nilai'] == 'SB' ? 'V' : '' }}</td>
                            </tr>
                        @endforeach
                        {{-- {{dd($value,$dimensi_list)}} --}}
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach

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
                    <p style="margin:0px;">{{$kelas_siswa->kelas->nbm_wali_kelas}}</p>
                </td>
                <td style="text-align: center;">
                    <p>
                        Mengetahui,<br />
                        Orangtua/Wali
                    </p>
                    <br />
                    {{-- <p class="ttd">{{$kelas_siswa->siswa->detail['nama_ayah'] ?? ''}}</p> --}}
                    <p class="ttd">(.................................)</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <p>
                        <br />
                        Kepala Sekolah
                    </p>
                    <br />
                    <p class="ttd">Hj. Yumi Pariyanti, S.Pd</p>
                    <p style="margin:0px;">NBM. 833 488</p>
                </td>
            </tr>
        </table>
    </div>
@endsection