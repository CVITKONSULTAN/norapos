@extends('layouts.app')
@section('title', "Rekap Sumatif Walikelas")

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
    <h1>Rekap Sumatif Walikelas</h1>
</section>

<!-- Main content -->

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


    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="product_table" class="table table-bordered table-striped ajax_view hide-footer">
                    <thead>
                        <tr>
                            <th rowspan="2">Nama Siswa</th>
                            @if(count($lm) > 0)
                                <th colspan="{{count($lm)}}">Sumatif Lingkup Materi (25%)</th>
                            @endif
                            <th colspan="2">Sumatif Akhir (50%)</th>
                            <th rowspan="2">Nilai Akhir Formatif (25%)</th>
                            <th rowspan="2">Nilai Rapor</th>
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


</section>
<!-- /.content -->

@endsection

@section('javascript')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


    $(document).ready( function(){
            product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                ordering:false,
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
                        data: 'siswa.nama',
                        render: function(data, type, row) {
                            return data ? data : '';
                        }
                    },
                    @foreach ($lm as $i => $item)
                        { 
                            searchable: false, 
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
                        data: 'sumatif_non_tes',
                        className:"text-center",
                    },
                    { 
                        searchable: false, 
                        data: 'sumatif_tes',
                        className:"text-center"
                    },
                    { 
                        searchable: false, 
                        data: 'nilai_akhir_tp',
                        className:"text-center"
                    },
                    { 
                        searchable: false, 
                        data: 'nilai_rapor',
                        className:"text-center"
                    }
                ]
            })
        })

</script>
@endsection