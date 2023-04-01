{{-- @extends('tastypointsapi::partner.partials.master') --}}
@extends('layouts.app')
{{-- @section( 'page_name', "Partner Management - Settings") --}}
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | '.__('tastypointsapi::lang.dashboard') )

@section('css')
    <style>
        .table_container{
            margin-top: 20px;
        }
        #add_new{
            margin-right: 20px;
        }
        .action_form{
            padding-top: 25px;
        }
    </style>
@endsection

@section('content')
@include('tastypointsapi::layouts.nav')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>System Settings
        {{-- <small>@lang( 'tastypointsapi::lang.api_usage' )</small> --}}
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="modal fade" id="modals_session">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title">Session settings</h4>
                </div>
                <form>
                    @csrf
                    <input type="hidden" name="item_id" value="0" />

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Lifetime</label>
                            <input class="form-control" name="life_time" required />
                        </div>
                        <div class="form-group">
                            <label>Date Created</label>
                            <input type="datetime-local" class="form-control" name="date_created" required />
                        </div>
                        <div class="form-group">
                            <label>Test Mode</label>
                            <select class="form-control" name="test_mode" required>
                                <option value="0">Off</option>
                                <option value="1">On</option>
                            </select>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modals_common">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title">Session settings</h4>
                </div>
                <form>
                    @csrf
                    <input type="hidden" name="item_id" value="0" />

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" name="name" required />
                        </div>
                        <div class="form-group">
                            <label>Value</label>
                            <input class="form-control" name="value" />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input class="form-control" name="description" />
                        </div>

                        <div class="text-right">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="main_page">
        <div class="box box-primary">
            <div class="box-body">
                <h4>Session Settings</h4>
                <div class="table_container">
                    <table class="table table-bordered table-striped" id="table_session">
                        <thead>
                            <tr>
                                <th>Life Time</th>
                                <th>Date Created</th>
                                <th>Test Mode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                <h4>Common Settings</h4>
                <div class="table_container">
                    <table class="table table-bordered table-striped" id="table_common">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Value</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('javascript')
    <script>
        let json = {
            "scrdata_id": 1042,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 50,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 1,
            "total_records": 3,
            "session_settings": [],
        };

        let temp_data_session = [];
        let session_table = $("#table_session").DataTable({
            "dom": "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "buttons": [
                'copyHtml5',
                'excelHtml5',
                'colvis',
                'csvHtml5',
                'pdfHtml5'
            ],
            "responsive":true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": '{{ route("tastypointsapi.datatables") }}',
                "type": 'POST',
                "data": function(d){
                    d._token =  "{{ csrf_token() }}";
                    d.input = JSON.stringify(json);
                    d.scr_name = "session_settings";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data_session[item.id] == undefined ? temp_data_session[item.id] = item : temp_data_session[item.id] = item;
                    });
                    return json.data;
                },
            },
            "columns": [
                { 
                    data: "life_time"
                },
                { 
                    data: "date_created",
                },
                { 
                    data: "test_mode",
                    render:function(data,type,row){
                        return data == 1 ? "On" : "Off";
                    }
                },
                { 
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="editSession('+
                        "'"+data+"'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroySession('+
                        "'"+data+"'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });

        function parseDatetime(dateString) {

            if (dateString !== "") {

                var dateVal = new Date(dateString);
                var day = dateVal.getDate().toString().padStart(2, "0");
                var month = (1 + dateVal.getMonth()).toString().padStart(2, "0");
                var hour = dateVal.getHours().toString().padStart(2, "0");
                var minute = dateVal.getMinutes().toString().padStart(2, "0");
                var sec = dateVal.getSeconds().toString().padStart(2, "0");
                var ms = dateVal.getMilliseconds().toString().padStart(3, "0");
                var inputDate = dateVal.getFullYear() + "-" + (month) + "-" + (day) + "T" + (hour) + ":" + (minute) + ":" + (sec) + "." + (ms);

                return inputDate;
            }

            return dateString;
            
        }

        function editSession(id) {
            let data = {};
            try {
                data = temp_data_session[id];
            } catch (error) {
                console.log(error);
            }
            data.date_created = parseDatetime(data.date_created);

            $("#modals_session input[name=item_id]").val(data.id);
            $("#modals_session input[name=life_time]").val(data.life_time);
            $("#modals_session input[name=date_created]").val(data.date_created);
            $("#modals_session select[name=test_mode]").val(data.test_mode);
            $("#modals_session").modal("show");
        }

        $("#modals_session form").validate({
            submitHandler:function(form){

                let input = {
                        "scrdata_id": 1043,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = parseInt(gotForm.item_id);
                input.session_settings = [gotForm];

                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            session_table.draw(false);
                            $("#modals_session").modal("hide");
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });

                });

                return false;

            }
        });

        function destroySession(id) {
            id = parseInt(id);
            let input = {
                "scrdata_id": 1043,
                "session_id": json.session_id,
                "session_exp": json.session_exp,
                "delete": 1,
                "item_id":id,
                "status": "OK",
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
                "session_settings": [
                    {
                        "id": id,
                        "detele":1
                    }
                ]
            };

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    Pace.track(function(){
                        $.ajax({
                            url:"{{ route('tastypointsapi.testnet') }}",
                            type:"post",
                            data:{"input":JSON.stringify(input)},
                            success:function(response){
                                response = JSON.parse(response);
                                if(response.status){
                                    swal("Data has been deleted!", {
                                        icon: "success",
                                    });
                                    session_table.draw(false);
                                }
                            },
                            error:function(error){
                                console.log(error);
                            }
                        });
                    });
                }
            });
        }
        
    </script>
    <script>

        let temp_data_common = [];
        let common_table = $("#table_common").DataTable({
            "dom": "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "buttons": [
                'copyHtml5',
                'excelHtml5',
                'colvis',
                'csvHtml5',
                'pdfHtml5'
            ],
            "responsive":true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": '{{ route("tastypointsapi.datatables") }}',
                "type": 'POST',
                "data": function(d){
                    d._token =  "{{ csrf_token() }}";
                    d.input = JSON.stringify(json);
                    d.scr_name = "common_settings";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data_common[item.id] == undefined ? temp_data_common[item.id] = item : temp_data_common[item.id] = item;
                    });
                    return json.data;
                },
            },
            "columns": [
                { 
                    data: "name"
                },
                { 
                    data: "value",
                },
                { 
                    data: "description",
                },
                { 
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="editCommon('+
                        "'"+data+"'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroyCommon('+
                        "'"+data+"'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });


        function editCommon(id) {
            let data = {};
            try {
                data = temp_data_common[id];
            } catch (error) {
                console.log(error);
            }

            $("#modals_common input[name=item_id]").val(data.id);
            $("#modals_common input[name=name]").val(data.name);
            $("#modals_common input[name=value]").val(data.value);
            $("#modals_common select[name=description]").val(data.description);
            $("#modals_common").modal("show");
        }

        $("#modals_common form").validate({
            submitHandler:function(form){

                let input = {
                        "scrdata_id": 1043,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = parseInt(gotForm.item_id);
                input.common_settings = [gotForm];

                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            common_table.draw(false);
                            $("#modals_common").modal("hide");
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });

                });

                return false;

            }
        });

        function destroyCommon(id) {
            id = parseInt(id);
            let input = {
                "scrdata_id": 1043,
                "session_id": json.session_id,
                "session_exp": json.session_exp,
                "delete": 1,
                "item_id":id,
                "status": "OK",
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
                "common_settings": [
                    {
                        "id": id,
                        "detele":1
                    }
                ]
            };

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    Pace.track(function(){
                        $.ajax({
                            url:"{{ route('tastypointsapi.testnet') }}",
                            type:"post",
                            data:{"input":JSON.stringify(input)},
                            success:function(response){
                                response = JSON.parse(response);
                                if(response.status){
                                    swal("Data has been deleted!", {
                                        icon: "success",
                                    });
                                    common_table.draw(false);
                                }
                            },
                            error:function(error){
                                console.log(error);
                            }
                        });
                    });
                }
            });
        }
        
    </script>
@endsection