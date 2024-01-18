@extends('compro.beautypro.layouts.master')

@push('style')
<!-- gallery style -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style>
        

        /* gallery css */
        div.head_background h1{
            font-weight: 700;
            font-size: 50pt;
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
            opacity:0.7;
            position: relative;
        }

        .box img{
            width:100%;
            margin:0;
            padding:0;
            object-fit: cover;
            height: 315px;
        }

        #gallery .caption{
            padding:10px;
            margin:0;
            font-size: 20px;
            font-weight: bold;
        }

        #gallery .box:hover{
            opacity: 1;
            transition: transform 0.5s ease-in-out;
            z-index: 999999;
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

        div.head_background h3{
            font-size: 30pt;
            font-weight: 700;
        }
        div.head_background{
            background-image: url(/images/about.png);
            background-repeat: no-repeat;
            background-size: cover;
            text-align: center;
            /* padding: 2rem 1rem; */
            padding: 8rem 0rem;
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
    <div class="head_background">
            <h1>OUR GALLERY</h1>
        </div>
        <div class="container py-5">

          <nav id="menu" class="nav nav-pills nav-justified mb-3">
            <a class="nav-item nav-link active" href="#gambar" role="tab" data-toggle="tab">Gambar</a>
            <a class="nav-item nav-link" href="#video" role="tab" data-toggle="tab">Video</a>
          </nav>
          
          <!-- Tab panes -->
          <div class="tab-content">

            <div role="tabpanel" class="tab-pane fade show active" id="gambar">
              <div class="gallery_container">
                <a class="box" data-fslightbox="gallery" href="/images/asian-cosmetician-giving-caucasian-client-face-massage 3.png">
                  <img src="/images/asian-cosmetician-giving-caucasian-client-face-massage 3.png" alt="image1">
                </a>
                <a class="box" data-fslightbox="gallery" href="/images/asian-cosmetician-giving-caucasian-client-face-massage 4.png">
                  <img src="/images/asian-cosmetician-giving-caucasian-client-face-massage 4.png" alt="image1">
                </a>
              </div>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="video">
              <div class="gallery_container">
                <a class="box" data-fslightbox="gallery" href="/mov_bbb.mp4">
                  <div class="icon-play">	
                    <i class="fa fa-play-circle-o"></i>
                  </div>
                  <img src="/images/asian-cosmetician-giving-caucasian-client-face-massage 5.png" alt="image1">
                </a>
              </div>
            </div>


          </div>
        </div>
    <!-- MAIN section -->
    
@endsection

@push('javascript')
<!-- gallery script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.9/index.min.js"></script>
@endpush