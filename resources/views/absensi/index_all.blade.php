@extends('layouts.app')
@section('title', 'Absensi')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Absensi
        <small>Data Absensi Pertanggal</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => "Semua absensi"])
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Filter Tanggal</label>
                    <input id="filter_tanggal" class="form-control" type="date" name="filter_tanggal" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" />
                </div>
            </div>
        {{-- @can('absensi.create') --}}
            {{-- @slot('tool')
                <div class="box-tools">
                    <a type="button" class="btn btn-block btn-primary" 
                        href="{{ route('absensi.create') }}">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</a>
                </div>
            @endslot --}}
        {{-- @endcan --}}
        {{-- @can('absensi.view') --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="data_table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                        </tr>
                    </thead>
                </table>
            </div>
        {{-- @endcan --}}
    @endcomponent

    <div class="modal fade unit_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script>

        const data_table = $('#data_table').DataTable({
            processing: true,
            serverSide: true,
            ordering:false,
            searching:false,

            ajax: {
                url:'{{ route("absensi.data") }}',
                "data": function ( d ) {
                    d.grouping = 1;
                    d.filter_tanggal = $("#filter_tanggal").val();
                    d = __datatable_ajax_callback(d);
                }
            },
            "columns":[
                {"data":"tanggal"},
                {"data":"nama"},
                {
                    "data":"foto_masuk",
                    "render":(data,type,row,meta) => {
                        const koor = row.koordinat_masuk;
                        let coor = '';
                        let akurasi = '';
                        const foto = data ? `<a target="_blank" href="${data}"><img class="img img-responsive absensi_picture" src="${data}" /></a>` : '';
                        if(koor){
                            coor = '<a target="_blank" href="https://maps.google.com/?q='+koor.latitude+','+koor.longitude+'">'+koor.latitude+','+koor.longitude+'</a>';
                            akurasi = parseFloat(koor.accuracy).toFixed(2);
                        }
                        return `
                        Jam : ${row.jam_masuk}<br/>
                        Koordinat : ${coor}<br/>
                        Akurasi : ${akurasi}<br/>
                        ${foto}`;
                    }
                },
                {
                    "data":"foto_pulang",
                    "render":(data,type,row,meta) => {
                        const koor = row.koordinat_pulang;
                        let coor = '';
                        let akurasi = '';
                        const foto = data ? `<a target="_blank" href="${data}"><img class="img img-responsive absensi_picture" src="${data}" /></a>` : '';
                        if(koor){
                            coor = '<a target="_blank" href="https://maps.google.com/?q='+koor.latitude+','+koor.longitude+'">'+koor.latitude+','+koor.longitude+'</a>';
                            akurasi = parseFloat(koor.accuracy).toFixed(2);
                        }
                        return `
                        Jam : ${row.jam_pulang}<br/>
                        Koordinat : ${coor}<br/>
                        Akurasi : ${akurasi}<br/>
                        ${foto}`;
                    }
                }
            ]
        });

        $("#filter_tanggal").change(function(){
            data_table.ajax.reload();
        })

        @can('absensi.delete')
            $(document).on('click', 'button.delete_user_button', function(){
                swal({
                title: LANG.sure,
                text: LANG.confirm_delete_user,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        const href = "{{ route('absensi.store') }}";
                        const id = $(this).data('id');
                        $.ajax({
                            method: "POST",
                            url: href,
                            dataType: "json",
                            data: {delete:1,id:id},
                            success: function(result){
                                if(result.status){
                                    toastr.success(result.message);
                                    data_table.ajax.reload();
                                } else {
                                    toastr.error(result.message);
                                }
                            }
                        });
                    }
                });
            });
        @endcan
    </script>
@endsection
