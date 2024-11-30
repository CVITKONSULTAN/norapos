
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
    <h3 style="text-align: center;">RAPOR PROJEK PENGUATAN PROFIL PELAJAR PANCASILA</h3>
    
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
                // dd($item);
                foreach ($item['dimensi'] ?? [] as $key => $value) {
                    $list_dimensi[$value['id']] = $value['nama'];
                }
            @endphp
            <h4>Projek {{$i+1}} | {{ $item['projek_nama'] }}</h4>
            <div class="container_deskripsi">
                {{$project->deskripsi}}
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
        <table class="tabel_projek">
            <thead>
                <tr>
                    <th>Projek Kelas {{ $kelas_siswa->kelas->nama_kelas ?? "" }}</th>
                    @foreach ($list_dimensi as $v)
                        <th>{{ $v }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas_siswa->nilai_projek ?? [] as $i => $item)
                    <tr>
                        <td>{{ $item['projek_nama'] }}</td>
                        @foreach ($list_dimensi as $k => $v)
                            @foreach ($item['dimensi'] as $value)
                                @if($value['id'] == $k)
                                    <td class="text-center">{{$value['nilai']}}</td>
                                @endif
                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
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
    
    @php
        $dimensi_list = $kelas_siswa->kelas->dimensi_list ?? [];
        $nilai_projek = $kelas_siswa->nilai_projek ?? []
    @endphp
    @foreach ($nilai_projek ?? [] as $i => $item)
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
                <p class="ttd">{{$kelas_siswa->siswa->detail['nama_ayah'] ?? ''}}</p>
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