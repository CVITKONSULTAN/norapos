@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | Screen Data Labs' )

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.css" />
    <style>
        .jsoneditor{
            height: 80vh;
            width: auto;
        }
        .main_server, .filter_section {
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

        .action_filter{
            cursor: pointer;
        }
        .filter_choice {
            margin-right: 15px !important;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .filter_choice > i {
            margin-left: 0px;
        }

        #detail_data_section{
            margin-bottom: 20px;
        }

        .jsoneditor-selected {
            background-color: #e7e7e7 !important;
            color: black !important;
            font-weight: bold !important;
        }

        #status_name {
            /* background-color: red; */
            /* color: white; */
        }
        #color-box {
            background-color: red;
            border-color: red;
        }
        #color-box-update {
            background-color: red;
            border-color: red;
        }
        #scrdata_id-error {
            display: block !important;
        }
        .data_respone_container.active {
            background-color: #ff9200;
            color: white;
        }
        .loading_data{
            color: #ff9200;
        }

        @media only screen and (min-width: 768px) {
            #detail_data_section{
                /* padding-left:7%; */
            }
        }
        
    </style>
@endsection

@section('content')

    @include('tastypointsapi::layouts.nav')

    {{-- All Modals --}}
    <div class="modal fade" id="modal_description">
        <div class="modal-dialog">
            <form id="form_description">
                <input type="hidden" name="type" value="" />
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title desc_title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea name="description" class="form-control" rows="5" id="description_field"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ./All Modals --}}

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{-- @lang( 'tastypointsapi::lang.setup' ) --}}
            Screen Data Labs
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
                                            >
                                            <span class="input-group-btn">
                                                {!! Form::submit("Update", ['class' => 'btn btn-primary']) !!}
                                            </span>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>

                                
                                    <div class="col-md-12 filter_section">
                                        {!!
                                            Form::open([
                                                'url' => "#", 
                                                'method' => 'post', 
                                                'id' => 'filter_form',
                                                "class" => "form-inline",
                                                'files' => false
                                            ]) 
                                        !!}

                                            <div class="form-group filter_choice">
                                                <label>SCRDATA NAME</label>
                                                <input class="form-control" name="scrdata_name" />
                                                {{-- <select class="form-control" name="scrdata_name">
                                                    <option value="GET REWARDS">GET REWARDS</option>
                                                </select> --}}
                                            </div>
                                            <div class="form-group filter_choice">
                                                <label>SCRDATA ID</label>
                                                <input class="form-control" name="scrdata_id" />
                                                {{-- <select class="form-control" name="scrdata_name">
                                                    <option value="10">10</option>
                                                </select> --}}
                                            </div>
                                            <div class="form-group filter_choice">
                                                <label>CATEGORY</label>
                                                <select class="form-control category_data" name="category_id"></select>
                                            </div>
                                            <div class="form-group filter_choice">
                                                <label>STATUS</label>
                                                <div class="input-group">
                                                    <select class="form-control status_data" name="status_id"></select>
                                                    <span class="input-group-addon color-box" id="color-box"> </span>
                                                </div>
                                            </div>
                                            <div class="checkbox filter_choice">
                                                <label>
                                                    <input type="checkbox" name="enabled"> ENABLED
                                                </label>
                                            </div>
                                            <div class="checkbox filter_choice">
                                                <label>
                                                    <input type="checkbox" name="production"> IN PRODUCTION
                                                </label>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-xs filter_choice"><i class="fas fa-filter"></i> FILTER</button>
                                            <button type="button" id="create_new" class="btn btn-primary btn-xs filter_choice"><i class="fas fa-plus"></i> NEW</button>
                                            
                                        {!! Form::close() !!}
                                    </div>

                            </div>
                    </div>
            
                </div>
                
            </div>

            <div class="col-md-9">

                <div class="box box-solid">
            
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12" id="detail_data_section">
                                {!!
                                    Form::open([
                                        'url' => route("tastypointsapi.testnet"), 
                                        'method' => 'post', 
                                        'id' => 'update_form',
                                        "class" => "form-inline",
                                        'files' => false
                                    ]) 
                                !!}
                
                                    <div class="form-group filter_choice">
                                        <input placeholder="SCRENDATA NAME" class="form-control" name="scrdata_name" />
                                    </div>
                                    <div class="form-group filter_choice">
                                        <input placeholder="SCRDATA ID" class="form-control" name="scrdata_id" required type="number" />
                                    </div>
                                    <div class="form-group filter_choice">
                                        <div class="input-group">
                                            <select required class="form-control category_data" name="category_id" id="category_name"></select>
                                        </div>
                                    </div>
                                    <div class="form-group filter_choice">
                                        <div class="input-group">
                                            <select required class="form-control status_data" name="status_id" id="status_name"></select>
                                            <span class="input-group-addon color-box" id="color-box-update"> </span>
                                        </div>
                                    </div>
                                    <button 
                                    type="button" 
                                    class="btn btn-primary btn-xs filter_choice description" 
                                    data-toggle="tooltip" 
                                    title="Screen Description"
                                    data-desc_title="Screen Description"
                                    data-input="screen_desc"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    <div class="checkbox filter_choice">
                                        <label>
                                            <input type="checkbox" name="enabled" id="enabled"> ENABLED
                                        </label>
                                    </div>
                                    <div class="checkbox filter_choice">
                                        <label>
                                            <input type="checkbox" name="production" id="production"> IN PRODUCTION
                                        </label>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary filter_choice" data-toggle="tooltip" title="Apply/Save"><i class="fas fa-save"></i></button>
                                    
                                    <input type="hidden" name="screen_desc" />
                                    <input type="hidden" name="req_desc" />
                                    <input type="hidden" name="res_desc" />
                                    <input type="hidden" name="type" value="0" />
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>JSON Request : 
                                        <button 
                                        type="button" 
                                        class="btn btn-primary btn-xs filter_choice description" 
                                        data-toggle="tooltip" 
                                        title="Request Description"
                                        data-desc_title="Request Description"
                                        data-input="req_desc"
                                        >
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </label>
                                    <div class="jsoneditor" id="request"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>JSON Response : 
                                        <button 
                                        type="button" 
                                        class="btn btn-primary btn-xs filter_choice description" 
                                        data-toggle="tooltip" 
                                        title="Response Description"
                                        data-desc_title="Response Description"
                                        data-input="res_desc"
                                        >
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </label>
                                    <div class="jsoneditor" id="response"></div>
                                </div>
                            </div>
                        </div>    
                    </div>
            
                </div>

            </div>
            <div class="col-md-3">
                <p>Total records : <span id="total_records"></span></p>
                <div id="list_data"></div>
            </div>
            
        </div>


    </section>
    <!-- /.content -->

@endsection

@section('javascript')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>

    <script type="text/javascript">
        
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

    </script>

    <script>
        // create the editor
        let req_json = document.getElementById("request");
        let res_json = document.getElementById("response");
        let config = {
            mode: 'tree',
            modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
        };

        let req_editor = new JSONEditor(req_json,config);
        let res_editor = new JSONEditor(res_json,config);

        $(document).ready(()=>{
            req_editor.set({"scrdata_id":0});
        });

    </script>

    <script>
        let url = "{{ route("tastypointsapi.testnet") }}";

        function loadCategory(){
            let json = {
                "scrdata_id": 1104,
                "sp_name": "OK",
                "session_id": "WA74edc6e2-7d9d-4ae5-b570-46d3b82b8fdc",
                "session_exp": "05/29/2015 05:50:06",
                "max_row_per_page": 10,
                "pagination": 1,
                "search_term": "0",
                "search_term_header": "0",
                "status": "OK",
                "item_id": 0
            };

            $.ajax({
                url:url,
                type:"POST",
                data:{"input":JSON.stringify(json)},
                success:function(result){
                    result = JSON.parse(result);
                    if(result.status){
                        let data = JSON.parse(result.data);
                        $(".category_data").empty();
                        data.scrdata_lab_category.map((item,index)=>{
                            let new_data = '<option value="'+item.id+'">'+item.name+'</option>';
                            $(".category_data").append(new_data);
                        });
                        $(".category_data").prepend('<option value="0" selected>Select category</option>');
                    }
                },
                error:function(error){

                }
            });
        }

        function loadStatus(){
            let json = {
                "scrdata_id" : 1106,
                "sp_name" : "OK",
                "session_id" : "WA74edc6e2-7d9d-4ae5-b570-46d3b82b8fdc",
                "session_exp" : "05/29/2015 05:50:06",
                "max_row_per_page" : 10,
                "pagination" : 1,
                "search_term" : "0",
                "search_term_header" : "0",
                "status" : "OK",
                "item_id" : 0
            };

            $.ajax({
                url:url,
                type:"POST",
                data:{"input":JSON.stringify(json)},
                success:function(result){
                    result = JSON.parse(result);
                    if(result.status){
                        let data = JSON.parse(result.data);
                        $(".status_data").empty();
                        data.scrdata_lab_status.map((item,index)=>{
                            let new_data = '<option value="'+item.id+'" data-color="'+item.color+'">'+item.name+'</option>';
                            $(".status_data").append(new_data);
                            $(".color-box").css("background-color","white");
                            $(".color-box").css("border-color","white");
                        });
                        $(".status_data").prepend('<option value="0" selected data-color="white">Select status</option>');
                    }
                },
                error:function(error){

                }
            });
        }

        $(".status_data").change(function(){
            let color = $(this).find(':selected').data("color");
            $(this).parent().find(".color-box").css("background-color",color);
            $(this).parent().find(".color-box").css("border-color",color);
        });

        $(document).ready(function(){
            loadCategory();
            loadStatus();
        });

        let all_rows = [];
        let session_id = "{{ Request::get("session")->session_id }}";
        let session_exp = "{{ Request::get("session")->session_exp }}";

        const getData = (
            pagination, 
            max_item, 
            options
        ) => {

            options.scrdata_id = isNaN(options.scrdata_id) || options.scrdata_id == ""  ? 0 : parseInt(options.scrdata_id);

            let get_json = {
                "scrdata_id": 1058,
                "sp_name": "OK",
                "session_id": session_id,
                "session_exp": session_exp,
                "item_id": 0,
                "max_row_per_page": max_item,
                "scrdata_name_filter": options.scrdata_name,
                "scrdata_id_filter": options.scrdata_id,
                "scrdata_category_filter": parseInt(options.category_id),
                "scrdata_status_filter": parseInt(options.status_id),
                "scrdata_enable_filter": options.enabled,
                "scrdata_production_filter": options.production,
                "pagination": pagination,
                "search_term": "",
                "search_term_header": "",
            };

            // console.log(get_json);
            // console.log(JSON.stringify(get_json));

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
                        let rows = data.scrdata_lab_jsons;

                        let string = '';
                        paginate = pagination;
                        if(pagination == 1){
                            $("#list_data").empty();
                            all_rows = rows;
                            console.log(all_rows);
                            let loadmore = '<div class="text-center loading_data"> <i class="fas fa-circle-notch fa-spin fa-3x"></i> </div>';
                            $("#list_data").append(loadmore);
                        }
                        let start_index = 0;
                        if(rows !== null) {
                            if(paginate > 1) {
                                start_index = all_rows.length;
                                all_rows = [...all_rows, ...rows];
                            }
                            rows.map((item,index)=>{
                                let status = item.enabled ? "ACTIVE" : "INACTIVE";
                                string = string+'<div class="data_respone_container data_index_'+start_index+'" onClick="showData('+start_index+',true)">'+
                                        '<div class="data_response_detail">'+
                                            '<p>SCRDATA: '+item.scrdata_id+'</p>'+
                                            '<p>NAME: '+item.scrdata_name+'</p>'+
                                            '<p>ACTIVE: '+status+'</p>'+
                                        '</div>'+
                                        '<div class="data_response_action">'+
                                            '<i class="fas fa-eye"></i>'+
                                        '</div>'+
                                    '</div>';
                                start_index++;
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
                }
            });
        }

        let options = {
            scrdata_name:"",
            scrdata_id:0,
            category_id:0,
            status_id:0,
            status:"",
            enabled:false,
            production:false,
        };

        $(document).ready(function(){

            getData(
                1,
                50,
                options
            );
        });

        $("#filter_form").on("submit",function(e){

            options = getFormData( $(this) );
            options.enabled = options.enabled == "on" ? true :  false;
            options.production = options.production == "on" ? true :  false;
            
            
            getData(
                1,
                50,
                options
            );
            return false;
        });

        function getFormData($form){
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }

        let active_data = null;
        function showData(index,from){

            const data = all_rows[index];
            
            $(".data_response_action").empty();
            $(".data_response_action").html('<i id class="fas fa-eye"></i>');

            // console.log(index == active_data && !from, index, active_data, from);

            if(index == active_data){
                $(".data_respone_container").removeClass("active");
                active_data = null;
                ClearField();
            } else {


                data.scrdata_category_id = data.scrdata_category_id == null ? 0 : data.scrdata_category_id;
                data.scrdata_status_id = data.scrdata_status_id == null ? 0 : data.scrdata_status_id;

                $("#update_form input[name=screen_desc]").val(data.scrdata_notes);
                $("#update_form input[name=req_desc]").val(data.req_description);
                $("#update_form input[name=res_desc]").val(data.res_description);
                
                $("#update_form input[name=scrdata_name]").val(data.scrdata_name);
                $("#update_form input[name=scrdata_id]").val(data.scrdata_id);
                $("#update_form select[name=category_id]").val(data.scrdata_category_id);

                $("#update_form select[name=status_id]").val(data.scrdata_status_id);
                let color = $("#update_form select[name=status_id]").find(":selected").data("color");
                
                $("#color-box-update").css("background-color",color);
                $("#color-box-update").css("border-color",color);

                $("#update_form input[name=type]").val(data.id);
                data.enabled ? $("#enabled").prop('checked', true) : $("#enabled").prop('checked', false);
                data.in_production ? $("#production").prop('checked', true) : $("#production").prop('checked', false);
                req_editor.set(data.req_json);
                res_editor.set(data.res_json);

                $(".data_respone_container").removeClass("active");
                $(".data_index_"+index).addClass("active");

                $(".data_index_"+index+" .data_response_action").empty();
                $(".data_index_"+index+" .data_response_action").html('<i id class="fas fa-eye-slash"></i>');

                active_data = index;

            }
        }

        $(".description").click(function(e){

            $("#description_field").val("");

            let title = $(this).data("desc_title");
            let input = $(this).data("input");
            let desc = $("#update_form input[name="+input+"]").val();

            $("#modal_description input[name=type]").val(input);
            $("#description_field").val(desc);
            $("#modal_description").modal("show");
            $("#modal_description .desc_title").html(title);
        });

        jQuery.validator.addMethod("notEqual", function(value, element, param) {
            return this.optional(element) || value != param;
        }, "Please specify a different (non-default) value");

        $("#update_form").validate({
            rules: {
                category_id: { notEqual: "0" },
                status_id: { notEqual: "0" },
                scrdata_id: { required: true }
            },
            messages:{
                category_id:{
                    notEqual:"Select category",
                },
                status_id:{
                    notEqual:"Select Status",
                },
            },
            submitHandler:function(form){
                let data = getFormData($(form));
                data.enabled = $("#enabled").is(":checked");
                data.production = $("#production").is(":checked");
                // console.log(data);
                
                let format_json = {
                    "scrdata_id" : 1059,
                    "sp_name" : "OK",
                    "session_id" : "WAd9fd957f-da4f-4969-ade3-d2209a3f6ecd",
                    "session_exp" : "05/29/2015 05:50:06",
                    "max_row_per_page" : 0,
                    "search_term" : "0",
                    "search_term_header" : "0",
                    "pagination" : 0,
                    "item_id" : parseInt(data.type),
                    "search_start_date_Time" : "0",
                    "search_end_date_Time" : "0",
                    "scrdata_lab_jsons" : [
                        {
                            "id" : parseInt(data.type),
                            "scrdata_id" : parseInt(data.scrdata_id),
                            "scrdata_name" : data.scrdata_name,
                            "scrdata_category_id" : parseInt(data.category_id),
                            "scrdata_category" : "",
                            "scrdata_status_id" : parseInt(data.status_id),
                            "scrdata_status_name" : "",
                            "scrdata_status_color" : "",
                            "enabled" : data.enabled,
                            "in_production" : data.production,
                            "req_json" : req_editor.get(),
                            "req_description" : data.req_desc,
                            "res_json" : res_editor.get(),
                            "res_description" : data.res_desc,
                            "scrdata_notes" : data.screen_desc,
                            "delete" : false
                        }
                    ]
                };
                // console.log(format_json);
                $.ajax({
                    url:form.action,
                    type:form.method,
                    data:{"input":JSON.stringify(format_json)},
                    beforeSend:function(){
                        $("#update_form button").attr("disabled",true);
                        $("#update_form button[type=submit]").html('<i class="fas fa-spinner fa-pulse"></i> Loading');
                    },
                    success:function(result){
                        result = JSON.parse(result);
                        if(result.status){
                            let data = JSON.parse(result.data);
                            // console.log(data);
                            if(data.status == "OK"){
                                swal({
                                    title: "",
                                    text: "Data is saved",
                                    icon: "success",
                                });
                                $("#filter_form").submit();
                            }
                        }
                    },
                    error:function(error){
                        console.log(error);
                    },
                    complete:function(){
                        $("#update_form button").removeAttr("disabled");
                        $("#update_form button[type=submit]").html('<i class="fas fa-save"></i>');
                    }
                });
                return false;
            }
        });

        $("#form_description").validate({
            submitHandler:function(form){
                let data = getFormData( $(form) );
                $("#update_form input[name="+data.type+"]").val(data.description);
                $("#description_field").val("");
                $("#modal_description").modal("hide");
                return false;
            }
        });

        const ClearField = () =>{
            $("#update_form input").val("");
            $("#update_form select").val("0");
            $("#update_form input[type=checkbox]").prop("checked",false);
            $("#update_form input[name=type]").val("0");
            $("#color-box-update").css("background-color","white");
            $("#color-box-update").css("border-color","white");
            req_editor.set({});
            res_editor.set({});
        }

        $("#create_new").click(ClearField);


        function chk_scroll(e) {
            var elem = $(e.currentTarget);
            let minus = elem[0].scrollHeight - elem.scrollTop();
            if (minus >= elem.outerHeight()) {
                // console.log("bottom",paginate,loading);
                if(!loading){
                    let loadmore = '<div class="text-center loading_data"> <i class="fas fa-circle-notch fa-spin fa-3x"></i> </div>';
                    $("#list_data").append(loadmore);
                    paginate = paginate+1;
                    getData(paginate,50,options);
                }
            }
        }

        $(document).ready(function () {
            $('#list_data').on('scroll', chk_scroll);
        });

    </script>

@endsection