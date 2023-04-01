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
      <h1 id="template_name">Landingpage Template</h1>
      <p style="margin-bottom:0px;"><small id="template_link"></small></p>
      <p><small id="date_created"></small></p>
  </section>

  <!-- Main content -->
  <section class="content">

      <div class="modal" id="variants">
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
                      <input required name="landing_page_name" class="form-control" placeholder="Enter your landing page name" />
                  </div>
                  <div class="form-group">
                      <input id="landing_page_web_link_name" maxlength="10" required name="landing_page_web_link" class="form-control" placeholder="Page link name" />
                  </div>
                  <div class="form-group">
                      <textarea rows="5" name="landing_page_description" class="form-control" placeholder="Page link description"></textarea>
                  </div>
                  <div class="form-group">
                      <select name="landing_page_folder_id" class="form-control" id="select2">
                          <option value="" disabled selected>Select Folder Name</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label>
                          <input id="random_id" name="random_id" type="checkbox" /> Use random id as page link name
                      </label>
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

      <div class="modal" id="debug">
        <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"></h4>
              </div>
                
                <div class="modal-body">
                  <p id="request_json"></p>
                </div>
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

    let page_id = {{ isset($id) ? $id : 0 }};
    let variants = [];

    let data_saved = {};

    function loadData() {

      let input = {
                "scrdata_id": 1182,
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
            };

      editor.setComponents("");
      editor.setStyle("");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                  response = JSON.parse(response);
                  if(response.status){

                    let data = JSON.parse(response.data);
                    data = data.landing_pages[0];

                    data_saved = data;
                    // alert("load data");
                    console.log("saved",data_saved);

                    $("#template_name").text(data.landing_page_name);
                    $("#template_link").text(data.landing_page_web_link);
                    $("#date_created").text(data.date_created);

                    if(data.landing_page_variants !== undefined && data.landing_page_variants !== null){
                      variants = data.landing_page_variants;
                    }

                    loadVariants();

                    selected_variant = -1;
                    $("#save_landing").show();
                    $("#list_variants").find("li").removeClass("active");
                    $(".control_action").hide();
                    $("#home").addClass("active");
                    editor.setComponents(data_saved.html_code);
                    editor.setStyle(data_saved.css_code);

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
            '<input disabled class="menu_field" required value="'+item.landing_page_name+'" />'+
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

      // console.log(elm,selected_variant,variants);

      // selected_variant == null && selected_variant < 0 ?
      //   $("#home").trigger("click")
      //   :
      //   selectedVariants(selected_variant);

    }

    async function saveVariants(index){
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
      await takeScreenshot(sc).then(async (res) => {
        // console.log(res);
        // alert("work");
        await savePage();
        await loadData();
      });
      // setTimeout(() => {
      //   savePage();
      // }, 5000);
      // setTimeout(() => {
      //   loadData();
      // }, 6000);
      // swal("Data has been saved",{
      //   icon:"success"
      // });
    }

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
        $("#variants_form select").val("");
        $("#variants_form input[type=checkbox]").removeAttr("checked");
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
      console.log("edit",data);
      $("#variants_form input[name=index]").val(index);
      $("#variants_form input[name=id]").val(data.id);
      $("#variants_form input[name=landing_page_name]").val(data.landing_page_name);
      $("#variants_form input[name=landing_page_web_link]").val(data.landing_page_web_link);
      $("#variants_form textarea[name=landing_page_description]").val(data.landing_page_description);
      $("#variants_form select[name=landing_page_folder_id]").val(data.landing_page_folder_id).trigger("change");
      $("#variants").modal("show");
    }

    let selected_variant = null;

    function checkDataChanged(index){
      const data = index >= 0 ? variants[index] : data_saved;
      const html = editor.getHtml();
      const css = editor.getCss();
      // console.log(index);
      // console.log(css);
      // console.log(data.css_code);
      return data.css_code !== css || data.html_code !== html ?  true : false;
    }
    
    function selectedVariants(index,type) {

        if(type !== undefined){
            if(index < 0){
              $("#save_landing").show();
              selected_variant = -1;
              $("#list_variants").find("li").removeClass("active");
              $(".control_action").hide();
              $("#home").addClass("active");
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
            return;
        }

        const result = checkDataChanged(selected_variant);
        if(result){
          const r = confirm("Click the save button, so you do not lose any changes you've made.");
          if(!r) return;
        }

        if(index == -1){
          $("#home").trigger("click");
          return;
        }
        $("#save_landing").hide();
        let elm = $("#variants_id_"+index);
        // let disabled_check = elm.find("input:disabled");

        if(selected_variant !== index){

          // editor.setComponents("");
          // editor.setStyle("");

          $(".control_action").hide();

          $("#home").removeClass("active");

          selected_variant = index;

          let control = elm.find(".control_action");
          control.show();

          let data = variants[index];
          console.log(data);
          editor.setComponents(data.html_code);
          editor.setStyle(data.css_code);
          $("#list_variants li").removeClass("active");
          elm.addClass("active");
        }

    }
    
    
    editor.on("component:add",(some, argument)=>{
      console.log("add",some);

    });

    editor.on("component:update",(some, argument)=>{
      console.log("update",some);
      //   let html = editor.getHtml();
      //   let css = editor.getCss();
      //   let data = variants[selected_variant];

      //   // if(data !== undefined){
      //   if(selected_variant > -1){

      //     data.html_code = html;
      //     data.css_code = css;
    
      //   } else {
      //     data_saved.html_code = html;
      //     data_saved.css_code = css;
      //   }
      //     console.log(data);


    });

    $("#save_btn").click(savePage);

    async function savePage() {

      $("#save_btn").html('<i class="fas fa-circle-notch fa-spin"></i>');
      $("#save_btn").attr("disabled");

      // editor.setComponents(data_saved.html_code);
      // editor.setStyle(data_saved.css_code);
      // await takeScreenshot(-1);

      // variants.map(async (item,index)=>{
      //   await takeScreenshot(index);
      // });

      return await sendServer();

    }

    async function takeScreenshot(index) {
        
        let elm = $(".gjs-frame").contents().find('body');
        let formData = new FormData();

        await html2canvas(elm[0]).then(canvas => {
          window.body.appendChild(canvas);
          $("canvas").hide();
          
          img_b64 = canvas.toDataURL('image/png');
          //Create blob from DataURL
          blob = dataURItoBlob(img_b64);

          // console.log(blob);

          // Pass the image file name as the third parameter if necessary.
          formData.append('file', blob, 'image.png');
          console.log(formData);
          
        });


        // Use `jQuery.ajax` method for example
        return $.ajax({
            url:'{{ route("tastypointsapi.upload","image") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success(response) {

              if(index < 0){
                data_saved.landing_page_thumbnail_link = response.link;
              } else {
                variants[index].landing_page_thumbnail_link = response.link;
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
      data_saved.landing_page_variants = convertData();

      delete data_saved.save_as_new_template;
      

      let input = {
          "scrdata_id": 1113,
          "session_id": "{{ Request::get("session")->session_id }}",
          "session_exp": "{{ Request::get("session")->session_exp }}",
          "item_id": page_id,
          "landing_page_load_builder": data_saved,
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

    $("#home").click(function(e){
      const result = checkDataChanged(selected_variant);
      if(result){
        const r = confirm("Click the save button, so you do not lose any changes you've made.");
        if(!r) return;
      }

      selected_variant = -1;
      $("#save_landing").show();
      $("#list_variants").find("li").removeClass("active");
      $(".control_action").hide();
      $(this).addClass("active");
      console.log(data_saved);
      editor.setComponents(data_saved.html_code);
      editor.setStyle(data_saved.css_code);

    });

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
            beforeSend:function(){
              $("#add").attr("disabled",true);
              $("#add").html('<i class="fas fa-circle-notch fa-spin"></i>');
            },
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
            },
            complete:function(){
              $("#add").removeAttr("disabled");
              $("#add").html('<i class="fas fa-plus"></i>');
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
    }

    $(document).ready(function(){
        load_folder();
    });

    function searchVariants(value) {
      variants.map((item,index)=>{
        if(item.id == value) return {"item":item,"index":index};
      });
    }

    $("#variants_form").validate({
      submitHandler:function(form){

        let data = getFormData($(form));
        data.index = parseInt(data.index);

        if(data.index < 0){
          data.html_code = data_saved.html_code;
          data.css_code = data_saved.css_code;
          data.delete = 0;
          console.log(data);
          variants.push(data);
        } else {

          let variant = variants[data.index];

          variant.landing_page_name = data.landing_page_name;
          variant.landing_page_web_link = data.landing_page_web_link;
          variant.landing_page_description = data.landing_page_description;
          variant.landing_page_folder_id = data.landing_page_folder_id;

          variants[data.index] = variant;
        }
        

        $("#variants").modal("hide");
        loadVariants();
        selectedVariants(selected_variant,0);

        return false;
      }
    });

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
            $("#variants_form").valid();
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

    function convertDataTemplate(type) {
        let splitter = "'";
        let joiner = "''";
        data_saved.html_code = data_saved.html_code.split(splitter).join(joiner);
        data_saved.css_code = data_saved.css_code.split(splitter).join(joiner);
        variants.map((item,index)=>{

            variants[index].html_code = item.html_code.split(splitter).join(joiner);

            variants[index].css_code = item.css_code.split(splitter).join(joiner);

            variants[index].delete = 0;

            item.landing_page_description = item.landing_page_description == undefined ? "" : item.landing_page_description;

            let save_as_new_template = {
                "template_category_id":cat_id,
                "new_template_name": item.landing_page_name,
                "new_template_description": item.landing_page_description,
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
        data_saved.landing_page_variants = variants;
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

        await saveVariants(selected_variant);

        let elm = type == "create" ? $("create_template") : $("#update_template");

        // takeScreenshot(selected_variant);

        elm.attr("disabled",true);
        elm.html('<i class="fas fa-circle-notch fa-spin"></i>');

        convertDataTemplate(type);
  
        data_saved.delete = 0;

        data_saved.landing_page_description = data_saved.landing_page_description == undefined ? "" : data_saved.landing_page_description;

        data_saved.save_as_new_template = {
          "template_category_id":cat_id,
          "new_template_name": data_saved.landing_page_name,
          "new_template_description": data_saved.landing_page_description,
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
            "scrdata_id": 1113,
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "item_id": 0,
            "landing_page_load_builder": data_saved,
        };
        console.log("Request : ",input);

        $.ajax({
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

        let elm = $("#select_category");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);

                    data.category_landing_page_template_list.map((item,index)=>{

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

    $( "#variants" ).on('shown.bs.modal', function(){
      console.log("modal show");
        $("#random_id").prop("checked",false);
    });
    

  </script>

@endsection