@extends('tastypointsapi::marketing.partials.master')
@section( 'page_name', "Partner Management - Nodes Group")

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

@section('content-header',"Nodes Group")

@section('main_content')

<div class="col-sm-12">
    <div class="box box-primary">
        <div class="box-body">
            <form id="form_data">
                @csrf
                <input type="hidden" name="item_id" value="0" />
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Name</label>
                        <input name="node_group_name" class="form-control" value="" required/>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Order</label>
                        <input name="node_group_order" class="form-control" value="" required type="number" />
                    </div>
                    <div class="form-group col-md-3">
                        <label>Description</label>
                        <input name="node_group_description" class="form-control" value="" required />
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

<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-body">
            <div class="main_page">
                <div class="table_container">
                    <table class="table table-bordered table-striped" id="table_data">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Order</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Updated</th>
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
<script>

    let json = {
        "scrdata_id": 1154,
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
                d.scr_name = "flow_nodes_group";
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
                data: "node_group_name"
            },
            { 
                data: "node_group_order",
            },
            { 
                data: "node_group_description",
            },
            { 
                data: "node_group_order",
            },
            { 
                data: "node_group_order",
            },
            { 
                data: "id",
                orderable:false,
                searchable:false,
                render:function(data,type,row){
                  return `
                  <button onclick="edit(${row.id})" class="btn btn-primary btn-xs">Edit</button>
                  <button onclick="destroy(${row.id})" class="btn btn-danger btn-xs">Delete</button>
                  `;
                }
            }
        ],
    });


    $("#form_data").validate({
        submitHandler:function(form){

            let input = {
                    "scrdata_id": 1155,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
            };
            let gotForm = getFormData($(form));
            input.item_id = parseInt(gotForm.item_id);
            gotForm.delete = 0;
            input.flow_nodes_group = [gotForm];

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
        $("#form_data input[name=item_id]").val(data.id);
        for(key in data){
            let val = data[key];
            $("#form_data input[name="+key+"]").val(val);
        }

    }

    function add() {
        $("#form_data input").val("");
        $("#form_data input[name=item_id]").val(0);
    }

    function destroy(id) {
        id = parseInt(id);
        let input = {
            "scrdata_id": 1155,
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
            "flow_nodes_group": [
                {
                    "id": id,
                    "delete":1
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