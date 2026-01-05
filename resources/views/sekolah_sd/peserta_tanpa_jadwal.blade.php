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
                            <tr class="slot-row" style="cursor: pointer;"
                                data-type="{{ $stat['type'] }}"
                                data-date="{{ $stat['date'] }}"
                                data-session="{{ $stat['session'] }}"
                                data-filled="{{ $stat['filled'] }}"
                                title="Klik untuk lihat daftar peserta">
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
                    <button class="btn btn-success btn-sm" id="btnAutoAssign" style="margin-right:10px;">
                        <i class="fa fa-magic"></i> Auto-Assign Semua
                    </button>
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

<!-- Modal untuk lihat peserta di slot -->
<div class="modal fade" id="modalPesertaSlot" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa fa-users"></i> Daftar Peserta di Slot
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Tipe Tes:</strong> <span id="slot_type"></span><br>
                    <strong>Tanggal:</strong> <span id="slot_date"></span><br>
                    <strong>Sesi:</strong> <span id="slot_session"></span><br>
                    <strong>Total Peserta:</strong> <span id="slot_count"></span>
                </div>

                <div id="peserta_list_container">
                    <div class="text-center">
                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                        <p>Memuat data...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

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
                                @php
                                    $times = explode(' - ', $stat['session']);
                                @endphp
                                <option value="{{ $stat['date'] }}|{{ $stat['session'] }}"
                                        data-date="{{ $stat['date'] }}"
                                        data-start="{{ $times[0] }}"
                                        data-end="{{ $times[1] }}">
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
                                @php
                                    $times = explode(' - ', $stat['session']);
                                @endphp
                                <option value="{{ $stat['date'] }}|{{ $stat['session'] }}"
                                        data-date="{{ $stat['date'] }}"
                                        data-start="{{ $times[0] }}"
                                        data-end="{{ $times[1] }}">
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
    
    // Click baris statistik untuk lihat peserta
    $(document).on('click', '.slot-row', function() {
        var type = $(this).data('type');
        var date = $(this).data('date');
        var session = $(this).data('session');
        var filled = $(this).data('filled');

        if (filled == 0) {
            swal('Info', 'Slot ini masih kosong, belum ada peserta', 'info');
            return;
        }

        // Set info di modal
        $('#slot_type').html('<span class="label label-' + (type == 'IQ' ? 'primary' : 'info') + '">' + type + '</span>');
        $('#slot_date').text(date);
        $('#slot_session').text(session);
        $('#slot_count').html('<strong>' + filled + '</strong>');

        // Show loading
        $('#peserta_list_container').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p>Memuat data...</p></div>');
        
        $('#modalPesertaSlot').modal('show');

        // Load peserta data
        $.ajax({
            url: '{{ route("sekolah.ppdb.slot_peserta") }}',
            method: 'GET',
            data: {
                type: type,
                date: date,
                session: session
            },
            success: function(response) {
                if (response.status && response.peserta.length > 0) {
                    var html = '<div class="table-responsive">';
                    html += '<table class="table table-striped table-bordered">';
                    html += '<thead><tr>';
                    html += '<th width="5%">#</th>';
                    html += '<th width="25%">Nama Peserta</th>';
                    html += '<th width="15%">Kode Bayar</th>';
                    html += '<th width="20%">No. HP</th>';
                    html += '<th width="15%">Tgl Validasi</th>';
                    html += '<th width="10%" class="text-center">Aksi</th>';
                    html += '</tr></thead>';
                    html += '<tbody>';
                    
                    $.each(response.peserta, function(index, p) {
                        html += '<tr>';
                        html += '<td>' + (index + 1) + '</td>';
                        html += '<td>' + p.nama + '</td>';
                        html += '<td><code>' + p.kode_bayar + '</code></td>';
                        html += '<td>' + (p.no_hp || '-') + '</td>';
                        html += '<td>' + p.validated_at + '</td>';
                        html += '<td class="text-center">';
                        html += '<button class="btn btn-xs btn-success btn-send-email" data-kode="' + p.kode_bayar + '" title="Kirim Email Jadwal">';
                        html += '<i class="fa fa-envelope"></i>';
                        html += '</button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                    
                    html += '</tbody></table></div>';
                    $('#peserta_list_container').html(html);
                } else {
                    $('#peserta_list_container').html('<div class="alert alert-warning"><i class="fa fa-info-circle"></i> Tidak ada data peserta</div>');
                }
            },
            error: function() {
                $('#peserta_list_container').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Gagal memuat data peserta</div>');
            }
        });
    });

    // Auto-assign semua peserta
    $('#btnAutoAssign').click(function() {
        swal({
            title: 'Auto-Assign Jadwal?',
            text: 'Sistem akan otomatis menjadwalkan semua peserta yang belum dapat jadwal ke slot yang tersedia.',
            icon: 'info',
            buttons: {
                cancel: 'Batal',
                confirm: 'Ya, Proses!'
            }
        }).then((willProceed) => {
            if (!willProceed) return;

            // Show loading
            swal({
                title: 'Sedang Memproses...',
                text: 'Mohon tunggu',
                icon: 'info',
                buttons: false,
                closeOnClickOutside: false,
                closeOnEsc: false
            });

            $.ajax({
                url: '{{ route("sekolah.ppdb.auto_assign") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    swal({
                        title: response.status ? 'Berhasil!' : 'Gagal!',
                        text: response.message,
                        icon: response.status ? 'success' : 'error'
                    });

                    if (response.status) {
                        // Reload data via AJAX
                        $.ajax({
                            url: '{{ route("sekolah.ppdb.no_schedule.data") }}',
                            method: 'GET',
                            success: function(resp) {
                                if (resp.status) {
                                    updateStatisticsTable(resp.jadwalStats);
                                    updatePesertaTable(resp.peserta);
                                    updateDropdowns(resp.jadwalStats);
                                }
                            }
                        });
                    }
                },
                error: function(xhr) {
                    swal('Error!', 'Terjadi kesalahan saat auto-assign', 'error');
                }
            });
        });
    });
    
    // Function reload data
    function reloadData() {
        $.ajax({
            url: '{{ route("sekolah.ppdb.no_schedule.data") }}',
            method: 'GET',
            success: function(response) {
                if (response.status) {
                    updateStatisticsTable(response.jadwalStats);
                    updatePesertaTable(response.peserta);
                }
            }
        });
    }

    // Update statistics table
    function updateStatisticsTable(stats) {
        let html = '';
        stats.forEach(function(stat) {
            let labelType = stat.type == 'IQ' ? 'label-primary' : 'label-info';
            let percentage = stat.capacity > 0 ? (stat.filled / stat.capacity) * 100 : 0;
            let statusLabel = '';
            
            if (stat.filled >= stat.capacity) {
                statusLabel = '<span class="label label-danger">PENUH</span>';
            } else if (percentage >= 80) {
                statusLabel = '<span class="label label-warning">' + Math.round(percentage) + '%</span>';
            } else {
                statusLabel = '<span class="label label-success">' + Math.round(percentage) + '%</span>';
            }

            html += `
                <tr>
                    <td class="text-center">
                        <span class="label ${labelType}">${stat.type}</span>
                    </td>
                    <td>${stat.date_formatted}</td>
                    <td>${stat.session}</td>
                    <td class="text-center"><strong>${stat.filled}</strong></td>
                    <td class="text-center"><strong>${stat.capacity}</strong></td>
                    <td class="text-center">${statusLabel}</td>
                </tr>
            `;
        });
        
        $('table tbody').first().html(html);
    }

    // Update peserta table
    function updatePesertaTable(peserta) {
        let html = '';
        
        if (peserta.length == 0) {
            html = `
                <tr>
                    <td colspan="7" class="text-center">
                        <div class="alert alert-success" style="margin:0;">
                            <i class="fa fa-check-circle"></i>
                            <b>Semua peserta yang sudah bayar telah mendapat jadwal tes.</b>
                        </div>
                    </td>
                </tr>
            `;
        } else {
            peserta.forEach(function(p, index) {
                html += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td><strong>${p.nama}</strong></td>
                        <td><code>${p.kode_bayar}</code></td>
                        <td>${p.no_hp || '-'}</td>
                        <td>${p.email || '-'}</td>
                        <td class="text-center">
                            <span class="label label-success">${p.status_bayar.toUpperCase()}</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary btn-assign-jadwal" 
                                    data-kode="${p.kode_bayar}"
                                    data-nama="${p.nama}">
                                <i class="fa fa-calendar-plus-o"></i> Jadwalkan
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
        
        $('table tbody').last().html(html);
        
        // Update counter
        $('.box-tools .label-warning').text('Total: ' + peserta.length + ' Peserta');
    }

    // Update dropdown options
    function updateDropdowns(stats) {
        let iqOptions = '<option value="">-- Pilih Slot IQ --</option>';
        let mapOptions = '<option value="">-- Pilih Slot MAP --</option>';
        
        stats.forEach(function(stat) {
            if (stat.type == 'IQ' && stat.filled < stat.capacity) {
                let times = stat.session.split(' - ');
                iqOptions += `
                    <option value="${stat.date}|${stat.session}"
                            data-date="${stat.date}"
                            data-start="${times[0]}"
                            data-end="${times[1]}">
                        ${stat.date_formatted} | ${stat.session} 
                        (${stat.filled}/${stat.capacity})
                    </option>
                `;
            } else if (stat.type == 'MAP' && stat.filled < stat.capacity) {
                let times = stat.session.split(' - ');
                mapOptions += `
                    <option value="${stat.date}|${stat.session}"
                            data-date="${stat.date}"
                            data-start="${times[0]}"
                            data-end="${times[1]}">
                        ${stat.date_formatted} | ${stat.session} 
                        (${stat.filled}/${stat.capacity})
                    </option>
                `;
            }
        });
        
        $('#assign_iq_slot').html(iqOptions);
        $('#assign_map_slot').html(mapOptions);
    }
    
    // Open modal untuk assign jadwal (using event delegation)
    $(document).on('click', '.btn-assign-jadwal', function() {
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
                    
                    // Reload data via AJAX
                    $.ajax({
                        url: '{{ route("sekolah.ppdb.no_schedule.data") }}',
                        method: 'GET',
                        success: function(resp) {
                            if (resp.status) {
                                updateStatisticsTable(resp.jadwalStats);
                                updatePesertaTable(resp.peserta);
                                updateDropdowns(resp.jadwalStats);
                            }
                        }
                    });
                } else {
                    swal('Gagal!', response.message, 'error');
                }
            },
            error: function(xhr) {
                swal('Error!', 'Terjadi kesalahan saat menyimpan jadwal', 'error');
            }
        });
    });

    // Handler untuk tombol kirim email (using event delegation)
    $(document).on('click', '.btn-send-email', function() {
        const kodeBayar = $(this).data('kode');
        const btn = $(this);
        
        swal({
            title: 'Kirim Email Jadwal?',
            text: 'Email jadwal tes akan dikirim ke peserta dengan kode: ' + kodeBayar,
            icon: 'info',
            buttons: {
                cancel: 'Batal',
                confirm: 'Ya, Kirim!'
            }
        }).then((willSend) => {
            if (!willSend) return;

            // Disable button & show loading
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

            $.ajax({
                url: '{{ route("sekolah.ppdb.send_schedule_email") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    kode_bayar: kodeBayar
                },
                success: function(response) {
                    if (response.status) {
                        swal('Berhasil!', response.message, 'success');
                    } else {
                        swal('Gagal!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Terjadi kesalahan saat mengirim email';
                    swal('Error!', msg, 'error');
                },
                complete: function() {
                    // Re-enable button
                    btn.prop('disabled', false).html('<i class="fa fa-envelope"></i>');
                }
            });
        });
    });

});
</script>
@endsection
