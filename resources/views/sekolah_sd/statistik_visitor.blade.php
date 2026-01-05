@extends('layouts.app')
@section('title', 'Statistik Pengunjung')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>Statistik Pengunjung PPDB</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Kunjungan</h3>
        </div>

        <div class="box-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="filter_page">Filter Halaman:</label>
                    <input type="text" id="filter_page" class="form-control" placeholder="Contoh: ppdb-simuda">
                </div>
                <div class="col-md-3">
                    <label>Dari Tanggal:</label>
                    <input type="date" id="start_date" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Sampai Tanggal:</label>
                    <input type="date" id="end_date" class="form-control">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button id="btn_filter" class="btn btn-primary w-100">Terapkan Filter</button>
                </div>
            </div>

            <table id="visitor_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Domain</th>
                        <th>IP Address</th>
                        <th>Halaman</th>
                        <th>User Agent</th>
                        <th>Dibuat Pada</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(document).ready(function() {
     // 🔹 Ambil domain[] dari URL query
    const urlParams = new URLSearchParams(window.location.search);
    const domainParams = [];
    for (const [key, value] of urlParams.entries()) {
        if (key.startsWith('domain')) {
            domainParams.push(value);
        }
    }

    const table = $('#visitor_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.visitor.data') }}",
            data: function (d) {
                d.page_name = $('#filter_page').val();
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
                if (domainParams.length > 0) {
                    d.domain = domainParams;
                }
            }
        },
        order: [],
        columns: [
            { data: 'id', name: 'id' },
            { data: 'visited_date', name: 'visited_date' },
            { data: 'domain', name: 'domain' },
            { data: 'ip_address', name: 'ip_address' },
            { data: 'page', name: 'page' },
            { data: 'user_agent', name: 'user_agent' },
            { data: 'created_at', name: 'created_at' },
        ],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', className: 'btn btn-success btn-sm', text: '<i class="fa fa-file-excel-o"></i> Excel' },
            { extend: 'csv', className: 'btn btn-info btn-sm', text: '<i class="fa fa-file-text-o"></i> CSV' },
            { extend: 'print', className: 'btn btn-primary btn-sm', text: '<i class="fa fa-print"></i> Cetak' }
        ]
    });

    $('#btn_filter').on('click', function() {
        table.ajax.reload();
    });
});
</script>
@endsection
