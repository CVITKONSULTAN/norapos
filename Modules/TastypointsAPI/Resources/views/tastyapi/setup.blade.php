@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | '.__('tastypointsapi::lang.setup') )

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .jsoneditor{
            height: 80vh;
            width: auto;
        }
        .main_server{
            margin-bottom: 20px;
        }
        .data_respone_container{
            border-radius: 10px;
            background: white;
            border: 1px #ff9200 solid;
            padding: 10px;
            font-size: 9pt;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .data_respone_container:hover{
            font-weight: 600;
            background: #f5f5f5;
        }
        .data_response_detail{
            display: inline-block;
            vertical-align: middle;
            width: 80%
        }
        .data_response_detail p {
            margin: 3px !important;
        }
        .data_response_action{
            display: inline-block;
            font-size: 20pt;
            font-weight: bold;
        }
        .data_response_action > * {
            vertical-align: middle;
        }
        #list_data{
            height: 80vh;
            overflow-y: scroll;
        }
        .jsoneditor-selected {
            background-color: #e7e7e7 !important;
            color: black !important;
            font-weight: bold !important;
        }
        .mt-10{
            margin-top: 10px;
        }
        .data_respone_container.active {
            background-color: #ff9200;
            color: white;
        }
        .select2-selection{
            min-width: 200px;
        }
        .loading_data{
            color: #ff9200;
        }
        @media only screen and (min-width: 768px) {
            .session_container_desktop{
                display: block;
            }
            .session_container_mobile{
                display: none;
            }  
        }
        @media only screen and (max-width: 480px) {
            .session_container_desktop{
                display: none;
            }
            .session_container_mobile{
                display: block;
            }
        }
    </style>
    
@endsection

@section('content')
@include('tastypointsapi::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{-- @lang( 'tastypointsapi::lang.setup' ) --}}
            JSON Debugger
            <small>@lang( 'tastypointsapi::lang.setup_subtitle' )</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            
            <div class="col-md-12">

                <div class="box box-solid">
            
                    <div class="box-body">
                            <div class="row">

                                    <div class="col-md-12 main_server">
                                        {!!
                                            Form::open([
                                                'url' => route("tastypointsapi.setup.update"), 
                                                'method' => 'post', 
                                                'id' => 'setup_form',
                                                'files' => false
                                            ]) 
                                        !!}
                                        <p> Link main server : </p>
                                        <div class="input-group">
                                            <input 
                                            type="url"
                                            name="link" 
                                            class="form-control" 
                                            placeholder="Link main server"
                                            value="{{$config->link}}"
                                            id="main_net"
                                            >
                                            <span class="input-group-btn">
                                                {!! Form::submit("Update", ['class' => 'btn btn-primary']) !!}
                                            </span>
                                        </div>
                                        {!! Form::close() !!}
                                        <div class="session_container_desktop">
                                            <p class="mt-10">Session ID : {{ Request::get("session")->session_id }} <button data-clipboard-text="{{ Request::get("session")->session_id }}" class="btn btn-primary btn-xs copy"><i class="fas fa-copy"></i></button> | Session Expired : {{ Request::get("session")->session_exp }} <button data-clipboard-text="{{ Request::get("session")->session_exp }}" class="btn btn-primary btn-xs copy"><i class="fas fa-copy"></i></button> | Clock : <span id="clock"></span> </p>
                                        </div>
                                        <div class="session_container_mobile">
                                            <p class="mt-10">Session ID : {{ Request::get("session")->session_id }} <button data-clipboard-text="{{ Request::get("session")->session_id }}" class="btn btn-primary btn-xs copy"><i class="fas fa-copy"></i></button> <br/> Session Expired : {{ Request::get("session")->session_exp }} <button data-clipboard-text="{{ Request::get("session")->session_exp }}" class="btn btn-primary btn-xs copy"><i class="fas fa-copy"></i></button></p>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        {!!
                                            Form::open([
                                                'url' => route("tastypointsapi.testnet"), 
                                                'method' => 'post', 
                                                'id' => 'test_form',
                                                'files' => false
                                            ]) 
                                        !!}
                                        <div class="input-group">
                                            <input 
                                            type="text"
                                            name="custom_session" 
                                            class="form-control" 
                                            id="custom_session"
                                            placeholder="Use custom session name (optional)"
                                            value=""
                                            maxlength="191"
                                            >
                                            <span class="input-group-btn">
                                                <button type="submit" id="submit_testnet" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                                            </span>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>

                                    <div class="col-md-9">
                                        {!!
                                            Form::open([
                                                'url' => "#", 
                                                'method' => 'post', 
                                                'id' => 'filter_form',
                                                "class" => "form-inline",
                                                'files' => false
                                            ]) 
                                        !!}
                                            <label>RESPONSE FILTER:</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fas fa fa-history"></i></div>
                                                    <input id="cus_session" class="form-control" name="custom_session" placeholder="CUSTOM SESSION" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fas fa fa-list"></i></div>
                                                    <input id="filter_scrdata" class="form-control" name="filter_scrdata" placeholder="SCRDATA" />
                                                    {{-- <select 
                                                    id="user_id" 
                                                    class="form-control" 
                                                    name="user_id[]"
                                                    multiple="multiple" 
                                                    >
                                                        <option value="1">Heru (1)</option>
                                                        <option value="2">Sharlon (2)</option>
                                                    </select> --}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fas fa fa-user"></i></div>
                                                    <input id="user_id" class="form-control" name="user_id" placeholder="USER_ID" />
                                                    {{-- <select 
                                                    id="user_id" 
                                                    class="form-control" 
                                                    name="user_id[]"
                                                    multiple="multiple" 
                                                    >
                                                        <option value="1">Heru (1)</option>
                                                        <option value="2">Sharlon (2)</option>
                                                    </select> --}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fas fa fa-calendar-alt"></i></div>
                                                    <input id="range_picker" class="form-control" name="date_time" placeholder="DATE & TIME" />
                                                    <span class="input-group-btn">
                                                        <button type="button" id="clear_date" class="btn btn-primary"><i class="fas fa-redo"></i> Clear</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <button id="filter_data" type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter Data</button>
                                        {!! Form::close() !!}
                                        <div class="form-inline" style="margin-top: 10px;">
                                            <label>SCRDATA LABS : </label>
                                            <div class="form-group" style="margin-left: 18px;">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fas fa fa-list"></i></div>
                                                    <select 
                                                    id="sclab" 
                                                    class="form-control" 
                                                    name="sclab"
                                                    >
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                    </div>
            
                </div>
                
            </div>

            <div class="col-md-10">

                <div class="box box-solid">
            
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>JSON Request : </label>
                                    <div class="jsoneditor" id="request"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>JSON Response : </label>
                                    <div class="jsoneditor" id="response"></div>
                                </div>
                            </div>
                        </div>    
                    </div>
            
                </div>

            </div>
            <div class="col-md-2">
                <p>Total Records : <span id="total_records"></span></p>
                <div class="checkbox">
                    <label><input type="checkbox" id="full_json" value="">FULL JSON</label>
                </div>
                <div id="list_data"></div>
            </div>
            
        </div>


    </section>
    <!-- /.content -->

@endsection

@section('javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>

<script type="text/javascript">

    new ClipboardJS('.copy');

    let start_range = null;
    let end_range = null;

    $("#cus_session").keyup(function(e){
        let target = $("#filter_scrdata");
        let scdata_filter = target.val();
        console.log(scdata_filter);
        if(scdata_filter == null || scdata_filter == "" ) target.val(-1).trigger("keyup");
    });

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
        // console.log(start,end);
    });

    $(document).ready(function() {
        // $('#user_id').select2({
        //     placeholder: "USER ID",
        //     allowClear: true,
        //     width:"100%"
        // });
        $('#range_picker').val("");
    });


    // create the editor
    let req_json = document.getElementById("request");
    let res_json = document.getElementById("response");
    let options = {
        mode: 'tree',
        modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
    };

    let req_editor = new JSONEditor(req_json,options);
    let res_editor = new JSONEditor(res_json,options);
    
    $(document).ready(()=>{
        req_editor.set({"scrdata_id":0});
    });

    let session_id = "{{ Request::get("session")->session_id }}";
    let session_exp = "{{ Request::get("session")->session_exp }}";
    
    $("#setup_form").validate({
        submitHandler:function(form){
            $.ajax({
                url:form.action,
                type:form.method,
                beforeSend:function(){
                    $("#setup_form [type=submit]").attr("disabled",true);
                    $("#setup_form [type=submit]").html('<i class="fas fa-spinner fa-spin"></i> Loading');
                },
                success:function(response){
                    swal({
                        title: "",
                        text: response.message,
                        icon: response.status,
                    });
                },
                complete:function(){
                    $("#setup_form [type=submit]").removeAttr("disabled");
                    $("#setup_form [type=submit]").html('Submit');
                },
                error:function(error){
                    swal({
                        title: "Bad request",
                        text: error.message,
                        icon: "error",
                    });
                }
            });
            return false;
        }
    });

    $("#test_form").validate({
        submitHandler:function(form){
            
            let custom_session = $("#custom_session").val();

            if(req_editor.getText() !== "") {

                let req_data = req_editor.get();
                // let req_data = req_editor.getText();
                // req_data = JSON.stringify(req_data).split("'").join("''");
                // req_data = JSON.parse(req_data);
                // console.log(req_data);
                // req_editor.set(req_data);
                req_data.custom_sname = custom_session;

                
                $.ajax({
                    url:form.action,
                    type:form.method,
                    data:{input:JSON.stringify(req_data)},
                    beforeSend:function(){
                        $("#submit_testnet").attr("disabled",true);
                        $("#submit_testnet").html('Loading...');
                    },
                    success:function(response){
                        let res = response;
                        response = JSON.parse(response);

                        if(response.status){
                            var hasil = JSON.parse(response.data);
                            res_editor.set(hasil);
                        } else {
                            res_editor.set({});
                        }
                    },
                    complete:function(){
                        $("#submit_testnet").removeAttr("disabled");
                        $("#submit_testnet").html('Submit');
                    },
                    error:function(error){
                        swal({
                            title: "Bad request",
                            text: error.message,
                            icon: "error",
                        });
                    }
                });

            } else {
                swal({
                    title: "",
                    text: "JSON Request is required",
                    icon: "error",
                });
            }

            return false;
        }
    });

    let url = "{{ route("tastypointsapi.testnet") }}";
    let all_rows = [];
    let active_data = null;
    let loading = false;
    let paginate = 1;

    const getData = (
        pagination, 
        max_item, 
        start, 
        end,
        user_id,
        custom_session_name,
        filter_scrdata,
    ) => {

        session_id = "WAd9fd957f-da4f-4969-ade3-d2209a3f6ecd";

        let get_json = {
            "scrdata_id": 1056,
            "sp_name": "OK",
            "session_id":session_id,
            "session_exp":session_exp,
            "max_row_per_page": max_item,
            "pagination": pagination,
            "item_id": 0,
            "user_id_filter": user_id,
            "search_start_date_time" : start,
            "search_end_date_time" : end,
            "custom_session_filter": custom_session_name,
            "filter_scrdata": filter_scrdata,
        }

        if(isNaN(user_id)){
            get_json.user_name_filter = user_id;
            get_json.user_id_filter = 0;
        } else {
            user_id = user_id == "" ? 0 : parseInt(user_id);
            get_json.user_id_filter = parseInt(user_id);
        }

        $.ajax({
            url:url,
            data:{input:JSON.stringify(get_json)},
            type:"POST",
            beforeSend:function(){
                loading = true;
            },
            success:function(result){
                let json = JSON.parse(result);
                if(json.status){

                    let data = JSON.parse(json.data);
                    let records = $.number(data.total_records);
                    $("#total_records").html(records);
                    let rows = data.json_request;
                    // console.log(JSON.stringify(rows));
                    let string = '';
                    paginate = pagination;
                    if(pagination == 1){
                        $("#list_data").empty();
                        all_rows = rows;
                        let loadmore = '<div class="text-center loading_data"> <i class="fas fa-circle-notch fa-spin fa-3x"></i> </div>';
                        $("#list_data").append(loadmore);
                    }
                    if(rows !== undefined && rows !== null) {

                        console.log(rows);
                        rows.map((item,index)=>{
                            item = item.request;
                            string = string+'<div class="data_respone_container data_index_'+index+'" onClick="showData('+index+',false)">'+
                                '<div class="data_response_detail">'+
                                    '<p>SCRDATA: '+item.scrdata_id+'</p>'+
                                    '<p>DATE_TIME: '+item.date_time_created+'</p>'+
                                    '<p>USER ID: '+item.user_name+'</p>'+
                                '</div>'+
                                '<div class="data_response_action">'+
                                    '<i id class="fas fa-eye"></i>'+
                                '</div>'+
                            '</div>';
                        });
                        $("#list_data").append(string);
                        
                    }


                }
            },
            error:function(error){
                console.error();
            },
            complete:function(){
                $(".loading_data").remove();
                loading = false;
                $("#filter_data").removeAttr("disabled");
                $("#filter_data").html('<i class="fas fa-filter"></i> Filter Data');
            }
        });
    }
    $("#full_json").click(()=>{
        showData(active_data,true);
    });
    function showData(index,from){
        
        $(".data_response_action").empty();
        $(".data_response_action").html('<i id class="fas fa-eye"></i>');

        if(index == active_data && !from){
            clearField();
            $(".data_respone_container").removeClass("active");
            active_data = null;
        } else {

            active_data = index;
            let getData = all_rows[index];

            let req = getData.request;
            let res = getData.response;
            let res_show = res.json;
            let req_show = req.json;
            if($("#full_json").is(':checked')) {
                res_show = res;
                req_show = req;
            }

            // req_show = JSON.stringify(req_show).split("'").join("''");
            // req_show = JSON.parse(req_show);
            
            res_editor.set(res_show);
            req_editor.set(req_show);
            
            $(".data_respone_container").removeClass("active");
            $(".data_index_"+index).addClass("active");

            $(".data_index_"+index+" .data_response_action").empty();
            $(".data_index_"+index+" .data_response_action").html('<i id class="fas fa-eye-slash"></i>');

            $("#custom_session").val(req.custom_sname);
        }
    }

    $(document).ready(function(){
        getData(
            1,
            50,
            null,
            null,
            0,
            "",
            "",
        );
    });

    let cus_session_filter = "";

    $("#cus_session").keyup(function(){
        cus_session_filter = $(this).val();
    });

    let filter_scrdata = "";
    $("#filter_scrdata").keyup(function(){
        filter_scrdata = $(this).val();
    });

    $("#filter_form").on("submit", function(){
        $("#filter_data").attr("disabled",true);
        $("#filter_data").html('<i class="fas fa-circle-notch fa-spin"></i>');
        getData(1,50,start_range,end_range,user_id,cus_session_filter,filter_scrdata);
        clearField();
        active_data = 0;
        return false;
    });

    $(document).ready(function () {
        $('#list_data').on('scroll', chk_scroll);
    });

    function chk_scroll(e) {
        var elem = $(e.currentTarget);
        let minus = elem[0].scrollHeight - elem.scrollTop();
        if (minus >= elem.outerHeight()) {
            // console.log("bottom",paginate,loading);
            if(!loading){
                let loadmore = '<div class="text-center loading_data"> <i class="fas fa-circle-notch fa-spin fa-3x"></i> </div>';
                $("#list_data").append(loadmore);
                paginate = paginate+1;
                getData(paginate,50,start_range,end_range,user_id,cus_session_filter,filter_scrdata);
            }
        }
    }

    $("#clear_date").click(()=>{
        $("#range_picker").val("");
    });

    setInterval(function(){
        let clock = moment().format("DD/MM/YYYY hh:mm:ss");
        $("#clock").html(clock);
    },1000);

    let user_id = 0;
    $("#user_id").keyup(function(){
        user_id = $(this).val();
    });
    $("#user_id").change(function(){
        user_id = $(this).val();
    });

    function clearFilter(){
        $("#filter_form input").val("");
    }

    function clearField(){
        $("#custom_session").val("");
        let set_json = {};
        req_editor.set(set_json);
        res_editor.set(set_json);
    }

    let sclab_data = [];

    function getSclab(){

        let get_json = {
            "scrdata_id": 1058,
            "sp_name": "OK",
            "session_id": session_id,
            "session_exp": session_exp,
            "item_id": 0,
            "max_row_per_page": 100,
            "search_term": "",
            "scrdata_name_filter": "",
            "scrdata_id_filter": 0,
            "scrdata_category_filter": 0,
            "scrdata_enable_filter": false,
            "scrdata_production_filter": false,
            "search_term_header": "",
            "pagination": 1
        };

        $.ajax({
            url:url,
            data:{input:JSON.stringify(get_json)},
            type:"POST",
            beforeSend:function(){
                loading = true;
                $("#sclab").select2("destroy");
            },
            success:function(result){
                let json = JSON.parse(result);
                if(json.status){

                    let data = JSON.parse(json.data);
                    let rows = data.scrdata_lab_jsons;
                    sclab_data = rows;

                    let string = '';
                    $("#sclab").empty();
                    if(rows !== null) {
                        rows.map((item,index)=>{
                            string = string+'<option value="'+item.id+'" data-index="'+index+'"> '+item.scrdata_id+' </option>';
                        });
                        string = string+'<option value="" selected data-index="-1"> SELECT SCRLAB </option>';
                        $("#sclab").append(string);
                    }


                }
            },
            error:function(error){
                console.error();
            },
            complete:function(){
                $(".loading_data").remove();
                loading = false;
                $("#sclab").select2(select2_config);
            }
        });
    }
    let select2_config = { width: '100%' };
    $(document).ready(()=>{
        $("#sclab").select2(select2_config);
        getSclab();
    })

    $("#sclab").change(()=>{
        let index = $("#sclab").find(":selected").data("index");
        if(index > 0) {
            let data = sclab_data[index];
            req_editor.set(data.req_json);
            res_editor.set(data.res_json);
        } else {
            req_editor.set({});
            res_editor.set({});
        }
    });

</script>

@endsection