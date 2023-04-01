@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | Newletter Template' )

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
    </style>

    <style>
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
    <h1 id="template_name">Newsletter Template</h1>
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

    <div id="gjs">
      <mjml>
        <mj-body>
          <!-- Your MJML body here -->
          <mj-section>
            <mj-column>
              <mj-text>My Company</mj-text>
            </mj-column>
          </mj-section>
        </mj-body>
      </mjml>
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.16.30/grapes.min.js"></script>
{{-- <script src="/tasty/js/grapejs-newsletter.min.js"></script> --}}
<script src="/tasty/vendor/grapesjs/grapesjs-mjml/dist/grapesjs-mjml.min.js"></script>

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

    let default_components = {
      mjml:`<mjml><mj-body></mj-body></mjml>`,
      html:null,
      css:null
    };

    var editor = grapesjs.init({
        container : '#gjs',
        components: default_components.mjml,
        plugins: [
            'grapesjs-mjml'
        ],
        pluginsOpts: {
            'grapesjs-mjml': {
                "resetDevices":false,
                "resetBlocks":true,
            }
        }
    });

    $(document).ready(function(){
        editor.setComponents(default_components.mjml);
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

    function savePage() {
        $("#save_btn").html('<i class="fas fa-circle-notch fa-spin"></i>');
        $("#save_btn").attr("disabled");
        takeScreenshot();
    }

    $("#form_validate").validate({
        submitHandler:function(form){

            let data = getFormData($(form));

            input.email_message_name = data.new_template_name;
            input.email_message_description = data.new_template_description;
            input.email_message_category_id = parseInt(data.template_category_id);
            input.save_as_new_template.template_category_id = parseInt(data.template_category_id);

            input.save_as_new_template.new_template_name = data.new_template_name;
            input.save_as_new_template.new_template_description = data.new_template_description;
            
            savePage();

        }
    });

    function takeScreenshot() {
        
        let elm = $(".gjs-frame").contents().find('body');

        html2canvas(elm[0]).then(canvas =>{
          window.body.appendChild(canvas);
          $("canvas").hide();
          
          img_b64 = canvas.toDataURL('image/png');
          //Create blob from DataURL
          blob = dataURItoBlob(img_b64);
          
          const formData = new FormData();

          // Pass the image file name as the third parameter if necessary.
          formData.append('file', blob, 'image.png');

          // Use `jQuery.ajax` method for example
          $.ajax({
              url:'{{ route("tastypointsapi.upload","image") }}',
              method: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success(response) {
                  input.email_message_thumbnail_link = response.link;
                  sendServer();
              },
              error(error) {
                  console.log('Upload error',error);
              },
          });
          
        });
      
    }

    let input = {
        "id": 0,
        "email_message_name": "Email name",
        "email_message_description": "Email description",
        "title": "this is the title",
        "html_code": "<html>",
        "mjml_code": "<MJML>",
        "css_code": "<CSS>",
        "email_message_thumbnail_link": "Email thumbnail link",
        "email_message_web_link": "",
        "public": 0,
        "date_created": null,
        "email_message_variants":null,
        "delete": 0,
        "save_as_new_template":{
            "template_category_id": 0,
            "new_template_name": "",
            "new_template_description": "",
            "overwrite_origin_template": 0,
            "create_new_template": 1
        },
    };

    function sendServer() {
        
        input.html_code = editor.runCommand('mjml-get-code').html;
        input.mjml_code = editor.getHtml();
        input.css_code = editor.getCss();

        let splitter = "'";
        let joiner = "''";
        input.html_code = input.html_code.split(splitter).join(joiner);
        input.mjml_code = input.mjml_code.split(splitter).join(joiner);
        input.css_code = input.css_code.split(splitter).join(joiner);
        input.delete = 0;
      

        let json = {
          "scrdata_id": 1121,
          "session_id": "{{ Request::get("session")->session_id }}",
          "session_exp": "{{ Request::get("session")->session_exp }}",
          "item_id": 0,
          "email_message_load_builder": input,
        };

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(json)},
            success:function(response){
                // console.log(response);
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
            "scrdata_id": 1122,
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

                    data.template_email_category_list.map((item,index)=>{
                        console.log(item);
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