@extends('tastypointsapi::marketing.partials.master')
@section( 'page_name', "Partner Management - Create Nodes")

@section('page_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.css" />
    <style>
        .material-switch > input[type="checkbox"] {
            display: none;   
        }

        .material-switch > label {
            cursor: pointer;
            height: 0px;
            position: relative; 
            width: 40px;  
        }

        .material-switch > label::before {
            background: rgb(0, 0, 0);
            box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            content: '';
            height: 16px;
            margin-top: -8px;
            position:absolute;
            opacity: 0.3;
            transition: all 0.4s ease-in-out;
            width: 40px;
        }
        .material-switch > label::after {
            background: rgb(255, 255, 255);
            border-radius: 16px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            content: '';
            height: 24px;
            left: -4px;
            margin-top: -8px;
            position: absolute;
            top: -4px;
            transition: all 0.3s ease-in-out;
            width: 24px;
        }
        .material-switch > input[type="checkbox"]:checked + label::before {
            background: inherit;
            opacity: 0.5;
        }
        .material-switch > input[type="checkbox"]:checked + label::after {
            background: inherit;
            left: 20px;
        }
    </style>
    <style>
        .table_container{
            margin-top: 20px;
        }
        #add_new{
            margin-right: 20px;
        }
        .action_form{
            padding-top: 25px;
        }
        .jsoneditor{
            height: 80vh;
            width: auto;
        }
        .icon_nodes {
            height: 100px;
            width: 100px;
            margin: 3px 10px;
        }
    </style>
@endsection

@section('content-header',"Create Nodes")

@section('main_content')

<input type="file" accept="image/*" name="file" id="fileDom" style="display: none;" />

<div class="col-sm-12">
    <div class="box box-primary">
        <div class="box-body">
            <form id="form_data">
                @csrf
                <input type="hidden" name="item_id" value="0" />
                <div class="row">
                    <div class="col-md-5">
                        <form id="form_data">
                            @csrf
                            <input type="hidden" name="item_id" value="0" />

                            <div class="form-group">
                                <label>Node Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-briefcase"></i></span>
                                    <input required name="name" placeholder="Node Name" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Node Description</label>
                                <textarea name="description" rows="5" class="form-control" placeholder="Node Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Node Icon</label>
                                <div class="input-group">
                                    <input id="icon_link" name="icon_link" required class="form-control" />
                                    <div class="input-group-btn">
                                        <button type="button" onclick="uploadImage(`icon_link`)" class="btn btn-primary"><i class="fas fa-folder-open"></i> Browse...</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Node Icon Selected</label>
                                <div class="input-group">
                                    <input id="icon_link_selected" name="icon_link_selected" required class="form-control" />
                                    <div class="input-group-btn">
                                        <button type="button" onclick="uploadImage(`icon_link_selected`)" class="btn btn-primary"><i class="fas fa-folder-open"></i> Browse...</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Node Tool Tip</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-phone-alt"></i></span>
                                    <input name="nodes_tooltip" placeholder="Node Tool Tip" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Select Node Group</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-map-marker"></i></span>
                                    <select name="nodes_group_id" class="form-control" id="node_group">
                                        <option value="" disabled selected>Select Node Group</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <select id="json_container" class="pull-right" style="border: 1px solid #d2d6dd;">
                                    <option value="" disabled selected>Settings JSON Container</option>
                                </select>
                                <div class="form-group">
                                    <label>Node Settings JSON</label>
                                    <textarea id="node_settings_json" name="node_settings_json" rows="5" class="form-control" placeholder=""></textarea>
                                    <small id="description_container"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Node Response Settings JSON</label>
                                <textarea name="node_response_settings_json" rows="5" class="form-control" placeholder=""></textarea>
                            </div>
                            <div class="form-group">
                                <label>Node Object Lists</label>
                                <textarea name="node_object_lists" rows="5" class="form-control" placeholder=""></textarea>
                            </div>
                            <div class="pull-right">
                                <div style="display: inline-block;">
                                    <span style="display: inline; margin-right:10px;">Active</span>
                                    <div style="display: inline;margin-right:10px;" class="material-switch">
                                        <input id="active" name="active" type="checkbox"/>
                                        <label for="active" class="label-success"></label>
                                    </div>
                                </div>
                                <div style="display: inline-block;">
                                    <button type="button" onclick="add()" class="btn btn-primary"><i class="fas fa-plus"></i> New</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save/Apply</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary"><i class="fas fa-file-upload"></i> Load JSON</button>
                        </form>
                    </div>
                    <div class="col-md-7">
                        <div class="jsoneditor" id="show"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-body">
            <div class="main_page">
                <div class="table_container">
                    <table class="table table-bordered table-striped" id="table_data">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Icon</th>
                                <th></th>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.js"></script>

<script>

    let options = {
        mode: 'tree',
        modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
        onChangeText: editorChange,
    };

    let editor = new JSONEditor(document.getElementById("show"),options);

    function editorChange(){
        const val = editor.get();
        // jsonToForm(val);
    }

    let json = {
        "scrdata_id": 1156,
        "sp_name": "OK",
        "session_id": "{{ Request::get("session")->session_id }}",
        "session_exp": "{{ Request::get("session")->session_exp }}",
        "status": "OK",
        "item_id": 0,
        "max_row_per_page": 50,
        "search_term": "0",
        "search_term_header": "0",
        "pagination": 1,
        "total_records": 3,
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
        "responsive":true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": '{{ route("tastypointsapi.datatables") }}',
            "type": 'POST',
            "data": function(d){
                d._token =  "{{ csrf_token() }}";
                d.input = JSON.stringify(json);
                d.scr_name = "flow_nodes";
                return d;
            },
            "dataSrc": function ( json ) {
                json.data.map((item,index)=>{
                    temp_data[item.nodes_id] = item;
                });
                return json.data;
            },
        },
        "columns": [
            { 
                data: "name"
            },
            { 
                data: "description",
            },
            { 
                data: "icon_link",
                render:function(data,type,row){
                    return `
                        <img class="icon_nodes" src="${data}" />
                        <img class="icon_nodes" src="${row.icon_link_selected}" />
                    `;
                }
            },
            { 
                data: "nodes_id",
                orderable:false,
                searchable:false,
                render:function(data,type,row){
                  return `
                  <button onclick="edit(${data})" class="btn btn-primary btn-xs">Edit</button>
                  <button onclick="destroy(${data})" class="btn btn-danger btn-xs">Delete</button>
                  `;
                }
            }
        ],
    });

    $("#form_data :input").on("keyup", FormToEditor);
    $("#form_data select").on("change", function(){
        let val = $(this).val();
        let data = editor.get();
        data.nodes_group_id = parseInt(val);
        editor.set(data);
    });

    $("#active").click(function(){
        let val = $('#active:checked').length > 0 ? 1 :0;
        let data = editor.get();
        data.active = val;
        editor.set(data);
    });

    function FormToEditor() {
        try {
            let val = getFormData($("#form_data"));
            let id = val.item_id;
            // let data = temp_data[id];
            let data = editor.get();

            let exclude_param = ["node_settings_json","node_response_settings_json","node_object_lists"];
            for(key in val){
                let value = val[key];
                // console.log(key,value);
                if(key == "nodes_group_id") value = parseInt(value);
                if(exclude_param.includes(key)){
                    try {
                        value = JSON.parse(value);
                    } catch (error) {
                        value = {};
                    }
                }
                if(key == "active") value = value == "on" ? 1 : 0;
                data[key] = value;
            }
            // console.log(data);
            editor.set(data);
            
        } catch (error) {
            console.log(error);
        }
    }

    $("#form_data").validate({
        submitHandler:function(form){

            let input = {
                    "scrdata_id": 1157,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
            };
            // let gotForm = getFormData($(form));
            // input.item_id = parseInt(gotForm.item_id);
            // gotForm.delete = 0;
            // gotForm.active = $('#active:checked').length > 0 ? 1 :0;

            // let exclude_param = [
            //     "node_settings_json",
            //     "node_response_settings_json",
            //     "node_object_lists"
            // ];

            // exclude_param.map((item,index)=>{
            //     let value = gotForm[item];
            //     let json = value == "" || value == "null" ? {} : value;
            //     try {
            //         json = JSON.parse(value);
            //     } catch (error) {
            //         console.log("eror parse",error);
            //         json = {};
            //     }
            //     gotForm[item] = json;
            // });
            
            // const data = temp_data[input.item_id];

            // gotForm = {...gotForm, ...data};

            // FormToEditor();
            let gotForm = editor.get();
            gotForm.delete = 0;

            // gotForm = {...gotForm, ...editor_json};

            console.log(gotForm);

            // return;
            input.item_id = gotForm.nodes_id;
            input.flow_nodes = [gotForm];
            
            Pace.track(function(){

                $.ajax({
                    url:'{{ route("tastypointsapi.testnet") }}',
                    type:"post",
                    data:{"input":JSON.stringify(input)},
                    success:function(response){
                        response = JSON.parse(response);
                        if(response.status){
                            response.data = JSON.parse(response.data);
                            if(response.data.response_error !== undefined){
                                swal(response.data.response_error,{"icon":"error"});
                                return;
                            }
                            swal('Data has been saved!',{"icon":"success"});
                            otable.draw(false);
                            edit(response.data.item_id,input.flow_nodes[0]);
                        }
                    },
                    error:function(error){
                        console.log(error);
                    }
                });

            });
            return false;
        }
    });

    function edit(id,json) {
        let data = {};
        try {
            data = temp_data[id];
        } catch (error) {
            console.log(error);
        }
        if(json !== undefined) data = json;
        editor.set(data);
        jsonToForm(data);
    }

    
    function jsonToForm(json) {
        let data = json;
        $("#form_data input[name=item_id]").val(data.nodes_id);
        let exclude_param = ["node_settings_json","node_response_settings_json","node_object_lists"];
        for(key in data){
            let val = data[key];
            if(key == "active") {
                let active = val == 1 ? true : false;
                $("#active").prop('checked', active);
                continue;
            }
            // console.log(val,key);
            if(exclude_param.includes(key)){
                val = JSON.stringify(val);
                // return;
                // console.log(val,key);
            }
            $("#form_data [name="+key+"]").val(val).trigger("change");

        }
    }

    function destroy(id) {
        id = parseInt(id);
        let data = {};
        try {
            data = temp_data[id];
        } catch (error) {
            console.log(error);
        }
        data.delete = 1;
        let input = {
            "scrdata_id": 1157,
            "session_id": json.session_id,
            "session_exp": json.session_exp,
            "delete": 1,
            "item_id":id,
            "status": "OK",
            "max_row_per_page": 50,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 1,
            "total_records": 3,
            "flow_nodes": [
                data
            ]
        };
        // console.log(input,JSON.stringify(input));
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                Pace.track(function(){
                    $.ajax({
                        url:"{{ route('tastypointsapi.testnet') }}",
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            response = JSON.parse(response);
                            if(response.status){
                                swal("Data has been deleted!", {
                                    icon: "success",
                                });
                                otable.draw(false);
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

    function add() {
        let elm = $("#form_data");
        elm.find("input").val("");
        elm.find("input[name=item_id]").val(0);
        elm.find("select").val("").trigger("change");
        elm.find("textarea").val("");
        editor.set({});
        $("#active").prop('checked', false);
    }
    

</script>
<script>
    function load_nodes_group() {
        let input = {
            "scrdata_id": 1154,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 1000,
            "search_term": "",
            "search_term_header":"",
        };

        let elm = $("#node_group");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);

                    data.flow_nodes_group.map((item,index)=>{
                        let new_data = `<option value="${item.id}">${item.node_group_name}</option>`;
                        elm.append(new_data);
                        elm.select2();
                    });

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }
    $(document).ready(function(){
        load_nodes_group();
    });

    let image_field = "";
    function uploadImage(elm_id){
        image_field = elm_id
        $("#fileDom").trigger("click");
    }

    $("#fileDom").change(function(e){
        var fd = new FormData();
        var files = $(this)[0].files;
        // Check file selected or not
        if(files.length > 0 ){
           fd.append('file',files[0]);

           $.ajax({
              url: '{{ route("tastypointsapi.upload","image") }}',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
                 if(response != 0){
                    $("#"+image_field).val(response.link);
                 }else{
                    alert('file not uploaded');
                 }
              },
           });
        }else{
           alert("Please select a file.");
        }
    });


</script>

<script>
    let temp_node_containers = [];
    function load_containers() {
        let input = {
            "scrdata_id": 1222,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 1000,
            "search_term": "",
            "search_term_header":"",
        };

        let elm = $("#json_container");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);

                    data.node_settings_containers.map((item,index)=>{
                        temp_node_containers[item.id] = item;
                        let new_data = `<option value="${item.id}">${item.name}</option>`;
                        elm.append(new_data);
                        // elm.select2();
                    });

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }
    $(document).ready(function(){
        load_containers();
    });

    $("#json_container").change(function(){
        let before = $("#node_settings_json").val();
        let value = $(this).val();
        let data = before;
        let description = "";
        try {
            data = temp_node_containers[value];
            description = `<i class="fas fa-info-circle"></i> ${data.description}`;
            data = data.settings_json;
        } catch (error) {
            console.log(error);
        }
        data = JSON.stringify(data);
        $("#node_settings_json").val(data).trigger("change");
        $("#description_container").html(description);
        FormToEditor();
    });
</script>
@endsection