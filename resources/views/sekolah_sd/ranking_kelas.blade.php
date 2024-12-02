@extends('layouts.app')
@section('title', "Ranking Kelas")

@section('css')
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    />
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
    <h1>Ranking Kelas</h1>
</section>

<!-- Main content -->

<section class="content">

    <form id="form_filter">
        @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-12">
                <div class="filter">
                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="kelas_id" class="kelas_selection_filter"></select>
                    </div>
                </div>
            </div>
        @endcomponent
    </form>

    @if(Request::has('kelas_id'))
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">{{ "Kelas $kelas->nama_kelas (Semester $kelas->semester - $kelas->tahun_ajaran)" }}</h2>
            <div class="table-responsive">
                <table id="product_table" class="table table-bordered table-striped ajax_view hide-footer">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            @foreach ($mapel as $i => $item)
                                <th>{{ $item->nama }}</th>
                            @endforeach
                            {{-- <th>Nilai Total</th> --}}
                            <th>Rata-Rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nilai_siswa as $item)
                            @php
                                $avg = $item->avg('nilai_rapor');
                                $total = $item->sum('nilai_rapor');
                                $item = $item->sortBy('orders');
                                // dd($item);
                            @endphp
                            <tr>
                                <td>{{$item[0]->siswa->detail['nis'] ?? ''}}</td>
                                <td>{{$item[0]->siswa->nama ?? ''}}</td>
                                @foreach ($item as $val)
                                    <td class="text-center">{{ $val->nilai_rapor }}</td>
                                @endforeach
                                {{-- <td>{{ $total }}</td> --}}
                                <td class="text-center">{{ $avg }}</td>
                            </tr>
                        @endforeach
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
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    ></script>
    <script type="text/javascript">

        @if(count($kelas_perwalian) > 0)
            const list_kelas_id = "{!! json_encode($kelas_perwalian) !!}";
        @endif
        
        let selectizeInstanceKelasFilter;

        const onChangeData = (value) => {
            console.log("val",value)
            $("#form_filter").submit();
        }

        $(function () {

            selectizeInstanceKelasFilter = $(".kelas_selection_filter").selectize({
                placeholder: 'Cari disini...',
                maxItems: 1,
                create: false,
                valueField: 'id',         // Field to use as the value
                labelField: 'name',       // Field to use as the label
                searchField: 'name',      // Field to use for searching
                onChange: onChangeData,
                load: function(query, callback) {
                    if (!query.length) return callback();
                    let url = '/sekolah_sd/kelas-data?draw=4&columns%5B0%5D%5Bdata%5D=id&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=tahun_ajaran&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=semester&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=nama_kelas&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=id&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&start=0&length=25&search%5Bvalue%5D=';
                    @if(count($kelas_perwalian) > 0)
                        url = `/sekolah_sd/kelas-data?filter_list_id=${list_kelas_id}&draw=4&columns%5B0%5D%5Bdata%5D=id&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=tahun_ajaran&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=semester&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=nama_kelas&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=id&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&start=0&length=25&search%5Bvalue%5D=`;
                    @endif
                    $.ajax({
                        url: url+query,
                        type: 'GET',
                        dataType: 'json',
                        error: function(error) {
                            console.log(error)
                            callback();
                        },
                        success: function(res) {
                            // console.log("Options Loaded:", res);
                            const results = res.data.map(item => ({
                                id: item.id,
                                name: `${item.nama_kelas} (Semester ${item.semester} - ${item.tahun_ajaran})`
                            }));
                            callback(results);
                        }
                    });
                }
            })[0].selectize;


        });

        $(document).ready( function(){
            @if(!empty($selected))
                selectizeInstanceKelasFilter.addOption({
                        id: {{$selected->id}},
                        name: `{{$selected->nama_kelas}} (Semester {{$selected->semester}} - {{$selected->tahun_ajaran}})`
                    });
                selectizeInstanceKelasFilter.setValue({{$selected->id}});
            @endif
        });

        @if(Request::has('kelas_id'))
            $(document).ready( function(){
                product_table = $('#product_table').DataTable({
                    pageLength:-1
                });
            });
        @endif


    </script>

@endsection