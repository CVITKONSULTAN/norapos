@extends('tastypointsapi::marketing.partials.master')
@section( 'page_name', "Marketing Campagins - Landing Page Templates")

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
            max-width: 15%;
            position: absolute;
            left: 50px;
        }
        .select_sortby{
            max-width: 25%;
            float: right;
        }
        #dataPage{
            width: 100%;
            height: 100vh;
            overflow-x: hidden;
            overflow-y: scroll;
            padding-top: 10px;
        }
        #dataPage > .item {
            display: inline-block;
            width: 200px;
            border-radius: 10px;
            margin: 10px 5px;
        }
        .list_choices{
            text-align:center;
            display: inline-block;
            vertical-align: middle;
            width: 200px;
            padding: 30px 20px;
            border: 1px gray dotted;
            border-radius: 10px;
            margin: 0px 5px 10px 5px;
            height: 310px;
        }
        .list_data{
            padding: 0px 20px 30px 20px;
        }
        .list-container{
            width: 100%;
            background: white;
            border-radius: 10px;
            padding-bottom: 10px;
        }
        .list-container > .list-header{
            padding: 20px;
            background-color: white;
            box-shadow: 0 1px 1px rgb(0 0 0 / 10%);
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .list-container > .list-header > p{
            font-weight: 400;
            margin: 0px;
        }
        .back_btn {
            font-size: 20px;
            float: left;
        }
        .list-container > .list_item{
            list-style-type: none;
            padding-left: 0px;
            background: white;
            margin-top: 1px;
        }
        .list-container > .clear {
            background:white;
            height:20px;
            margin-top:10px;
        }
        .list-container > .list_item > li{
            padding: 10px 20px;
            font-weight: 400;
        }
        .list-container > .list_item > li.active{
            border-left: 3px #3c8dbc solid;
            font-weight: bold;
            padding-left: 15px;
        }
        .list-container > .list_item > li.active > a:hover{
            cursor: auto;
            font-weight: bold;
        }
        
        .list-container > .list_item > li > a {
            color: #66666a;
        }
        .list-container > .list_item > li > a:hover {
            font-weight: 500;
        }
        span.ctrl_action {
            float: right;
            color: #3c8dc3;
            cursor: pointer;
        }
        .create_new{
            padding: 10px 20px;
        }
        .cstm_preview{
            margin-top: 20px;
        }
        @media only screen and (min-width: 768px) {

            .desktop_view_menu {
                padding-right: 0px;
                margin-top: 10px;
            }

        }

    </style>

    <style>
        .select_template{
            background: transparent;
            border-radius: 50px;
            color: white;
            font-size: 11pt;
            margin:  10px 0px;
            border-style: dashed;
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
            padding-top: 20px;
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
            margin-top: 0px;
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
           /* text-align: center; */
       }
       .nav-tabs-custom {
           background: transparent;
           margin-bottom: 10px;
           max-height: 44px;
       }
       .ctrl_action{
           display: none;
       }
       .category_item{
           vertical-align: "-webkit-baseline-middle";
       }
   </style>
@endsection

@section('content-header',"Landing Page Template")

@section('main_content')

    <div class="modal fade" id="select_template">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <form id="useTemplate" >
                        @csrf
                        <input type="hidden" name="template_page_id" value="0" />

                        <div class="row cstm_preview">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input required name="landing_page_name" class="form-control" placeholder="Enter your landing page name" />
                                </div>
                                <div class="form-group">
                                    <input id="landing_page_web_link_name" maxlength="10" required name="landing_page_web_link" class="form-control" placeholder="Page link name" />
                                </div>
                                <div class="form-group">
                                    <textarea rows="5" name="landing_page_description" class="form-control" placeholder="Page link description"></textarea>
                                </div>
                                <div class="form-group">
                                    <select required name="landing_page_folder_id" class="form-control" id="select2">
                                        <option value="" disabled selected>Select Folder Name</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input id="random_id" name="random_id" type="checkbox" /> Use random id as page link name
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary">Next Step</button>
                            </div>
                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs nav_center">
                                        <li class="active">
                                          <a href="javascript:void(0)">Landingpage</a>
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

<div class="col-md-12 list_screen">

    <div class="row">
        
        <div class="col-md-12">
            <div class="list_action">
                <a class="back_btn" href="{{ URL::previous() }}"> <i class="fas fa-angle-left"></i> Back</a>
                <div class="select_sortby">
                    <div class="form-group form-inline">
                        <label>Sort By</label>
                        <select class="form-control select_filter">
                            <option disabled selected>Date Added</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-2 desktop_view_menu">
            <div class="list-container">
                <div class="list-header">
                    <p>Build from scratch</p>
                </div>
                <ul class="list_item" id="list_item_category"></ul>
                <a class="create_new" href="javascript:void(0)" onclick="categoryModal('create')">
                    Create new category
                </a>
            </div>
        </div>
        
        <div class="col-sm-10">
            <div class="list_screen">
                <div class="list_data">
                    <div id="dataPage">
                        <div class="list_choices">
                            <p style="
                                font-size: 20px;
                                font-weight: 300;
                            ">Build from scratch</p>
                            <p style="
                                color: #969696;
                            ">Start with a blank template and create your own design</p>
                            <i class="fas fa-box fa-3x" style="
                                margin: 25px;
                            "></i>
                            <a href="{{ route("marketing.landingpage.pagebuilder") }}" class="btn btn-default" style="
                                color: #49a1fd;
                                border-color: #49a1fd;
                            ">Start Building</a>
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
                            "scrdata_id": 1115,
                            "session_id": "{{ Request::get("session")->session_id }}",
                            "session_exp": "{{ Request::get("session")->session_exp }}",
                            "delete": 1,
                            "item_id":id,
                            "category_landing_page_template_list": [
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

            let elm = $("#list_item_category");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);

                        elm.empty();

                        data.category_landing_page_template_list.map((item,index)=>{

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
                        "scrdata_id": 1115,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = parseInt(gotForm.item_id);
                input.category_landing_page_template_list = [gotForm];
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
                "scrdata_id": 1110,
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

                        elm.contents().filter(function(){
                            return !$(this).is('.list_choices');
                        }).remove();

                        let template_pages_category_list = data.template_pages_category_list;

                        if(template_pages_category_list !== null){

                            template_pages_category_list.map((item,index)=>{

                                item = item.templates_list;
                                temp_List[item.id] = item;
                                // val.templates_list.map((item,)=>{
                                    // console.log(item);
                                    temp_List[item.id] = item;
                                    item.template_name = item.template_name.length > 25 ? item.template_name.substring(0,25)+" .." : item.template_name;
    
                                    let new_data = '<div class="card--content">'+
                                        '<div class="container_card">'+
                                            '<img class="image_card"'+
                                                'src="'+item.template_thumbnail_link+'"'+
                                            '/>'+
                                            '<div class="overlay_card">'+
                                                '<button class="btn btn-default btn-lg select_template" onclick="useTemplate('+item.id+')">Use Template</button>'+
                                                '<button class="btn btn-default btn-lg select_template" onclick="deleteTemplate('+item.id+')">Delete Template</button>'+
                                                '<button class="btn btn-default btn-lg select_template" onclick="editTemplate('+item.id+')">Edit Template</button>'+
                                                '<button class="btn btn-default btn-lg select_template" onclick="editTemplate('+item.id+')">View Pages</button>'+
                                            '</div>'+
                                            '<div class="item_footer">'+
                                                '<p>'+item.template_name+'</p>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
    
                                    elm.append(new_data);
    
                                // });
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
                    "scrdata_id": 1116,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                    "template_id":id,
                    "landing_page_id": 0,
                    "landing_page_variant_id": 0,
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
                        "scrdata_id": 1117,
                        "sp_name": "OK",
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                        "status": "OK",
                        "confirmation_code": confirmation_code,
                        "template_id": id,
                        "landing_page_id": 0,
                        "landing_page_variant_id": 0,
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

        let temp_folder = [];
        function load_folder() {
            let input = {
                "scrdata_id": 1180,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "nested_view": 1,
            };

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);
                        data = data.landing_page_folders;

                        let flattened = [];
                        data.forEach(tree => {
                            let prevDepth = -1
                            let stack = []

                            walkTree(tree, (item, depth) => {
                            
                                if (depth > prevDepth) {
                                    stack.push(item)
                                } else if (depth < prevDepth) {
                                    stack.pop()
                                }

                                let idChain = stack.map(item => item.id).join(".")
                                // let folderNameChain = stack.map(item => item.folder_name).join(" / ")
                                // let folder_name = idChain + " " + folderNameChain;

                                flattened.push({
                                    id: item.id,
                                    text: idChain+" - "+item.folder_name,
                                    level: depth + 1,
                                })
                            })
                        })

                        $("#select2").select2({
                            placeholder: 'Select Folder Name',
                            width: "100%",
                            data: flattened,
                            templateResult: formatResult,
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        function walkTree(item, callback, depth = 0) {
            callback(item, depth)
            if (item.sub_items !== null) {
                item.sub_items.forEach(subItem => {
                    walkTree(subItem, callback, depth + 1)
                })
            }
        }

        function formatResult(node) {
            var $result = $('<span style="padding-left:' + (10 * node.level) + 'px;">' + node.text + '</span>');
            return $result;
        };

        $(document).ready(function(){
            loadlist({});
            load_folder();
        });

        function useTemplate(id) {

            id = parseInt(id);
            let data = temp_List[id];


            let input = {
                "scrdata_id": 1111,
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
                        data = data.template_page_preview[0];
                        console.log(data);
                        $("#useTemplate input[name=template_page_id]").val(data.template_id);
                        $("#useTemplate input[name=landing_page_name]").val(data.template_name);
                        $("#useTemplate input[name=landing_page_web_link]").val("");
                        $("#useTemplate textarea[name=landing_page_description]").val(data.template_description);
                        // data.css_code = "b{font-size:5pt;}";
                        // data.html_code = "<html><body>Hello, <b>world</b>.</body></html>";
                        // console.log(data.html_code);
                        let html = "<html><style>"+data.css_code+"</style>"+data.html_code+"</html>";
                        // data.html_code = data.html_code.replace("<html>",css);
                        $("#iframe_preview").attr("srcdoc",html);
                        $("#select_template").modal("show");
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });

        }

        function makeid(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        $("#random_id").change(function(e){
            if($(this).is(":checked")){
                let id = makeid(10);
                $("#landing_page_web_link_name").val(id);
            }
        });

        function removeSpace() {
            let elm = $("#landing_page_web_link_name");
            let val = elm.val();
            val = val.split(" ").join("_");
            elm.val(val);
        }

        $("#landing_page_web_link_name").change(removeSpace);
        $("#landing_page_web_link_name").keyup(removeSpace);

        $("#useTemplate").validate({
            submitHandler:function(form){
                let input = {
                        "scrdata_id": 1112,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                gotForm.landing_page_folder = parseInt(gotForm.landing_page_folder);
                gotForm.template_page_id = parseInt(gotForm.template_page_id);
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

                                let url = "{{ route('marketing.landingpage.pagebuilder') }}/"+data.item_id+"/build";
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
            let url = "{{ route('marketing.landingpage.pagebuilder') }}/"+id+"/edit";
            location.href = url;
        }
    </script>
@endsection