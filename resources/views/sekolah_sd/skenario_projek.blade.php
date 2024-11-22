@extends('layouts.app')
@section('title', "Skenario Projek")

@section('css')
<style>
    .project_wrapper{
        border: 1px solid black;
        padding: 10px;
        border-radius: 5px;
        margin-top: 30px;
    }
</style>
@endsection

@section('content')

<div id="tambah_projek" class="modal fade">
    <div class="modal-dialog">
        <form enctype="multipart/form-data" method="POST" action="{{route('sekolah_sd.rapor_projek.store')}}" class="modal-content">
            @csrf
            <input type="hidden" name="kelas" value="{{Request::get('kelas') ?? 0}}" />
            <input type="hidden" name="action" value="add_project" />
            <div class="modal-header">
                <h4 class="modal-title">
                    Tambah Projek
                </h4>
            </div>
            <div class="modal-body">
               <div class="form-group">
                    <label>Nama Projek</label>
                    <input required class="form-control" type="text" name="nama" />
               </div>
               <div class="form-group">
                    <label>Deskripsi Projek</label>
                    <textarea required class="form-control" type="text" name="deskripsi"></textarea>
               </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
              </div>
        </form>
    </div>
</div>

<div id="tambah_dimensi" class="modal fade">
    <div class="modal-dialog">
        <form id="dimensi_local" enctype="multipart/form-data" method="POST" action="{{route('sekolah_sd.rapor_projek.store')}}" class="modal-content">
            @csrf
            <input type="hidden" name="projek_id" value="0" />
            <input type="hidden" name="action" value="add_dimensi" />
            <div class="modal-header">
                <h4 class="modal-title">
                    Tambah Dimensi
                </h4>
            </div>
            <div class="modal-body">
               <div class="form-group">
                <label>Dimensi</label>
                <select name="dimensi_id" class="form-control">
                    @foreach ($dimensi as $item)
                        <option value="{{$item->id}}">{{ $item->keterangan }}</option>
                    @endforeach
                </select>
               </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
              </div>
        </form>
    </div>
</div>

<div id="tambah_subelemen" class="modal fade">
    <div class="modal-dialog">
        <form id="dimensi_local" enctype="multipart/form-data" method="POST" action="{{route('sekolah_sd.rapor_projek.store')}}" class="modal-content">
            @csrf
            <input type="hidden" name="projek_id" value="0" />
            <input type="hidden" name="dimensi_id" value="0" />
            <input type="hidden" name="action" value="add_subelemen" />
            <div class="modal-header">
                <h4 class="modal-title">
                    Tambah Subelemen
                </h4>
            </div>
            <div class="modal-body">
               <div class="form-group">
                <label>Subelemen</label>
                <select id="subelemen_list" name="subelemen_id" class="form-control"></select>
               </div>
               <div class="form-group">
                <label>Target Capaian</label>
                <textarea class="form-control" name="target_capaian" id="target_capaian"></textarea>
               </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
              </div>
        </form>
    </div>
</div>

<form action="{{route('sekolah_sd.rapor_projek.store')}}" id="delete_data" method="POST">
    @csrf
    <input type="hidden" name="delete" value="1" />
    <input type="hidden" name="parent_id" value="0" />
    <input type="hidden" name="id" value="0" />
    <input type="hidden" name="type" value="projek" />
    {{-- <input type="hidden" name="type" value="dimensi" /> --}}
    {{-- <input type="hidden" name="type" value="subelemen" /> --}}
</form>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Skenario Projek</h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Form Skenario Projek</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="product_list_tab">
                <form id="filter_kelas">
                    <div class="form-group">
                        <label>Kelas</label>
                        <select class="form-control" name="kelas" id="select_kelas">
                            <option value="-1">--Pilih Kelas--</option>
                            @foreach ([1,2,3,4,5,6] as $item)
                                <option {{Request::get('kelas') == $item ? 'selected' : ''}} value="{{$item}}">Kelas {{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                
                <div id="project_list">
                    @foreach ($rapor_projek as $i => $item)    
                        <div id="project_{{$item->id}}" class="project_wrapper">
                            <h4 class="text-center">PROJEK {{$i+1}} 
                                <button onclick="deleteData('projek',{{$item->id}})" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                            </h4>
                            <hr />
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nama Projek</label>
                                    <input value="{{$item->nama}}" readonly class="form-control" name="nama" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Deskripsi Projek</label>
                                    <input value="{{$item->deskripsi}}" readonly class="form-control" name="deskripsi" />
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Dimensi
                                                    <button onclick="tambahDimensi({{$item->id}})" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i></button>
                                                </th>
                                                <th>Subelemen</th>
                                                <th>Target Capaian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->dimensi as $val)    
                                                @php
                                                    $first_sub = null;
                                                    $subelemen_fase = $val->subelemen_fase ?? [];
                                                    // if($item->id == 2){
                                                    //     dd($val->subelemen_fase);
                                                    // }
                                                    // try {
                                                    //     $subelemen_fase = json_decode($val->subelemen_fase,true);
                                                    //     if(empty($subelemen_fase)) $subelemen_fase = [];
                                                    // } catch (\Throwable $th) {
                                                    //     $subelemen_fase = [];
                                                    // }
                                                    if(count($subelemen_fase) > 0){
                                                        $first_sub = $subelemen_fase[0];
                                                        // dd($first_sub);
                                                    }
                                                @endphp
                                                <tr>
                                                    <td rowspan="{{
                                                        count($subelemen_fase) == 0 ? 1 : count($subelemen_fase)
                                                    }}">
                                                        {{$val->dimensi_text}}
                                                        <button onclick="deleteData('dimensi',{{$val->id}})" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                                        <button onclick="tambahSubelemen({{$val->dimensi_id}},{{$item->id}})" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Subelemen</button>
                                                    </td>
                                                    <td>
                                                        {{$first_sub['text'] ?? ""}}
                                                        @if(!empty($first_sub['text']))
                                                            <button onclick="deleteData('subelemen',0,{{$val->id}})" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{$first_sub['target'] ?? ""}}
                                                    </td>
                                                </tr>
                                                @foreach ($subelemen_fase as $j => $value)  
                                                    @php
                                                        if($j == 0) continue;
                                                    @endphp  
                                                    <tr>
                                                        <td>
                                                            {{$value['text']}}
                                                            <button onclick="deleteData('subelemen',{{$j}},{{$val->id}})" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                        <td>{{$value['target']}}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(Request::get('kelas') > 0)
                    <button onclick="tambahProjek()" style="margin-top: 10px;" class="btn btn-block btn-primary btn-lg"><i class="fa fa-plus"></i> Projek</button>
                @endif
                {{-- <button style="margin-top: 10px;" class="btn btn-block btn-success btn-lg"><i class="fa fa-save"></i> Simpan</button> --}}
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
 <script>

    let data = [];

    let kelas = "{{Request::get('kelas') ?? 0}}";

    @if(!empty($rapor_projek))

    @endif

    const tambahProjek = () => {
        $("#tambah_projek").modal("show")
    }
    const tambahDimensi = (projek_id) => {
        const modals = $("#tambah_dimensi");
        modals.find("[name=projek_id]").val(projek_id);
        modals.modal("show")
    }
    $("#select_kelas").change(function(){
        $("#filter_kelas").submit();
    })
    
    const tambahSubelemen = (id,projek_id) => {
        const modals = $("#tambah_subelemen");
        modals.find("[name=dimensi_id]").val(id);
        modals.find("[name=projek_id]").val(projek_id);
        modals.modal("show")
        loadSubelemen(id)
    }

    let subelemen;

    const loadSubelemen = (id) => {
        $.ajax({
            url:`/sekolah_sd/fase-dimensi?dimensi_id=${id}`,
            success: res => {
                console.log(res)
                subelemen = res;
                const dom = $("#subelemen_list");
                dom.empty();
                dom.append(`<option value="">--Pilih--</option>`)
                res.map((item,index)=>{
                    dom.append(`<option value="${item.id}">${item.subelemen}</option>`)
                })
            }
        })
    }

    $("#subelemen_list").change(function(){
        const id = $(this).val();
        const data = subelemen.find(elm => elm.id == id)
        let msg = '';
        if(kelas <= 2 ){
            msg = data.fase_a
        }
        if(kelas > 2 && kelas <= 4){
            msg = data.fase_b
        }
        if(kelas > 4 && kelas <= 6){
            msg = data.fase_c
        }
        $("#target_capaian").val(msg)
    })

    const deleteData = (tipe,id,parent_id = null) => {
        const form = $("#delete_data");
        form.find('[name=type]').val(tipe);
        form.find('[name=id]').val(id);
        if(parent_id)
        form.find('[name=parent_id]').val(parent_id);
        form.submit();
    }

 </script>
@endsection