@extends('layouts.app')
@section('title', 'Tambah Bahan Baku')

@section('content')
<section class="content-header">
    <h1>Tambah Bahan Baku</h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        {!! Form::open(['url' => action('IngredientController@store'), 'method' => 'post']) !!}

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('name', 'Nama Bahan *') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Nama bahan baku']) !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    {!! Form::label('sku', 'SKU') !!}
                    {!! Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Kode bahan (opsional)']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('unit_id', 'Satuan') !!}
                    <div class="input-group">
                        {!! Form::select('unit_id', $units, null, ['class' => 'form-control select2', 'id' => 'unit_id', 'placeholder' => 'Pilih satuan']) !!}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_add_unit" title="Tambah Satuan Baru">
                                <i class="fa fa-plus"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('min_stock', 'Minimal Stok') !!}
                    {!! Form::number('min_stock', 0, ['class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <br>
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('is_active', 1, true) !!} Aktif
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary pull-right">
                    <i class="fa fa-save"></i> @lang('messages.save')
                </button>
            </div>
        </div>

        {!! Form::close() !!}
    @endcomponent
</section>

@include('ingredient.partials.modal_add_unit')
@endsection

@section('javascript')
@include('ingredient.partials.unit_modal_js')
@endsection
