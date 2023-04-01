@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - POS Setup")

@section('page_css')
    <style>
        .form-horizontal{
            padding: 20px 31px;
            border: 1px solid #E5E5E5;
        }
        .nav-tabs-custom>.nav-tabs>li > a {
            color: #FFFFFF;
        }
        .nav-tabs-custom>.nav-tabs>li {
            background: #C4C4C4;
        }
        .nav-tabs-custom>.nav-tabs>li.active {
            background: #3c8dbc;
        }
        .nav-tabs-custom>.nav-tabs>li:first-of-type.active>a,
        .nav-tabs-custom>.nav-tabs>li.active:hover>a, .nav-tabs-custom>.nav-tabs>li.active>a
        {
            background: #3c8dbc;
            color: #FFFFFF;
        }
        .sound-logo{
            height: 30px;
            width: 30px;
        }
        .play-logo{
            height: 20px;
            width: 20px;
        }
        @media (min-width: 768px) {
           .form-horizontal .control-label {
               text-align: left !important;
           }
           .form-horizontal .form-title{
                top: 97px;
                position: absolute;
                font-size: 13pt;
                line-height: 15.23px;
           }
           .form-horizontal{
            margin-bottom: 30px;
            margin-top: 24px;
           }
        }
    </style>
@endsection

@section('content-header',"POS Setup")

@section('main_content')

    <div class="modal" id="modal_video">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>

                    <video id="video_player" width="100%" controls>
                        <source src="#" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>
            </div>
        </div>
    </div>

    <input id="selectedSound" accept="audio/*" name="file" type="file" style="display: none;" />

    <div class="main_page">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs nav-justified">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Manage Sound</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Manage Screensaver</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Activation Message</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <form id="form_sound" class="form-horizontal" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="0" />

                        <p class="form-title">Sound Group</p>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sound Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" required name="sound_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Upsell Sound</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-sm">
                                    <input type="url" name="upsell_sound" type="text" class="form-control" required>
                                    <span class="input-group-btn">
                                        <button onclick="browse_data(this,'audio/*')" type="button" class="btn btn-primary btn-flat btn-lg">Browse</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Scan Sound</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-sm">
                                    <input type="url" name="scan_sound" type="text" class="form-control" required>
                                    <span class="input-group-btn">
                                        <button onclick="browse_data(this,'audio/*')" type="button" class="btn btn-primary btn-flat btn-lg">Browse</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Scan Fail</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-sm">
                                    <input type="url" name="scan_fail_sound" type="text" class="form-control" required>
                                    <span class="input-group-btn">
                                        <button onclick="browse_data(this,'audio/*')" type="button" class="btn btn-primary btn-flat btn-lg">Browse</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Reward Fail</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-sm">
                                    <input type="url" name="reward_fail_sound" type="text" class="form-control" required>
                                    <span class="input-group-btn">
                                        <button onclick="browse_data(this,'audio/*')" type="button" class="btn btn-primary btn-flat btn-lg">Browse</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-primary btn-lg">Save/Change</button>
                                <button onclick="addNew(this)" type="button" class="btn btn-success btn-lg">Add New Sound</button>
                            </div>
                        </div>
                    </form>
                    <div class="table_container">
                        <table id="table_sound" class="table table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Sound Name</th>
                                    <th>Upsell Sound</th>
                                    <th>Scan</th>
                                    <th>Scan Fail</th>
                                    <th>Reward Fail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
              <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <form id="form_screensaver" class="form-horizontal" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="0" />
                        <p class="form-title">Screensaver Group</p>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Screensaver timeout</label>
                            <div class="col-sm-10">
                                <input name="screensaver_timeout" class="form-control" placeholder="60" required type="number" min="10">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title / Name</label>
                            <div class="col-sm-10">
                                <input name="screensaver_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Screensaver Media</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-sm">
                                    <input name="screensaver_media" type="url" type="text" class="form-control" required>
                                    <span class="input-group-btn">
                                        <button onclick="browse_data(this,'video/*')" type="button" class="btn btn-primary btn-flat btn-lg">Browse</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-primary btn-lg">Save/Change</button>
                                <button onclick="addNew(this)" type="button" class="btn btn-success btn-lg">Add New Sound</button>
                            </div>
                        </div>
                    </form>
                    <div class="table_container">
                        <table id="table_screensaver" class="table table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Screensaver timeout</th>
                                    <th>Title/Name</th>
                                    <th>Screensaver Media</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
              <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <form id="form_status" class="form-horizontal" method="POST">
                        @csrf
                        <input name="item_id" type="hidden" value="0" />
                        <p class="form-title">Message Group</p>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status Message</label>
                            <div class="col-sm-10">
                                <input name="status_msg" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-primary btn-lg">Save/Change</button>
                                <button onclick="addNew(this)" type="button" class="btn btn-success btn-lg">Add New Sound</button>
                            </div>
                        </div>
                    </form>
                    <div class="table_container">
                        <table id="table_status" class="table table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Status Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    </div>

@stop

@section('javascript')
    <script>

        let json = {
            "scrdata_id": 1076,
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

        let json_sound = {
            "scrdata_id": 1256,
            "sp_name": "OK",
            "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
            "session_exp": "05/29/2015 05:50:06",
            "max_row_per_page": 0,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 0,
            "status": "OK",
            "item_id": 0,
            "lab_test": 1,
            "pos_sound": []
        };

        function playSound(url) {
            var audio = new Audio(url);
            audio.play();
        }

        function renderAudio(data,type,row) {
            if(data == null || data == "") return "";
            return `<a href="javascript:void(0)" onclick="playSound('${data}')">
                <img class="sound-logo" src="https://s3-alpha-sig.figma.com/img/0804/b85b/100be87de1a4a0fb2538a070b998c9ba?Expires=1628467200&Signature=hrzH3u7eecVQISGTSj5bLf9Jq1Rk-t7sWPyx0ZeQBAoDVONflGQ04ujwIVmyQGpuGCmrm9mpBcNdVzjEhaxc3M~uyLLu4ZTidt6e22a4vz6sf8lZuqteylVukXBr7Vy79kynidNtpfQ~3BxABddzjx2kMIDDpbcZCdOZBOBd7nZGD7CPP28Nr6bXR3W5wjGB2yHufmu3RomTO5eLmubZMOnmzjev3NAEyIbDrqJJFx6zUH2LmsIwR~ItJ0z37mOgLVSYCBPnkHrltsfU6UFvBTmzbMJNRDLn~ry8hzOzgrY0nSy2XajqPRVRHck1vcGb5GHHInmbWSKRq7jFeoupug__&Key-Pair-Id=APKAINTVSUGEWH5XD5UA" />
                <p>${data}</p>
            </a>`;
        }

        let temp_data_sound = [];
        let sound_table = $("#table_sound").DataTable({
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
                    d.input = JSON.stringify(json_sound);
                    d.scr_name = "pos_sound";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data_sound[item.id] = item;
                    });
                    return json.data;
                },
            },
            "columns": [
                { 
                    data: "sound_name"
                },
                { 
                    data: "upsell_sound",
                    className:"text-center",
                    render:(data,type,row) => renderAudio(data,type,row)
                },
                { 
                    data: "scan_sound",
                    className:"text-center",
                    render:(data,type,row) => renderAudio(data,type,row)
                },
                { 
                    data: "scan_fail_sound",
                    className:"text-center",
                    render:(data,type,row) => renderAudio(data,type,row)
                },
                { 
                    data: "reward_fail_sound",
                    className:"text-center",
                    render:(data,type,row) => renderAudio(data,type,row)
                },
                { 
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="edit('+
                        "'"+data+"','sound'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                        "'"+data+"','sound'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });

        let temp_elm;
        let temp_elm_btn;
        function browse_data(elm,type) {
            temp_elm_btn = $(elm);
            let input = $(elm).parent().parent().find("input");
            temp_elm = input;
            $("#selectedSound").attr("accept",type);
            $("#selectedSound").trigger("click");
        }

        $("#selectedSound").change(function(e){
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
                        $("#selectedSound").val("");
                    }
                },
                complete:function(){
                    temp_elm_btn.html('Browse');
                    temp_elm_btn.removeAttr('disabled');
                }
            });
        });

        $("#form_sound").validate({
            submitHandler:function(form){

            let input = {
                "scrdata_id": 1257,
                "sp_name": "OK",
                "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
                "session_exp": "05/29/2015 05:50:06",
                "item_id": 0,
                "lab_test":1,
                "pos_sound": [
                    {
                    "upsell_sound": "http://google.com",
                    "scan_sound": "",
                    "scan_fail_sound": "",
                    "reward_fail_sound": ""
                    }
                ]
            };

            // input = {
            //         "scrdata_id": 1257,
            //         "session_id": "{{ Request::get("session")->session_id }}",
            //         "session_exp": "{{ Request::get("session")->session_exp }}",
            // };
            // let gotForm = getFormData($(form));
            // input.item_id = parseInt(gotForm.item_id);
            // input.pos_sound = [gotForm];

            console.log(input);
            Pace.track(function(){

                $.ajax({
                    url:'{{ route("tastypointsapi.testnet") }}',
                    type:"post",
                    data:{"input":JSON.stringify(input)},
                    success:function(response){
                        swal("","Data has changed","success");
                        sound_table.draw(false);
                    },
                    error:function(error){
                        console.log(error);
                    }
                });

            });
            return false;
            }
        });

        function edit(id,type) {
            let form,data;
            switch (type) {
                case "sound":
                    form = $("#form_sound");
                    data = temp_data_sound[id];
                    break;
                case "screensaver":
                    form = $("#form_screensaver");
                    data = temp_data_sc[id];
                    break;
                default:
                    form = $("#form_status");
                    data = temp_data_status[id];
                    break;
            }
            for(key in data){
                let value = data[key];
                if(key == "id") key = "item_id";
                form.find("input[name="+key+"]").val(value);
            }
            
        }

        function destroy(id,type) {
            id = parseInt(id);
            let input = {
                "scrdata_id": 1257,
                "session_id": json.session_id,
                "session_exp": json.session_exp,
                "delete": 1,
                "item_id":id,
            };
            switch (type) {
                case "sound":
                    input.scrdata_id = 1257;
                    input.pos_sound = [
                        {
                            "id": id,
                            "detele":1
                        }
                    ];
                    break;
                case "screensaver":
                    input.scrdata_id = 1259;
                    input.pos_screensaver = [
                        {
                            "id": id,
                            "detele":1
                        }
                    ];
                    break;
                default:
                input.scrdata_id = 1261;
                    input.pos_activation_message = [
                        {
                            "id": id,
                            "detele":1
                        }
                    ];
                    break;
            }
            console.log(input);
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
                                    switch (type) {
                                        case "sound":
                                            sound_table.draw(false);
                                            break;
                                    
                                        default:
                                            break;
                                    }
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

        function addNew(elm) {
            let form = $(elm).parents("form");
            form.find("input").val("");
            form.find("input[name=item_id]").val(0);
        }
    </script>

    <script>

        function playVideo(url) {
            let video = $("#video_player");
            console.log(video);
            video.find("source").attr("src",url);
            $("#modal_video").modal("show");
            video[0].load();
        }

        let json_video = {
            "scrdata_id": 1258,
            "sp_name": "OK",
            "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
            "session_exp": "05/29/2015 05:50:06",
            "max_row_per_page": 0,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 0,
            "status": "OK",
            "lab_test": 1,
            "item_id": 0,
            "pos_screensaver": []
        };

        let temp_data_sc = [];
        let sc_table = $("#table_screensaver").DataTable({
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
                    d.input = JSON.stringify(json_video);
                    d.scr_name = "pos_screensaver";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data_sc[item.id] = item;
                    });
                    return json.data;
                },
            },
            "columns": [
                { 
                    data: "screensaver_timeout"
                },
                { 
                    data: "screensaver_name"
                },
                { 
                    data: "screensaver_media",
                    render:(data,type,row) => {
                        if(data == null || data == "") return "";
                        return `<a href="javascript:void(0)" onclick="playVideo('${data}')">
                            <p>
                                <img class="play-logo" src="https://s3-alpha-sig.figma.com/img/0290/2811/f8afc76c84ab9d721130a3809f5fe02e?Expires=1628467200&Signature=hrEbp3TTQmXPUaqqxeogLgs~ZqHmhJA5Qzg6FotEbzliHL7hVcnHOWYNsuL-G9ntJCxQiMM~5pQ37hxYnedsFYOutpUA0nBBEYUFnvFTID-io9tcfsqrkqOnTifoQO0~MrWYK~0tnQiPgFtQPppBP-8brXb7ffQYj4q8zJEczMHWNSODkwrbWGc1fxiUAfpzQlw5MI0xCgqIvwf7oHpZ4TDHU6i9YkrE~6PYopYCNfVCa3WOn1MCg1O5mK4yn0sCSntmljXFgc1w72eDDbb8LrGz8kdZE9cmflZ09asWd7bLwpYsZBHnObTE1YZlf2JiE2bFoTU2Athtz9WhQlPU3Q__&Key-Pair-Id=APKAINTVSUGEWH5XD5UA" /> 
                                ${data}
                            </p>
                        </a>`;
                    }
                },
                { 
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="edit('+
                        "'"+data+"','screensaver'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                        "'"+data+"','screensaver'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });

        $("#form_screensaver").validate({
            submitHandler:function(form){

            let input = {
                "scrdata_id": 1259,
                "sp_name": "OK",
                "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
                "session_exp": "05/29/2015 05:50:06",
                "lab_test": 1,
                "item_id": 0,
                "pos_screensaver": [
                    {
                    "screensaver_name": "Smoke blue",
                    "screensaver_timeout": 30,
                    "screensaver_media": "https://cdn.videvo.net/videvo_files/video/free/2016-11/small_watermarked/Smoke_Light_08_Videvo_preview.webm"
                    }
                ]
            };

            // input = {
            //         "scrdata_id": 1259,
            //         "session_id": "{{ Request::get("session")->session_id }}",
            //         "session_exp": "{{ Request::get("session")->session_exp }}",
            // };
            // let gotForm = getFormData($(form));
            // input.item_id = parseInt(gotForm.item_id);
            // input.pos_screensaver = [gotForm];

                console.log(input);
                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            swal("","Data has changed","success");
                            sound_table.draw(false);
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

    <script>

        let json_status = {
        "scrdata_id": 1260,
        "sp_name": "OK",
        "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
        "session_exp": "05/29/2015 05:50:06",
        "max_row_per_page": 0,
        "search_term": "0",
        "search_term_header": "0",
        "pagination": 0,
        "status": "OK",
        "lab_test": 1,
        "item_id": 0,
        "pos_activation_message": []
        };

        let temp_data_status = [];
        let table_status = $("#table_status").DataTable({
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
                    d.input = JSON.stringify(json_status);
                    d.scr_name = "pos_activation_message";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data_status[item.id] = item;
                    });
                    return json.data;
                },
            },
            "columns": [
                { 
                    data: "status_msg"
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

        $("#form_status").validate({
            submitHandler:function(form){

                // let input = {
                //         "scrdata_id": 1261,
                //         "session_id": "{{ Request::get("session")->session_id }}",
                //         "session_exp": "{{ Request::get("session")->session_exp }}",
                //         "sp_name": "OK",
                //         "lab_test": 1,
                // };
                // let gotForm = getFormData($(form));
                // input.item_id = parseInt(gotForm.item_id);
                // input.pos_screensaver = [gotForm];

                let input = {
                    "scrdata_id": 1261,
                    "sp_name": "OK",
                    "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
                    "session_exp": "05/29/2015 05:50:06",
                    "lab_test": 1,
                    "item_id": 0,
                    "pos_activation_message": [
                        {
                        "status_msg": "Sorry, your account is temporarly disabled"
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
                            table_status.draw(false);
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