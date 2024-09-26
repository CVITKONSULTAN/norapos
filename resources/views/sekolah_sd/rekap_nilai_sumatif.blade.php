@extends('layouts.app')
@section('title', "Rekap Nilai Sumatif")

@section('css')
    <style>
        .table thead tr th {
            text-align: center;
            vertical-align: middle;
        }
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
    <h1>Rekap Nilai Sumatif</h1>
</section>

<!-- Main content -->
<div id="editor_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Form Nilai Sumatif
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Cari NISN/Nama Siswa</label>
                    <input class="form-control" placeholder="Cari disini..." />
                </div>
                <div class="form-group">
                    <label>NISN</label>
                    <input readonly class="form-control" />
                </div>
                <div class="form-group">
                    <label>Nama Siswa</label>
                    <input readonly class="form-control" />
                </div>
                <div class="row">
                    @for ($i = 1; $i <= 3; $i++)   
                        <div class="form-group col-sm-4">
                            <label>S {{$i}}
                                <i 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="S {{$i}} adalah bla bla bla bla bla bla bla bla"
                                    class="fa fa-info-circle"
                                ></i>
                            </label>
                            <input type="number" class="form-control" />
                        </div>
                    @endfor
                    <div class="form-group col-sm-6">
                        <label>Sumatif Akhir (Non Tes)</label>
                        <input type="number" class="form-control" />
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Sumatif Akhir (Tes)</label>
                        <input type="number" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Nilai Akhir</label>
                    <input type="number" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
              </div>
        </div>
    </div>
</div>

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
                            <th rowspan="2">No.</th>
                            <th rowspan="2">Nama Siswa</th>
                            <th colspan="3">Sumatif Lingkup Materi</th>
                            <th colspan="2">Sumatif Akhir</th>
                            <th rowspan="2">Nilai Rapor</th>
                            <th rowspan="2">Tindakan</th>
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 3; $i++)
                                <th>S{{$i}}</th>
                            @endfor
                            <th>Non Tes</th>
                            <th>Tes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($k = 0; $k < 51; $k++)    
                            <tr>
                                <td>Juliani Okta Farida</td> 
                                @for ($i = 1; $i <= 6; $i++)   
                                    <td>{{$i}}</td> 
                                @endfor
                                <td>100</td> 
                                <td>
                                    <a 
                                        class="btn btn-primary btn-xs" 
                                        href="#"
                                        onclick='$("#editor_modal").modal("show")'
                                    >
                                        Edit
                                    </a>
                                    <a 
                                        class="btn btn-danger btn-xs" 
                                        href="#"
                                        target="_blank"
                                    >
                                        Hapus
                                    </a>
                                </td>
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