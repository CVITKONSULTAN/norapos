@extends('tastypointsapi::communications.partials.master')
@section( 'page_name', "Communications - Sms Messages Template")

@section('page_css')
    <style>
        .item_parameter{
            display: inline-block;
            padding: 5px 20px;
            color: white;
            background-color: #1572e8;
            cursor: pointer;
            margin-right: 10px;
        }
        .item_parameter:hover{
            background: #1367d1;
            border-color: #115bb9;
        }
        .phone-container{
            background-image: url("/tasty/images/wireframe1.png");
            background-size: contain;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0 auto;
        }
        .message{
            background-color: #e5e5eb;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0px 10px 10px;
            width: 80%;
            font-size: 9pt;
            word-break: break-word;
        }
        .phone-container > .inner{
            height: 100%;
            width: 100%;
            padding: 13vh 13% 50vh 13%;
        }
        #list_message{
            overflow-y: scroll;
            overflow-x: none;
            height: 100%;
            width: 100%;
        }
        .phone_header{
            text-align: center;
        }
        .table_container{
            margin-top: 20px;
        }
        @media only screen and (max-width: 600px) {
            .phone-container{
                margin-top: 70px;
            }
        }
    </style>
@endsection

@section('content-header',"Sms Messages Template")


@section('new-box')
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <form id="form_data">
                    @csrf
                    <input type="hidden" name="item_id" value="0" />

                    <div class="row">
                      <div class="col-md-9">
                        <div class="form-group">
                            <label>SMS from:</label>
                            <select name="originator_id" class="form-control" id="sender_dom">
                                <option value="100">SendPulse</option>
                                <option value="999">Twilio</option>
                                @for ($i = 0; $i < 10; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>SMS text:</label>
                            <textarea name="template_text" rows="8" class="form-control" id="text_dom">Please writer your message here...</textarea>
                            <p class="text-right"><span class="char_sms">0</span>/140 Characters <span class="count_sms">1</span> SMS</p>
                        </div>
                        <div class="form-group">
                            <label>Parameters:</label>
                            <div id="container-parameter">
                                <div class="item_parameter" onclick="insertParameter('firstname')">
                                    First Name
                                </div>
                                <div class="item_parameter" onclick="insertParameter('lastname')">
                                    Last Name
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Template Name:</label>
                            <input name="name" class="form-control" placeholder="Enter template name" />
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="description" rows="5" class="form-control" placeholder="Write template description..."></textarea>
                        </div>
                        <button class="btn btn-primary btn-lg pull-right">Save</button>
                      </div>
                      <div class="col-md-3">
                          <div class="phone-container">
                              <div class="inner">
                                  <div class="phone_header" id="sender_sms">
                                    SendPulse
                                  </div>
                                  <div id="list_message">
                                      <div class="message" id="message_sms">
                                        Please writer your message here...
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('main_content')

    <div class="main_page">
        <div class="text-right">
            <button onclick="add()" class="btn btn-primary"> <i class="fas fa-plus"></i> New </button>
        </div>
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Template Name</th>
                        <th>Description</th>
                        <th>SMS From</th>
                        <th>SMS Text</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@section('javascript')
    <script>
        $("#text_dom").keyup(function(){
            let value = $(this).val();
            let counter = value.length;
            if(counter > 140){
                value = value.substring(0, 140);
                $(this).val(value);
            }
            $(".char_sms").html(counter);
            let sms = counter / 140;
            sms = Math.ceil(sms);
                $(".count_sms").html(sms);
            value = value.replace(/\r?\n/g, '<br />');
            $("#message_sms").html(value);
        });

        $("#sender_dom").change(function(){

        let value = $("#sender_dom").find(":selected").text();
            $("#sender_sms").html( value );
        });

        $(document).ready(function() {
            $('select').select2({
                width:"100%",
            });
        });
        function insertParameter(parameter) {
            var cursorPos = $('#text_dom').prop('selectionStart');
            var v = $('#text_dom').val();
            var textBefore = v.substring(0,  cursorPos);
            var textAfter  = v.substring(cursorPos, v.length);

            $('#text_dom').val(textBefore + ''+parameter+'' + textAfter);
        }
    </script>
   <script>

    let json = {
        "scrdata_id": 1044,
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
        "scrdata_lab_category": [],
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
                d.scr_name = "sms_templates";
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
                data: "originator",
            },
            { 
                data: "template_text",
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
                    "scrdata_id": 1045,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
            };
            let gotForm = getFormData($(form));
            gotForm.templ_text = gotForm.template_text;
            input.item_id = gotForm.item_id;
            input.sms_templates = [gotForm];

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
        $("#form_data input[name=name]").val(data.name);
        $("#form_data textarea[name=template_text]").val(data.template_text);
        $("#form_data textarea[name=description]").val(data.description);
        $("#form_data select[name=originator_id]").val(data.originator_id);

    }

    function add() {
        $("#form_data input").val("");
        $("#form_data input[name=item_id]").val(0);
        $("#form_data textarea").val("");
        $("#form_data select").val("");
    }

    function destroy(id) {
        id = parseInt(id);
        let input = {
            "scrdata_id": 1045,
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
            "sms_templates": [
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

    function loadParameters() {
        let input = {
            "scrdata_id": 1090,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 1000,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 1,
            "total_records": 3,
        };

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    let data = JSON.parse(response.data);
                    $("#container-parameter").empty();
                    data.message_parameters.map((item,index)=>{
                        let new_item = 
                        '<div class="item_parameter" '+
                        'onclick="insertParameter('+"'"+item.parameter+"'"+')">'
                        +item.parameter_name+
                        '</div>';
                        $("#container-parameter").append(new_item);
                    });

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    $(document).ready(function(e){
        loadParameters();
    });

</script>
@endsection