@php
    $data = [
        [
            "q"=>1.00,
            "desc"=>"Arduino Uno R3",
            "price"=>"$25.00",
        ],
        [
            "q"=>2.00,
            "desc"=>"JAVASCRIPT BOOK",
            "price"=>"$10.00",
        ],
        [
            "q"=>1.00,
            "desc"=>"STICKER PACK",
            "price"=>"$10.00",
        ],
    ];    
@endphp
<html>
    <head>
        <title>Print</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&family=Roboto:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <style>
            * { font-size: 17px; font-family: 'Times New Roman'; } 
            td, th, tr, table { 
                border-top: 1px solid black; 
                border-collapse: collapse;
            } 
            td{
                padding: 3px 10px;
            }
            td.description, th.description { 
                width: 75px; 
                max-width: 75px; 
            } 
            td.quantity, th.quantity { 
                width: 40px; 
                max-width: 40px; 
                word-break: break-all;
                text-align: center;
            } 
            td.price, th.price { 
                width: 40px; max-width: 40px; word-break: break-all;
            } 
            .centered { text-align: center; align-content: center; } 
            .ticket { width: 300px;} 
            table{
                width: 100%;
            }
            img { 
                max-width: 40%; 
            }  
            .ticket{ 
                margin: 5px auto;
                text-align: center;
                margin-top: 90px;
            } 
            @media print { 
                .hidden-print, .hidden-print * { display: none !important; } 
            }
            .print {
                width: 100%;
                background: #ff7f32;
                color: white;
                border-width: 1px;
                padding: 15px 0px;
                border: none;
                font-family: 'Nunito Sans','Roboto', sans-serif;
                font-size: 20pt;
                border-radius: 10px;
            }
            .print:disabled {
                background: #e79561;
            }
            .print:disabled i {
                font-size: 20pt;
            }
            body{
                margin: 0px;
            }
            #fix_btn{
                position: fixed;
                top: 10;
                left: 13;
                width: 93%;
            }
        </style>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script>

            const dataURItoBlob = (dataURI,btn,formData) => {
                // convert base64/URLEncoded data component to raw binary data held in a string
                var byteString;
                if (dataURI.split(',')[0].indexOf('base64') >= 0)
                    byteString = atob(dataURI.split(',')[1]);
                else
                    byteString = unescape(dataURI.split(',')[1]);

                // separate out the mime component
                var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

                // write the bytes of the string to a typed array
                var ia = new Uint8Array(byteString.length);
                for (var i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }

                var blob = new Blob([ia], {type:mimeString});
                var url = '{{ route("tastypointsapi.upload.public","image") }}';
                formData.append('file', blob, 'image.png');
                var ar = document.getElementsByTagName("canvas");
                for (i = 0; i < ar.length; ++i)
                    ar[i].style.display = "none";

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        var response  = JSON.parse(xhr.response);
                        btn.removeAttribute('disabled',"");
                        btn.innerHTML = 'Send to kitchen';
                        console.log(response.success);
                        if(response.success){
                            window.ReactNativeWebView.postMessage(response.link);
                        }
                    }
                }

                xhr.open('POST', url, true);
                xhr.send(formData);
            }
            
            function cetak(btn){
                
                var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var formData = new FormData();
                formData.append('_token', csrf);
                btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
                btn.setAttribute('disabled',true);

                html2canvas(document.querySelector("#my-node")).then( canvas => {
                    document.body.appendChild(canvas);
                    var base64 = canvas.toDataURL('image/png');
                    dataURItoBlob(base64,btn,formData);
                });
            }

        </script>
    </head>
    <body>
        <div id="fix_btn" class=".hidden-print">
            {{-- <button onclick="window.print()" class="print">Window.Print()</button> --}}
            <button onclick="cetak(this)" class="print">Send to kitchen</button>
        </div>
        <div id="my-node" class="ticket"> 
            <img src="https://tastypos.onprocess.work/images/logo.png" alt="Logo"> 
            <p class="centered">RECEIPT EXAMPLE <br>Address line 1 <br>Address line 2</p>
            <div class="table-style">
                <table> 
                    <thead> 
                        <tr> 
                            <th class="quantity">Q.</th> 
                            <th class="description">Description</th> 
                            <th class="price">$$</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                        @foreach ($data as $item)    
                            <tr> 
                                <td class="quantity">{{$item["q"]}}</td> 
                                <td class="description">{{ $item["desc"] }}</td> 
                                <td class="price">{{$item["price"]}}</td> 
                            </tr> 
                        @endforeach
                        <tr> 
                            <td class="centered" colspan="2">SUBTOTAL</td> 
                            <td class="price">$10.00</td> 
                        </tr> 
                        <tr> 
                            <td class="centered" colspan="2">TAX</td> 
                            <td class="price">$1.00</td> 
                        </tr> 
                        <tr> 
                            <td class="centered" colspan="2">TOTAL</td> 
                            <td class="price">$11.00</td> 
                        </tr> 
                    </tbody> 
                </table> 
            </div>
            <img style="margin-top: 20px;" src="https://tastypos.onprocess.work/tasty/images/barcode.gif" alt="barcode"> 
            <p class="centered">Thanks for your purchase!</p> 
        </div>
    </body>
</html>