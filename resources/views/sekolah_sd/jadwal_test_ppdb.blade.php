@extends('layouts.app')
@section('title', 'Jadwal Tes Harian PPDB')

@section('content')

<section class="content-header">
    <h1>Jadwal Tes PPDB — Rekap Per Hari & Per Sesi</h1>
</section>

<section class="content">

    <!-- FILTER PANEL -->
    <div class="box box-success">
        <div class="box-body">

            <form method="GET" 
                  action="{{ route('sekolah_sd.ppdb.jadwal_harian.detail') }}" 
                  class="form-inline">

                <!-- FILTER TANGGAL -->
                <label style="margin-right:10px;"><b>Tanggal Tes</b></label>

                <select name="tanggal" class="form-control" style="margin-right:15px; min-width:200px;">
                    @foreach ($dates as $d)
                        <option value="{{ $d }}" 
                            {{ $filter == $d ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($d)->translatedFormat('d F Y') }}
                        </option>
                    @endforeach
                </select>

                <!-- FILTER TIPE TES -->
                <label style="margin-right:10px;"><b>Tipe Tes</b></label>

                <select name="tipe" class="form-control" style="margin-right:15px;">
                    <option value="iq"  {{ $tipe == 'iq'  ? 'selected' : '' }}>Tes IQ</option>
                    <option value="map" {{ $tipe == 'map' ? 'selected' : '' }}>Tes Pemetaan</option>
                </select>

                <!-- BUTTON TAMPILKAN -->
                <button class="btn btn-primary">
                    <i class="fa fa-search"></i> Tampilkan
                </button>

                <!-- BUTTON RESET -->
                <a href="{{ route('sekolah_sd.ppdb.jadwal_harian.detail') }}"
                   class="btn btn-default" style="margin-left:10px;">
                    Reset
                </a>

                <!-- BUTTON EXPORT -->
                <a href="{{ route('sekolah_sd.ppdb.jadwal_harian.export', ['tanggal' => $filter, 'tipe' => $tipe]) }}"
                   class="btn btn-success" 
                   style="margin-left:10px;">
                    <i class="fa fa-file-excel-o"></i> Export Excel
                </a>

            </form>

        </div>
    </div>

    <!-- JIKA KOSONG -->
    @if (count($data) === 0)
        <div class="alert alert-warning">
            <b>Tidak ada data jadwal.</b>
        </div>
    @endif


    <!-- LIST HARI -->
    @foreach ($data as $hari => $sessions)

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">📅 {{ $hari }}</h3>
            </div>

            <div class="box-body">

                <!-- LIST SESI -->
                @foreach ($sessions as $jam => $peserta)

                    <h4 style="margin-top:20px;"><b>⏰ {{ $jam }}</b></h4>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="30%">Nama Peserta</th>
                                <th width="15%">Kode Bayar</th>
                                <th width="20%">No HP</th>
                                <th width="35%">Jadwal Pemetaan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($peserta as $p)
                                <tr>
                                    <td>{{ $p['nama'] }}</td>
                                    <td>{{ $p['kode_bayar'] }}</td>
                                    <td>{{ $p['no_hp'] ?? '-' }}</td>
                                    <td>
                                        {{ $p['pemetaan']['tanggal'] }}
                                        ({{ $p['pemetaan']['jam'] }})
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @endforeach

            </div>
        </div>

    @endforeach

</section>

@endsection
