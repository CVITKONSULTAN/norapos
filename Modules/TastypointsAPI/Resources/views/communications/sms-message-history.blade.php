@extends('tastypointsapi::communications.partials.master')
@section( 'page_name', "Communications - SMS Message History")

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
    </style>
@endsection

@section('content-header',"SMS Message History")

@section('main_content')

    <div class="main_page">
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Tasty Lover Name</th>
                        <th>Mobile Phone</th>
                        <th>SMS Text</th>
                        <th>Sendtime</th>
                        <th>Action</th>
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
                <form id="filter_form">
                    @csrf

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Filter user:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                    <input name="filter_tid" class="form-control" value=""/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Filter date & time:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                    <input id="range_picker" class="form-control" value=""/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Filter sms template:</label>
                                <select id="sms_template_select" name="filter_sms_template_id" class="form-control">
                                    <option value="0">-- All Data --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 action_form">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter Data</button>
                        </div>
                    </div>
                </form>
                <div class="form-group">
                    <label>View full response payload</label>
                    <textarea rows="5" class="form-control" id="view_response"></textarea>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    let format_date = "YYYY/MM/DD hh:mm:ss";
    // console.log()
    let start_range = moment().startOf('hour').subtract(24, 'months').format(format_date);
    let end_range = moment().startOf('hour').format(format_date);
    $(function() {

        $('#range_picker').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour').subtract(24, 'months'),
            endDate: moment().startOf('hour'),
            locale: {
                format: 'DD/MM/YYYY hh:mm A'
            }
            
        },function(start,end){
            // alert("x");
            start_range = start.format(format_date);
            end_range = end.format(format_date);
            json.filter_date_start = start_range;
            json.filter_date_end = end_range;
            // console.log(start_range,end_range,json);
        });

    });

</script>
<script>

    let json = {
        "scrdata_id": 1092,
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
        "filter_sms_template_id":null,
        "filter_date_end":end_range,
        "filter_date_start":start_range,
        "filter_tid":null,
        "filter_contacts_id":null,
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
                console.log(json);
                d._token =  "{{ csrf_token() }}";
                d.input = JSON.stringify(json);
                d.scr_name = "sms_history";
                return d;
            },
            "dataSrc":function(json){
                temp_data = json.data;
                return json.data;
            }
        },
        "columns": [
            { 
                data: "tasty_lover_name"
            },
            { 
                data: "mobile_phone",
            },
            { 
                data: "sms_text",
            },
            { 
                data: "send_time",
            },
            { 
                data: "response_payload",
                orderable:false,
                searchable:false,
                render:function(data,type,row,meta){
                    return '<button class="btn btn-primary btn-xs" onclick="view('+
                    "'"+meta.row+"'"+
                    ')">View</button>';
                }
            }
        ],
    });

    $("#filter_form input[name=filter_tid]").keyup(function(e){
        let val = $(this).val();
        json.filter_tid = val == "" ? null : val ;
    });

    $("#filter_form").submit(function(e){
            otable.ajax.reload();
        return false;
    });

    function loadSMSTemplate() {

        let input = {
            "scrdata_id": 1044,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 100000,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 1,
            "total_records": 3,
        };

        $.ajax({
            "url": '{{ route("tastypointsapi.testnet") }}',
            "type":"post",
            "data":{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    let data = JSON.parse(response.data);
                    data.sms_templates.map((item,index)=>{
                        let new_item = '<option value="'+item.id+'">'+item.name+'</option>';
                        $("#sms_template_select").append(new_item);
                    });

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }
    
    $("#sms_template_select").change(function(){
        json.filter_sms_template_id = $(this).val();
    });

    $(document).ready(function(e){
        loadSMSTemplate();
    });

    function htmlDecode(input) {
        var doc = new DOMParser().parseFromString(input, "text/html");
        return doc.documentElement.textContent;
    }

    function view(index) {
        let result = temp_data[index];
        result.response_payload = htmlDecode(result.response_payload);
        $("#view_response").val(result.response_payload);
    }
</script>
@endsection