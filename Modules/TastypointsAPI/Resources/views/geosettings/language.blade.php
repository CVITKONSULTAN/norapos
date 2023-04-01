@extends('tastypointsapi::geosettings.partials.master')
@section( 'page_name', "Geographic Settings - Language")

@section('page_css')
    <style>
        .table_container{
            margin-top: 20px;
        }
        #add_new{
            margin-right: 20px;
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
                {{-- <div class="col-md-4">
                    <div class="form-group">
                        <label>LANGUAGE</label>
                        <input name="country_name" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>SHORT NAME</label>
                        <input name="country_code" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>SELECT COUNTRY</label>
                        <select class="form-control" name="langauge" required>
                            <option value="en">English</option>
                        </select>
                    </div>
                </div> --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label>name</label>
                        <input name="name" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>lang_display_text</label>
                        <input name="lang_display_text" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>code</label>
                        <input name="code" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-3" style="margin-top: 25px;">
                    {{-- <div class="form-group">
                        <label>SALUTATION</label>
                        <input name="country_name" class="form-control" required />
                    </div> --}}
                    <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-save"></i> Save / Apply</button>
                    <button onclick="add()" type="button" class="btn btn-primary pull-right" id="add_new"><i class="fas fa-plus"></i> New</button>
                </div>
            </div>
        </form>

        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>name</th>
                        <th>lang_display_text</th>
                        <th>code</th>
                        <th>ACTION</th>
                    </tr>
                    {{-- <tr>
                        <th>ID</th>
                        <th>COUNTRY NAME</th>
                        <th>COUNTRY CODE</th>
                        <th>AREA CODES</th>
                        <th>ACTION</th>
                    </tr> --}}
                </thead>
            </table>
        </div>
    </div>

@stop

@section('javascript')
    <script>

        let json = {
            "scrdata_id": 1034,
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
                    d.scr_name = "language";
                    return d;
                },
            },
            "columns": [
                { 
                    data: "id",
                },
                { 
                    data: "name",
                },
                { 
                    data: "lang_display_text",
                },
                { 
                    data: "code",
                },
                { 
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="edit('+
                        "'"+row.id+"',"+
                        "'"+row.name+"',"+
                        "'"+row.lang_display_text+"',"+
                        "'"+row.code+"'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                        "'"+row.id+"',"+
                        "'"+row.name+"',"+
                        "'"+row.lang_display_text+"',"+
                        "'"+row.code+"'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });


        $("#form_data").validate({
            submitHandler:function(form){

                let input = {
                    "scrdata_id": 1035,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = gotForm.item_id;
                input.language = [gotForm];
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

        function edit(id,name,lang_display_text,code) {
            $("#form_data input[name=item_id]").val(id);
            $("#form_data input[name=name]").val(name);
            $("#form_data input[name=lang_display_text]").val(lang_display_text);
            $("#form_data input[name=code]").val(code);
        }

        function add() {
            $("#form_data input").val("");
            $("#form_data input[name=item_id]").val(0);
        }

        function destroy(id,name,lang_display_text,code) {
            let input = {
                "scrdata_id": 1035,
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
                        "lang_display_text": lang_display_text,
                        "code": code,
                    }
                ]
            };

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