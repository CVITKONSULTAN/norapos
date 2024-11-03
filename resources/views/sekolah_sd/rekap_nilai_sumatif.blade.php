@php
    $lm = $mapel_choices->lingkup_materi ?? [];
@endphp

@extends('layouts.app')
@section('title', "Rekap Nilai Sumatifs")

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
<form id="form_nilai_sumatif" method="POST" action="{{route('sekolah_sd.rekap_nilai.store')}}">
    @csrf
    <input value="" type="hidden" name="id" />
            <div class="modal-body">
                {{-- <div class="form-group">
                    <label>Cari NISN/Nama Siswa</label>
                    <input class="form-control" placeholder="Cari disini..." />
                </div> --}}
                <div class="form-group">
                    <label>NISN</label>
                    <input name="nisn" disabled class="form-control" />
                </div>
                <div class="form-group">
                    <label>Nama Siswa</label>
                    <input name="nama" disabled class="form-control" />
                </div>
                <div class="row">
                    @foreach ($lm as $i => $item)
                        <div class="form-group col-sm-4">
                            <label>S{{$i}}
                                <i 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="{{$item}}"
                                    class="fa fa-info-circle"
                                ></i>
                            </label>
                            <input name="nilai_sumatif[]" required type="number" 
                            class="form-control lm_{{$i}}" />
                        </div>
                        @endforeach
                    <div class="form-group col-sm-6">
                        <label>Sumatif Akhir (Non Tes)</label>
                        <input name="sumatif_tes" required type="number" class="form-control" />
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Sumatif Akhir (Tes)</label>
                        <input name="sumatif_non_tes" required type="number" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Nilai Akhir Sumatif</label>
                    <input name="nilai_akhir_sumatif" type="number" required class="form-control" />
                </div>
                <div class="form-group">
                    <label>Nilai Rapor</label>
                    <input name="nilai_rapor" type="number" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
            </div>
</form>
        </div>
    </div>
</div>

<section class="content">
    
    <form>
        @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-2">
                <div class="form-group">
                    <label>Tahun Ajaran</label>
                    <select required class="form-control" name="tahun_ajaran">
                        @foreach ($tahun_ajaran as $item)
                            <option>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Semester</label>
                    <select required class="form-control" name="semester">
                        @foreach ($semester as $item)
                            <option>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Mata Pelajaran</label>
                    <select required class="form-control" name="mapel_id">
                        @foreach ($mapel as $item)
                            <option value="{{$item->id}}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Kelas</label>
                    <select required class="form-control" name="nama_kelas">
                        @foreach ($nama_kelas as $item)
                            <option>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div style="margin-top: 2.5rem;">
                    <button type="submit" class="btn btn-primary" id="cari"><i class="fa fa-search"></i> CARI</button>
                    {{-- <button class="btn btn-primary" id="reset">RESET</button> --}}
                </div>
            </div>
        @endcomponent
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped ajax_view hide-footer">
                    <thead>
                        <tr>
                            {{-- <th rowspan="2">No.</th> --}}
                            <th rowspan="2">Nama Siswa</th>
                            <th colspan="{{count($lm)}}">Sumatif Lingkup Materi</th>
                            <th colspan="2">Sumatif Akhir</th>
                            <th rowspan="2">Nilai Rapor</th>
                            <th rowspan="2">Tindakan</th>
                        </tr>
                        <tr>
                            @foreach ($lm as $i => $item)
                                <th>S{{$i+1}}</th>
                            @endforeach
                            <th>Non Tes</th>
                            <th>Tes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_data as $item)   
                            @php
                                $nilai_sumatif = [];
                                try {
                                    $nilai_sumatif = json_decode($item->nilai_sumatif,true);
                                } catch (\Throwable $th) {
                                    $nilai_sumatif = [];
                                }
                            @endphp 
                            <tr>
                                <td>{{$item->siswa->nama}}</td> 
                                @foreach ($lm as $j => $item_data)
                                    <td class="text-center">{{ isset($nilai_sumatif[$j]) ? $nilai_sumatif[$j] : 0 }}</td> 
                                @endforeach
                                <td class="text-center">{{ $item->sumatif_tes }}</td> 
                                <td class="text-center">{{ $item->sumatif_non_tes }}</td> 
                                <td class="text-center">{{ $item->nilai_rapor }}</td> 
                                <td>
                                    <a 
                                        class="btn btn-primary btn-xs" 
                                        href="#"
                                        onclick='editNilaiSumatif("{{$item->id}}")'
                                    >
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
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
        const editNilaiSumatif = (id) => {
            const form = $("#editor_modal");
            $.ajax({
                type:"GET",
                url:`{{route('sekolah_sd.rekap_nilai.index')}}/${id}/show`,
                success: response => {
                    if(!response.success) 
                    return toastr.error(result.message);
                    let res = response.data
                    form.find('input[name=id]').val(res?.id ?? "0");
                    form.find('input[name=nisn]').val(res?.siswa?.nisn ?? "");
                    form.find('input[name=nama]').val(res?.siswa?.nama ?? "");
                    form.find('input[name=nilai_akhir_sumatif]').val(res?.nilai_akhir_sumatif ?? "0");
                    form.find('input[name=nilai_rapor]').val(res?.nilai_rapor ?? "0");
                    form.find('input[name=sumatif_tes]').val(res?.sumatif_tes ?? "0");
                    form.find('input[name=sumatif_non_tes]').val(res?.sumatif_non_tes ?? "0");

                    let nilai_sumatif = [];
                    try{
                        nilai_sumatif = JSON.parse(res.nilai_sumatif)
                    } catch(e){
                        nilai_sumatif = [];
                    }
                    for(const k in nilai_sumatif){
                        form.find(`.lm_${k}`).val(nilai_sumatif[k]);
                    }
                    
                    form.modal("show")
                }
            })
        }

        $("#form_nilai_sumatif").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                console.log("result",result);
                if(result.success){
                    toastr.success(result.message);
                    // product_table.ajax.reload();
                } else {
                    toastr.error(result.message);
                }
                $("#form_nilai_sumatif button[type=submit]").removeAttr('disabled')
                $("#form_nilai_sumatif").trigger("reset"); // to reset form input fields
                window.location.reload();
                $("#editor_modal").modal("hide");
            },
            error: function(e) {
                console.log(e);
            }
            });
        }));
    </script>
@endsection