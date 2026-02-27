@extends('layouts.app')
@section('title', 'Log Stok - ' . $ingredient->name)

@section('content')
<section class="content-header">
    <h1>Log Stok: {{ $ingredient->name }}
        <small>{{ $ingredient->unit->actual_name ?? '' }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ action('IngredientController@index') }}">Bahan Baku</a></li>
        <li class="active">Log Stok</li>
    </ol>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        @slot('tool')
            <div class="box-tools">
                <a class="btn btn-primary" href="{{ action('IngredientController@adjustStock', [$ingredient->id]) }}">
                    <i class="fa fa-plus-minus"></i> Adjust Stok
                </a>
            </div>
        @endslot

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="stock_log_table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Perubahan Qty</th>
                        <th>Tipe</th>
                        <th>Catatan</th>
                        <th>Oleh</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent
</section>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#stock_log_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ action("IngredientController@stockLog", [$ingredient->id]) }}',
            columns: [
                { data: 'created_at', name: 'created_at' },
                { data: 'location_name', name: 'location_name', orderable: false, searchable: false },
                { data: 'qty_change', name: 'qty_change' },
                { data: 'ref_type', name: 'ref_type' },
                { data: 'notes', name: 'notes' },
                { data: 'created_by_name', name: 'created_by_name', orderable: false, searchable: false },
            ],
            order: [[0, 'desc']],
        });
    });
</script>
@endsection
