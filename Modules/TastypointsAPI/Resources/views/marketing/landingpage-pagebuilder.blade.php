@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | Landingpage Template' )

@section('css')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.16.45/css/grapes.min.css" /> --}}
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" />
    <link rel="stylesheet" href="/tasty/css/grapejs-webpage.css"/>
    <link rel="stylesheet" href="/tasty/vendor/grapesjs/code-editor/grapesjs-component-code-editor.min.css"/>

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

    </style>

    <style>
      /* menu and title header list */
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
          margin-bottom: 10px;
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
<section class="content-header">
    {{-- <h1 id="template_name">Landingpage Template</h1>
    <p style="margin-bottom:0px;"><small id="template_link"></small></p>
    <p><small id="date_created"></small></p> --}}
</section>

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
          <select required id="category_template" class="form-control" name="template_category_id">
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

<script src="https://unpkg.com/grapesjs"></script>

<script src="/tasty/js/grapejs-webpage.min.js"></script>
<script src="/tasty/vendor/grapesjs/code-editor/grapesjs-component-code-editor.min.js"></script>
<script src="/tasty/vendor/grapesjs/parser-postcss/dist/grapesjs-parser-postcss.min.js"></script>
<script src="/tasty/vendor/grapesjs/ckeditor/node_modules/ckeditor/ckeditor.js"></script>
<script src="/tasty/vendor/grapesjs/ckeditor/dist/grapesjs-plugin-ckeditor.min.js"></script>

<script src="https://unpkg.com/grapesjs-tui-image-editor"></script>
<script src="https://unpkg.com/grapesjs-script-editor"></script>
<script src="https://unpkg.com/grapesjs-custom-code"></script>

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
    const remoteIcons = "/tasty/images/";
    var editor = grapesjs.init({
        container : '#gjs',
        allowScripts: 1,
        plugins: [
          'gjs-preset-webpage',
          'grapesjs-component-code-editor',
          'grapesjs-parser-postcss',
          'gjs-plugin-ckeditor',

          'grapesjs-tui-image-editor',
          'grapesjs-script-editor',
          'grapesjs-custom-code',
          

        ],
        pluginsOpts: {
          'gjs-plugin-ckeditor': {
            position: 'center',
            options: {
              language: 'en',
              //skin: 'moono-dark',
            }
          },
          'gjs-preset-webpage': {
            // options
          },
          'grapesjs-component-code-editor':{

          },
          'grapesjs-tui-image-editor': {
            config: {
              includeUI: {
                initMenu: 'filter',
              },
            },
            icons: {
              'menu.normalIcon.path': `${remoteIcons}default.svg`,
              'menu.activeIcon.path': `${remoteIcons}default.svg`,
              'menu.disabledIcon.path': `${remoteIcons}default.svg`,
              'menu.hoverIcon.path': `${remoteIcons}default.svg`,
              'submenu.normalIcon.path': `${remoteIcons}default.svg`,
              'submenu.activeIcon.path': `${remoteIcons}default.svg`,
            },
          },
        },
        // assetManager: {

        //   // Upload endpoint, set `false` to disable upload, default `false`
        //   // upload: 'https://endpoint/upload/assets',

        //   // The name used in POST to pass uploaded files, default: `'files'`
        //   // uploadName: 'files',

        //   multiUpload: false,

        //    // Custom uploadFile function
        //   // @example
        //   uploadFile: function(e) {

        //     var files = e.dataTransfer ? e.dataTransfer.files : e.target.files;
        //     // ...send somewhere
        //     console.log(files);

        //     var formData = new FormData();

        //     for(var i in files){
        //         // formData.append('file-'+i, files[i]):
        //         formData.append('file', files[i]);
        //     }


        //     $.ajax({
        //       url: '{{ route("tastypointsapi.upload","image") }}',
        //         type: 'POST',
        //         data: formData,
        //         mimeType: "multipart/form-data",
        //         success: function(result){
        //           console.log(result);
        //           var images = result.link; // <- should be an array of uploaded images
        //           editor.AssetManager.add(images);
        //         }
        //     });

        //   }

        // },
    });

    const pn = editor.Panels;
    const panelViews = pn.addPanel({
      id: 'views'
    });
    panelViews.get('buttons').add([{
      attributes: {
        title: 'Open Code'
      },
      className: 'fa fa-file-code',
      command: 'open-code',
      togglable: false, //do not close when button is clicked again
      id: 'open-code'
    }]);

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

    function sendServer(){

      $.ajax({
          url:"{{ route('tastypointsapi.testnet') }}",
          type:"post",
          data:{"input":JSON.stringify(input)},
          beforeSend:function(){
            $("#save_btn").html("Loading...");
            $("#save_btn").attr("disabled");
          },
          success:function(response){
            // console.log(response);
            response = JSON.parse(response);
            if(response.status){

              let data = JSON.parse(response.data);
              console.log(data);

              swal("Data has been saved",{
                icon:"success"
              });
              // return false;
            }
          },
          complete:function(){
            $("#save_btn").html("Save");
            $("#save_btn").removeAttr("disabled");
          }
        });
    }

    function takeScreenshot() {
      let elm = $(".gjs-frame").contents().find('body');

      html2canvas(elm[0]).then(canvas =>{
        window.body.appendChild(canvas);
        $("canvas").hide();
        
        img_b64 = canvas.toDataURL('image/png');
        //Create blob from DataURL
        blob = dataURItoBlob(img_b64);

        console.log(blob);
        
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
              // alert("https://tastypos.onprocess.work"+response.link);
              input.landing_page_load_builder.landing_page_thumbnail_link = response.link;
              sendServer();
            },
            error(error) {
                console.log('Upload error',error);
            },
        });
        
      });
    }

    let input = {
          "scrdata_id": 1113,
          "session_id": "{{ Request::get("session")->session_id }}",
          "session_exp": "{{ Request::get("session")->session_exp }}",
          "item_id": 0,
          "landing_page_load_builder": {
            "save_as_new_template":{
              "template_category_id": 1,
              "new_template_name": "",
              "new_template_description": "",
              "overwrite_origin_template": 0,
              "create_new_template": 1
            },
            "id": 0,
            "landing_page_name": "This is test",
            "html_code": "html",
            "css_code": "",
            "landing_page_thumbnail_link": "https://www.findbestwebhosting.com/web-hosting-blog/wp-content/uploads/2015/04/Page2Images-495x400.png",
            "landing_page_web_link": "http://1.1.1.1/landingpage/name1/name3/1",
            "public": 0,
            "date_created": "",
            "randomid": 241254213,
            "folder_id": null,
            "folder_name": null,
            "delete": 0,
            "landing_page_variants": null
          }
    };

    editor.on("component:update",(some, argument)=>{

      let html = editor.getHtml();
      let css = editor.getCss();

      input.landing_page_load_builder.html_code = html;
      input.landing_page_load_builder.css_code = css;

    });

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

        let elm = $("#category_template");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            beforeSend:function(){
              elm.attr("disabled",true);
            },
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);

                    data.category_landing_page_template_list.map((item,index)=>{

                        temp_category[item.id] = item;

                        elm.append('<option value="'+item.id+'">'+item.template_category_name+'</option>');
                    });

                    elm.select2({
                      width:"300px"
                    });

                }
            },
            error:function(error){
                console.log(error);
            },
            complete:function(){
              elm.removeAttr("disabled");
            }
        });
    }

    $(document).ready(function(){
        load_category();
        editor.setComponents("");
        editor.setStyle("");
    });

    $("#form_validate").validate({
      submitHandler:function(form){


        let data = getFormData($(form));

        // console.log(data);

        input.landing_page_load_builder.save_as_new_template.new_template_name = data.new_template_name;
        input.landing_page_load_builder.save_as_new_template.new_template_description = data.new_template_description;
        input.landing_page_load_builder.save_as_new_template.template_category_id = data.template_category_id;
        input.landing_page_load_builder.landing_page_name = data.new_template_name;

        console.log(input);
        takeScreenshot();

        // return false;

      }
    });
    

  </script>

@endsection