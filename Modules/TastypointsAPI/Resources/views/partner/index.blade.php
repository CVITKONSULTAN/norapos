@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - All Partners")

@section('page_css')
    <style>
        .table_container{
            margin-top: 20px;
        }
        #add_new{
            margin-right: 20px;
        }
        #table_data .action_btn {
            text-align: center;
        }
        #table_data .action_btn button,a {
            margin: 0px 5px;
        }
    </style>
@endsection

@section('content-header',"All Partners")

@section('main_content')

    <div tabindex="-1" class="modal fade docs-cropped" id="add_new_staff" role="dialog" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Staff Data</h4>
            </div>
            <form id="form_staff">
                @csrf
                <input type="hidden" name="item_id" value="0" />
                <input type="hidden" name="tpartner_id" value="{{ isset($id) ? $id : -1 }}" />
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text">Tasty Lover ID:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                    <input name="tid" required type="number" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text">Business Name:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-briefcase"></i></span>
                                    <input 
                                    readonly 
                                    name="tpartner_name" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text">Staff Status:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-users"></i></span>
                                    <select required name="staff_status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text">Direct Phone #:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-phone-alt"></i></span>
                                    <input required name="direct_phone_num" type="number" class="form-control" placeholder="Alternate contact number" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text">Extension #:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                    <input required name="extension_num" type="number" placeholder="Extension number" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text">Email:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                                    <input required name="company_email" type="text" placeholder="Email" type="email" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="text">Prefix:</label>
                                <input name="prefix" type="text" placeholder="Mr / Mrs / Miss" 
                                readonly 
                                class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="text">First Name:*</label>
                                <input name="staff_first_name" type="text" placeholder="First Name" 
                                readonly 
                                class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="text">Middle Name:</label>
                                <input name="staff_middle_name" type="text" placeholder="Middle name" 
                                readonly 
                                class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="text">Last Name:</label>
                                <input name="staff_last_name" type="text" placeholder="Last Name" 
                                readonly 
                                class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text">Staff Title:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-users"></i></span>
                                    <select id="staff_title_id" name="staff_title_id" class="form-control">
                                        <option>Select staff title</option>
                                        {{-- <option value="1">COO</option>
                                        <option value="2">CEO</option>
                                        <option value="3">COQ</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text">Admin Level:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-users"></i></span>
                                    <select name="admin_level_id" id="admin_level"
                                    {{-- readonly  --}}
                                    class="form-control">
                                        <option disabled selected>Select admin level</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text">Pin:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-info"></i></span>
                                    <input id="random_value" required readonly type="number" required name="pin" class="form-control" placeholder="Staff pin" />
                                    <span class="input-group-btn">
                                        <button id="randomPin" type="button" class="btn btn-primary" type="button"><i class="fas fa-random"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
        </div>
    </div><!-- /.modal -->

    <div class="main_page">
        <div class="table-control text-right">
            <a href="{{ route("partner.create") }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
        </div>
        <div class="table_container table-responsive">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Description</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Industry</th>
                        <th>HQ Branch ID</th>
                        <th>Business contact numbers</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Timezone</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@section('javascript')
<script>

    let json = {
        "scrdata_id": 1002,
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
                d.scr_name = "partners";
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
                data: "city.name",
            },
            { 
                data: "country.name",
            },
            { 
                data: "industry.name",
            },
            { 
                data: "hq_branch_id",
            },
            { 
                data: "phone[0].phone",
                render:function(data,type,row){
                    let string = "";
                    row.phone.map((item)=>{
                        string += item.phone+", ";
                    });
                    return string.slice(0, -2); 
                }
            },
            { 
                data: "address",
            },
            { 
                data: "status.name",
            },
            { 
                data: "timezone",
                render:function(data,type,row){
                    return row.timezone == null ? "-" : row.timezone.name;
                }
            },
            { 
                data: "id",
                orderable:false,
                searchable:false,
                className:"action_btn",
                render:function(data,type,row){
                    return '<a class="btn btn-primary btn-xs" href="/tastypointsapi/partner-management/partner/'+data+'/edit">Edit</a>'+
                    '<button class="btn btn-primary btn-xs" onclick="addStaff('+data+')">Add Staff</button>'+
                    '<button class="btn btn-danger btn-xs" onclick="destroy('+
                    "'"+data+"'"+
                    ')">Delete</button>';
                }
            }
        ],
    });

    function destroy(id) {
        id = parseInt(id);
        let data = temp_data[id];
        data.delete = 1;
        let input = {
            "scrdata_id": 1003,
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
            "partners": [
               data
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

    function edit(id) {
        window.location = '/tastypointsapi/partner-management/partner/'+id+'/edit';
    }
    
</script>

<script>

    function addStaff(id) {
        let elm = $("#form_staff");
        elm.find("input").val("");
        elm.find("select").val("");
        elm.find("[name=item_id]").val(0);
        elm.find("[name=tpartner_id]").val(parseInt(id));
        $("#add_new_staff").modal("show");
    }

    // staff script
    $("#form_staff").validate({
        submitHandler:function(form){
            let input = {
                    "scrdata_id": 1047,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
            };
            let gotForm = getFormData($(form));
            input.item_id = parseInt(gotForm.item_id);

             // clean from bracket
             for (var key in gotForm) {
                if(
                    key.includes("_id") ||
                    key.includes("staff_status") ||
                    key.includes("point_amount") ||
                    key.includes("direct_phone_num") ||
                    key.includes("extension_num") ||
                    key.includes("pin") ||
                    key.includes("id")
                ){
                    let val = gotForm[key];
                    gotForm[key] = parseInt(val);
                }
            }

            gotForm.staff_title_name = $("#staff_title_id").find("option:selected").text();

            input.staff = [gotForm];

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
                                $("#json_req").html(JSON.stringify(input,null,2));
                                $("#json_res").html(JSON.stringify(response.data,null,2));
                                $("#modals-debug").modal("show");
                                return;
                            }
                            swal("Data has been recorded!", {
                                icon: "success",
                            });
                            $("#add_new_staff").modal("hide");
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


    function load_staff_title() {
        let input = {
            "scrdata_id": 1086,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 1000,
            "search_term": "",
            "search_term_header":"",
        };

        let elm = $("#staff_title_id");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);
                    // elm.empty();
                    data.staff_title.map((item,index)=>{
                        elm.append('<option value="'+item.id+'">'+item.name+'</option>');
                    });

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    function load_admin_level() {
        let input = {
            "scrdata_id": 1062,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 1000,
            "search_term": "",
            "search_term_header":"",
        };

        let elm = $("#admin_level");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);
                    // elm.empty();
                    data.admin_level.map((item,index)=>{
                        elm.append('<option value="'+item.admin_level_id+'">'+item.admin_level_name+'</option>');
                    });

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    $(document).ready(function(){
        load_staff_title();
        load_admin_level();
    });

    function makeid(length) {
        var result           = [];
        var characters       = '0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result.push(characters.charAt(Math.floor(Math.random() * 
            charactersLength)));
        }
        return result.join('');
    }

    $("#randomPin").click(function(){
        $("#random_value").val(makeid(4));
    });
</script>
@endsection