@extends('layouts.app')
@section('title', 'Peserta Tanpa Jadwal Tes')

@section('content')

<section class="content-header">
    <h1>Peserta Tanpa Jadwal Tes</h1>
    <p class="text-muted">Daftar peserta yang sudah bayar tapi belum mendapat jadwal tes</p>
</section>

<section class="content">

<div class="row">
    <div class="col-md-6">
        <!-- STATISTIK JADWAL -->
        @if (count($jadwalStats) > 0)
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-bar-chart"></i> 
                    Statistik Kapasitas Jadwal Tes
                </h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="10%" class="text-center">Tipe Tes</th>
                                <th width="25%">Tanggal</th>
                                <th width="20%">Sesi</th>
                                <th width="15%" class="text-center">Terisi</th>
                                <th width="15%" class="text-center">Kapasitas</th>
                                <th width="15%" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalStats as $stat)
                            <tr>
                                <td class="text-center">
                                    @if ($stat['type'] == 'IQ')
                                        <span class="label label-primary">IQ</span>
                                    @else
                                        <span class="label label-info">MAP</span>
                                    @endif
                                </td>
                                <td>{{ $stat['date_formatted'] }}</td>
                                <td>{{ $stat['session'] }}</td>
                                <td class="text-center">
                                    <strong>{{ $stat['filled'] }}</strong>
                                </td>
                                <td class="text-center">
                                    <strong>{{ $stat['capacity'] }}</strong>
                                </td>
                                <td class="text-center">
                                    @php
                                        $percentage = $stat['capacity'] > 0 ? ($stat['filled'] / $stat['capacity']) * 100 : 0;
                                    @endphp
                                    @if ($stat['filled'] >= $stat['capacity'])
                                        <span class="label label-danger">PENUH</span>
                                    @elseif ($percentage >= 80)
                                        <span class="label label-warning">{{ number_format($percentage, 0) }}%</span>
                                    @else
                                        <span class="label label-success">{{ number_format($percentage, 0) }}%</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        
                <div style="margin-top:15px;">
                    <span class="label label-success" style="margin-right:10px;">
                        <i class="fa fa-circle"></i> &lt; 80% - Tersedia
                    </span>
                    <span class="label label-warning" style="margin-right:10px;">
                        <i class="fa fa-circle"></i> ≥ 80% - Hampir Penuh
                    </span>
                    <span class="label label-danger">
                        <i class="fa fa-circle"></i> 100% - Penuh
                    </span>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-6">
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
                                    <th width="25%">Nama Peserta</th>
                                    <th width="12%">Kode Bayar</th>
                                    <th width="12%">No HP</th>
                                    <th width="15%">Email</th>
                                    <th width="10%" class="text-center">Status Bayar</th>
                                    <th width="11%" class="text-center">Aksi</th>
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
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary btn-assign-jadwal" 
                                                    data-kode="{{ $p->kode_bayar }}"
                                                    data-nama="{{ $p->nama }}">
                                                <i class="fa fa-calendar-plus-o"></i> Jadwalkan
                                            </button>
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
    </div>
</div>
</section>

<!-- MODAL ASSIGN JADWAL -->
<div class="modal fade" id="modalAssignJadwal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa fa-calendar-plus-o"></i> Jadwalkan Tes
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="assign_kode_bayar">
                
                <div class="alert alert-info">
                    <strong>Peserta:</strong> <span id="assign_nama_peserta"></span><br>
                    <strong>Kode Bayar:</strong> <code id="assign_kode_display"></code>
                </div>

                <div class="form-group">
                    <label><i class="fa fa-brain"></i> <strong>Pilih Slot Tes IQ</strong></label>
                    <select class="form-control" id="assign_iq_slot">
                        <option value="">-- Pilih Slot IQ --</option>
                        @foreach ($jadwalStats as $stat)
                            @if ($stat['type'] == 'IQ' && $stat['filled'] < $stat['capacity'])
                                <option value="{{ $stat['date'] }}|{{ $stat['session'] }}"
                                        data-date="{{ $stat['date'] }}"
                                        data-start="{{ explode(' - ', $stat['session'])[0] }}"
                                        data-end="{{ explode(' - ', $stat['session'])[1] }}">
                                    {{ $stat['date_formatted'] }} | {{ $stat['session'] }} 
                                    ({{ $stat['filled'] }}/{{ $stat['capacity'] }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fa fa-map"></i> <strong>Pilih Slot Tes Pemetaan (MAP)</strong></label>
                    <select class="form-control" id="assign_map_slot">
                        <option value="">-- Pilih Slot MAP --</option>
                        @foreach ($jadwalStats as $stat)
                            @if ($stat['type'] == 'MAP' && $stat['filled'] < $stat['capacity'])
                                <option value="{{ $stat['date'] }}|{{ $stat['session'] }}"
                                        data-date="{{ $stat['date'] }}"
                                        data-start="{{ explode(' - ', $stat['session'])[0] }}"
                                        data-end="{{ explode(' - ', $stat['session'])[1] }}">
                                    {{ $stat['date_formatted'] }} | {{ $stat['session'] }} 
                                    ({{ $stat['filled'] }}/{{ $stat['capacity'] }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnSaveJadwal">
                    <i class="fa fa-save"></i> Simpan Jadwal
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
$(document).ready(function() {
    
    // Open modal untuk assign jadwal
    $('.btn-assign-jadwal').click(function() {
        const kodeBayar = $(this).data('kode');
        const nama = $(this).data('nama');
        
        $('#assign_kode_bayar').val(kodeBayar);
        $('#assign_nama_peserta').text(nama);
        $('#assign_kode_display').text(kodeBayar);
        $('#assign_iq_slot').val('');
        $('#assign_map_slot').val('');
        
        $('#modalAssignJadwal').modal('show');
    });

    // Save jadwal
    $('#btnSaveJadwal').click(function() {
        const kodeBayar = $('#assign_kode_bayar').val();
        const iqSlot = $('#assign_iq_slot').find(':selected');
        const mapSlot = $('#assign_map_slot').find(':selected');

        if (!iqSlot.val() || !mapSlot.val()) {
            swal('Perhatian!', 'Harap pilih slot IQ dan MAP', 'warning');
            return;
        }

        const data = {
            kode_bayar: kodeBayar,
            iq_date: iqSlot.data('date'),
            iq_start_time: iqSlot.data('start') + ':00',
            iq_end_time: iqSlot.data('end') + ':00',
            map_date: mapSlot.data('date'),
            map_start_time: mapSlot.data('start') + ':00',
            map_end_time: mapSlot.data('end') + ':00',
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: '{{ route("sekolah.ppdb.assign_jadwal") }}',
            method: 'POST',
            data: data,
            success: function(response) {
                if (response.status) {
                    swal('Berhasil!', response.message, 'success');
                    $('#modalAssignJadwal').modal('hide');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    swal('Gagal!', response.message, 'error');
                }
            },
            error: function(xhr) {
                swal('Error!', 'Terjadi kesalahan saat menyimpan jadwal', 'error');
            }
        });
    });

});
</script>
@endsection
