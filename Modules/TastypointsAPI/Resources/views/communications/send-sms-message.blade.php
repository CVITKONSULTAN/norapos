@extends('tastypointsapi::communications.partials.master')
@section( 'page_name', "Communications - Send Sms Messages")

@section('page_css')
    <link rel="stylesheet" href="/tasty/js/Emojiarea/dist/reset.css">
    <link rel="stylesheet" href="/tasty/js/Emojiarea/dist/style.css">
    <style>
         #emoji_picker_subject{
            position: absolute;
            /* top: 27px; */
            right: 21px;
        }
        .emoji-picker{
            position: absolute;
            /* right: 39px !important; */
            /* left: auto !important; */
        }
        .emoji-selector > li > a {
            padding: 0px;
        }
        .label_emoji, #input1{
            font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif !important;
        }
    </style>

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
        @media only screen and (max-width: 600px) {
            .phone-container{
                margin-top: 70px;
            }
        }
    </style>
@endsection

@section('content-header',"Send Sms Messages")

@section('main_content')

    <div class="main_page">

        <form id="form_data">
            @csrf
            <input type="hidden" name="item_id" value="0" />

            <div class="row">
              <div class="col-md-9">
                <div class="form-group">
                    <label>SMS from:</label>
                    <select name="originator_id" class="form-control" id="sender_dom" required>
                        <option value="" disabled selected>-- Select --</option>
                        {{-- <option value="11">SendPulse</option>
                        <option value="12">Twilio</option>
                        @for ($i = 0; $i < 10; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor --}}
                    </select>
                </div>
                <div class="form-group">
                    <label>Template:</label>
                    <select name="sms_template_id" class="form-control" id="template_id">
                        <option value="" disabled selected>Select template</option>
                    </select>
                </div>
                <div class="form-group" 
                data-emojiarea data-type="unicode" 
                data-global-picker="false">
                    <label class="label_emoji">SMS text:</label>
                    <div class="emoji-button" id="emoji_picker_subject">&#x1f604;</div>
                    <textarea name="sms_text" rows="8" class="form-control label_emoji" id="text_dom">Please writer your message here...</textarea>
                    <p class="text-right label_emoji"><span class="char_sms">0</span>/140 Characters <span class="count_sms">1</span> SMS</p>
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
                    <label>Tasty lovers:</label>
                    <input id="tasty_loverys_tid" class="form-control" name="tasty_lovers_tid" required />
                    {{-- <select id="tasty_lovers_tid" name="tasty_lovers_tid[]" multiple="multiple" class="form-control"> --}}
                        {{-- @for ($i = 0; $i < 10; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor --}}
                    {{-- </select> --}}
                </div>
                <div class="form-group">
                    <label>Tasty groups:</label>
                    <select name="group_id" class="form-control" id="tasty_group">
                        <option value="" disabled selected>Select user groups</option>
                    </select>
                </div>
                <button class="btn btn-primary btn-lg pull-right">Send</button>
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

@stop

@section('javascript')

    <script src="/tasty/js/Emojiarea/dist/jquery.emojiarea.js"></script>

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
            // $('#tasty_lovers_tid').select2({
            //     createTag: function (params) {
            //         return {id: params.term, text: params.term, newTag: true};
            //     },
            //     multiple: true,
            //     data: []
            // });
        });

        function insertParameter(parameter) {
            var cursorPos = $('#text_dom').prop('selectionStart');
            var v = $('#text_dom').val();
            var textBefore = v.substring(0,  cursorPos);
            var textAfter  = v.substring(cursorPos, v.length);

            $('#text_dom').val(textBefore + '['+parameter+']' + textAfter);
        }
   </script>

   <script>

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
        let temp_template = [];
        function loadTemplate() {
            let input = {
                "scrdata_id": 1044,
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
                        let elm = $("#template_id");
                        // temp_template = data.sms_templates;
                        data.sms_templates.map((item,index)=>{
                            temp_template[item.id] = item;
                            let new_item = '<option data-text="'+item.template_text+'" value="'+item.id+'">'+item.name+'</option>';
                            elm.append(new_item);
                        });
                        // elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $("#template_id").change(function(e){
            let id = $(this).val();
            const data = temp_template[id];
            if(data == undefined) return console.log(id);
            $("#text_dom").val(data.template_text).trigger("change");
        });
        
        function loadOrginator() {
            let input = {
                "scrdata_id": 1088,
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
                        let elm = $("#sender_dom");
                        data.sms_originators.map((item,index)=>{
                            let new_item = '<option value="'+item.id+'">'+item.originator+'</option>';
                            elm.append(new_item);
                        });
                        // elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        function loadGroupee() {
            let input = {
                "scrdata_id": 1020,
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
                        data.tasty_group.map((item,index)=>{
                            let new_item = '<option value="'+item.id+'">'+item.name+'</option>';
                            $("#tasty_group").append(new_item);
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
            loadGroupee();
            loadTemplate();
            loadOrginator();
        });


        $("#form_data").validate({
            submitHandler:function(form){

                let input = {
                        "scrdata_id": 1096,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                gotForm.item_id = parseInt(gotForm.item_id);
                gotForm.originator_id = parseInt(gotForm.originator_id);
                gotForm.sms_template_id = parseInt(gotForm.sms_template_id);
                gotForm.tasty_lovers_tid = gotForm.tasty_lovers_tid.split(",").map((item,index)=>{
                    return parseInt(item);
                });
                delete gotForm["tasty_lovers_tid[]"];
                delete gotForm._token;

                // gotForm.sms_template_id = 1;
                gotForm.contacts_id = [];

                input.item_id = gotForm.item_id;
                // input.send_sms = [gotForm];
                input.send_sms = gotForm;

                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            response = JSON.parse(response);
                            if(response.status){
                                swal("Data has been saved!", {
                                    icon: "success",
                                });
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

   </script>
@endsection