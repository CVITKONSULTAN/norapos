@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | Screen Data Lab Status' )

@section('css')
    <!-- One of the following themes -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/> <!-- 'classic' theme -->
    <style>
        .action_form{
            padding-top: 25px;
        }
        .input-group .input-group-addon {
            padding-right: 0px;
            padding-left: 0px;
            padding-top: 0px;
            padding-bottom: 0px;
        }
        #color-picker-container{
            background-color: rgb(66, 68, 90);
        }
        .box_color{
            height: 20px;
            width: 20px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')
@include('tastypointsapi::layouts.nav')


<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Screen Data Lab Status</h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <form id="form_data">
                    @csrf
                    <input type="hidden" name="item_id" value="0" />

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status Name:</label>
                                <div class="input-group">
                                    <input class="form-control" value="" name="name" required/>
                                    <span class="input-group-addon" id="color-picker-container"><div class="color-picker"></div></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Description</label>
                                <input class="form-control" value="" name="description"/>
                            </div>
                        </div>
                        <div class="col-md-4 action_form">
                            <button onclick="add()" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> New</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save / Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="main_page">
                    <div class="table_container">
                        <table class="table table-bordered table-striped" id="table_data">
                            <thead>
                                <tr>
                                    <th>Status Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')

    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <script>
        const pickr = Pickr.create({
            el: '.color-picker',
            theme: 'classic', // or 'monolith', or 'nano'
            padding: 0,

            swatches: [
                'rgba(244, 67, 54, 1)',
                'rgba(233, 30, 99, 0.95)',
                'rgba(156, 39, 176, 0.9)',
                'rgba(103, 58, 183, 0.85)',
                'rgba(63, 81, 181, 0.8)',
                'rgba(33, 150, 243, 0.75)',
                'rgba(3, 169, 244, 0.7)',
                'rgba(0, 188, 212, 0.7)',
                'rgba(0, 150, 136, 0.75)',
                'rgba(76, 175, 80, 0.8)',
                'rgba(139, 195, 74, 0.85)',
                'rgba(205, 220, 57, 0.9)',
                'rgba(255, 235, 59, 0.95)',
                'rgba(255, 193, 7, 1)'
            ],

            components: {

                // Main components
                preview: true,
                opacity: true,
                hue: true,

                // Input / output Options
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        });

        let color = "#000000";
        pickr.on('save', (colour, instance) => {
            // console.log('Event: "save"', color, instance);
            color = colour.toHEXA().toString();
            $("#color-picker-container").css("background-color",color);
        });
    </script>

    <script>

        let json = {
            "scrdata_id": 1106,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 1,
            "max_row_per_page": 50,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 1,
            "total_records": 5,
            "scrdata_lab_status": [],
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
                    d.scr_name = "scrdata_lab_status";
                    return d;
                },
            },
            "columns": [
                { 
                    data: "name",
                    render:function(data,type,row){
                        return '<div class="box_color" style="background:'+row.color+';"></div>'+data;
                    }
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
                        "'"+row.id+"',"+
                        "'"+row.name+"',"+
                        "'"+row.description+"',"+
                        "'"+row.color+"'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                        "'"+row.id+"',"+
                        "'"+row.name+"',"+
                        "'"+row.description+"',"+
                        "'"+row.color+"'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });


        $("#form_data").validate({
            submitHandler:function(form){

                let input = {
                    "scrdata_id": 1107,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                gotForm.color = color;
                input.item_id = gotForm.item_id;
                input.scrdata_lab_status = [gotForm];
                console.log(input);
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

        function edit(id,name,description,colour) {
            $("#form_data input[name=item_id]").val(id);
            $("#form_data input[name=name]").val(name);
            $("#form_data input[name=description]").val(description);
            pickr.setColor(colour);
            color = colour;
        }

        function add() {
            $("#form_data input[name=item_id]").val(0);
            $("#form_data input[name=name]").val("");
            $("#form_data input[name=description]").val("");
            pickr.setColor("#000000");
        }

        function destroy(id,name,description,colour) {
            let input = {
                "scrdata_id": 1107,
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
                "scrdata_lab_status": [
                    {
                        "id": id,
                        "name": name,
                        "description": description,
                        "color": colour,
                        "delete":1,
                    }
                ]
            };
            console.log(input,JSON.stringify(input));
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