@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | '.__('tastypointsapi::lang.verify') )

@section('css')
    <style>
        .steping{
            font-size: 15pt;
        }
        .steping > li{
            padding: 10px 0px;
        }
        #qrcode{
            text-align: center;
            min-height: 259px;
            min-width: 259px;
        }
        #container_reload{
            position: absolute;
            left: 0; 
            right: 0; 
            margin-left: auto; 
            margin-right: auto; 
            height: 259px;
            width: 259px;
            background-color: rgb(255 255 255 / 0.82);
            display: none;
        }
        #reload_qrcode {
            height: 90%;
            width: 90%;
            background-color: rgb(255 127 50 / 0.82);
            color: white;
            border-radius: 50%;
            margin: 5%;
            /* margin: 0 auto; */
        }
        .text_reload{
            text-align: center;
            margin: auto;
            width: 50%;
            padding-top: 35%;
        }
        .text_reload:hover{
            font-weight: bold;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'tastypointsapi::lang.verify' )
        <small>@lang( 'tastypointsapi::lang.verify_desc' )</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="box box-solid">
        
        <div class="box-body">
            <div class="row">

                <div class="col-md-8">
                    <h1>@lang("tastypointsapi::lang.title_instruction")</h1>
                    <ol class="steping">
                        <li>@lang("tastypointsapi::lang.instruction_step1")</li>
                        <li>@lang("tastypointsapi::lang.instruction_step2")</li>
                        <li>@lang("tastypointsapi::lang.instruction_step3")</li>
                    </ol>
                </div>
                <div class="col-md-4">
                    <div id="container_reload">
                        <div id="reload_qrcode">
                            <div class="text_reload">
                                <p><i class="fa fas fa-redo-alt fa-2x"></i></p>
                                <p>CLICK TO RELOAD QRCODE</p>
                            </div>
                        </div>
                    </div>
                    <div id="qrcode"></div>
                </div>

            </div>
        </div>
    </div>

</section>
<!-- /.content -->

<form id="set_session" method="POST" action="{{ route("tastypointsapi.test_session") }}">
    @csrf
    <input id="session_id" type="hidden" name="session" value="" />
</form>

@endsection

@section('javascript')
<!-- <script src="/js/easy.qrcode.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/easyqrcodejs-arm@3.7.2/dist/easy.qrcode.min.js"></script>
<script type="text/javascript">

    // Options
	let options = {
        text: "{{ env("APP_URL") }}",
        logo: "/tasty/images/logo.png",
	};

    let session = null;
    let qrcode = null;
    let count = -1;

    function takeToken() {
        let data = {"scrdata_id":"1000"};
        if(session !== null) data.session_id = session.session_id;
        count = count+1;
        console.log(
            count,
            count % 2
        );
        $.ajax({
            url:"{{ route("tastypointsapi.testnet") }}",
            type:"post",
            data:{"input":JSON.stringify(data)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    let res = JSON.parse(response.data);
                    options.text = res.session_id;
                    
                    session = res;

                    if(qrcode !== null) qrcode.clear();
                    $("#session_id").val(JSON.stringify(res));
                    qrcode = new QRCode(document.getElementById("qrcode"), options);

                    if(count !== 0 && count % 2 == 0){
                        stopSession();
                    }

                    if(res.login !== undefined && res.login == "OK"){
                        $("#set_session").submit();
                        stopSession();
                    }
                    
                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    function checkToken() {
        let data = {"scrdata_id":"1000"};
        if(session !== null) data.session_id = session.session_id;

        $.ajax({
            url:"{{ route("tastypointsapi.testnet") }}",
            type:"post",
            data:{"input":JSON.stringify(data)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    let res = JSON.parse(response.data);
                    options.text = res.session_id;

                    if(res.login !== undefined && res.login == "OK"){
                        $("#set_session").submit();
                        stopSession();
                    }
                    
                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    function startSession(){
        $("#container_reload").hide();
        interval = setInterval(takeToken,10000);
        check_interval = setInterval(checkToken,1000);
    }

    function stopSession(){
        if(check_interval !== null) clearInterval(check_interval);
        if(interval !== null) clearInterval(interval);
        $("#container_reload").show();
    }

    $("#container_reload").click(()=>{
        count = 0;
        startSession();
    });

    let interval = null;
    let check_interval = null;
    
    $(document).ready(()=>{
        takeToken();
        startSession();
    })

</script>

@endsection
