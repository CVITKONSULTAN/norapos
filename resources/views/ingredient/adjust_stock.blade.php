@extends('layouts.app')
@section('title', 'Adjust Stok - ' . $ingredient->name)

@php
    $unit_name = $ingredient->unit->actual_name ?? $ingredient->unit->short_name ?? '';
@endphp

@section('content')
<section class="content-header">
    <h1>Adjust Stok: {{ $ingredient->name }}
        <small>{{ $ingredient->unit->actual_name ?? '' }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ action('IngredientController@index') }}">Bahan Baku</a></li>
        <li class="active">Adjust Stok</li>
    </ol>
</section>

<section class="content">
    {{-- Stok saat ini --}}
    @if($stocks->isNotEmpty())
    @component('components.widget', ['class' => 'box-info', 'title' => 'Stok Saat Ini'])
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Lokasi</th>
                    <th>Qty {{ !empty($unit_name) ? '(' . $unit_name . ')' : '' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $s)
                <tr>
                    <td>{{ $s->location->name ?? '-' }}</td>
                    <td class="{{ $s->current_qty < 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($s->current_qty, 2) }} {{ $unit_name }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endcomponent
    @endif

    @component('components.widget', ['class' => 'box-primary', 'title' => 'Tambah / Kurangi Stok'])
        {!! Form::open(['url' => action('IngredientController@adjustStock', [$ingredient->id]), 'method' => 'post']) !!}

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('location_id', 'Lokasi *') !!}
                    {!! Form::select('location_id', $locations, null, ['class' => 'form-control select2', 'required', 'placeholder' => 'Pilih lokasi']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('stock_in', 'Stok Masuk *') !!}
                    <div class="input-group">
                        {!! Form::number('stock_in', 0, ['class' => 'form-control', 'required', 'min' => '0', 'step' => '0.01', 'placeholder' => 'Contoh: 100.00']) !!}
                        <span class="input-group-addon">{{ $ingredient->unit->actual_name ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('stock_out', 'Stok Keluar *') !!}
                    <div class="input-group">
                        {!! Form::number('stock_out', 0, ['class' => 'form-control', 'required', 'min' => '0', 'step' => '0.01', 'placeholder' => 'Contoh: 50.00']) !!}
                        <span class="input-group-addon">{{ $ingredient->unit->actual_name ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('notes', 'Catatan') !!}
                    {!! Form::text('notes', null, ['class' => 'form-control', 'placeholder' => 'Keterangan adjustment']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">
                    <i class="fa fa-save"></i> Simpan Adjustment
                </button>
            </div>
        </div>

        {!! Form::close() !!}
    @endcomponent
</section>
@endsection
