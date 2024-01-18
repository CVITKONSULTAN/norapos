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
            <h1>Best Products</h1>
            <h3>BEAUTY PRO CLINIC</h3>
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
            <div class="gallery_container">
                <a data-product="popup" data-id="1" class="box">
                  <img src="/images/asian-cosmetician-giving-caucasian-client-face-massage 3.png">
                  <div class="caption">
                    <h4>NAMA PRODUK</h4>
                    <h5>Rp199.000</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Pellentesque in mauris eget nulla. <span class="read_more">Selengkapnya...</span></p>
                  </div>
                </a>
                <a data-product="popup" data-id="2" class="box">
                  <img src="/images/asian-cosmetician-giving-caucasian-client-face-massage 4.png">
                  <div class="caption">
                    <h4>NAMA PRODUK</h4>
                    <h5>Rp199.000</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Pellentesque in mauris eget nulla. <span class="read_more">Selengkapnya...</span></p>
                  </div>
                </a>
              </div>
          
        </div>
    <!-- MAIN section -->
    
    
@endsection

@push('javascript')
<script>
    $('a[data-product="popup"]').click(function(e){
        const id = $(this).data('id')
        $("#modals").modal("show");
    })
</script>
@endpush