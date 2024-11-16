@extends('layouts.app')
@section('title', "Mata Pelajaran")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Mata Pelajaran</h1>
</section>

<!-- Main content -->

<section class="content">

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
                        <select class="form-control">
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                   </div>
                   <div class="form-group">
                        <label>File</label>
                        <input required class="form-control" type="file" name="import_file" />
                        <p>Format file import data mapel : <a href="#">Download</a></p>
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
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Semua Data</a>
                    </li>
                    @if(!auth()->user()->checkGuru())
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
                                    @for ($i = 1; $i <= 6; $i++)
                                        <option value="{{$i}}">Kelas {{$i}}</option>
                                    @endfor
                                </select>
                           </div>
                        </div>
                        <div class="text-right" style="margin-bottom:20px;">
                            <button onclick="$('#import_modal').modal('show')" class="btn btn-primary">Import</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mapel</th>
                                        <th>Kelas</th>
                                        <th>Kategori</th>
                                        @if(!Auth::user()->checkGuru())
                                        <th>Tindakan</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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
    <script type="text/javascript">

        $(document).ready( function(){
            product_table = $('#product_table').DataTable({
                columnDefs: [
                    {
                        "targets": [0],
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "targets": [3],
                        "orderable": false,
                        "searchable": false
                    },
                ],
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
                    { data: 'id'  },
                    { data: 'nama'  },
                    { data: 'kelas'  },
                    { data: 'kategori'  },
                    @if(!Auth::user()->checkGuru())
                    { 
                        data: 'id',
                        className:"text-center",
                        render:(data)=> {
                            const template = `
                                <a 
                                    class="btn btn-primary btn-xs" 
                                    href="{{ route('sekolah_sd.mapel.index') }}/${data}/edit"
                                    target="_blank"
                                >
                                    Edit
                                </a>
                                <a 
                                    class="btn btn-danger btn-xs delete-product" 
                                    href="{{ route('sekolah_sd.mapel.index') }}/${data}"
                                    target="_blank"
                                >
                                    Hapus
                                </a>
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

        });

        $("#filter_kelas").change(function(){
            product_table.ajax.reload();
        })

    </script>
@endsection