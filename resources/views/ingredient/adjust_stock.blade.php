@extends('layouts.app')
@section('title', 'Adjust Stok - ' . $ingredient->name)

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
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $s)
                <tr>
                    <td>{{ $s->location->name ?? '-' }}</td>
                    <td class="{{ $s->current_qty < 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($s->current_qty, 2) }}
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
                    {!! Form::label('qty', 'Qty (+ untuk tambah, - untuk kurangi) *') !!}
                    {!! Form::number('qty', null, ['class' => 'form-control', 'required', 'step' => '0.01', 'placeholder' => 'Contoh: 100 atau -50']) !!}
                </div>
            </div>
            <div class="col-sm-4">
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
