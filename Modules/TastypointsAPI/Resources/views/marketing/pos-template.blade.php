@extends('tastypointsapi::marketing.partials.master')
@section( 'page_name', "Marketing Campagins - POS receipt template")

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
            height: 40px;
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
        }
        #dataPage{
            width: 100%;
            height: 350px;
            overflow-x: auto;
            overflow-y: hidden;
            text-align: center;
            white-space: nowrap;
        }
        #dataPage > .item {
            display: inline-block;
            width: 200px;
            border-radius: 10px;
            margin: 10px 5px;
        }
        .list_data{
            padding: 30px 20px;
        }

        .select_template{
            background: transparent;
            border-radius: 50px;
            color: white;
            font-size: 11pt;
            margin:  10px auto;
            border-style: dashed;
            display: block;
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
            margin-bottom: 50px;
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
            padding-top: 50px;
            text-align: center;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
        }

        /* When you mouse over the container, fade in the overlay title */
        .container_card:hover .overlay_card {
            opacity: 1;
        }

        .modal-content {
            border-radius: 10px;
        }
        .preview_template{
            max-height: 300px;
            margin-top: 20px;
        }

    </style>

    <style>
         /* menu and title header list */
        .nav-tabs-custom>.nav-tabs>li {
            border-bottom: 3px solid transparent;
            border-top: none;
        }
        .nav-tabs-custom>.nav-tabs>li.active {
            border-bottom-color: #3c8dbc;
            border-top-color: transparent;
        }
        .nav-tabs-custom>.nav-tabs>li.active>a {
            background-color: transparent;
        }
        .nav-tabs-custom>.nav-tabs>li>a {
            font-size: 10pt;
            font-weight: 500;
        }
        .nav_center{
            display: inline-block;
        }
        .nav-tabs-custom{
            text-align: center;
        }
        .nav-tabs-custom {
            background: transparent;
            margin-bottom: 10px;
            max-height: 44px;
        }
        .nav-tabs-custom>.nav-tabs>li.active>a:hover {
            background-color: transparent;
        }
        .ctrl_action{
            display: none;
            cursor: pointer;
            margin-left: 5px;
        }
    </style>
@endsection

@section('content-header',"POS receipt template")

@section('main_content')

    <div class="modal fade" id="select_template">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <form id="useTemplate" >
                        @csrf
                        <input type="hidden" name="template_receipt_id" value="0" />

                        <div class="row cstm_preview">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input required name="pos_receipt_name" class="form-control" placeholder="POS receipt name" />
                                </div>
                                {{-- <div class="form-group">
                                    <input id="email_message_web_link_name" maxlength="10" required name="pos_receipt_web_link" class="form-control" placeholder="POS receipt link name" />
                                </div> --}}
                                <div class="form-group">
                                    <textarea rows="5" name="pos_receipt_description" class="form-control" placeholder="Email link description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary">Next Step</button>
                            </div>
                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs nav_center">
                                        <li class="active">
                                        <a href="javascript:void(0)">Preview</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="embed-responsive embed-responsive-4by3 preview_template">
                                    <iframe id="iframe_preview" class="embed-responsive-item" allowfullscreen srcdoc=""></iframe>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="category_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Modal Category Header</h4>
                </div>
                <div class="modal-body">
                    <form id="category_form">
                        @csrf
                        <input type="hidden" name="item_id" value="0" />

                        <div class="form-group">
                            <input required name="template_category_name" class="form-control" placeholder="Enter category name" />
                        </div>
                        <div class="form-group">
                            <textarea name="template_category_description" rows="5" class="form-control" placeholder="Category description"></textarea>
                        </div>
                        <div class="btn_ctrl text-right">
                            <button class="btn btn-primary">Save & Apply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="preview">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Preview Template
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </p>
                    <div class="form-group">
                        <input class="form-control" placeholder="Enter receipt template name" />
                    </div>
                    <div class="embed-responsive embed-responsive-4by3 preview_template">
                        <iframe class="embed-responsive-item" src="https://tastypos.onprocess.work/" allowfullscreen></iframe>
                    </div>
                    <div class="text-center" style="margin-top: 10px;">
                        <a href="{{ route("marketing.pos.pagebuilder") }}" class="btn btn-primary btn-sm">Load in builder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="main_page">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="list_screen">
                                <div class="list_action">
                                    <div class="title_header">
                                        <h4 class="text-center"> Design and content</h4>
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs nav_center" id="list_category">
                                                <li id="add_btn"><a onclick="categoryModal('create')" href="javascript:void(0)"><i class="fas fa-plus"></i> Add category</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="select_category">
                                        {{-- <div class="form-group">
                                            <select class="form-control select_filter">
                                                <option disabled selected>Selected template category</option>
                                            </select>
                                        </div> --}}
                                        <a href="{{ route('marketing.pos.pagebuilder') }}" class="btn btn-primary">Build from scratch</a>
                                    </div>
                                    <div class="select_sortby">
                                        <div class="form-group form-inline">
                                            <label>Sort By</label>
                                            <select class="form-control select_filter">
                                                <option disabled selected>Date Added</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="list_data">
                                    <div id="dataPage">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop



@section('javascript')

<script>

    function categoryModal(type,id = 0) {
        let text = "Create new category";
        switch (type) {
            case "edit":
                text = "Edit Category";
                break;
        }
        $("#category_modal input[name=item_id]").val(id);
        if(id !== 0){
            let data = temp_category[id];
            $("#category_modal input[name=template_category_name]").val(data.template_category_name);
            $("#category_modal textarea[name=template_category_description]").val(data.template_category_description);
        } else {
            $("#category_modal input[name=template_category_name]").val("");
            $("#category_modal textarea[name=template_category_description]").val("");
        }
        $("#category_modal .modal-title").text(text);
        $("#category_modal").modal("show");
    }

    function deleteData(id) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                let input = {
                        "scrdata_id": 1135,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                        "delete": 1,
                        "item_id":id,
                        "template_pos_receipt_category_list": [
                            {
                                "id": id,
                                "detele":1
                            }
                        ]
                };
                console.log(input);

                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            load_category();
                            swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                            });
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });

                });
               
            }
        });
    }

    let selected_category = null;

    function selectedCategory(id) {

        selected_category = id;

        let data = temp_category[id];
        let all_elm = $(".category_item");
        all_elm.removeClass("active");
        all_elm.find(".ctrl_action").hide();

        let elm = $("#category_item_"+id);
        elm.addClass("active");
        elm.find(".ctrl_action").show();

        loadlist({
            "filter_category_id":id
        });
    }

    let temp_category = [];
    function load_category() {
        let input = {
            "scrdata_id": 1134,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 1000,
            "search_term": "",
            "search_term_header":"",
        };

        let elm = $("#list_category");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);
                    
                    elm.find("li").not('#add_btn').remove();

                    data.template_pos_receipt_category_list.map((item,index)=>{

                        temp_category[item.id] = item;

                        let new_data = '<li class="category_item" id="category_item_'+item.id+'">'+
                            '<a href="javascript:void(0)" onclick="selectedCategory('+item.id+')">'+
                                item.template_category_name+
                                '<span class="ctrl_action">'+
                                    '<i class="fas fa-pencil-alt" onclick="categoryModal('+"'edit'"+','+item.id+')"></i> '+
                                    '<i class="fas fa-trash" onclick="deleteData('+item.id+')"></i>'+
                                '</span>'+
                            '</a>'+
                        '</li>';

                        elm.append(new_data);
                    });

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    $(document).ready(function(){
        load_category();
    });

    $("#category_form").validate({
        submitHandler:function(form){
            let input = {
                    "scrdata_id": 1135,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
            };
            let gotForm = getFormData($(form));
            input.item_id = parseInt(gotForm.item_id);
            input.template_pos_receipt_category_list = [gotForm];
            console.log(input);

            Pace.track(function(){

                $.ajax({
                    url:'{{ route("tastypointsapi.testnet") }}',
                    type:"post",
                    data:{"input":JSON.stringify(input)},
                    success:function(response){
                        load_category();
                        $("#category_modal").modal("hide");
                    },
                    error:function(error){
                        console.log(error);
                    }
                });

            });
        }
    });
</script>

<script>

    let temp_List = [];
    function loadlist(option) {
        let options = {
            "filter_category_id": 0,
            "filter_category_name": "",
            "filter_date_created_from": "",
            "filter_date_created_till": "",
        };
        if(option !== undefined){
            options = option;
        }
        let input = {
            "scrdata_id": 1130,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 1000,
            "search_term": "",
            "search_term_header":"",
        };

        input = {...input,...options};

        let elm = $("#dataPage");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);

                    let template_receipt_category_list = data.template_receipt_category_list;

                    elm.empty();

                    if(template_receipt_category_list !== null){

                        template_receipt_category_list.map((item,index)=>{

                            item = item.templates_list;
                            temp_List[item.id] = item;
                         
                                temp_List[item.id] = item;
                                item.template_name = item.template_name !== null && item.template_name.length > 25 ? item.template_name.substring(0,25)+" .." : item.template_name;

                                let new_data = '<div class="card--content">'+
                                    '<div class="container_card">'+
                                        '<img class="image_card"'+
                                            'src="'+item.template_thumbnail_link+'"'+
                                        '/>'+
                                        '<div class="overlay_card">'+
                                            '<button class="btn btn-default btn-lg select_template" onclick="useTemplate('+item.id+')">Use Template</button>'+
                                            '<button class="btn btn-default btn-lg select_template" onclick="deleteTemplate('+item.id+')">Delete Template</button>'+
                                            '<button class="btn btn-default btn-lg select_template" onclick="editTemplate('+item.id+')">Edit Template</button>'+
                                        '</div>'+
                                        '<div class="item_footer">'+
                                            '<p>'+item.template_name+'</p>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';

                                elm.append(new_data);

                        });

                    }

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    function deleteTemplate(id) {
        id = parseInt(id);
        let input = {
                "scrdata_id": 1136,
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "template_id":0,
                "receipt_id": id,
                "confirmation_id": 0
        };

        console.log("request confirmation",input);

        Pace.track(function(){

            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        // console.log(data.here_is_the_confirmation_code);
                        destroyTemplate(data.here_is_the_confirmation_code,id);
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });

        });
        
    }

    function destroyTemplate(confirmation_code,id) {

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                let input = {
                    "scrdata_id": 1137,
                    "sp_name": "OK",
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                    "status": "OK",
                    "template_id": 0,
                    "receipt_id": id,
                    "confirmation_code": confirmation_code,
                };
                // console.log("request confirmed",input);

                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            response = JSON.parse(response);
                            if(response.status){
                                let data = JSON.parse(response.data);
                                // console.log("result",data);
                                loadlist({});
                                swal("Poof! Your imaginary file has been deleted!", {
                                    icon: "success",
                                });
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

    $(document).ready(function(){
        loadlist({});
    });

    function useTemplate(id) {

        id = parseInt(id);
        let data = temp_List[id];


        let input = {
            "scrdata_id": 1131,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id":id,
        };

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);
                    data = data.template_receipt_preview[0];

                    $("#useTemplate input[name=template_receipt_id]").val(data.template_id);
                    $("#useTemplate input[name=pos_receipt_name]").val(data.template_name);
                    $("#useTemplate input[name=pos_receipt_description]").val(data.template_description);

                    let css = "<html><style>"+data.css_code+"</style>";
                    data.html_code = data.html_code.replace("<html>",css);

                    $("#iframe_preview").attr("srcdoc",data.html_code);
                    $("#select_template").modal("show");
                }
            },
            error:function(error){
                console.log(error);
            }
        });

    }

    $("#useTemplate").validate({
        submitHandler:function(form){
            let input = {
                    "scrdata_id": 1132,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
            };
            let gotForm = getFormData($(form));
            
            input = {...input,...gotForm};

            Pace.track(function(){

                $.ajax({
                    url:'{{ route("tastypointsapi.testnet") }}',
                    type:"post",
                    data:{"input":JSON.stringify(input)},
                    success:function(response){
                        response = JSON.parse(response);
                        if(response.status){

                            let data = JSON.parse(response.data);
                            console.log(data);
                            let url = "{{ route('marketing.pos.pagebuilder') }}/"+data.item_id+"/build";
                            location.href = url;

                            swal("Data has been saved",{
                                icon:"success"
                            });

                            $("#select_template").modal("hide");
                        }
                    },
                    error:function(error){
                        console.log(error);
                    }
                });

            });
        }
    });

    function editTemplate(id) {
        let url = "{{ route('marketing.newsletter.pagebuilder') }}/"+id+"/edit";
        location.href = url;
    }

    function removeSpace() {
        let elm = $("#email_message_web_link_name");
        let val = elm.val();
        val = val.split(" ").join("_");
        elm.val(val);
    }

    $("#email_message_web_link_name").change(removeSpace);
    $("#email_message_web_link_name").keyup(removeSpace);
</script>
@endsection