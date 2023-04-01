@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Partner Types")

@section('page_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" />
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
        .new_items{
            width: 170px;
            height: 250px;
            background: rgb(224 246 253);
            border: 2px dashed rgb(166 202 255);
            padding: 20px;
            cursor: pointer;
            margin-right: 10px;
        }
        .new_items .wrap p{
            font-size: 14pt;
        }
        .new_items .wrap i{
            font-size: 30pt;
        }
        .new_items .wrap{
            text-align: center;
            padding-top: 40px;
        }
        #list-container{
            overflow-y: hidden;
            overflow-x: auto;
            flex: 1;
            height: 275px;
            white-space: nowrap;
            list-style-type: none;
            padding-left: 0px;
        }
        #list-container li{
            float: left;
        }
        #list-container li .action button{
            position: absolute;
            right: 10px;
            top: 10px;
        }
        #list-container li .action{
            height: 250px;
            width: 170px;
            position: absolute;
            top: 0;
        }
        .image_onboard{
            height: 250px;
            width: 170px;
        }
        .dz-preview, .dz-file-preview {
            display: none;
        }
        .loading_upload{
            display: none;
        }
    </style>
@endsection

@section('content-header',"Add Partner Types")

@section('main_content')

    <div class="main_page">
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Type Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@section('new-box')
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <form id="form_data">
                    @csrf
                    <input type="hidden" name="item_id" value="0" />

                    <div class="row">
                        <div class="col-md-9">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type Name</label>
                                    <input name="name" class="form-control" value="" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input name="description" class="form-control" value=""/>
                                </div>
                            </div>
                            <div class="col-md-12" style="display: flex;flex-direction:row;">
                                <div id="add-image">
                                    <div class="new_items">
                                        <div class="wrap">
                                            <div class="loading_upload">
                                                <i class="fa fa-circle-notch fa-2x fa-spin"></i>
                                                <p>Uploading...</p>
                                            </div>
                                            <div class="input_upload">
                                                <i class="fa fa-image"></i>
                                                <p>Drag or Click to upload image files</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul id="list-container"></ul>
                            </div>
                        </div>
                        <div class="col-md-3 action_form">
                            <button onclick="add()" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> New</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save / Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.js"></script>
    <script>
           let optionsDrop = { 
            url: "{{ route("tastypointsapi.upload","image") }}",
            clickable: ["#add-image", "#add-image .new_items"],
            createImageThumbnails:false,
            acceptedFiles: 'image/*',
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                        this.removeAllFiles();
                        this.addFile(file);
                });
                
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
                $(".loading_upload").show();
                $(".input_upload").hide();
            },
            success: function(file, response){
                
                file.previewElement.parentNode.removeChild(file.previewElement);
                $(".loading_upload").hide();
                $(".input_upload").show();

                if(response.success){  
                    let string = `<li>
                        <img
                        class="image_onboard"
                        src="${response.link}" />
                        <div class="action">
                            <button 
                            class="btn btn-primary" 
                            type="button" 
                            onclick="deleteOnboard(this)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </li>`;
                    $("#list-container").prepend(string);
                }
                
            },
        };

        var myDropzone = new Dropzone(document.getElementById('add-image'), optionsDrop);
        let temp_onboard = [];
        
        let list = $("#list-container");
        const getValue = () => {
            temp_onboard = [];
            list.find("li").each(function(i, el){
                let url = $(el).find("img").attr("src");
                temp_onboard.push(url);
            });
            console.log(temp_onboard);
        }
        $(document).ready(function(){
            list.sortable({
                stop: (e,ui) => getValue(),
            });
            list.disableSelection();
        });

        function deleteOnboard(elm) {
            $(elm).parents("li").remove();
            getValue();
        }
    </script>
    <script>

        let json = {
            "scrdata_id": 1038,
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
                    d.scr_name = "partner_type";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data[item.id] == undefined ? temp_data[item.id] = item : temp_data[item.id] = item;
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
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="edit('+
                        "'"+data+"'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                        "'"+data+"'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });


        $("#form_data").validate({
            submitHandler:function(form){

                let input = {
                        "scrdata_id": 1039,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = parseInt(gotForm.item_id);
                gotForm.onboard = temp_onboard;
                input.partner_type = [gotForm];

                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            otable.draw(false);
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });

                });
                return false;
            }
        });

        function edit(id) {
            let data = {};
            try {
                data = temp_data[id];
            } catch (error) {
                console.log(error);
            }
            if(data.onboard !== undefined && data.onboard !== null){
                data.onboard.map((item,index)=>{
                    let string = `<li>
                        <img
                        class="image_onboard"
                        src="${response.link}" />
                        <div class="action">
                            <button 
                            class="btn btn-primary" 
                            type="button" 
                            onclick="deleteOnboard(this)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </li>`;
                    $("#list-container").prepend(string);
                });
                getValue();
            }
            $("#form_data input[name=item_id]").val(data.id);
            $("#form_data input[name=name]").val(data.name);
            $("#form_data input[name=description]").val(data.description);

        }

        function add() {
            $("#form_data input").val("");
            $("#form_data input[name=item_id]").val(0);
            temp_onboard = [];
            $("#list-container").empty();
        }

        function destroy(id) {
            id = parseInt(id);
            let input = {
                "scrdata_id": 1039,
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
                "partner_type": [
                    {
                        "id": id,
                        "detele":1
                    }
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

    </script>
@endsection