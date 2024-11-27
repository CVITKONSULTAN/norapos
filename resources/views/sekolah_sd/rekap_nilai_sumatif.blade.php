{{-- @php
    $lm = $mapel_choices->lingkup_materi ?? [];
@endphp --}}

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
<form id="form_nilai_sumatif" method="POST" action="{{route('sekolah_sd.rekap_nilai.store')}}">
    @csrf
    <input value="" type="hidden" name="id" />
    <input value="update_nilai_tp" type="hidden" name="tipe" />
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
                            <label>S{{$i+1}}
                                <i 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="{{$item}}"
                                    class="fa fa-info-circle"
                                ></i>
                            </label>
                            <input name="nilai_sumatif[]" required type="number" 
                            class="form-control lm_{{$i}} tp_field_satuan" />
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Sumatif Akhir (Non Tes)</label>
                        <input id="field_sumatif_akhir_non_tes" name="sumatif_non_tes" required type="number" class="form-control" />
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Sumatif Akhir (Tes)</label>
                        <input id="field_sumatif_akhir_tes" name="sumatif_tes" required type="number" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Nilai Akhir Formatif</label>
                    <input id="field_formatif" readonly name="nilai_akhir_formatif" type="number" required class="form-control" />
                </div>
                <div class="form-group">
                    <label>Nilai Akhir Sumatif</label>
                    <input id="nilai_sumatif" readonly name="nilai_akhir_sumatif" type="number" required class="form-control" />
                </div>
                <div class="form-group">
                    <label>Nilai Rapor</label>
                    <input id="nilai_rapor" readonly name="nilai_rapor" type="number" class="form-control" />
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
                            <th rowspan="2">NIS</th>
                            <th rowspan="2">Nama Siswa</th>
                            @if(count($lm) > 0)
                                <th colspan="{{count($lm)}}">Sumatif Lingkup Materi (25%)</th>
                            @endif
                            <th colspan="2">Sumatif Akhir (50%)</th>
                            <th rowspan="2">Nilai Akhir Formatif (25%)</th>
                            <th rowspan="2">Nilai Rapor</th>
                            <th rowspan="2">Tindakan</th>
                        </tr>
                        <tr>
                            @foreach ($lm as $i => $item)
                                <th>
                                    S{{$i+1}} 
                                    <i 
                                        data-toggle="tooltip" 
                                        data-placement="top" 
                                        title="{{$item}}"
                                        class="fa fa-info-circle"
                                    ></i>
                                </th>
                            @endforeach
                            <th>Non Tes</th>
                            <th>Tes</th>
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
        const sumatifAkhir = (type) => {
            if(type == 'tes') $('#field_sumatif_akhir_non_tes').val("0")
            if(type == 'nontes') $('#field_sumatif_akhir_tes').val("0")
        }

        $('#field_sumatif_akhir_tes').change(function(){
            const val = $(this).val();
            if(parseInt(val) > 100) $(this).val(100)
            sumatifAkhir('tes')
            calculateRaport()
        })
        $('#field_sumatif_akhir_tes').keyup(function(){
            const val = $(this).val();
            if(parseInt(val) > 100) $(this).val(100)
            sumatifAkhir('tes')
            calculateRaport()
        })

        $('#field_sumatif_akhir_non_tes').change(function(){
            const val = $(this).val();
            if(parseInt(val) > 100) $(this).val(100)
            sumatifAkhir('nontes')
            calculateRaport()
        })
        $('#field_sumatif_akhir_non_tes').keyup(function(){
            const val = $(this).val();
            if(parseInt(val) > 100) $(this).val(100)
            sumatifAkhir('nontes')
            calculateRaport()
        })
        
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

                    form.find('input[name=nilai_akhir_formatif]').val(res?.nilai_akhir_tp ?? "0");

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
                    product_table.ajax.reload();
                } else {
                    toastr.error(result.message);
                }
                $("#form_nilai_sumatif button[type=submit]").removeAttr('disabled')
                $("#form_nilai_sumatif").trigger("reset"); // to reset form input fields
                // window.location.reload();
                $("#editor_modal").modal("hide");
            },
            error: function(e) {
                console.log(e);
            }
            });
        }));

        const reloadTable = () => {
            product_table.ajax.reload();
        }

        // $('#filter_tahun_ajaran').change(reloadTable)
        // $('#filter_semester').change(reloadTable)
        // $('#filter_nama_kelas').change(reloadTable)

        // $("#filter_mapel").change(function(){
        //     $("#form_filter").submit();
        // });
        @if(Request::has('mapel_id'))
        $(document).ready( function(){
            product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
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
                    { 
                        searchable: true, 
                        orderable: true, 
                        data: 'nis',
                    },
                    { 
                        searchable: true, 
                        orderable: true, 
                        data: 'nama',
                        render: function(data, type, row) {
                            return data ? data : '';
                        }
                    },
                    @foreach ($lm as $i => $item)
                        { 
                            searchable: false, 
                            orderable: false, 
                            data: 'id',
                            className:"text-center",
                            render:(data,type,row)=> {
                                let val = 0;
                                if(row.nilai_sumatif){
                                    val = row.nilai_sumatif[{{$i}}] ?? 0;
                                }
                                return val;
                            }
                        },
                    @endforeach
                    { 
                        searchable: false, 
                        orderable: false, 
                        data: 'sumatif_non_tes',
                        className:"text-center",
                    },
                    { 
                        searchable: false,
                        orderable: false,  
                        data: 'sumatif_tes',
                        className:"text-center"
                    },
                    { 
                        searchable: false,
                        orderable: false,  
                        data: 'nilai_akhir_tp',
                        className:"text-center"
                    },
                    { 
                        searchable: false,
                        orderable: false,  
                        data: 'nilai_rapor',
                        className:"text-center"
                    },
                    { 
                        searchable: false,
                        orderable: false, 
                        data: 'id',
                        className:"text-center",
                        render:(data)=> {
                            const template = `
                                <a 
                                    class="btn btn-primary btn-xs" 
                                    href="#"
                                    onclick='editNilaiSumatif("${data}")'
                                >
                                    Edit
                                </a>
                            `
                            return template;
                        }
                    }
                ]
            })
        })
        @endif

    function calculateRaport() {
        let total = 0;
        $('.tp_field_satuan').each(function() {
            total += parseInt($(this).val());
        })
        let count = $('.tp_field_satuan').length;
        let nilai_SLM = 0;
        if(count > 0){
            nilai_SLM = total / count;
        }

        let nilai_SLA = 0;
        const nontes = $("#field_sumatif_akhir_non_tes").val();
        const tes = $("#field_sumatif_akhir_tes").val();
        if(parseInt(nontes) >= 0){
            nilai_SLA += parseInt(nontes)
        }
        if(parseInt(tes) >= 0){
            nilai_SLA += parseInt(tes)
        }

        const formatif = parseInt($("#field_formatif").val());

        let nilai_rapor = 0;
        // console.log("SLM",(nilai_SLM * 0.25))
        // console.log("SLA",(nilai_SLA * 0.5))
        // console.log("FORMATIF",(formatif * 0.25))
        const total_sumatif = (nilai_SLM * 0.25) + (nilai_SLA * 0.5);
        nilai_rapor = total_sumatif + (formatif * 0.25);
        $("#nilai_sumatif").val(total_sumatif);
        $("#nilai_rapor").val(nilai_rapor.toFixed(0));
    }

    $(document).on('keyup','.tp_field_satuan',function(){
        const val = $(this).val();
        if(parseInt(val) > 100) $(this).val(100)
        calculateRaport()
    })
    </script>
@endsection