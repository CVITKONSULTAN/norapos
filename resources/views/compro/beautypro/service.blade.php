@extends('compro.beautypro.layouts.master')

@push('style')
<style>
        

        /* gallery css */
        button.btn-primary{
            background-color: var(--primary);
            border: none;
        }
        div.head_background h1{
            font-family: "Scriptina";
            color: var(--primary);
            font-size: 60pt;
        }
        div.head_background h3{
            font-weight: 700;
            font-size: 40pt;
            text-decoration: underline;
            text-decoration-color: var(--primary);
            text-underline-offset: 2rem;
        }
        .nav-pills a.nav-link.active {
          background-color: var(--primary);
          color: var(--white) !important;
          border-radius: 0px;
        }
        #menu.nav a{
          color: var(--primary);
        }
        #menu.nav {
          border: 1px solid var(--primary);
          color: var(--primary);
          font-weight: 700;
        }

        .gallery_container{
            text-align: center;
            margin:auto;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }
        .box{
            cursor: pointer;
            box-sizing:padding-box;
            width:25%;
            border:1px solid #afafaf;
            margin:10px;
            box-shadow: 1px 1px 10px 1px rgba(0,0,0,0.5) ,1px 1px 10px 1px rgba(0,0,0,0.3);
            /* opacity:0.7; */
            opacity:1;
            position: relative;
        }

        .box img{
            width:100%;
            margin:0;
            padding:0;
            object-fit: cover;
            height: 315px;
        }

        .caption{
            padding:10px;
            margin:0;
            text-align: left;
        }

        .caption h4 {
            font-weight: 700;
            font-size: 15pt;
        }
        .caption p span.read_more{
            color: rgba(30, 30, 30, 0.5);
        }
        .caption p {
            font-size: 9pt;
        }
        .caption h5 {
            font-weight: 700;
            font-size: 10pt;
            color: var(--primary);
        }

        .box:hover{
            opacity: 1;
            transition: transform 0.5s ease-in-out;
            z-index: 1;
            transform:scale(1.05);
        }

        #lbt-thumbnails, #lbt-profile_lightbox, #lbt-name_lightbox, #lbt-date_lightbox{
          display: none;
        }

        .box video {
          display: none;
        }

        .icon-play{
          position: absolute;
          width: 100%;
          height: 100%;
          flex: 1;
          display: flex;
          justify-content: center;
          align-items: center;
          font-size: 3rem;
          color: var(--primary);
        }

        div.head_background{
            background-image: url(/images/about.png);
            background-repeat: no-repeat;
            background-size: cover;
            text-align: center;
            /* padding: 2rem 1rem; */
            padding: 8rem 0rem;
        }

        .input-group{
            align-items:center;
        }
        .input-group input.form-control{
            border-radius: 5px !important;
        }
        .input-group label{
            margin: 0;
            margin-right: 1rem;
        }

        div.card-header.active h5 button{
            color: var(--white) !important;
        }
        div.card-header.active{
            background-color: var(--primary);
        }
        button.btn-link{
            width: 100%;
            text-align: left;
            font-weight: 700;
            font-size: 14pt;
            color: var(--primary);
        }
        .btn-link:hover{
            color: var(--primary);
        }

        div.label_before{
            position: absolute;
            left: 15px;
            bottom: 0;
            z-index: 2;
            color: white;
            background: rgb(109 109 109 / 65%);
            padding: 5px;
            border-top-right-radius: 5px;
        }
        div.label_after{
            position: absolute;
            right: 15px;
            bottom: 0;
            z-index: 2;
            color: white;
            background: rgb(109 109 109 / 65%);
            padding: 5px;
            border-top-left-radius: 5px;
        }

        h4.service_name{
            font-size: 20pt;
            font-weight: 700;
            margin-bottom: 1rem;
            margin-top: 2rem;
        }
        h5.normal_price{
            color: rgba(30, 30, 30, 0.4);
            font-size: 15pt;
        }
        h5.best_price{
            color: var(--primary);
            font-size: 25pt;
            font-weight: 700;
        }



        /*========--------- Responsive -------==========*/

        @media(max-width:830px){
            .box{
                width:29%;
            }
        }
        @media(max-width:637px){
            .box{
                width:42%;
            }
        }
        @media(max-width:450px){
            .box{
                width:100%;
            }
        }

        /* gallery css */

    </style>
@endpush

@section('main')

 <!-- MAIN section -->

        <!-- Modal -->
        <div class="modal fade" id="modals" tabindex="2" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="row">
                            <img class="col-md-6" src="https://foodjeespace.nyc3.digitaloceanspaces.com/YLEFZODh.png" />
                            <div class="caption col-md-6">
                                <h4>NAMA PRODUK</h4>
                                <h5>Rp199.000</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Pellentesque in mauris eget nulla dictum molestie.
Cras rhoncus ullamcorper dignissim. Sed venenatis risus in leo
dapibus molestie. Vivamus vel risus facilisis tellus efficitur interdum.
Nunc in tempus nulla, feugiat rhoncus enim. Pellentesque sodales,
nisl sit amet vestibulum venenatis, justo est volutpat sem nec dictum
quam lorem vitae augue. Vivamus dapibus facilisis libero
eget pulvinar.

Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Pellentesque in mauris eget nulla dictum molestie.
Cras rhoncus ullamcorper dignissim. Sed venenatis risus in leo
dapibus molestie. Vivamus vel risus facilisis tellus efficitur interdum.
Nunc in tempus nulla, feugiat rhoncus enim.</p>
                                
<button class="btn btn-primary btn-block">
    <img src="./images/wa logo.svg" />
    PESAN SEKARANG
</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="head_background">
            <h1>Best Offer</h1>
            <h3>SERVICES & TREATMENTS</h3>
        </div>
        <div class="container py-5">

            <div class="row">
                <p class="col-md-6"><b>Rekomendasi Produk Terbaik Kami</b></p>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <label>Search Products :</label>
                        <input type="text" class="form-control" placeholder="Type here..." aria-label="Type here..." aria-describedby="basic-addon2">
                    </div>
                </div>
            </div>

            <div id="accordion">
                <div class="card">
                  <div class="card-header active" id="headingOne">
                    <h5 class="mb-0">
                      <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        IPL REJUVE + FREE IPL NECK
                      </button>
                    </h5>
                  </div>
              
                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <h5>Hasil Treatment IPL REJUVE + FREE IPL NECK</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="before_after_container">
                                    <div class="label_before">Sebelum</div>
                                    <div class="label_after">Sesudah</div>
                                    <div class="beforeAfter">
                                        <img src="/images/before.jpeg" />
                                        <img src="/images/after.jpeg" />
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p>Treatmen ini meredakan masa inflamasi jerawat aktif serta mengeringkan jerawat, meregenerasi kolagen, mengatasi
                                    spider veins ringan, mencerahkan kulit,  menghilangkan noda hitam dan bercak kemerahan di permukaan kulit.</p>
                                <p>Yuk booking treatment pilihanmu sekarang juga..
                                    Alamat Kami BEAUTY PRO CLINIC
                                    Jalan Sepakat 2, UNTAN. Pontianak Tenggara</p>
                                <h4 class="service_name">INFORMASI BIAYA IPL REJUVE + FREE IPL NECK</h4>
                                <h5 class="normal_price">NORMAL PRICE : Rp599.000</h5>
                                <h5 class="best_price">BEST PRICE : Rp199.000</h5>
                                <button class="btn btn-primary btn-block mt-5">
                                    <img src="./images/wa logo.svg" />
                                    PESAN SEKARANG
                                </button>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        DIAMOND GLOW + FREE MELASMA INJECTION
                      </button>
                    </h5>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <h5>DIAMOND GLOW + FREE MELASMA INJECTION</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="before_after_container">
                                    <div class="label_before">Sebelum</div>
                                    <div class="label_after">Sesudah</div>
                                    <div class="beforeAfter">
                                        <img src="https://www.instantlaserclinic.com.au/wp-content/uploads/2021/09/Instant-Laser-Clinic-4-D-Face-Lift-Before-5-1.jpg" />
                                        <img src="https://www.instantlaserclinic.com.au/wp-content/uploads/2021/09/Instant-Laser-Clinic-4-D-Face-Lift-After-5.jpg" />
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p>Treatmen ini meredakan masa inflamasi jerawat aktif serta mengeringkan jerawat, meregenerasi kolagen, mengatasi
                                    spider veins ringan, mencerahkan kulit,  menghilangkan noda hitam dan bercak kemerahan di permukaan kulit.</p>
                                <p>Yuk booking treatment pilihanmu sekarang juga..
                                    Alamat Kami BEAUTY PRO CLINIC
                                    Jalan Sepakat 2, UNTAN. Pontianak Tenggara</p>
                                <h4 class="service_name">INFORMASI BIAYA IPL REJUVE + FREE IPL NECK</h4>
                                <h5 class="normal_price">NORMAL PRICE : Rp599.000</h5>
                                <h5 class="best_price">BEST PRICE : Rp199.000</h5>
                                <button class="btn btn-primary btn-block mt-5">
                                    <img src="./images/wa logo.svg" />
                                    PESAN SEKARANG
                                </button>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>

        </div>
    <!-- MAIN section -->

    
    
@endsection

@push('javascript')
    <!-- services js -->
    <script src="./js/vendor/beforeafter.jquery-1.0.0.min.js"></script>
    <script>
        $("button.btn-link").click(function(e){
            $(".card-header").removeClass("active")
            console.log($(this).closest('.card-header').addClass('active'))
        })
        $(function(){
            $('.beforeAfter').beforeAfter();
        });

    </script>
@endpush