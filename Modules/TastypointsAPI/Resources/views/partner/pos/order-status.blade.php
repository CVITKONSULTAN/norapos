@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Order Status")

@section('page_css')
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
    </style>
@endsection

@section('content-header',"Order Status")

@section('main_content')

    <div class="main_page">
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Status Name</th>
                        <th>Color</th>
                        <th>Icon</th>
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
                <input type="file" name="file" accept="image/*" id="selectedFile" style="display: none;" />
                <form id="form_data">
                    @csrf
                    <input type="hidden" name="item_id" value="0" />
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status Name</label>
                                <input name="order_status_name" class="form-control" value="" required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Color</label>
                                <input name="order_status_color" class="form-control" value="#BF5C14" id="color_picker" required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Icon</label>
                                <div class="input-group">
                                    <input name="order_status_icon" class="form-control" value=""/>
                                    <span class="input-group-btn">
                                        <button onclick="browse_data(this,'image/*')" type="button" class="btn btn-primary">Browse</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 action_form">
                            <button onclick="addNew(this)" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> New</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save / Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinyColorPicker/1.1.1/jqColorPicker.min.js"></script>
    <script>
        $('#color_picker').colorPicker();

        let json = {
            "scrdata_id": 1270,
            "sp_name": "OK",
            "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
            "session_exp": "05/29/2015 05:50:06",
            "max_row_per_page": 0,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 0,
            "status": "OK",
            "lab_test": 1,
            "item_id": 0
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
                    d.scr_name = "order_status";
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
                    data: "order_status_name"
                },
                { 
                    data: "order_status_color",
                    render:function(data,type,row){
                        return `<div style="height:25px;width:25px;background:${data};margin:0 auto;"></div>`;
                    },
                    className:"text-center"
                },
                { 
                    data: "order_status_icon",
                    render:function(data,type,row){
                        return `<img src="${data}" style="height:25px;width:25px;margin:0 auto;" />`;
                    },
                    className:"text-center"
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

                // let input = {
                //         "scrdata_id": 1266,
                //         "session_id": "{{ Request::get("session")->session_id }}",
                //         "session_exp": "{{ Request::get("session")->session_exp }}",
                // };
                // let gotForm = getFormData($(form));
                // input.item_id = parseInt(gotForm.item_id);
                // input.pos_terminals = [gotForm];

                let input = {
                    "scrdata_id": 1271,
                    "sp_name": "OK",
                    "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
                    "session_exp": "05/29/2015 05:50:06",
                    "lab_test": 1,
                    "item_id": 0,
                    "order_status": [
                        {
                        "order_status_name": "Waiting for action",
                        "order_status_color": "#BF5C14",
                        "order_status_icon": "https://tastypoints.io/akm/tasty_images/xAAw9QXP.png"
                        }
                    ]
                };

                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            swal("","Data has changed","success");
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
        
        let temp_elm;
        let temp_elm_btn;
        function browse_data(elm,type) {
            temp_elm_btn = $(elm);
            let input = $(elm).parent().parent().find("input");
            temp_elm = input;
            $("#selectedFile").attr("accept",type);
            $("#selectedFile").trigger("click");
        }

        $("#selectedFile").change(function(e){
            let val = $(this).val();
            let formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            $.ajax({
                url: "{{ route("tastypointsapi.upload","others") }}",
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                beforeSend:function(){
                    temp_elm_btn.html('<i class="fas fa-circle-notch fa-spin"></i>');
                    temp_elm_btn.attr('disabled',true);
                },
                success : function(response) {
                    if(response.success){
                        temp_elm.val(response.link);
                        $("#selectedFile").val("");
                    }
                },
                complete:function(){
                    temp_elm_btn.html('Browse');
                    temp_elm_btn.removeAttr('disabled');
                }
            });
        });

        function addNew(elm) {
            let form = $(elm).parents("form");
            form.find("input").val("");
            form.find("input[name=item_id]").val(0);
        }

        function edit(id,type) {
            
            let form = $("#form_data");
            let data = temp_data[id];
            
            for(key in data){
                let value = data[key];
                if(key == "id") key = "item_id";
                form.find("input[name="+key+"]").val(value);
            }
            
        }

        function destroy(id) {
            id = parseInt(id);
            let input = {
                "scrdata_id": 1271,
                "session_id": json.session_id,
                "session_exp": json.session_exp,
                "delete": 1,
                "item_id":id,
                "order_status": [
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