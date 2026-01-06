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

            <div class="form-inline" style="margin-bottom:15px;">

                <!-- FILTER TANGGAL -->
                <label style="margin-right:10px;"><b>Tanggal Tes</b></label>

                <select id="filter-tanggal" class="form-control" style="margin-right:15px; min-width:200px;">
                    <option value="">-- Pilih Tanggal --</option>
                </select>

                <!-- BUTTON TAMPILKAN -->
                <button id="btn-tampilkan" class="btn btn-primary">
                    <i class="fa fa-search"></i> Tampilkan
                </button>

                <!-- BUTTON RESET -->
                <button id="btn-reset" class="btn btn-default" style="margin-left:10px;">
                    Reset
                </button>

                <!-- BUTTON EXPORT -->
                <a id="btn-export" href="#" class="btn btn-success" style="margin-left:10px;">
                    <i class="fa fa-file-excel-o"></i> Export Excel
                </a>

            </div>

            <!-- SEARCH NAMA PESERTA -->
            <div class="form-inline">
                <label style="margin-right:10px;"><b>Cari Peserta</b></label>
                <input type="text" id="search-nama" class="form-control" placeholder="Ketik nama peserta..." style="min-width:300px; margin-right:10px;">
                <button id="btn-search" class="btn btn-info">
                    <i class="fa fa-search"></i> Cari
                </button>
                <button id="btn-clear-search" class="btn btn-default" style="margin-left:10px;">
                    <i class="fa fa-times"></i> Clear
                </button>
            </div>

        </div>
    </div>

    <!-- LOADING SPINNER -->
    <div id="loading-spinner" class="text-center" style="display:none; padding:30px;">
        <i class="fa fa-spinner fa-spin fa-3x"></i>
        <p>Memuat data...</p>
    </div>

    <!-- CONTAINER HASIL -->
    <div id="hasil-jadwal"></div>

</section>

@endsection

@section('javascript')
<script>
$(document).ready(function() {
    let currentFilter = '';
    let availableDates = [];
    let searchKeyword = '';

    // Load initial data
    loadData();

    // Event: Klik Tampilkan
    $('#btn-tampilkan').click(function() {
        currentFilter = $('#filter-tanggal').val();
        loadData(currentFilter);
    });

    // Event: Klik Reset
    $('#btn-reset').click(function() {
        currentFilter = '';
        $('#filter-tanggal').val('');
        searchKeyword = '';
        $('#search-nama').val('');
        loadData();
    });

    // Event: Change tanggal dropdown
    $('#filter-tanggal').change(function() {
        currentFilter = $(this).val();
        loadData(currentFilter);
    });

    // Event: Klik Search
    $('#btn-search').click(function() {
        searchKeyword = $('#search-nama').val().trim();
        if (searchKeyword === '') {
            toastr.warning('Silakan masukkan nama peserta');
            return;
        }
        filterByName(searchKeyword);
    });

    // Event: Enter pada input search
    $('#search-nama').keypress(function(e) {
        if (e.which === 13) { // Enter key
            $('#btn-search').click();
        }
    });

    // Event: Clear search
    $('#btn-clear-search').click(function() {
        searchKeyword = '';
        $('#search-nama').val('');
        renderJadwal(window.allData); // Tampilkan semua data lagi
    });

    // Fungsi load data via AJAX
    function loadData(tanggal = '') {
        $('#loading-spinner').show();
        $('#hasil-jadwal').html('');

        $.ajax({
            url: "{{ route('sekolah_sd.ppdb.jadwal_harian.detail.ajax') }}",
            method: 'GET',
            data: { tanggal: tanggal },
            success: function(response) {
                $('#loading-spinner').hide();

                if (!response.status) {
                    toastr.error('Gagal memuat data');
                    return;
                }

                // Update dropdown tanggal
                availableDates = response.dates;
                updateDateDropdown(response.dates, response.filter);

                // Update link export
                $('#btn-export').attr('href', "{{ route('sekolah_sd.ppdb.jadwal_harian.export') }}?tanggal=" + response.filter);

                // Simpan data untuk filter
                window.allData = response.data;

                // Render data
                renderJadwal(response.data);
            },
            error: function() {
                $('#loading-spinner').hide();
                toastr.error('Terjadi kesalahan saat memuat data');
            }
        });
    }

    // Update dropdown tanggal
    function updateDateDropdown(dates, selected) {
        let options = '<option value="">-- Pilih Tanggal --</option>';
        
        dates.forEach(function(date) {
            let formattedDate = moment(date).locale('id').format('DD MMMM YYYY');
            let isSelected = date === selected ? 'selected' : '';
            options += `<option value="${date}" ${isSelected}>${formattedDate}</option>`;
        });

        $('#filter-tanggal').html(options);
    }

    // Filter data berdasarkan nama
    function filterByName(keyword) {
        if (!window.allData || Object.keys(window.allData).length === 0) {
            toastr.warning('Tidak ada data untuk dicari');
            return;
        }

        let filteredData = {};
        let found = false;
        keyword = keyword.toLowerCase();

        // Loop dan filter data
        $.each(window.allData, function(hari, testTypes) {
            $.each(testTypes, function(tipeTes, sessions) {
                $.each(sessions, function(jam, peserta) {
                    let filteredPeserta = peserta.filter(function(p) {
                        return p.nama.toLowerCase().includes(keyword);
                    });

                    if (filteredPeserta.length > 0) {
                        found = true;
                        if (!filteredData[hari]) {
                            filteredData[hari] = {};
                        }
                        if (!filteredData[hari][tipeTes]) {
                            filteredData[hari][tipeTes] = {};
                        }
                        filteredData[hari][tipeTes][jam] = filteredPeserta;
                    }
                });
            });
        });

        if (!found) {
            toastr.warning('Peserta dengan nama "' + $('#search-nama').val() + '" tidak ditemukan');
            return;
        }

        toastr.success('Ditemukan peserta dengan nama "' + $('#search-nama').val() + '"');
        renderJadwal(filteredData, keyword);
    }

    // Render jadwal ke HTML
    function renderJadwal(data, highlightKeyword = '') {
        if (Object.keys(data).length === 0) {
            $('#hasil-jadwal').html(`
                <div class="alert alert-warning">
                    <b>Tidak ada data jadwal.</b>
                </div>
            `);
            return;
        }

        let html = '';

        // Loop per hari
        $.each(data, function(hari, testTypes) {
            html += `
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">📅 ${hari}</h3>
                    </div>
                    <div class="box-body">
            `;

            // Loop per tipe tes (IQ/MAP)
            $.each(testTypes, function(tipeTes, sessions) {
                let icon = tipeTes === 'IQ' ? '🧠' : '📘';
                let label = tipeTes === 'IQ' ? 'Tes IQ' : 'Tes Pemetaan';

                html += `<h3 style="margin-top:10px;"><b>${icon} ${label}</b></h3>`;

                // Loop per sesi
                $.each(sessions, function(jam, peserta) {
                    html += `<h4 style="margin-top:20px;"><b>⏰ ${jam}</b></h4>`;
                    html += `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="35%">Nama Peserta</th>
                                    <th width="20%">Kode Bayar</th>
                                    <th width="25%">No HP</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    // Loop peserta
                    peserta.forEach(function(p, index) {
                        let namaDisplay = p.nama;
                        let rowClass = '';
                        
                        // Highlight jika ada keyword
                        if (highlightKeyword !== '') {
                            let regex = new RegExp('(' + highlightKeyword + ')', 'gi');
                            namaDisplay = p.nama.replace(regex, '<span style="background-color:yellow; font-weight:bold;">$1</span>');
                            rowClass = 'style="background-color:#d4edda;"';
                        }

                        html += `
                            <tr ${rowClass}>
                                <td>${index + 1}</td>
                                <td>${namaDisplay}</td>
                                <td>
                                    <p>${p.kode_bayar}</p>
                                    <a href="{{ route('sekolah.cetak_kartutes_ppdb') }}?kode_bayar=${p.kode_bayar}" 
                                       class="btn btn-primary btn-sm">
                                        Cetak Kartu Tes
                                    </a>
                                </td>
                                <td>${p.no_hp || '-'}</td>
                            </tr>
                        `;
                    });

                    html += `
                            </tbody>
                        </table>
                    `;
                });
            });

            html += `
                    </div>
                </div>
            `;
        });

        $('#hasil-jadwal').html(html);
    }
});
</script>
@endsection
