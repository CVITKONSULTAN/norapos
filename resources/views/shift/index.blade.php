@extends('layouts.app')
@section('title', 'Shift Log')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Shift Log
        <small>Data daftar shift log</small>
    </h1>
</section>

<div id="tambah_data" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Tambah Data
                </h4>
            </div>
            <form method="POST" action="{{route('shift.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">File Data</label>
                        <input type="file" class="form-control" name="filePath" required />
                    </div>
                    <div class="form-group">
                        <label>Total Cash (Walk in)</label>
                        <input type="number" class="form-control" name="total_cash" required />
                    </div>
                    <div class="form-group">
                        <label>Total Transfer (Walk in)</label>
                        <input type="number" class="form-control" name="total_transfer" required />
                    </div>
                    <div class="form-group">
                        <label>Total Room</label>
                        <input type="number" class="form-control" name="total_room" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => "Semua data"])
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Start Tanggal</label>
                    <input id="filter_start" class="form-control" type="date" name="filter_start" value="" />
                </div>
                <div class="form-group col-md-4">
                    <label>End Tanggal</label>
                    <input id="filter_end" class="form-control" type="date" name="filter_end" value="" />
                </div>
            </div>
            @slot('tool')
                <div class="box-tools">
                    <button onclick="tambahData()" type="button" class="btn btn-block btn-primary"><i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="data_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Upload By</th>
                            <th>Timestamp</th>
                            <th>Reviewed By</th>
                            <th>Reviewed Time</th>
                            {{-- @can('shift.action') --}}
                            @if(auth()->user()->checkAdmin() || auth()->user()->checkHRD())
                                <th>@lang( 'messages.action' )</th>
                            @endif
                            {{-- @endcan --}}
                        </tr>
                    </thead>
                </table>
            </div>
    @endcomponent
</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script>

        const tambahData  = () => {
            $("#tambah_data").modal('show');
        }

        const data_table = $('#data_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                    url:'{{ route("shift.data") }}',
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
                {"data":"id"},
                {
                    "data":"status",
                    "render":(data,type,row,meta) => {
                        if(data == 'reviewed'){
                            return `<span class="label label-success">Telah Direview</span>`;
                        } else {
                            return `<span class="label label-warning">Belum Direview</span>`;
                        }
                    }
                },
                {
                    "data":"file_path",
                    "render":(data,type,row,meta) => {
                        return `<a href="${data}"><i class="fa fa-file"></i> Klik Disini</a>`
                    }
                },
                {"data":"name"},
                {
                    "data":"created_at",
                    "render":(data,type,row,meta) => {
                        return moment(data).format('DD/MM/YYYY HH:mm:ss');
                    }
                },
                {
                    "data":"reviewer_name",
                    "render":(data,type,row,meta) => {
                        if(!data) return '-';
                        return data;
                    }
                },
                {
                    "data":"updated_at",
                    "render":(data,type,row,meta) => {
                        if(!row.reviewed_by) return '-';
                        return moment(data).format('DD/MM/YYYY HH:mm:ss');
                    }
                },
                {
                    "data":"id",
                    "render":(data,type,row,meta) => {
                        let str = '';
                        @if(
                            Auth::user()->checkHRD() || 
                            Auth::user()->checkAdmin()
                        )
                            if(!row.reviewed_by){
                                str += `<button data-id="${data}" class="btn btn-primary update_status">Telah Direview</button> `;
                            }
                            str += `<button data-id="${data}" class="btn btn-danger delete_button">Hapus</button>`;
                        @endif
                        return str;
                    }
                }
            ]
        });

        const filterLoad = () => {
            data_table.ajax.reload();
        }

        $("#filter_start").change(filterLoad)
        $("#filter_end").change(filterLoad)
        
        @if(auth()->user()->checkAdmin() || auth()->user()->checkHRD())
            $(document).on('click', 'button.delete_button', function(){
                swal({
                title: LANG.sure,
                text: LANG.confirm_delete_user,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        const href = "{{ route('shift.store') }}";
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
            $(document).on('click', 'button.update_status', function(){
                swal({
                title: LANG.sure,
                text: "Apakah anda yakin setuju dengan data ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        const href = "{{ route('shift.store') }}";
                        const id = $(this).data('id');
                        $.ajax({
                            method: "POST",
                            url: href,
                            dataType: "json",
                            data: {accepted:1,id:id},
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
        @endif
    </script>
@endsection
