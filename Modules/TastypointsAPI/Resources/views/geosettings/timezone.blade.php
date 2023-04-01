@extends('tastypointsapi::geosettings.partials.master')
@section( 'page_name', "Geographic Settings - Timezone")

@section('page_css')
    <style>
        .table_container{
            margin-top: 20px;
        }
        #add_new{
            margin-right: 20px;
        }
        #map{
            width: 100%;
            height: 50vh;
            margin: 10px 0px;
        }
        #map-control{
            margin-left: 10px;
        }
    </style>
@endsection

@section('content-header',"Geographic Settings")

@section('main_content')

    <div class="main_page">

        <form id="form_data">
            @csrf
            <input type="hidden" name="item_id" value="0" />

            <div class="row">
                <div class="form-group col-md-3">
                    <label>NAME</label>
                    <input name="name" class="form-control" required />
                </div>
                <div class="form-group col-md-3">
                    <label>ABBREVIATION</label>
                    <input name="abbreviation" class="form-control" required />
                </div>
                <div class="form-group col-md-3">
                    <label>OFFSET</label>
                    <input name="offset" class="form-control" required />
                </div>
                <div class="col-md-3" style="margin-top: 26px;">
                    <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-save"></i> Save / Apply</button>
                    <button onclick="add()" type="button" class="btn btn-primary pull-right" id="add_new"><i class="fas fa-plus"></i> New</button>
                </div>
            </div>
        </form>

        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>ABBREVIATION</th>
                        <th>OFFSET</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@section('javascript')
    
    <script>

        let json = {
            "scrdata_id": 1128,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "item_id": 0,
            "max_row_per_page": 50,
            "search_term": "",
            "search_term_header": "",
            "pagination": 1,
            "sp_name": "OK",
            "status": "OK",
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
                    d.scr_name = "time_zones";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data[item.id] = item;
                    });
                    return json.data;
                }  
            },
            "columns": [
                { 
                    data: "name",
                },
                { 
                    data: "abbreviation",
                },
                { 
                    data: "offset",
                },
                { 
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="edit('+
                        "'"+row.id+"'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                        "'"+row.id+"'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });


        $("#form_data").validate({
            submitHandler:function(form){

                let input = {
                    "scrdata_id": 1129,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = gotForm.item_id;
                gotForm.delete = 0;

                input.time_zones = [gotForm];
                // console.log(JSON.stringify(input));
                
                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            response = JSON.parse(response);
                            if(response.status){
                                response.data = JSON.parse(response.data);
                                if(response.data.response_error){
                                    swal(response.data.response_error,{"icon":"error"});
                                    return ;
                                }
                                swal("Data has been recorded",{"icon":"success"});
                                otable.draw(false);
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
        
        let state_id = "";
        function edit(id) {
            let data = [];
            try {
                data = temp_data[id];
            } catch (error) {
                console.log(error);
            }
            $("#form_data input[name=item_id]").val(id);
            for(key in data){
                let value = data[key];
                $("#form_data input[name="+key+"]").val(value);
            }

        }

        function add() {
            $("#form_data input").val("");
            $("#form_data select").val("");
            $("#form_data textarea").val("");
            $("#form_data input[name=item_id]").val(0);
        }

        function destroy(id) {
            let data = temp_data[id];
            data.delete = 1;
            let input = {
                "scrdata_id": 1129,
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
                "time_zones":[data],
            };
            console.log(JSON.stringify(input));

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