@extends('layouts.app')
@section('title', 'Absensi')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Absensi
        <small>Data daftar absensi</small>
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
                    <label>Start Tanggal</label>
                    <input class="form-control" type="date" 
                    id="filter_start" 
                    name="filter_start" 
                    value="{{ \Carbon\Carbon::now()->subDay()->format("Y-m-d") }}" />
                </div>
                <div class="form-group col-md-4">
                    <label>End Tanggal</label>
                    <input class="form-control" type="date" 
                    id="filter_end" 
                    name="filter_end" 
                    value="{{ \Carbon\Carbon::now()->addDay()->format("Y-m-d") }}" />
                </div>
            </div>
        {{-- @can('absensi.create') --}}
            @slot('tool')
                <div class="box-tools">
                    <a type="button" class="btn btn-block btn-primary" 
                        href="{{ route('absensi.create') }}">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</a>
                </div>
            @endslot
        {{-- @endcan --}}
        {{-- @can('absensi.view') --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="data_table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Lokasi</th>
                            @can('absensi.delete')
                            <th>@lang( 'messages.action' )</th>
                            @endcan
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
            lengthMenu: [[-1, 10, 25, 50], ["Semua", 10, 25, 50]],
            pageLength: -1,
            ajax: {
                    url:'{{ route("absensi.data") }}',
                    "data": function ( d ) {
                        d.start = $("#filter_start").val();
                        d.end = $("#filter_end").val();
                        d = __datatable_ajax_callback(d);
                    }
            },
            columnDefs: [ {
                "orderable": false,
                "searchable": false
            } ],
            "columns":[
                {
                    "data":"created_at",
                    "render":(data,type,row,meta) => {
                        let string = moment(data).format('dddd')+", "+moment(data).format(moment_date_format)+" "+moment(data).format(moment_time_format)+
                        "<br/>Tipe: <b>"+row.tipe.toUpperCase()+"</b>";
                        if(row.tipe === "pulang"){
                            string += "<br/>Jam Kerja: "+row.total_hours;
                        }
                        return string;
                    }
                },
                {
                    "data":"name"
                },
                {
                    "data":"picture",
                    "render":(data,type,row,meta) => {
                        return `<a target="_blank" href="${data}"><img class="img img-responsive absensi_picture" src="${data}" /></a>`;
                    }
                },
                {
                    "data":"coordinates",
                    "render":(data,type,row,meta) => {
                        let string = '<a target="_blank" href="https://maps.google.com/?q='+data.latitude+','+data.longitude+'">'+data.latitude+','+data.longitude+'</a>'
                        if(data.accuracy){
                            string += '<br/>Akurasi: '+parseFloat(data.accuracy).toFixed(2)+' m'
                        }
                        return string;
                    }
                },
                @can('absensi.delete')
                {
                    "data":"id",
                    "render":(data,type,row,meta) => {
                        let str = '';
                        @if(
                            Auth::user()->checkHRD() || 
                            Auth::user()->checkAdmin()
                        )
                            str = `<button data-id="${data}" class="btn btn-danger delete_user_button">Hapus</button>`;
                        @endif
                        return str;
                    }
                }
                @endcan
            ]
        });
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

        $("#filter_start").change(function(){
            data_table.ajax.reload();
        })
        $("#filter_end").change(function(){
            data_table.ajax.reload();
        })
    </script>
@endsection
