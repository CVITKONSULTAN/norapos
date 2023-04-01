@extends('tastypointsapi::marketing.partials.master')
@section( 'page_name', "Marketing Campagins - Stamp Campaigns")

@section('page_css')
    <style>
        .table_container{
            margin-top: 20px;
        }
        #add_new{
            margin-right: 20px;
        }
        .action_form{
            padding: 24px 0px;
        }
        .choices_stamp{
            min-width: 75px;
        }
        .select_assign{
            display: inline-block;
            width: 64%;
        }
        .list_screen{
            background-color: #f5f5f5;
            margin-bottom: 10px;
        }
        .list_action{
            padding: 10px;
        }
        .item_preview {
            height: 270px;
            width: 100%;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            cursor: pointer;
        }
        .item_footer {
            min-height: 40px;
            padding: 10px;
            width: 100%;
            background: white;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            text-align: center;
        }
        .select_filter{
            background-color: #f2f4f7;
            border: 1px #f2f4f7 solid;
            color: #2196f3;
        }
        .select_category{
            max-width: 12%;
            position: absolute;
            left: 50px;
        }
        .select_sortby{
            max-width: 15%;
            position: absolute;
            right: 50px;
        }
        .list_choices{
            display: inline-block;
            vertical-align: middle;
            width: 15%;
            text-align: center;
            padding: 30px 20px;
            border: 1px gray dotted;
            border-radius: 5px;
            /* min-height: 147.750px; */
            height: 345px;
        }
        .dataPage{
            display: inline-block;
            vertical-align: middle;
            width: 100%;
            overflow-y: hidden;
            overflow-x: auto;
            height: 345px;
            white-space: nowrap;
        }
        .dataPage > .item {
            display: inline-block;
            width: 200px;
            border-radius: 10px;
            margin: 0px 5px;
        }
        .list_data{
            padding: 30px 20px;
        }
        .select_template{
            background: transparent;
            border-radius: 50px;
            color: white;
            font-size: 11pt;
            margin:  75px 0px 0px 0px;
        }
        .select_template:hover{
            color: rgb(54, 54, 54);
            background: white;
        }

        .card--content {
            display: inline-block;
            vertical-align: middle;
            width: 200px;
            height: 270px;
            margin: 5px;
        }

        .card--content img {
            width: 200px;
            height: 270px;
        }
        /* Container needed to position the overlay. Adjust the width as needed */
        .container_card {
        position: relative;
        width: 200px;
        max-width: 200px;
        }
        /* Make the image to responsive */
        .image_card {
            display: block;
            width: 200px;
            height: 270px;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
        }

        /* The overlay effect - lays on top of the container and over the image */
        .overlay_card {
            position: absolute; 
            top: 0; 
            background: rgb(0, 0, 0);
            background: rgb(154 154 154 / 50%); /* Black see-through */
            color: #f1f1f1; 
            width: 100%;
            height: 270px;
            transition: .5s ease;
            opacity:0;
            color: white;
            font-size: 20px;
            padding: 20px;
            text-align: center;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
        }

        /* When you mouse over the container, fade in the overlay title */
        .container_card:hover .overlay_card {
        opacity: 1;
        }

    </style>
@endsection

@section('content-header',"Stamp Campaigns")

@section('main_content')


<div class="col-sm-12">
    <div class="box box-primary">
        <div class="box-body">
            <div class="main_page">
                <form id="form_validate">
                    @csrf
                    <input type="hidden" name="item_id" value="0" />

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Campaign Title:</label>
                                <input required name="campaign_title" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Action Text:</label>
                                <input required name="action_text" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Start Date:</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-calendar"></i></div>
                                    <input required name="start_date" type="datetime-local" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>End Date:</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-calendar"></i></div>
                                    <input required name="end_date" type="datetime-local" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 action_form">
                            <button onclick="clearForm()" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> New</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save/Apply</button>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Stamp Max Count:</label>
                                <select name="max_stamp_count" required class="form-control" id="stamp_max">
                                    @for ($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Spend amount required per stamp:</label>
                                <input required name="spend_required" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Info Button Link:</label>
                                <div class="input-group">
                                    <input name="info_button_link" required id="input_info_link" class="form-control" />
                                    <div class="input-group-btn">
                                        <button type="button" onclick="loadPartner({'target':'info_btn_link_choices','input':'input_info_link'})" class="btn btn-primary">Builder Link</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="info_btn_link_choices"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Prize Info Page Link:</label>
                                <div class="input-group">
                                    <input required name="prize_page_link" class="form-control" id="input_prize_info" />
                                    <div class="input-group-btn">
                                        <button type="button" onclick="loadPartner({'target':'prize_info_choices','input':'input_prize_info'})" class="btn btn-primary">Builder Link</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="prize_info_choices"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Motivation text (Per stamp # received):</label>
                                <div class="input-group">
                                    <div class="input-group-btn choices_stamp">
                                        <select class="form-control" id="stamp_indexing">
                                            <option>-</option>
                                        </select>
                                    </div>
                                    <input class="form-control" id="motivation_text" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea name="description" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="text">Partners Group :</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-users"></i></span>
                                <select required class="form-control" id="partner_groups" multiple="multiple" name="partner_groups"></select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="box box-primary">
        <div class="box-body">
            <div class="main_page">
                <div class="table_container">
                    <table class="table table-bordered table-striped" id="table_data">
                        <thead>
                            <tr>
                                <th>Campaign Title</th>
                                <th>Description</th>
                                <th>Default</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop



@section('javascript')
    <script>

        let stamp_max = null;
        let stamp_motivation = [];

        $("#stamp_max").change(function(e){
            stamp_max = $(this).find(":selected").val();
            stamp_motivation = [];
            for (let index = 1; index <= stamp_max; index++) {
                stamp_motivation.push({
                    "id":0,
                    "index":index,
                    "text":"",
                });
                render_stamp_indexing();
                $("#motivation_text").val("");
            }
        });

        function render_stamp_indexing() {
            $("#stamp_indexing").empty();
            stamp_motivation.map((item,index)=>{
                $("#stamp_indexing").append('<option value="'+item.index+'">'+item.index+'</option>');
            });
        }

        function searchingText(val) {
            let data = "";
            stamp_motivation.map((item,index)=>{
                if(item.index == val) data = item.text;
            });
            return data;
        }

        $("#stamp_indexing").change(function(e){
            console.log(stamp_motivation);
            let value = $(this).find(":selected").val();
            let text = searchingText(value);
            $("#motivation_text").val(text);
        });

        $("#motivation_text").keyup(function(){
            let value = $("#stamp_indexing").find(":selected").val();
            let val = $(this).val();
            stamp_motivation.map((item,index)=>{
                if(item.index == value) stamp_motivation[index].text = val;
            });
        });

    </script>

    <script>

        let json = {
            "scrdata_id": 1060,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 10000,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 1,
            "total_records": 3,
            "sample_profile_images": [],
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
            "order": [[ 0, "desc" ]],
            "responsive":true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": '{{ route("tastypointsapi.datatables") }}',
                "type": 'POST',
                "data": function(d){
                    d._token =  "{{ csrf_token() }}";
                    d.input = JSON.stringify(json);
                    d.scr_name = "stamp_campaign";
                    return d;
                },
                "dataSrc": function ( json ) {
                    console.log(json);
                    json.data.map((item,index)=>{
                        temp_data[item.id] = item;
                    });
                    return json.data;
                }  
            },
            "columns": [
                { 
                    data: "campaign_title",
                },
                { 
                    data: "campaign_title",
                    render:function(data,type,row){
                        return row.description == undefined ? "-" : row.description;
                    }
                },
                { 
                    data: "max_stamp_count",
                },
                { 
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="edit('+
                        "'"+row.id+"'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                        "'"+row.id+"'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });

        function getDataTemplate(options) {

            let elm = options.target;
            console.log(elm,options);
            let list_elm = elm.find(".dataPage");
            // return;

            let input = {
                "scrdata_id": 1182,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 50,
                "search_term": "",
                "search_term_header": "",
                "filter_template_id": 0,
                "filter_category_id":selected_category,
            };

            input.pagination = options.pagination;

            if(input.pagination <= 1) list_elm.empty();
            
            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                    list_elm.html('<i class="fas fa-notch fa-spin fa-3x loading"></i>');
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        response.data = JSON.parse(response.data);
                        response.data.landing_pages.map((item,index)=>{

                            item.landing_page_name = 
                            item.landing_page_name !== null && item.landing_page_name.length > 25 ? 
                            item.landing_page_name.substring(0,25)+" .." : 
                            item.landing_page_name;

                            let new_data = 
                            '<div class="card--content">'+
                                '<div class="container_card">'+
                                    '<img class="image_card"'+
                                        'src="'+item.landing_page_thumbnail_link+'"'+
                                    '/>'+
                                    '<div class="overlay_card">'+
                                        '<button onclick="selectedTemplate('+
                                        "'"+item.landing_page_web_link+"',"+
                                        "'"+show_status+"'"+
                                        ')" type="button" class="btn btn-default btn-lg select_template">Select Template</button>'+
                                    '</div>'+
                                    '<div class="item_footer">'+
                                        '<p>'+item.landing_page_name+'</p>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

                            list_elm.append(new_data);
                        });
                    }
                },
                error:function(error){
                    console.log(error);
                },
                complete:function(){
                    list_elm.find(".loading").hide();
                }
            });

        }

        let show_status = "";
        let pagination = 1;

        let input_target = null;

        function loadPartner(options) {

            const { target, input } = options;
            let elm = $("#"+target);

            input_target = input_target !== input ? input : null;
            
            elm.empty();

            if(show_status == target){
                elm.hide();
                show_status = "";
                pagination = 1;
                return;
            }

            if(show_status !== ""){
                pagination = 1;
                $("#"+show_status).hide();
            }

            show_status = target;

            let content_container = 
            '<div class="list_screen">'+
                '<div class="list_action">'+
                    '<div class="select_category">'+
                        '<div class="form-group">'+
                            '<select onChange="selectCategory(this)" class="form-control select_filter">'+
                                '<option value="0" selected>Selected template category</option>';
            
            temp_category.map((item,index)=>{
                content_container += '<option value="'+item.id+'">'+item.template_category_name+'</option>';
            });

            content_container += '</select>'+
                        '</div>'+
                    '</div>'+
                    '<div class="select_sortby">'+
                        '<div class="form-group form-inline">'+
                            '<label>Sort By</label>'+
                            '<select class="form-control select_filter">'+
                                '<option disabled selected>Date Added</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="list_data">'+
                    '<div class="dataPage">'+
                    '</div>'+
                '</div>'+
            '</div>';

            elm.html(content_container);
            elm.show();
            
            getDataTemplate({
                "target":elm,
                "pagination":pagination
            });
        }

        let selected_category = 0;
        function selectCategory(elm){
            let val = $(elm).val();
            selected_category = val;
            let target = $("#"+show_status);
            pagination = 1;
            getDataTemplate({
                "target":target,
                "pagination":pagination
            });
        }

        let temp_category = [];
        function load_category() {
            let input = {
                "scrdata_id": 1114,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };


            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){

                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);

                        temp_category = data.category_landing_page_template_list;

                    }
                },
                error:function(error){
                    console.log(error);
                },
                complete:function(){

                }
            });
        }

        function selectedTemplate(link) {
            console.log(input_target);
            $("#"+input_target).val(link);
            $("#"+show_status).hide();
            show_status = "";
        }

        $(document).ready(function(){
            load_category();
            $("#stamp_max").val(1).trigger("change");
        });

        $("#form_validate").validate({
            submitHandler:function(form){

                let formData = getFormData($(form));

                formData.motivation_text_per_stamp = stamp_motivation.map(
                    (item,index)=>{
                        return {
                            "id":item.id,
                            "stamp":item.index,
                            "motivation_text": item.text,
                            "delete": 0
                        }
                    }
                );
                
                let partner_groups = $("#partner_groups").val();
                formData.assigned_partner_group = [];
                for(key in partner_groups){
                    let value = parseInt(partner_groups[key]);
                    formData.assigned_partner_group.push(value);
                }

                let input = {
                    "scrdata_id": 1061,
                    "sp_name": "OK",
                    "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
                    "session_exp": "2021-02-05T10:16:49.619471",
                    "status": "OK",
                    "item_id": formData.item_id,
                    "max_row_per_page": 50,
                    "search_term": "",
                    "search_term_header": "",
                    "pagination": 1,
                    "total_records": 1,
                    "stamp_campaign": [formData],
                };

                console.log(input);
                let elm_submit = $("button[type=submit]");
                $.ajax({
                    url:"{{ route('tastypointsapi.testnet') }}",
                    type:"post",
                    data:{"input":JSON.stringify(input)},
                    beforeSend:function(){
                        elm_submit.attr("disabled");
                    },
                    success:function(response){
                        response = JSON.parse(response);
                        if(response.status){
                            
                            let data = JSON.parse(response.data);

                            swal("Data has been saved!",{icon:"success"});
                            otable.draw(false);
                            clearForm();

                        }
                    },
                    error:function(error){
                        console.log(error);
                    },
                    complete:function(){
                        elm_submit.removeAttr("disabled");
                    }
                });

            }
        });

        function clearForm() {
            let elm = $("#form_validate");
            elm.find("input").val("");
            elm.find("textarea").val("");
            elm.find("select").val("");
            elm.find("input[name=item_id]").val("0");
            $("#partner_groups").val("").trigger("change");
        }

        function edit(id) {
            let elm = $("#form_validate");
            let data = temp_data[id];
            // console.log(data,temp_data);
            elm.find("input[name=item_id]").val(data.id);
            elm.find("input[name=campaign_title]").val(data.campaign_title);
            elm.find("input[name=action_text]").val(data.action_text);
            elm.find("input[name=start_date]").val(data.start_date);
            elm.find("input[name=end_date]").val(data.end_date);
            elm.find("input[name=spend_required]").val(data.spend_required);
            elm.find("input[name=info_button_link]").val(data.info_button_link);
            elm.find("input[name=prize_page_link]").val(data.prize_page_link);

            data.description = data.description == undefined ? "" : data.description;
            elm.find("textarea[name=description]").val(data.description);

            elm.find("select[name=max_stamp_count]").val(data.max_stamp_count).trigger("change");
            stamp_max = data.max_stamp_count;
            stamp_motivation = data.motivation_text_per_stamp.map(
                (item,index)=>{
                    return {
                        "id":item.id,
                        "index":index,
                        "text":item.motivation_text,
                    };
            });
            $("#stamp_indexing").trigger("change");

            // console.log(data.assigned_partner_group);

            $("#partner_groups").val(data.assigned_partner_group).trigger("change");
        }

        function destroy(id) {
            
        }

        var data_partner_groups = [];

        function load_partner_groups() {
            let input = {
                "scrdata_id": 1232,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": 1,
                "search_term_header": "delivery_option_active",
                "pagination": 1,
                "total_records": 3,
            };

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        data.partner_groups.map((item,index)=>{
                            data_partner_groups.push( {"id":item.id,"text":item.name} );
                        });

                        $('#partner_groups').select2({
                            placeholder: "Select Partner Groups",
                            allowClear: true,
                            width:"100%",
                            data:data_partner_groups,
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $(document).ready(function(){
            load_partner_groups();
        });

    </script>
@endsection