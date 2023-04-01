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
        .navigation_control{
            background: white;
            margin-bottom: 20px;
        }
    </style>

@endsection

@section('content')
@include('tastypointsapi::marketing.partials.nav')

<!-- Content Header (Page header) -->
{{-- <section class="content-header">
    <h1 id="template_name">POS Template</h1>
    <p><small id="date_created"></small></p>
</section> --}}

<!-- Main content -->
<section class="content">

    <form id="form_validate">
        @csrf
        <input type="hidden" name="item_id" value="0"/>
  
        <div class="navigation_control form-inline">
          <button type="button" style="border-radius:0px;border-top-left-radius: 10px;min-height: 35px;min-width: 35px;" class="btn btn-primary"></button>
          <div class="form-group">
            <input style="min-width: 300px;" required placeholder="Template name" class="form-control" name="new_template_name" />
          </div>
          <div class="form-group">
            <input style="min-width: 300px;" placeholder="Template description" class="form-control" name="new_template_description" />
          </div>
          <div class="form-group">
            <select required id="select_category" class="form-control" name="template_category_id">
              <option value="" selected disabled>Select template category</option>
            </select>
          </div>
          <button id="save_btn" type="submit" class="btn btn-primary">Save</button>
        </div>

    </form>

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

    $(document).ready(function(){
        editor.setComponents("");
    });

    // let html = '<div class="ticket"> <img src="/images/logo.png" alt="Logo"> <p class="centered">RECEIPT EXAMPLE <br>Address line 1 <br>Address line 2</p> <table> <thead> <tr> <th class="quantity">Q.</th> <th class="description">Description</th> <th class="price">$$</th> </tr> </thead> <tbody> <tr> <td class="quantity">1.00</td> <td class="description">ARDUINO UNO R3</td> <td class="price">$25.00</td> </tr> <tr> <td class="quantity">2.00</td> <td class="description">JAVASCRIPT BOOK</td> <td class="price">$10.00</td> </tr> <tr> <td class="quantity">1.00</td> <td class="description">STICKER PACK</td> <td class="price">$10.00</td> </tr> <tr> <td class="quantity"></td> <td class="description">TOTAL</td> <td class="price">$55.00</td> </tr> </tbody> </table> <p class="centered">Thanks for your purchase! <br>parzibyte.me/blog</p> </div>';
    // editor.setComponents(html);
    // let style = "* { font-size: 12px; font-family: 'Times New Roman'; } td, th, tr, table { border-top: 1px solid black; border-collapse: collapse; } td.description, th.description { width: 75px; max-width: 75px; } td.quantity, th.quantity { width: 40px; max-width: 40px; word-break: break-all; } td.price, th.price { width: 40px; max-width: 40px; word-break: break-all; } .centered { text-align: center; align-content: center; } .ticket { width: 155px; max-width: 155px; } img { max-width: inherit; width: inherit; }  .ticket{ margin: 5px auto; } @media print { .hidden-print, .hidden-print * { display: none !important; } }";
    // editor.setStyle(style);

    // editor.on("component:update",(some, argument)=>{

    //     const html = editor.getHtml() ;
    //     // const html = editor.runCommand('mjml-get-code').html;
    //     let css = editor.getCss();
    //     let data = variants[selected_variant];

    //     if(data !== undefined){

    //         data.html_code = html;
    //         data.css_code = css;
    //         // data.mjml_code = mjml;
    //         console.log(data);
    //         return;
    //     }

    //     data_saved.html_code = html;
    //     data_saved.css_code = css;
    //     // data_saved.mjml_code = mjml;
    //     console.log(data_saved);

    // });

    let input = {
        "origin_template_info": {
                "template_id": 0,
                "template_name": "",
                "template_description": "",
                "template_thumbnail_link": "",
                "template_category_id":0,
        },
        "id": 0,
        "receipt_name": "",
        "receipt_description": "",
        "html_code": "",
        "css_code": "",
        "receipt_thumbnail_link": "",
        "receipt_web_link": "",
        "public": 0,
        "date_created": "",
        "delete": 0,
        "receipt_category_id":0,
        "receipt_variants": [],
        "save_as_new_template": {
          "template_category_id": 0,
          "new_template_name": "",
          "new_template_description": "",
          "overwrite_origin_template": 0,
          "create_new_template": 1
        }
    };

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


    async function savePage() {

        $("#save_btn").attr("disabled",true);
        $("#save_btn").html('<i class="fas fa-circle-notch fa-spin"></i>');
        return await takeScreenshot().then( async (res) => {
          return await sendServer();
        });

    }

    $("#form_validate").validate({
        submitHandler:function(form){

            let data = getFormData($(form));
            console.log(data);

            input.html_code = editor.getHtml().split("'").join("''");
            input.css_code = editor.getCss().split("'").join("''");
            input.receipt_name = data.new_template_name;
            input.receipt_description = data.new_template_description;
            input.receipt_category_id = parseInt(data.template_category_id);

            input.origin_template_info.template_category_id = parseInt(data.template_category_id);
            input.origin_template_info.template_name = data.new_template_name;
            input.origin_template_info.template_description = data.new_template_description;
            
            
            input.save_as_new_template.new_template_name = data.new_template_name;
            input.save_as_new_template.new_template_description = data.new_template_description;
            input.save_as_new_template.template_category_id = parseInt(data.template_category_id);
            // console.log(input);
            
            savePage();

        }
    });

    async function takeScreenshot() {
        
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

        // console.log(formData);

        // Use `jQuery.ajax` method for example
        return $.ajax({
            url:'{{ route("tastypointsapi.upload","image") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success(response) {
                // console.log(response);
                input.receipt_thumbnail_link = response.link;
                input.save_as_new_template.template_thumbnail_link = response.link;
            },
            error(error) {
                console.log('Upload error',error);
            },
        });

    }

    function sendServer() {

        let json = {
            "scrdata_id": 1133,
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "item_id": 0,
            "pos_receipt_load_builder": input,
        };

        console.log(json);

        return $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(json)},
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