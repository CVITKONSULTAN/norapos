@extends('layouts.app')
@section('title', 'Laporan Pemakaian Bahan Baku')

@section('content')
<section class="content-header">
    <h1>Laporan Pemakaian Bahan Baku
        <small>Berdasarkan penjualan</small>
    </h1>
</section>

<section class="content">
    {{-- Filter --}}
    @component('components.widget', ['class' => 'box-primary', 'title' => 'Filter'])
        <form method="GET" action="{{ action('IngredientController@usageReport') }}">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $start_date }}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $end_date }}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Lokasi</label>
                        {!! Form::select('location_id', $locations, $location_id, ['class' => 'form-control select2', 'placeholder' => 'Semua Lokasi']) !!}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endcomponent

    {{-- Ringkasan pemakaian bahan --}}
    @if(!empty($usage_data) && count($usage_data) > 0)
    @component('components.widget', ['class' => 'box-success', 'title' => 'Ringkasan Pemakaian Bahan (' . $start_date . ' s/d ' . $end_date . ')'])
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Total Pemakaian</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usage_data as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->ingredient_name }}</td>
                        <td class="text-right"><strong>{{ number_format($row->total_used, 2) }}</strong></td>
                        <td>{{ $row->unit_short ?? $row->unit_name ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcomponent
    @elseif(request()->has('start_date'))
    @component('components.widget', ['class' => 'box-warning'])
        <p class="text-center text-muted">Tidak ada data pemakaian bahan pada periode ini.</p>
    @endcomponent
    @endif

    {{-- Detail per penjualan --}}
    @if(!empty($sale_summary) && count($sale_summary) > 0)
    @component('components.widget', ['class' => 'box-info', 'title' => 'Detail Pemakaian per Penjualan'])
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed" id="detail_table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No Invoice</th>
                        <th>Lokasi</th>
                        <th>Produk</th>
                        <th>Qty Jual</th>
                        <th>Bahan Terpakai</th>
                        <th>Qty Bahan</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale_summary as $row)
                    <tr>
                        <td>{{ $row->transaction_date ? \Carbon\Carbon::parse($row->transaction_date)->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $row->invoice_no ?? '-' }}</td>
                        <td>{{ $row->location_name ?? '-' }}</td>
                        <td>{{ $row->product_name ?? '-' }}</td>
                        <td class="text-right">{{ number_format($row->qty_sold, 0) }}</td>
                        <td>{{ $row->ingredient_name }}</td>
                        <td class="text-right text-danger">{{ number_format($row->qty_used, 2) }}</td>
                        <td>{{ $row->unit_short ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcomponent
    @endif
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    if ($('#detail_table').length) {
        $('#detail_table').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
        });
    }
});
</script>
@endsection
