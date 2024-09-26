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
        .unchecked{
            color: red;
        }
        .checked{
            color: green;
        }
        div.suggestion_selection_container::-webkit-scrollbar {
            height: 5px;              /* height of horizontal scrollbar ← You're missing this */
            width: 5px;               /* width of vertical scrollbar */
            border: 1px solid gray;
        }
        div.suggestion_selection_container{
            background: gray;
            height: 60px;
            padding: 10px 15px;

            white-space: nowrap;
            position: relative;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
        }
    </style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Rekap Nilai Formatif</h1>
</section>

<!-- Main content -->
<div id="editor_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Form Nilai Formatif
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
                    @for ($i = 1; $i <= 11; $i++)   
                        <div class="form-group col-sm-4">
                            <label>TP {{$i}}
                                <i 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="TP {{$i}} adalah bla bla bla bla bla bla bla bla"
                                    class="fa fa-info-circle"
                                ></i>
                            </label>
                            <input type="number" class="form-control" />
                        </div>
                    @endfor
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

<div id="editor_modal_catatan_penilaian" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Form Catatan Penilaian
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
                    <div class="form-group col-md-6">
                        <label>Kolom TP Tertinggi</label>
                        <input readonly class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nilai TP Tertinggi</label>
                        <input readonly class="form-control" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Catatan Penilaian Tertinggi</label>
                        <div 
                        id="notes_tertinggi"
                        data-target="textbox_tertinggi"
                        class="suggestion_selection_container">
                            <button class="btn btn-secondary">Menunjukan penguasaan dalam</button>
                            <button class="btn btn-secondary">Menunjukan penguasaan yang sangat baik dalam</button>
                            <button class="btn btn-secondary">Menunjukan pemahaman dalam</button>
                            <button class="btn btn-secondary">Menunjukan pemahaman yang sangat baik dalam</button>
                        </div>
                        <textarea id="textbox_tertinggi" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Kolom TP Terendah</label>
                        <input readonly class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nilai TP Terendah</label>
                        <input readonly class="form-control" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Catatan Penilaian Terendah</label>
                        <div 
                        id="notes_terendah"
                        data-target="textbox_terendah"
                        class="suggestion_selection_container">
                            <button class="btn btn-secondary">Perlu bimbingan dalam</button>
                            <button class="btn btn-secondary">Perlu bantuan dalam</button>
                            <button class="btn btn-secondary">Perlu pembinaan dalam</button>
                            <button class="btn btn-secondary">Perlu pendampingan dalam</button>
                        </div>
                        <textarea id="textbox_terendah" rows="5" class="form-control"></textarea>
                    </div>
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
                            <td>Nama Siswa</td> 
                            @for ($i = 1; $i <= 11; $i++)   
                                <td>TP {{$i}}</td> 
                            @endfor
                            <td>Nilai Akhir</td> 
                            <td>Catatan Penilaian</td> 
                            <td>Tindakan</td> 
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
                                <td class="text-center">
                                    @if ($k == 0)
                                        <i class="fa fa-times unchecked"></i>
                                    @else
                                        <i class="fa fa-check checked"></i>
                                    @endif
                                </td> 
                                <td>
                                    <a 
                                        class="btn btn-primary btn-xs" 
                                        href="#"
                                        onclick='$("#editor_modal").modal("show")'
                                    >
                                        Edit
                                    </a>
                                    <a 
                                        class="btn btn-primary btn-xs" 
                                        href="#"
                                        onclick='$("#editor_modal_catatan_penilaian").modal("show")'
                                    >
                                        Catatan Penilaian
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
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $("#notes_tertinggi button").click(function(){
        const text = $(this).text();
        const target = $(this).parent().data('target')
        $("#"+target).val(text);
    });
    $("#notes_terendah button").click(function(){
        const text = $(this).text();
        const target = $(this).parent().data('target')
        $("#"+target).val(text);
    });
</script>
@endsection