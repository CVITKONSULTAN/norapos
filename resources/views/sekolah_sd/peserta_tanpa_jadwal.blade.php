@extends('layouts.app')
@section('title', 'Peserta Tanpa Jadwal Tes')

@section('content')

<section class="content-header">
    <h1>Peserta Tanpa Jadwal Tes</h1>
    <p class="text-muted">Daftar peserta yang sudah bayar tapi belum mendapat jadwal tes</p>
</section>

<section class="content">

    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-exclamation-triangle"></i> 
                Peserta Belum Dijadwalkan
            </h3>
            <div class="box-tools pull-right">
                <span class="label label-warning" style="font-size:14px;">
                    Total: {{ count($peserta) }} Peserta
                </span>
            </div>
        </div>

        <div class="box-body">

            @if (count($peserta) == 0)
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i>
                    <b>Semua peserta yang sudah bayar telah mendapat jadwal tes.</b>
                </div>
            @else

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="30%">Nama Peserta</th>
                                <th width="15%">Kode Bayar</th>
                                <th width="15%">No HP</th>
                                <th width="20%">Email</th>
                                <th width="15%" class="text-center">Status Bayar</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($peserta as $index => $p)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $p->nama }}</strong>
                                    </td>
                                    <td>
                                        <code>{{ $p->kode_bayar }}</code>
                                    </td>
                                    <td>{{ $p->no_hp ?? '-' }}</td>
                                    <td>{{ $p->email ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="label label-success">
                                            {{ strtoupper($p->status_bayar) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-info" style="margin-top:20px;">
                    <i class="fa fa-info-circle"></i>
                    <strong>Catatan:</strong> Peserta di atas sudah melakukan pembayaran namun belum dijadwalkan untuk tes IQ maupun Pemetaan.
                </div>

            @endif

        </div>
    </div>

</section>

@endsection
