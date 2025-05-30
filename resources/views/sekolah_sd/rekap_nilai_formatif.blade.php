{{-- @php
    $tp = $mapel_choices->tujuan_pembelajaran ?? [];
@endphp --}}

@extends('layouts.app')
@section('title', "Rekap Nilai Formatifs")

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
<form id="form_nilai_formatif" method="POST" action="{{route('sekolah_sd.rekap_nilai.store')}}">
    @csrf
    <input value="" type="hidden" name="id" />
    <input value="update_nilai_tp" type="hidden" name="tipe" />
            <div class="modal-body">
{{--                  
                <div class="form-group">
                    <label>Cari NISN/Nama Siswa</label>
                    <input class="form-control" placeholder="Cari disini..." />
                </div>
  --}}
                <div class="form-group">
                    <label>NISN</label>
                    <input name="nisn" disabled class="form-control" />
                </div>
                <div class="form-group">
                    <label>Nama Siswa</label>
                    <input name="nama" disabled class="form-control" />
                </div>
                <div class="row">
                    {{-- @for ($i = 1; $i <= 11; $i++)    --}}
                    {{-- {{dd($tp)}} --}}
                    @foreach ($tp as $i => $item)
                        <div class="form-group col-sm-4">
                            <label>TP {{$i+1}}
                                <i 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="{{$item}}"
                                    class="fa fa-info-circle"
                                ></i>
                            </label>
                            <input required max="100" min="0" name="nilai_tp[]" type="number" 
                            class="form-control tp_{{$i}} tp_field_satuan"
                            />
                        </div>
                    @endforeach
                    {{-- @endfor --}}
                </div>
                <div class="form-group">
                    <label>Nilai Akhir</label>
                    <input readonly id="nilai_akhir_tp" name="nilai_akhir_tp" required max="100" min="0" type="number" class="form-control" />
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

<div id="editor_modal_catatan_penilaian" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Form Catatan Penilaian
                </h4>
            </div>
<form id="form_catan_penilaian" method="POST" action="{{route('sekolah_sd.rekap_nilai.store')}}">
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
                    <div class="form-group col-md-6">
                        <label>Kolom TP Tertinggi</label>
                        <input name="kolom_max_tp" disabled class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nilai TP Tertinggi</label>
                        <input name="nilai_max_tp" disabled class="form-control" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Catatan Penilaian Tertinggi</label>
                        <div 
                        id="notes_tertinggi"
                        data-target="textbox_tertinggi"
                        class="suggestion_selection_container">
                            <button type="button" class="btn btn-secondary">Menunjukan penguasaan dalam</button>
                            <button type="button" class="btn btn-secondary">Menunjukan penguasaan yang sangat baik dalam</button>
                            <button type="button" class="btn btn-secondary">Menunjukan pemahaman dalam</button>
                            <button type="button" class="btn btn-secondary">Menunjukan pemahaman yang sangat baik dalam</button>
                        </div>
                        <textarea name="catatan_max_tp" id="textbox_tertinggi" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Kolom TP Terendah</label>
                        <input name="kolom_min_tp" disabled class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nilai TP Terendah</label>
                        <input name="nilai_min_tp" disabled class="form-control" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Catatan Penilaian Terendah</label>
                        <div 
                        id="notes_terendah"
                        data-target="textbox_terendah"
                        class="suggestion_selection_container">
                            <button type="button" class="btn btn-secondary">Perlu bimbingan dalam</button>
                            <button type="button" class="btn btn-secondary">Perlu bantuan dalam</button>
                            <button type="button" class="btn btn-secondary">Perlu pembinaan dalam</button>
                            <button type="button" class="btn btn-secondary">Perlu pendampingan dalam</button>
                        </div>
                        <textarea name="catatan_min_tp" id="textbox_terendah" rows="5" class="form-control"></textarea>
                    </div>
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

    <form id="form_filter">
        @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-2">
                <div class="form-group">
                    <label>Tahun Ajaran</label>
                    <select id="filter_tahun_ajaran" required class="form-control" name="tahun_ajaran">
                        @foreach ($tahun_ajaran as $item)
                            <option {{ isset($filter['tahun_ajaran']) && $filter['tahun_ajaran'] == $item ? 'selected' : ''}}>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Semester</label>
                    <select id="filter_semester" required class="form-control" name="semester">
                        @foreach ($semester as $item)
                            <option {{ isset($filter['semester']) && $filter['semester'] == $item ? 'selected' : ''}} value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Mata Pelajaran</label>
                    <select id="filter_mapel" required class="form-control" name="mapel_id">
                        @foreach ($mapel as $item)
                            <option {{ isset($filter['mapel_id']) && $filter['mapel_id'] == $item->nama ? 'selected' : ''}} value="{{$item->nama}}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Kelas</label>
                    <select id="filter_nama_kelas" required class="form-control" name="nama_kelas">
                        @foreach ($nama_kelas as $item)
                            <option {{ isset($filter['nama_kelas']) && $filter['nama_kelas'] == $item ? 'selected' : ''}} value="{{ $item }}">{{ $item }}</option>
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

    @if(Request::has('mapel_id'))
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="product_table" class="table table-bordered table-striped ajax_view hide-footer">
                    <thead>
                        <tr>
                            <td>NIS</td> 
                            <td>Nama Siswa</td> 
                            @foreach ($tp as $i => $item)
                                <td>
                                    TP {{$i+1}}
                                    <i 
                                        data-toggle="tooltip" 
                                        data-placement="top" 
                                        title="{{$item}}"
                                        class="fa fa-info-circle"
                                    ></i>
                                </td> 
                            @endforeach
                            <td>Nilai Akhir</td> 
                            <td width="200" >Catatan Penilaian</td> 
                            <td>Tindakan</td> 
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif


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

    const editNilaiFormatif = (id) => {
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
                form.find('input[name=nilai_akhir_tp]').val(res?.nilai_akhir_tp ?? "0");

                let nilai_tp = [];
                try{
                    nilai_tp = JSON.parse(res.nilai_tp)
                } catch(e){
                    nilai_tp = [];
                }
                for(const k in nilai_tp){
                    form.find(`.tp_${k}`).val(nilai_tp[k]);
                }
                
                form.modal("show")
            }
        })
    }

    $("#form_nilai_formatif").on('submit', (function(e) {
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
                    product_table.ajax.reload();
                } else {
                    toastr.error(result.message);
                }
                $("#form_nilai_formatif button[type=submit]").removeAttr('disabled')
                $("#form_nilai_formatif").trigger("reset"); // to reset form input fields
                $("#editor_modal").modal("hide");
            },
            error: function(e) {
                console.log(e);
            }
            });
    }));

    const editCatatanPenilaian = (id) => {
        const form = $("#editor_modal_catatan_penilaian");
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

                const kolom_max_tp = res.kolom_max_tp ? parseInt(res.kolom_max_tp)+1 : ""
                form.find('input[name=kolom_max_tp]').val("TP "+kolom_max_tp);
                form.find('input[name=nilai_max_tp]').val(res.nilai_max_tp ?? "");
                form.find("#textbox_tertinggi").text(res.catatan_max_tp ?? "")
                
                const kolom_min_tp = res.kolom_min_tp ? parseInt(res.kolom_min_tp)+1 : ""
                form.find('input[name=kolom_min_tp]').val("TP "+kolom_min_tp);
                form.find('input[name=nilai_min_tp]').val(res.nilai_min_tp ?? "");
                form.find("#textbox_terendah").text(res.catatan_min_tp ?? "")

                // if(kolom_max_tp == ){

                // }
                
                
                form.modal("show")
            }
        })
    }

    $("#form_catan_penilaian").on('submit', (function(e) {
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
                    product_table.ajax.reload();
                } else {
                    toastr.error(result.message);
                }
                $("#form_catan_penilaian button[type=submit]").removeAttr('disabled')
                $("#form_catan_penilaian").trigger("reset"); // to reset form input fields
                $("#editor_modal_catatan_penilaian").modal("hide");
            },
            error: function(e) {
                console.log(e);
            }
            });
    }));
    @if(Request::has('mapel_id'))
        $(document).ready( function(){
            product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                // ordering:false,
                "paging": false,      // Disable pagination
                "pageLength": -1,     // Show all rows
                "lengthChange": false, // Disable the page length dropdown
                "ajax": {
                    "url": "{{ route('sekolah_sd.rekap_nilai.data') }}",
                    "data": function(d){
                        d.tahun_ajaran = $('#filter_tahun_ajaran').val();
                        d.semester = $('#filter_semester').val();
                        d.nama_kelas = $('#filter_nama_kelas').val();
                        d.mapel_id = $('#filter_mapel').val();
                        d = __datatable_ajax_callback(d);
                    }
                },
                columns: [
                    { searchable: false, data: 'nis', orderable:true  },
                    { searchable: true, data: 'siswa.nama', orderable:false  },
                    @foreach ($tp as $i => $item)
                        { 
                            searchable: false, 
                            orderable:false,
                            data: 'id',
                            className:"text-center",
                            render:(data,type,row)=> {
                                let val = 0;
                                if(row.nilai_tp){
                                    val = row.nilai_tp[{{$i}}] ?? 0;
                                }
                                return val;
                            }
                        },
                    @endforeach
                    { 
                        searchable: false, 
                        orderable:false,
                        data: 'nilai_akhir_tp',
                        className:"text-center",
                    },
                    { 
                        searchable: false, 
                        orderable:false,
                        data: 'catatan_max_tp',
                        render:(data,type,row)=> {
                            return `<b>TP Maks</b> : <br /> ${data ?? '-'}<br /><b>TP Min</b> : <br />${row.catatan_min_tp ?? '-'}`
                        }
                    },
                    { 
                        searchable: false,
                        orderable:false,
                        data: 'id',
                        className:"text-center",
                        render:(data)=> {
                            const template = `
                                <a 
                                    class="btn btn-primary btn-xs" 
                                    href="#"
                                    onclick='editNilaiFormatif("${data}")'
                                >
                                    Edit
                                </a>
                                <a 
                                    class="btn btn-primary btn-xs" 
                                    href="#"
                                    onclick='editCatatanPenilaian("${data}")'
                                >
                                    Catatan Penilaian
                                </a>
                            `
                            return template;
                        }
                    },
                ]
            })
        })
    @endif

    const reloadTable = () => {
        product_table.ajax.reload();
    }

    // $('#filter_tahun_ajaran').change(reloadTable)
    // $('#filter_semester').change(reloadTable)
    // $('#filter_nama_kelas').change(reloadTable)

    // $("#filter_mapel").change(function(){
    //     $("#form_filter").submit();
    // });

    $(document).on('keyup','.tp_field_satuan',function(){
        if(parseInt($(this).val()) > 100) $(this).val(100)
        let total = 0;
        $('.tp_field_satuan').each(function() {
            total += parseInt($(this).val());
        })
        const count = $('.tp_field_satuan').length;
        let nilai_rapor = 0;
        if(count > 0)
        nilai_rapor = total / count;
        $("#nilai_akhir_tp").val(nilai_rapor.toFixed(0));
    })

</script>
@endsection