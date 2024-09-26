@extends('layouts.app')
@section('title', "Rekap Nilai Formatif")

@section('css')
    <style>
        .table thead {
            background-color: gray;
            color: white;
            font-weight: 500;
            text-align: center;
        }
    </style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Rekap Nilai Formatif</h1>
</section>

<!-- Main content -->

<section class="content">
<div class="row">
    <div class="col-md-12">
    @component('components.filters', ['title' => __('report.filters')])
    
        <div class="col-md-3">
            <div class="form-group">
                <label>Tahun Ajaran/Smester</label>
                <select class="form-control" name="tahun">
                    <option>2024/2025 (Semester I)</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Mata Pelajaran</label>
                <select class="form-control" name="mapel">
                    <option>Matematika</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Kelas</label>
                <select class="form-control" name="kelas">
                    <option>4 A</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div style="margin-top: 2.5rem;">
                <button class="btn btn-primary" id="cari"><i class="fa fa-search"></i> CARI</button>
                <button class="btn btn-primary" id="reset">RESET</button>
            </div>
        </div>

       
    @endcomponent
    </div>
</div>


    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped ajax_view hide-footer">
                    <thead>
                        <tr>
                            <td>Nama Siswa</td> 
                            @for ($i = 1; $i <= 11; $i++)   
                                <td>TP {{$i}}</td> 
                            @endfor
                            <td>Nilai Akhir</td> 
                        </tr>
                    </thead>
                    <tbody>
                        @for ($k = 0; $k < 51; $k++)    
                            <tr>
                                <td>Juliani Okta Farida</td> 
                                @for ($i = 1; $i <= 11; $i++)   
                                    <td>{{$i}}</td> 
                                @endfor
                                <td>100</td> 
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</section>
<!-- /.content -->

@endsection

@section('javascript')

@endsection