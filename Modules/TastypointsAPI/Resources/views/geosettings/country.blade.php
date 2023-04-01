@extends('tastypointsapi::geosettings.partials.master')
@section( 'page_name', "Geographic Settings - Country")

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
                <div class="col-md-6">
                    <div class="form-group">
                        <label>COUNTRY NAME</label>
                        <input name="name" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>COUNTRY CODE</label>
                        <input name="country_code" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>LANGUAGE</label>
                        <select class="form-control" name="language_id" required>
                            <option value="" selected disabled>-- Select --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CURRENCY</label>
                        <select class="form-control" name="currency_id" required>
                            <option value="" selected disabled>-- Select --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>AREA CODES</label>
                        <textarea name="area_codes" required rows="5" class="form-control"></textarea>
                    </div>
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
                        <th>COUNTRY NAME</th>
                        <th>COUNTRY CODE</th>
                        <th>AREA CODES</th>
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
            "scrdata_id": 1010,
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
                    d.scr_name = "country";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data[item.id] == undefined ? temp_data[item.id] = item : temp_data[item.id] = item;
                    });
                    return json.data;
                }  
            },
            "columns": [
                { 
                    data: "id",
                },
                { 
                    data: "name",
                },
                { 
                    data: "country_code",
                },
                { 
                    data: "area_code",
                    render:function(data,type,row){
                        try{
                            return data.join();
                        } catch(e){
                            return "-";
                        }
                    }
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
                    "scrdata_id": 1011,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = gotForm.item_id;
                
                try {
                    gotForm.area_code = gotForm.area_codes.split(",");
                    let lang_id = parseInt(gotForm.language_id);
                    let lang_data = language[lang_id];
                    lang_data.language_id = lang_id;
                    gotForm.language = lang_data;
                    let cur_id = parseInt(gotForm.currency_id);
                    let cur_data = currency[cur_id];
                    cur_data.currency_id = cur_id;
                    gotForm.currency = cur_data;
                } catch (error) {
                    gotForm.area_code = [];
                    gotForm.language = [];
                    gotForm.currency = [];
                }

                input.country = [gotForm];
                console.log(JSON.stringify(input));
                
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
            let data = [];
            let area = "";
            try {
                data = temp_data[id];
                area = data.area_code.join();
            } catch (error) {
                console.log(error);
            }
            // console.log(data);
            $("#form_data input[name=item_id]").val(id);
            $("#form_data input[name=name]").val(data.name);
            $("#form_data input[name=country_code]").val(data.country_code);
            $("#form_data textarea[name=area_codes]").val(area);
            $("#form_data select[name=currency_id]").val(data.currency.currency_id);
            $("#form_data select[name=language_id]").val(data.language.language_id);
        }

        function add() {
            $("#form_data input").val("");
            $("#form_data select").val("");
            $("#form_data textarea").val("");
            $("#form_data input[name=item_id]").val(0);
        }

        function destroy(id) {
            let data = temp_data[id];
            let input = {
                "scrdata_id": 1011,
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
                "country":data,
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

        let language = [];
        function load_language() {
            let input = {
                "scrdata_id": 1034,
                "session_id": json.session_id,
                "session_exp": json.session_exp,
                "item_id": 0,
                "max_row_per_page": 100000,
                "search_term": "",
                "search_term_header": "",
                "pagination": 1,
                "sp_name": "OK",
                "status": "OK",
            };
            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{input:JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        $("#form_data select[name=language_id]").empty();
                        data.language.map((item,index)=>{
                            language[item.id] = item;
                            $("#form_data select[name=language_id]").append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                    }
                },
                error:function(error){

                }
            });
        }

        let currency = [];
        function load_currency() {
            let input = {
                "scrdata_id": 1036,
                "session_id": json.session_id,
                "session_exp": json.session_exp,
                "item_id": 0,
                "max_row_per_page": 100000,
                "search_term": "",
                "search_term_header": "",
                "pagination": 1,
                "sp_name": "OK",
                "status": "OK",
            };
            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{input:JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        $("#form_data select[name=currency_id]").empty();
                        data.currency.map((item,index)=>{
                            currency[item.id] = item;
                            $("#form_data select[name=currency_id]").append('<option value="'+item.id+'">'+item.short_name+'</option>');
                        });
                    }
                },
                error:function(error){

                }
            });
        }

        $(document).ready(function(e){
            load_language();
            load_currency();
        });
        
    </script>
@endsection