@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Data Order")

@section('page_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
        .filter-label{
            padding-top:7px;
        }
    </style>
@endsection

@section('content-header',"Data Order")

@section('main_content')

    <div class="main_page">
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Partner Name</th>
                        <th>Branch</th>
                        <th>Device</th>
                        <th>DateTime</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@section('new-box')
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <form>
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-sm-2 filter-label control-label">Filter</label>
                                <div class="col-sm-10">
                                    <select id="tpartner_id" name="tpartner_id" class="form-control" required>
                                        <option value="">-- Partner --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select id="branch_id" name="branch_id" class="form-control" required>
                                    <option value="">-- Branch --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select id="pos_id" name="pos_id" class="form-control" required>
                                    <option value="">-- POS Device --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa fa-calendar-alt"></i></div>
                                    <input id="range_picker" name="range_picker" placeholder="Range Time" class="form-control" value=""/>
                                    <span class="input-group-btn">
                                        <button type="button" onclick="$('#range_picker').val('');" class="btn btn-primary"><i class="fas fa-redo"></i> Clear</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>

        let start_range = "",end_range = "";
        $('#range_picker').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour').subtract(1, 'months'),
            endDate: moment().startOf('hour'),
            locale: {
                format: 'DD/MM/YYYY hh:mm A'
            }
            
        },function(start,end){
            let format = "YYYY/MM/DD hh:mm:ss";
            start_range = start.format(format);
            end_range = end.format(format);
            console.log(start,end);
            loadTable();
        });


        let json = {
            "scrdata_id": 1264,
            "sp_name": "OK",
            "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
            "session_exp": "05/29/2015 05:50:06",
            "max_row_per_page": 0,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 0,
            "status": "OK",
            "lab_test": 1,
            "item_id": 0,
            "filter_partner": 1,
            "filter_branch": 1,
            "filter_devices": 1,
            "filter_end_datetime": "2021/08/31 01:00:00",
            "filter_start_datetime": "2021/08/01 01:00:00"
        };

        let temp_data = [];
        let otable = $("#table_data").DataTable({
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
                    d.scr_name = "data_orders";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data[item.id] = item;
                    });
                    return json.data;
                },
            },
            "columns": [
                { 
                    data: "id"
                },
                { 
                    data: "partner_name"
                },
                { 
                    data: "branch_name",
                },
                { 
                    data: "devices_name",
                },
                { 
                    data: "order_time",
                }
                // { 
                //     data: "id",
                //     orderable:false,
                //     searchable:false,
                //     render:function(data,type,row){
                //         return '<button class="btn btn-primary btn-xs" onclick="edit('+
                //         "'"+data+"'"+
                //         ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                //         "'"+data+"'"+
                //         ')">Delete</button>';
                //     }
                // }
            ],
        });

        function loadPartner() {
            let input = {
                "scrdata_id": 1002,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000000,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        response.data.partners.map((item,index)=>{
                            let new_item = '<option value="'+item.id+'">'+item.name+'</option>';
                            $("#tpartner_id").append(new_item);
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        function loadBranch(id = 0) {

            let input = {
                    "scrdata_id": 1262,
                    "sp_name": "OK",
                    "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
                    "session_exp": "05/29/2015 05:50:06",
                    "max_row_per_page": 0,
                    "search_term": "0",
                    "search_term_header": "0",
                    "pagination": 0,
                    "status": "OK",
                    "lab_test": 1,
                    "item_id": 0,
                    "filter_partner": id
            };

            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        let elm = $("#branch_id");
                        elm.empty();
                        response.data = JSON.parse(response.data);
                        elm.append('<option selected value="">-- Branch --</option>');
                        response.data.branchs.map((item,index)=>{
                            let new_item = '<option value="'+item.id+'">'+item.branch_name+'</option>';
                            elm.append(new_item);
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        function loadDevices(id = 0) {

            let input = {
                "scrdata_id": 1266,
                "sp_name": "OK",
                "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
                "session_exp": "05/29/2015 05:50:06",
                "max_row_per_page": 0,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 0,
                "status": "OK",
                "lab_test": 1,
                "item_id": 0,
                "filter_partner": partner_id,
                "filter_branch": id
            };

            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        let elm = $("#pos_id");
                        elm.empty();
                        response.data = JSON.parse(response.data);
                        elm.append('<option selected value="">-- POS Device --</option>');
                        response.data.pos_devices.map((item,index)=>{
                            let new_item = '<option value="'+item.id+'">'+item.serial_number+'</option>';
                            elm.append(new_item);
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        let partner_id = 0;
        $("#tpartner_id").change(function(e){
            partner_id = parseInt($(this).val());
            loadBranch(partner_id);
            loadTable();
        });
        let branch_id = 0;
        $("#branch_id").change(function(e){
            branch_id = parseInt($(this).val());
            loadDevices(branch_id);
            loadTable();
        });
        let devices_id = 0;
        $("#pos_id").change(function(e){ 
            devices_id = parseInt($(this).val());
            loadTable();
        });

        $(document).ready(function(e){
            loadPartner();
            $('#range_picker').val("");
        });
        
        function loadTable() {
            json.filter_start_datetime = start_range;
            json.filter_end_datetime = end_range;
            json.filter_partner = partner_id;
            json.filter_branch = branch_id;
            json.filter_devices = devices_id;
            console.log(json);
            otable.draw(false);
        }

    </script>
@endsection