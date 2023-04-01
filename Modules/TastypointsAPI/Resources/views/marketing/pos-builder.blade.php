@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | POS Template' )

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.16.30/css/grapes.min.css" />
    <link rel="stylesheet" href="/tasty/css/grapejs-newsletter.css"/>
    
    <style>
        .gjs-block-label, .gjs-sm-title,
        .gjs-clm-tags.gjs-one-bg.gjs-two-color,
        .gjs-sm-properties,
        .gjs-layer,
        .gjs-traits-label, .gjs-trt-traits,
        .gjs-blocks-cs, .gjs-trt-header
        {
        font-size: 1rem;
        }
                
        .gjs-editor-cont .fa {
        font-weight: 400;
        }

        .fa-square-o:before {
        content: "\f0c8";
        }

        .fa-arrows:before {
        content: "\f0b2";
        }

        .fa-trash-o:before {
        content: "\f1f8";
        }

        .fa-map-o:before {
        content: "\f279";
        }

        .fa-youtube-play:before {
        content: "\f04b";
        }

        /* Fix: open close chevrons: FA5 has the tags in different order ?!!? */
        .fa-chevron-right:before {
        content: "\f054";
        }

        .fa-chevron-down:before {
        content: "\f078";
        }

        .fa-arrows-v:before{
            content: "\f7a4";
        }

        .fa-html5:before{
            content: "\f121";
        }

    </style>

    <style>

        /* menu and title header list */
        .ctrl_btn {
            display: inline-block;
            vertical-align: super;
        }
        .nav-tabs-custom {
            display: inline-block;
            width: 65%;
            /* margin-bottom: 0px; */
            vertical-align: middle;
        }
        .nav-tabs-custom>.nav-tabs>li {
            border-bottom: 3px solid transparent;
            border-top: none;
            display: inline-block;
            float: none;
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
        #list_variants {
            background: transparent;
            /* margin-bottom: 10px; */
            min-height:45px;
            white-space: nowrap;
            flex-wrap: nowrap;
            max-width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 2px;
        }
        #list_variants::-webkit-scrollbar {
            height: 6px;
        }
        span.control_action i {
            margin-right: 3px;
            cursor: pointer;
            color: #2b80ec;
        }
        .control_action{
            display: none;
        }

        .menu_field {
            background: #f8f9fe;
            max-width: 200px;
            margin-right: 10px;
            border: none;
            border-bottom: 1px solid #837777;
            padding: 5px 5px;
        }
        input.menu_field:hover {
            color: black;
        }

        .menu_field:disabled {
            padding: 0;
            border: 0;
            cursor: pointer;
            background: white;
        }

        li#add_variants {
            background: #2b80ec;
            border-top-left-radius: 10px;
            margin-right: 0px;
        }
        li#add_variants a {
            color: white;
            font-weight: bold;
        }
        .save_action{
            display: none;
        }
        div.custom_btn{
            display: inline-block;
            vertical-align: top;
        }
        button.control_variants{
            border-radius: 0px;
            min-height: 45px;
        }
        button.control_variants.first{
            border-top-left-radius: 10px;
        }
        button.control_variants.first:hover, button.control_variants.first.active{
            background: white;
            color: #1572e8;
            border: 1px solid #1572e8;
        }
        #save_landing{
            display: none;
        }
    </style>

@endsection

@section('content')
@include('tastypointsapi::marketing.partials.nav')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 id="template_name">POS Template</h1>
    <p><small id="date_created"></small></p>
</section>

<!-- Main content -->
<section class="content">


    <div class="modal fade" id="variants">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Variants</h4>
                </div>
                <form id="variants_form">
                @csrf
                <input type="hidden" name="id" value="0" />
                <input type="hidden" name="index" value="-1" />
                
                <div class="modal-body">
                    <div class="form-group">
                        <input required name="receipt_name" class="form-control" placeholder="POS receipt name" />
                    </div>
                    <div class="form-group">
                        <textarea rows="5" name="receipt_description" class="form-control" placeholder="Email link description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="category_modals">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Category</h4>
                </div>
                <form id="select_category_form">
                @csrf
                
                <div class="modal-body">
                    <div class="form-group">
                        <select required name="category_id" class="form-control" id="select_category">
                            <option value="" disabled selected>Select Category</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="navigation_control">
        <div class="custom_btn">
        <button id="home" class="btn btn-primary control_variants first"><i class="fa fa-plane-arrival"></i></button>
        <button id="save_landing" onclick="saveVariants(-1)" class="btn btn-primary control_variants"><i class="fa fa-save"></i></button>
        <button id="add" onclick="addVariants()" class="btn btn-primary control_variants "><i class="fa fa-plus"></i></button>
        </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="list_variants"></ul>
        </div>
        <div class="ctrl_btn">
            <button onclick="cat_select('create',this)" id="create_template" class="btn btn-primary">Create Template</button>
            <button onclick="cat_select('update',this)" id="update_template" class="btn btn-primary">Update Template</button>
            <button id="save_btn" class="btn btn-primary">Save</button>
        </div>
    </div>

    <div id="gjs"></div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.16.30/grapes.min.js"></script>
<script src="/tasty/js/grapejs-newsletter.min.js"></script>

<script>
    function getFormData($form){
         var unindexed_array = $form.serializeArray();
         var indexed_array = {};
  
         $.map(unindexed_array, function(n, i){
             indexed_array[n['name']] = n['value'];
         });
  
         return indexed_array;
     }
</script>

<script type="text/javascript">
    var editor = grapesjs.init({
        container : '#gjs',
        plugins: ['gjs-preset-newsletter'],
        pluginsOpts: {
          'gjs-preset-newsletter': {
            modalTitleImport: 'Import template',
          }
        }
    });

    let page_id = {{ isset($id) ? $id : 0 }};
    let variants = [];

    let data_saved = {};

    function loadData() {
        let input = {
            "scrdata_id": 1186,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": page_id,
            "max_row_per_page": 50,
            "search_term": "",
            "search_term_header": "",
            "pagination": 1,
            "filter_template_id": 0,
            "filter_category_id": 0,
        };

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            beforeSend:function(){
                $("button").attr("disabled",true);
                editor.setComponents("");
            },
            complete:function(){
                $("button").removeAttr("disabled");
            },
            success:function(response){

                response = JSON.parse(response);

                if(response.status){

                    let data = JSON.parse(response.data);
                    data = data.receipt[0];
                    data.delete = 0;

                    data_saved = data;
                    console.log("saved",data_saved);

                    $("#template_name").text(data.receipt_name);
                    $("#date_created").text(data.date_created);

                    if(data.receipt_variants !== undefined && data.receipt_variants !== null){
                        variants = data.receipt_variants;
                    }

                    loadVariants();
                    selected_variant == null ? selectedVariants(-1) : selectedVariants(selected_variant,0);

                }
            }
        });

    }

    $(document).ready(function(){
        loadData();
    });

    function loadVariants() {

        let elm = $("#list_variants");

        elm.empty();

        variants.map((item,index)=>{

            let menu_item = '<li onclick="selectedVariants('+index+')" id="variants_id_'+index+'" class="">'+
                '<a href="javascript:void(0)">'+
                '<input disabled class="menu_field" required value="'+item.receipt_name+'" />'+
                '<span class="control_action">'+
                    '<i onclick="saveVariants('+index+')" class="fas fa-save"></i>'+
                    '<i onclick="editVariants('+index+')" class="fas fa-pencil-alt"></i>'+
                    '<i onclick="deleteVariants('+index+')" class="fas fa-trash"></i>'+
                '</span>'+
                '<span class="save_action"><button onclick="saveVariants('+index+')" class="btn btn-primary btn-sm"><i class="fas fa-save"></i></button></span>'+
                '</a>'+
            '</li>';

            elm.append(menu_item);

        });

    }

    function checkDataChanged(index){
        if(index == null) return false;
        const data = index >= 0 ? variants[index] : data_saved;
        const html = editor.getHtml();
        const css = editor.getCss();
        console.log(index);
        // console.log(mjml);
        console.log(data);
        return data.html_code !== html || data.css_code !== css ?  true : false;
    }

    let selected_variant = null;
    function selectedVariants(index,type) {

        // console.log(type);
        if(type !== undefined){
            // alert("work");
            if(index < 0){
                $("#save_landing").show();
                selected_variant = -1;
                $("#list_variants").find("li").removeClass("active");
                $(".control_action").hide();
                $("#home").addClass("active");
                editor.setComponents(data_saved.html_code);
                editor.setStyle(data_saved.css_code);
                return;
            }
            $("#save_landing").hide();
            let elm = $("#variants_id_"+index);
            $(".control_action").hide();
            $("#home").removeClass("active");
            let control = elm.find(".control_action");
            control.show();
            $("#list_variants li").removeClass("active");
            elm.addClass("active");
            const data = variants[index];
            if(data == undefined) return selectedVariants(-1,0);
            editor.setComponents(data.html_code);
            editor.setStyle(data.css_code);
            return;
        }

        if(selected_variant == index) return;


        const result = checkDataChanged(selected_variant);
        if(result){
            const r = confirm("Click the save button, so you do not lose any changes you've made.");
            if(!r) return;
        }

        if(index == -1){
            $("#home").trigger("click");
            return;
        }
        let elm = $("#variants_id_"+index);

        if(selected_variant !== index){

            $(".control_action").hide();

            $("#home").removeClass("active");

            selected_variant = index;

            let control = elm.find(".control_action");
            control.show();

            let data = variants[index];
            console.log(data);

            setToEditor(data);

            $("#list_variants li").removeClass("active");
            elm.addClass("active");

            $("#save_landing").hide();
        }
    }

    function setToEditor(data) {
        let html = "";
        // console.log(data);
        editor.setComponents(data.html_code);
        editor.setStyle(data.css_code);
    }

    $("#home").click(function(e){

        const result = checkDataChanged(selected_variant);
        if(result){
            const r = confirm("Click the save button, so you do not lose any changes you've made.");
            if(!r) return;
        }

        selected_variant = -1;
        $("#list_variants").find("li").removeClass("active");
        $(".control_action").hide();
        $("#save_landing").show();
        $(this).addClass("active");
        setToEditor(data_saved);
    });

    function dataURItoBlob(dataURI) {
        // convert base64/URLEncoded data component to raw binary data held in a string
        var byteString;
        if (dataURI.split(',')[0].indexOf('base64') >= 0)
            byteString = atob(dataURI.split(',')[1]);
        else
            byteString = unescape(dataURI.split(',')[1]);

        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

        // write the bytes of the string to a typed array
        var ia = new Uint8Array(byteString.length);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        return new Blob([ia], {type:mimeString});
    }

    function addVariants() {
        $("#variants_form input").val("");
        $("#variants_form input[name=id]").val(0);
        $("#variants_form input[name=index]").val(-1);
        $("#variants_form textarea").val("");
        $("#variants").modal("show");
    }

    function deleteVariants(index) {
        variants.splice(index,1);
        $("#variants_id_"+index).remove();

        let i = 0;
        if(variants.length > 1) 
        i = variants.length - 1 ;
        selectedVariants(i);

    }

    function editVariants(index) {
        let data = variants[index];
        $("#variants_form input[name=index]").val(index);
        $("#variants_form input[name=id]").val(data.id);
        $("#variants_form input[name=receipt_name]").val(data.receipt_name);
        $("#variants_form input[name=receipt_description]").val(data.receipt_description);
        $("#variants").modal("show");
    }

    async function saveVariants(index) {
        const html = editor.getHtml();
        const css = editor.getCss();
        let sc = -1;
        if(index >= 0) {
            const data = variants[index];
            data.html_code = html;
            data.css_code = css;
            variants[index] = data;
            sc = index;
        } else {
            data_saved.html_code = html;
            data_saved.css_code = css;
        }
        await takeScreenshot(sc).then( async (res) => {
            await savePage();
        });
    }

    function removeSpace() {
        let elm = $("#email_message_web_link_name");
        let val = elm.val();
        val = val.split(" ").join("_");
        elm.val(val);
    }

    $("#email_message_web_link_name").change(removeSpace);
    $("#email_message_web_link_name").keyup(removeSpace);

    $("#variants_form").validate({
        submitHandler:function(form){

        let data = getFormData($(form));
        data.index = parseInt(data.index);

        if(data.index < 0){
            data.html_code = data_saved.html_code;
            data.css_code = data_saved.css_code;
            data.delete = 0;
            variants.push(data);
        } else {

            let variant = variants[data.index];

            for (key in data) {
                const value = data[key];
                variant[key] = value;
            }

            console.log(variant);

            variants[data.index] = variant;
        }
            
            $("#variants").modal("hide");
            loadVariants();

            // console.log(selected_variant);
            selectedVariants(selected_variant,0);

            // selected_variant = -1;
            // selectedVariants(data.index);

            return false;
        }
    });

    $("#save_btn").click(savePage);

    async function savePage() {

        $("#save_btn").attr("disabled",true);
        $("#save_btn").html('<i class="fas fa-circle-notch fa-spin"></i>');

        await sendServer();
        await loadData();
        return selectedVariants(selected_variant,0);
    }

    async function takeScreenshot(index) {
        
        let elm = $(".gjs-frame").contents().find('body');
        let formData = new FormData();

        await html2canvas(elm[0]).then(canvas =>{
            window.body.appendChild(canvas);
            $("canvas").hide();
            
            img_b64 = canvas.toDataURL('image/png');
            //Create blob from DataURL
            blob = dataURItoBlob(img_b64);

            // Pass the image file name as the third parameter if necessary.
            formData.append('file', blob, 'image.png');
            
        });

        // Use `jQuery.ajax` method for example
        return $.ajax({
            url:'{{ route("tastypointsapi.upload","image") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success(response) {
            console.log(response);
            if(index < 0){
                data_saved.receipt_thumbnail_link = response.link;
            } else {
                variants[index].receipt_thumbnail_link = response.link;
            }
            },
            error(error) {
                console.log('Upload error',error);
            },
        });

    }

    function convertData() {
        let splitter = "'";
        let joiner = "''";
        data_saved.html_code = data_saved.html_code.split(splitter).join(joiner);
        data_saved.css_code = data_saved.css_code.split(splitter).join(joiner);
        return variants.map((item,index)=>{
            item.html_code = item.html_code.split(splitter).join(joiner);
            item.css_code = item.css_code.split(splitter).join(joiner);
            delete item.save_as_new_template;
            return item;
        });
    }

    function sendServer() {

        data_saved.delete = 0;
        // data_saved.email_message_variants = convertData();
        data_saved.receipt_variants = convertData();

        delete data_saved.save_as_new_template;


        let input = {
            "scrdata_id": 1133,
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "item_id": page_id,
            "pos_receipt_load_builder": data_saved,
        };

        console.log(input);

        return $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            beforeSend:function(){
                // $("#save_btn").html("Loading...");
                // $("#save_btn").attr("disabled");
            },
            success:function(response){
                console.log(response);
                response = JSON.parse(response);
                if(response.status){

                let data = JSON.parse(response.data);
                console.log(data);

                swal("Data has been saved",{
                    icon:"success"
                });
                }
            },
            complete:function(){
                $("#save_btn").html("Save");
                $("#save_btn").removeAttr("disabled");
            }
        });

    }

    function convertDataTemplate(type) {
        let splitter = "'";
        let joiner = "''";
        data_saved.html_code = data_saved.html_code.split(splitter).join(joiner);
        data_saved.css_code = data_saved.css_code.split(splitter).join(joiner);
        variants.map((item,index)=>{

            variants[index].html_code = item.html_code.split(splitter).join(joiner);

            variants[index].css_code = item.css_code.split(splitter).join(joiner);

            variants[index].delete = 0;

            item.receipt_description = item.receipt_description == undefined ? "" : item.receipt_description;

            let save_as_new_template = {
                "template_category_id":cat_id,
                "new_template_name": item.receipt_name,
                "new_template_description": item.receipt_description,
                "overwrite_origin_template": 0,
                "create_new_template": 0
            };

            if( 
                (selected_variant == null || selected_variant >= 0) 
                && selected_variant == index
            ) {

                if(type == "create") {
                    save_as_new_template.overwrite_origin_template = 0;
                    save_as_new_template.create_new_template = 1;
                } 

                if(type == "update") {
                    save_as_new_template.overwrite_origin_template = 1;
                    save_as_new_template.create_new_template = 1;
                }

            }

            variants[index].save_as_new_template = save_as_new_template;

            // takeScreenshot(index);

        });
    }

    let type_update = null;
    function cat_select(type) {
        type_update = type;
        $("#category_modals select").val("");
        $("#category_modals").modal("show");
    }

    $("#select_category_form").validate({
        submitHandler:function(form){
            send_template(type_update);
            $("#category_modals").modal("hide");
        }
    });

    async function send_template(type) {

        let elm = type == "create" ? $("create_template") : $("#update_template");

        await saveVariants(selected_variant);

        elm.attr("disabled",true);
        elm.html('<i class="fas fa-circle-notch fa-spin"></i>');

        await convertDataTemplate(type);

        data_saved.delete = 0;

        data_saved.receipt_description = data_saved.receipt_description == undefined ? "" : data_saved.landing_page_description;

        data_saved.save_as_new_template = {
            "template_category_id":cat_id,
            "new_template_name": data_saved.receipt_name,
            "new_template_description": data_saved.receipt_description,
            "overwrite_origin_template": 0,
            "create_new_template": 0
        };

        if(selected_variant == null || selected_variant < 0) {
            if(type == "create") {
            data_saved.save_as_new_template.overwrite_origin_template = 0;
            data_saved.save_as_new_template.create_new_template = 1;
            } 

            if(type == "update") {
            data_saved.save_as_new_template.overwrite_origin_template = 1;
            data_saved.save_as_new_template.create_new_template = 1;
            } 
        }

        let input = {
            "scrdata_id": 1133,
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "item_id": 0,
            "pos_receipt_load_builder": data_saved,
        };
        console.log("Request : ",input);

        return $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            beforeSend:function(){
                // elm.attr("disabled");
                // elm.html('<i class="fas fa-circle-notch fa-spin"></i>');
            },
            success:function(response){
                 // console.log(response);
                response = JSON.parse(response);
                if(response.status){

                    let data = JSON.parse(response.data);
                    // console.log(data);

                    swal("Data has been saved",{
                    icon:"success"
                    });

                    // alert(JSON.stringify(input));
                    // $("#request_json").html(JSON.stringify(input,2,null));
                    // $("#debug").modal("show");

                }
            },
            complete:function(){
                elm.removeAttr("disabled");

                elm.html(type+" template");
                $("#category_modals").modal("hide");
            }
        });
    }

</script>

<script>

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

        let elm = $("#select_category");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);

                    data.template_pos_receipt_category_list.map((item,index)=>{

                        temp_category[item.id] = item;

                        elm.append('<option value="'+item.id+'">'+item.template_category_name+'</option>');
                    });

                    elm.select2({
                        width:"100%",
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

    let cat_id = "";
    $("#select_category").change(function(){
        cat_id = $(this).val();
        cat_id = parseInt(cat_id);
    });


</script>

@endsection