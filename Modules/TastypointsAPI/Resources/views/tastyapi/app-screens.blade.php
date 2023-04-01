@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | App Screens' )
@section('css')
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

@section('content')

@include('tastypointsapi::layouts.nav')


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>App Screens</h1>
</section>

<!-- Main content -->
<section class="content">

<div class="box box-primary">
        <div class="box-body">
            <form id="form_data">
                @csrf
                <input type="hidden" name="item_id" value="0" />

                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Screen Name:</label>
                                    <input name="name" class="form-control" value="" required/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Store Proc/Function:</label>
                                    <input maxlength="3" name="store_proc" class="form-control" value="" required/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Client Type:</label>
                                    <input maxlength="3" name="client_type" class="form-control" value="" required/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Scrdata ID:</label>
                                    <input type="number" name="scrdata_id" class="form-control" value="" required/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Web Link:</label>
                                    <input type="url" name="weblink" class="form-control" value="" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 action_form">
                        <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> New</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save / Apply</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="main_page">
                <div class="table_container">
                    <table class="table table-bordered table-striped" id="table_data">
                        <thead>
                            <tr>
                                <th>Screen Name</th>
                                <th>Store Proc/Function</th>
                                <th>Client Type</th>
                                <th>Scrdata ID</th>
                                <th>Web Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


</section>
<!-- /.content -->

@endsection


@section('javascript')
    <script>

        let json = {
            "scrdata_id": 1070,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 10000,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 1,
            "total_records": 3,
            "scrdata_lab_category": [],
        };

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
                    d.scr_name = "app_screens";
                    return d;
                },
            },
            "columns": [
                { 
                    data: "name"
                },
                { 
                    data: "store_proc",
                },
                { 
                    data: "client_type",
                },
                { 
                    data: "scrdata_id",
                },
                { 
                    data: "weblink",
                },
                { 
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="edit('+
                        "'"+row.id+"',"+
                        "'"+row.name+"',"+
                        "'"+row.store_proc+"',"+
                        "'"+row.client_type+"',"+
                        "'"+row.scrdata_id+"',"+
                        "'"+row.weblink+"'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                        "'"+row.id+"',"+
                        "'"+row.name+"',"+
                        "'"+row.store_proc+"',"+
                        "'"+row.client_type+"',"+
                        "'"+row.scrdata_id+"',"+
                        "'"+row.weblink+"'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });


        $("#form_data").validate({
            submitHandler:function(form){

                let input = {
                        "scrdata_id": 1071,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = parseInt(gotForm.item_id);
                input.app_screens = [gotForm];

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

        function edit(
            id,
            name,
            store_proc,
            client_type,
            scrdata_id,
            weblink,
        ) {
            $("#form_data input[name=item_id]").val(id);
            $("#form_data input[name=name]").val(name);
            $("#form_data input[name=store_proc]").val(store_proc);
            $("#form_data input[name=client_type]").val(client_type);
            $("#form_data input[name=scrdata_id]").val(scrdata_id);
            $("#form_data input[name=weblink]").val(weblink);
        }

        function add() {
            $("#form_data input[name=item_id]").val(0);
            $("#form_data input[name=name]").val("");
            $("#form_data input[name=description]").val("");
        }

        function destroy(
            id,
            name,
            store_proc,
            client_type,
            scrdata_id,
            weblink,
        ) {
            let input = {
                "scrdata_id": 1071,
                "session_id": json.session_id,
                "session_exp": json.session_exp,
                "item_id":id,
                "status": "OK",
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
                "app_screens": [
                    {
                        "id": id,
                        "name": name,
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