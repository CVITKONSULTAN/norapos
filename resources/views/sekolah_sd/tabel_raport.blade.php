@extends('layouts.app')
@section('title', "Tabel Raport Siswa")

@section('css')
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
/>
@endsection

@section('content')



    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Tabel Raport Siswa</h1>
    </section>

    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-md-12">
            <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Semua Data</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="product_list_tab">
                            <div class="filter">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select name="kelas_id" class="kelas_selection_filter"></select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                    <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>NISN</td>
                                            <td>NAMA LENGKAP</td>
                                            <td>KELAS</td>
                                            <td>TAHUN AJARAN</td>
                                            <td>SEMESTER</td>
                                            <td>Tindakan</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
            product_table.ajax.reload();
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
            product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{route('sekolah_sd.kelas.data')}}",
                    "data": function ( d ) {
                        
                        const kelas = $(".kelas_selection_filter").val();
                        if(kelas){
                            d.kelas_id = kelas;
                        }

                        d = __datatable_ajax_callback(d);
                    }
                },
                columns: [
                    { data: 'id'  },
                    { data: 'siswa.nisn'  },
                    { data: 'siswa.nama'  },
                    { data: 'kelas.nama_kelas'  },
                    { data: 'kelas.tahun_ajaran'  },
                    { data: 'kelas.semester'  },
                    { 
                        data: 'id',
                        render:(data)=>{
                            // return`<a href="/sekolah_sd/raport-akhir/${data}/print" type="button" class="btn btn-success">Cetak</a>`
                            return`<a target="_blank" href="/sekolah_sd/raport-akhir?kelas_id=${data}" type="button" class="btn btn-success">Lihat</a>`
                        }
                    }

                ]
            });

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
    </script>
@endsection