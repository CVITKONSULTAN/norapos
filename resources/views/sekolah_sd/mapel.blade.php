@extends('layouts.app')
@section('title', "Mata Pelajaran")

@section('css')
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    />
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Mata Pelajaran</h1>
</section>

<!-- Main content -->

<section class="content">

    <div id="apply_modal" class="modal fade">
        <div class="modal-dialog">
            <form class="modal-content" id="apply_kelas" method="POST" action="{{route('sekolah_sd.mapel.apply')}}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">
                        Apply Mapel ke Kelas
                    </h4>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-4">
                        <label>Kelas</label>
                        <select name="kelas" class="form-control">
                            @foreach ($kelas as $item)    
                                <option value="{{$item}}">Kelas {{$item}}</option>
                            @endforeach
                        </select>
                   </div>
                    <div class="form-group col-md-4">
                        <label>Tahun Ajaran</label>
                        <select name="tahun_ajaran" class="form-control">
                            @foreach ($tahun_ajaran as $item)
                                <option>{{ $item }}</option>
                            @endforeach
                        </select>
                   </div>
                    <div class="form-group col-md-4">
                        <label>Semester</label>
                        <select name="semester" class="form-control">
                            @foreach ($semester as $item)
                                <option>{{ $item }}</option>
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

    <div id="apply_modal_perkelas" class="modal fade">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('sekolah_sd.mapel.apply.perkelas') }}">
                <input type="hidden" name="mapel_id" value="" id="mapel_id" />
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">
                        Apply Mapel Perkelas
                    </h4>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-sm-12">
                        <label>Kelas</label>
                        <select name="kelas_id" class="kelas_selection_filter"></select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Mapel</label>
                        <input id="mapel_field" class="form-control" readonly value="" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                  </div>
            </form>
        </div>
    </div>

    <div id="import_modal" class="modal fade">
        <div class="modal-dialog">
            <form enctype="multipart/form-data" method="POST" action="{{route('sekolah_sd.mapel.import')}}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">
                        Import Mapel
                    </h4>
                </div>
                <div class="modal-body">
                   <div class="form-group">
                        <label>Kelas</label>
                        <select name="kelas" class="form-control">
                            @foreach ($kelas as $item)    
                                <option value="{{$item}}">Kelas {{$item}}</option>
                            @endforeach
                        </select>
                   </div>
                   <div class="form-group">
                        <label>File</label>
                        <input required class="form-control" type="file" name="import_file" />
                        <p>Format file import data mapel : <a href="/files/format_import_mapel.xlsx">Download</a></p>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                  </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true">
                            @if(auth()->user()->checkAdmin())
                            <i class="fa fa-cubes" aria-hidden="true"></i>Semua Data
                            @else
                            <i class="fa fa-cubes" aria-hidden="true"></i>Mapel Saya
                            @endif
                        </a>
                    </li>
                    @if(
                        auth()->user()->checkGuruWalikelas() ||
                        auth()->user()->checkAdmin()
                    )
                        <li>
                            <a href="#mapel_wali" data-toggle="tab" aria-expanded="true">
                                <i class="fa fa-cubes" aria-hidden="true"></i>Mapel Walikelas
                            </a>
                        </li>
                    @endif
                    @if(
                        auth()->user()->checkAdmin()
                    )
                    <li>
                        <a 
                            target="_blank" 
                            href="{{ route('sekolah_sd.mapel.create') }}"
                        >
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data
                        </a>
                    </li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Filter Kelas</label>
                                <select id="filter_kelas" class="form-control">
                                    @foreach ($kelas as $item)    
                                        <option value="{{$item}}">Kelas {{$item}}</option>
                                    @endforeach
                                </select>
                           </div>
                        </div>
                        <div class="text-right" style="margin-bottom:20px;">
                            @if(
                                auth()->user()->checkAdmin()
                            )
                                <button onclick="$('#import_modal').modal('show')" class="btn btn-primary">Import</button>
                                <button onclick="applykelas(this)" class="btn btn-success">Apply ke Kelas</button>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>Urutan</th>
                                        <th>ID</th>
                                        <th>Mapel</th>
                                        <th>Kelas</th>
                                        <th>Kategori</th>
                                        @if(
                                            auth()->user()->checkAdmin() ||
                                            auth()->user()->checkGuruMapel() ||
                                            auth()->user()->checkGuruWalikelas()
                                        )
                                        <th>Tindakan</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(
                        auth()->user()->checkGuruWalikelas() || 
                        auth()->user()->checkAdmin()
                    )
                        <div class="tab-pane" id="mapel_wali">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Filter Kelas</label>
                                    <select id="filter_kelas_wali" class="form-control">
                                        @foreach ($kelas_wali as $item)    
                                            <option value="{{$item->id}}">{{$item->nama_kelas}} (Semester {{$item->semester}} - {{$item->tahun_ajaran}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <table width="100%" class="table table-bordered table-striped ajax_view hide-footer" id="mapel_wali_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mapel</th>
                                        <th>Kategori</th>
                                        <th>Kelas</th>
                                        <th>TP</th>
                                        <th>LM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    @endif
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

        $(document).ready( function(){
            product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('sekolah_sd.mapel.data') }}",
                    "data":function(d){
                        const kelas = $("#filter_kelas").val();
                        d.kelas = kelas;
                        @if(!empty($mapel_id_list))
                            d.mapel_list = [
                                @foreach($mapel_id_list as $key => $item)
                                    {{$item}},
                                @endforeach
                            ];
                        @endif
                        d = __datatable_ajax_callback(d);
                    }
                },
                columns: [
                    { data: 'orders'  },
                    { data: 'id'  },
                    { data: 'nama'  },
                    { data: 'kelas'  },
                    { data: 'kategori'  },
                    @if(
                        auth()->user()->checkAdmin() ||
                        auth()->user()->checkGuruMapel() ||
                        auth()->user()->checkGuruWalikelas()
                    )
                    { 
                        data: 'id',
                        className:"text-center",
                        render:(data,type,row)=> {
                            const template = `
                                <button onclick="applyPerkelas(this,${data},'${row.nama}')" class="btn btn-primary btn-xs">
                                    Apply Perkelas
                                </button>
                                <a 
                                    class="btn btn-primary btn-xs" 
                                    href="{{ route('sekolah_sd.mapel.index') }}/${data}/edit"
                                    target="_blank"
                                >
                                    Edit
                                </a>
                                @if(auth()->user()->checkAdmin())
                                <a 
                                    class="btn btn-danger btn-xs delete-product" 
                                    href="{{ route('sekolah_sd.mapel.index') }}/${data}"
                                    target="_blank"
                                >
                                    Hapus
                                </a>
                                @endif
                            `
                            return template;
                        }
                    },
                    @endif
                ]
            });

            $('table#product_table tbody').on('click', 'a.delete-product', function(e){
                e.preventDefault();
                swal({
                  title: LANG.sure,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: "DELETE",
                            url: href,
                            dataType: "json",
                            success: function(result){
                                if(result.success == true){
                                    toastr.success(result.msg);
                                    product_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });

            @if(Request::get('kelas'))
                $("#filter_kelas").val({{Request::get('kelas')}});
                $("#filter_kelas").trigger('change')
            @endif

        });

        $("#filter_kelas").change(function(){
            product_table.ajax.reload();
        })
        const applykelas = (elm) => {
            const dom = $(elm)
            const kelas_form = $("#apply_kelas")
            const kelas = $('#filter_kelas').val();
            kelas_form.find('[name=kelas]').val(kelas);
            $("#apply_modal").modal("show")
        } 

        let mapel_wali;
        $(document).ready( function(){
            mapel_wali = $('#mapel_wali_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('sekolah_sd.mapel.data.perkelas') }}",
                    "data":function(d){
                        const kelas = $("#filter_kelas_wali").val();
                        d.kelas_id = kelas;
                        d = __datatable_ajax_callback(d);
                    }
                },
                columns: [
                    { 
                        data: 'id',
                        "orderable": false,
                        "searchable": false,
                    },
                    { data: 'nama_mapel'  },
                    { data: 'kategori_mapel'  },
                    { data: 'nama_kelas'  },
                    { 
                        data: 'tp',
                        "orderable": false,
                        "searchable": false,
                        render:(data)=> {
                            const list = data?.map((item) => {
                                return `<li>${item}</li>`
                            })
                            return `<ul>${list}</ul>`;
                        }
                    },
                    { 
                        data: 'lm',
                        "orderable": false,
                        "searchable": false,
                        render:(data)=> {
                            const list = data?.map((item) => {
                                return `<li>${item}</li>`
                            })
                            return `<ul>${list}</ul>`;
                        }
                    },
                ]
            });
        });

        $("#filter_kelas_wali").change(function(){
            console.log($(this).val());
            mapel_wali.ajax.reload();
        })

        const applyPerkelas = (elm,id,nama) => {
            const modals = $("#apply_modal_perkelas")
            modals.find('#mapel_id').val(id)
            modals.find('#mapel_field').val(nama)
            modals.modal('show');
        }

        let selectizeInstanceKelasFilter;

        $(function () {

            selectizeInstanceKelasFilter = $(".kelas_selection_filter").selectize({
                placeholder: 'Cari disini...',
                maxItems: 1,
                create: false,
                valueField: 'id',         // Field to use as the value
                labelField: 'name',       // Field to use as the label
                searchField: 'name',      // Field to use for searching
                // onChange: onChangeData,
                load: function(query, callback) {
                    if (!query.length) return callback();
                    let url = '/sekolah_sd/kelas-data?draw=4&columns%5B0%5D%5Bdata%5D=id&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=tahun_ajaran&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=semester&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=nama_kelas&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=id&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&start=0&length=25&search%5Bvalue%5D=';
                    @if( isset($kelas_perwalian) && count($kelas_perwalian) > 0)
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

    </script>
@endsection