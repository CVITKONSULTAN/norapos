@extends('layouts.app')
@section('title', __('lang_v1.presence'))

@section('css')
<style>
    #player{
        width:100%;
        height:50vh;
    }
    #result{
        display:none;
    }
    #canvas{
        height: 238px;
        width: 330px;
    }
    #control_btn{
        display:none;
    }
    #control_container{
        margin-bottom:20px;
    }
    @media only screen and (max-width: 600px) {
        #canvas{
            width:100%;
            height:50vh;
        }
    }
</style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <!-- <h1>@lang('lang_v1.presence')</h1> -->
    <h1>Tambah Absensi</h1>
</section>

<section class="content">
    <div class="box box-solid"> <!--business info box start-->
        <div class="box-body">
            <div class="text-center" id="control_container">
                <button id="capture" class="btn btn-primary"><i class="fa fa-circle"></i> Simpan</button>
                <div id="control_btn">
                    <button id="retake" class="btn btn-primary"><i class="fa fa-camera"></i> Ambil Ulang</button>
                    <button id="save" class="btn btn-primary"><i class="fa fa-save"></i> Upload</button>
                </div>
            </div>
            <div class="display-wrapper text-center" id="player_container">
                <video id="player" autoplay playsinline></video>
            </div>
            <div id="result" class="text-center">
                <canvas id="canvas"></canvas>
            </div>
        </div>
    </div>
</section>
@endsection

@section("javascript")
<script src="/js/vendor/webrtc/adapter-latest.js"></script>
<script>
    
    // Put variables in global scope to make them available to the browser console.
    const constraints = window.constraints = {
        audio: false,
        video: true
    };

    let player;

    function handleSuccess(stream) {
        player = document.querySelector('#player');
        const videoTracks = stream.getVideoTracks();
        // console.log('Got stream with constraints:', constraints);
        // console.log(`Using video device: ${videoTracks[0].label}`);
        window.stream = stream; // make variable available to browser console
        player.srcObject = stream;
    }

    function handleError(error) {
        if (error.name === 'OverconstrainedError') {
            const v = constraints.video;
            errorMsg(`The resolution ${v.width.exact}x${v.height.exact} px is not supported by your device.`);
        } else if (error.name === 'NotAllowedError') {
            window.location.href = "/pos/create";
            errorMsg('Permissions have not been granted to use your camera and ' +
            'microphone, you need to allow the page access to your devices in ' +
            'order for the demo to work.');
        }
        errorMsg(`getUserMedia error: ${error.name}`, error);
    }

    function errorMsg(msg, error) {
        console.log(msg,error)
    }

    async function init() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            handleSuccess(stream);
        } catch (e) {
            handleError(e);
        }
    }

    $(document).ready(function(){
        init()
    })

    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const captureButton = document.getElementById('capture');
    let coordinates;

    captureButton.addEventListener('click', () => {
        // Draw the video frame to the canvas.
        const btn = $("#capture");
        btn.attr("disabled",true);
        btn.text("Loading...");
        context.drawImage(player, 0, 0, canvas.width, canvas.height);
        context.font = "15px Arial";
        context.fillStyle = "#FFFFFF";
        const time_text = "Waktu : "+new Date().toLocaleString();
        context.fillText(time_text, 5, 35);
        let location_text;
        $("#result").show();
        $("#player_container").hide();
        $("#capture").hide();
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position)=>{
                coordinates = position.coords;
                location_text = `Koordinat : ${position.coords.latitude.toFixed(4)},${position.coords.longitude.toFixed(4)}`;
                context.fillText(location_text, 5, 20);
                $("#control_btn").show();
                btn.removeAttr("disabled");
                btn.html('<i class="fa fa-circle"></i> Simpan');
            });
        } else { 
            // x.innerHTML = "Geolocation is not supported by this browser.";
            alert("Geolocation is not supported by this browser.");
        }
    });

    $("#retake").click(()=>{
        $("#control_btn").hide();
        $("#result").hide();
        $("#player_container").show();
        $("#capture").show();
    })

    const dataStore = (data,btn) => {
        $.ajax({
            method: 'POST',
            url: '{{ route("absensi.store") }}',
            data: data,
            success:result => {
                if(result.status){
                    swal("Berhasil", "Data absensi berhasil di simpan. Terimakasih", "success");
                    btn.removeAttr("disabled");
                    btn.text("Upload");
                    window.location.href = "/absensi/list";
                }else {
                    btn.removeAttr("disabled");
                    btn.text("Upload");
                }
            },
            error: e => {
                console.log(e)
                btn.removeAttr("disabled");
                btn.text("Upload");
            }
        });
    }

    $("#save").click(()=>{
        const photo = $("#canvas")[0].toDataURL('image/png');
        const btn = $("#save");
        btn.attr("disabled",true);
        btn.text("Loading...");
        $.ajax({
            method: 'POST',
            url: '{{ route("upload") }}',
            data: {file_data: photo,absensi:1},
            success:result => {
                console.log(result)
                if(result.status){
                    dataStore({
                        picture:result.data,
                        coordinates:coordinates
                    },btn)
                } else {
                    btn.removeAttr("disabled");
                    btn.text("Upload");
                }
            },
            error: e => {
                console.log(e)
                btn.removeAttr("disabled");
                btn.text("Upload");
            }
        });
    })

</script>
@endsection