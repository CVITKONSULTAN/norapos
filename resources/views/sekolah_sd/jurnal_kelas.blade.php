@extends('layouts.app')
@section('title', "Jurnal Kelas Siswa")

@section('css')
    <style>
        input[type="radio"]{
            height:30px; 
            width:30px; 
            vertical-align: middle;
        }
        /* .text-center{
            text-align: center;
            vertical-align: middle;
        } */
    </style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Jurnal Kelas Siswa</h1>
</section>

<!-- Main content -->

<section class="content">

    <div id="import_modal" class="modal fade">
        <div class="modal-dialog">
            <form enctype="multipart/form-data" method="POST" action="{{route('sekolah_sd.siswa.import')}}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">
                        Import Siswa
                    </h4>
                </div>
                <div class="modal-body">
                   <div class="form-group">
                        <label>File</label>
                        <input required class="form-control" type="file" name="import_file" />
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                  </div>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Semua Data</a>
                    </li>
                    {{-- <li>
                        <a target="_blank" href="{{ route('sekolah_sd.siswa.create') }}">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data
                        </a>
                    </li> --}}
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Mata Pelajaran</label>
                                <select class="form-control" name="mapel_id" required>
                                    @foreach ($mapel as $item)
                                        <option value="{{$item->id}}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Kelas</label>
                                <select class="form-control" name="kelas_id" required>
                                    @foreach ($kelas as $item)
                                        <option value="{{$item->id}}">{{ $item->nama_kelas }} (Semester {{$item->semester}} - {{$item->tahun_ajaran}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tanggal</label>
                                <input class="form-control" type="date" required name="tanggal" value="{{$tgl}}" />
                            </div>
                        </div>
                        {{-- <div class="text-right" style="margin-bottom:20px;">
                            <button onclick="simpanData()" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Lengkap</th>
                                        <th>Hadir</th>
                                        <th>Izin</th>
                                        <th>Sakit</th>
                                        <th>Tanpa<br />Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <button onclick="simpanData()" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
<!-- /.content -->

@endsection

@section('javascript')
<script type="text/javascript">

    $(document).ready( function(){
        product_table = $('#product_table').DataTable({
            pageLength: -1,
            "paging": false,
            buttons: [],
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "{{ route('sekolah_sd.siswa.data') }}",
            },
            columns: [
                { searchable: false, data: 'id'  },
                { data: 'nama'  },
                { 
                    searchable: false, 
                    data: 'id',
                    className:"text-center",
                    render:(data)=> {
                        return `<input type="radio" name="masuk[${data}]" value="hadir" checked />`
                    }
                },
                { 
                    searchable: false, 
                    data: 'id',
                    className:"text-center",
                    render:(data)=> {
                        return `<input type="radio" name="masuk[${data}]" value="izin" />`
                    }
                },
                { 
                    searchable: false, 
                    data: 'id',
                    className:"text-center",
                    render:(data)=> {
                        return `<input type="radio" name="masuk[${data}]" value="sakit" />`
                    }
                },
                { 
                    searchable: false, 
                    data: 'id',
                    className:"text-center",
                    render:(data)=> {
                        return `<input type="radio" name="masuk[${data}]" value="tanpa keterangan" />`
                    }
                },
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

        $(document).on('click', '#delete-selected', function(e){
            e.preventDefault();
            var selected_rows = getSelectedRows();
            
            if(selected_rows.length > 0){
                $('input#selected_rows').val(selected_rows);
                swal({
                    title: LANG.sure,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $('form#mass_delete_form').submit();
                    }
                });
            } else{
                $('input#selected_rows').val('');
                swal('@lang("lang_v1.no_row_selected")');
            }    
        });


    });

    function getSelectedRows() {
        var selected_rows = [];
        var i = 0;
        $('.row-select:checked').each(function () {
            selected_rows[i++] = $(this).val();
        });

        return selected_rows; 
    }

    const simpanData = () => {
        let json = {};
        let list_hadir = {};
        $('input[type="radio"]:checked').each(function() {
            const radioName = $(this).attr('name');
            const radioValue = $(this).val();
            // console.log('Name: ' + radioName + ', Value: ' + radioValue);
            list_hadir[radioName] = radioValue;
        });
        json.kelas_id = $('select[name=kelas_id]').val();
        json.mapel_id = $('select[name=mapel_id]').val();
        json.tanggal = $('input[name=tanggal]').val();
        json.jurnal = list_hadir;
        console.log("json",json)
    }

</script>
@endsection