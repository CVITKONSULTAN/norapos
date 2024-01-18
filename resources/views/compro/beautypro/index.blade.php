@extends('compro.beautypro.layouts.master')

@push('style')
<style>
        /* header */
        .navbar-brand img{
            height: 60px;
            width: 60px;
        }
        h1.head_title{
          color: #1E1E1E;
          font-weight: 700;
          font-size: 16pt;
        }
        span.tagline{
          color: var(--primary);
          font-weight: 400;
          font-size: 13pt;
        }
        nav.navbar-custom{
          background-color: #FFFFFF;
        }
        .navbar-light .navbar-nav .nav-link{
          font-size: 12pt;
          color: #1E1E1E;
          font-weight: 400;
        }
        .navbar-light .navbar-nav .active>.nav-link, .navbar-light .navbar-nav .nav-link.active, .navbar-light .navbar-nav .nav-link.show, .navbar-light .navbar-nav .show>.nav-link {
          color: var(--primary);
          font-weight: 700;
        }

        .testimoni_container p {
          overflow: hidden;
          display: -webkit-box;
          -webkit-line-clamp: 10;
          -webkit-box-orient: vertical;
        }

      /* slider */
      #main_slider.swiper {
        max-height: 75vh;
      }
      .swiper-button-next, .swiper-button-prev{
        color: var(--primary);
      }
      .swiper-pagination-bullet{
        background: #D9D9D9;
        opacity:1;
      }
      .swiper-pagination-bullet-active{
        background: var(--primary);
      }
      img.slide-img{
        width: 100vw;
        height: 100vh;
        object-fit: cover;
      }
      .about{
        font-family: 'Scriptina';
        font-size: 40pt;
        color: var(--primary);
        text-align: center;
        margin-top: 3rem;
      }
      #testimonials{
        background: url("./images/slide2.png");
        background-repeat: no-repeat;
        background-size: cover;
      }

      div.testimoni_container{
        background-color: rgba(30, 30, 30, 0.5);
        color: #FFF;
      }

      section.services_component .img-block.right{
        background-position-x:right;
      }
      section.services_component .img-block{
        height: auto;
        /* width: 125rem; */
        width: 83rem;
        background-repeat: no-repeat;
        background-position-y: top;
      }

      .promo-banner{
        width: 100%;
      }
      footer.page-footer{
        background-color: var(--primary);
        color: var(--white);
      }
      footer hr {
        width: 20%;
        margin: 0;
        border-color: #fff;
      }

      div.footer-copyright{
        background-color: #1E1E1E;
        color: var(--white);
      }
      /* footer h4.head {
        border-bottom: 1px solid var(--white);
      } */

      /* on mobile */
      @media screen and (max-width: 768px) {
        .testimoni_container p{
          -webkit-line-clamp: 5;
        }
        section.services_component .img-block{
          height: 30vh;
          width: 100%;
        }
      }
      /* in desktop */
      @media (min-width: 992px){
        .navbar-expand-lg .navbar-nav .nav-link {
          padding:.5rem 2rem;
        }
        nav.navbar-custom{
          padding: 1rem 3rem;
        }
        .testimoni_container{
          padding-left: 3rem;
          padding-right: 3rem;
        }
        /* section.services_component .content{
          margin-left: 2rem;
        } */
        section.services_component{
          display: flex;
          flex-direction: row;
        }
        .testi-wrapper{
          padding-left: 10rem;
          padding-right: 10rem;
        }
      }
      
</style>
@endpush

@section('main')

    <!-- Slider main container -->
    <div class="swiper" id="main_slider">
      <!-- Additional required wrapper -->
      <div class="swiper-wrapper">
        <!-- Slides -->
        <div class="swiper-slide">
          <img src="./images/slide1.png" class="slide-img" />
        </div>
        <div class="swiper-slide">
          <img src="./images/slide2.png" class="slide-img" />
        </div>
      </div>
      <!-- If we need pagination -->
      <div class="swiper-pagination"></div>

      <!-- If we need navigation buttons -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
    <!-- END Slider main container -->

    <h5 class="about mb-2">About Us</h5>
    <h3 class="text-center mb-5">Beauty Pro Clinic Pontianak</h3>
    <div class="container mb-5">
      <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        Pellentesque in mauris eget nulla dictum molestie. Cras rhoncus ullamcorper dignissim. Sed venenatis risus in leo dapibus molestie.
        Vivamus vel risus facilisis tellus efficitur interdum. Nunc in tempus nulla, feugiat rhoncus enim. Pellentesque sodales, nisl sit amet vestibulum venenatis, justo est volutpat sem
         nec dictum quam lorem vitae augue. Vivamus dapibus facilisis libero eget pulvinar. Proin rhoncus pretium est, non egestas neque condimentum at. Vivamus aliquam mattis aliquet.
        Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam vehicula non elit vel varius. Nullam id vestibulum libero.
        Phasellus dignissim elit ipsum, non tempus erat malesuada sit amet. Phasellus efficitur, erat non efficitur lacinia, dolor risus hendrerit metus, et gravida dolor tortor a diam.</p>
    </div>

    <section id="testimonials" class="p-5">

      <h3 class="text-center pb-5">Testimonials</h3>

      <!-- Slider testimonials container -->
      <div class="swiper" id="testimonials_slider">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">

          <!-- Slides -->
          <div class="swiper-slide testi-wrapper">
            <div class="p-5 testimoni_container">
              <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in mauris eget nulla dictum molestie.
                Cras rhoncus ullamcorper dignissim. Sed venenatis risus in leo dapibus molestie.<br/>
                Vivamus vel risus facilisis tellus efficitur interdum. Nunc in tempus nulla, feugiat rhoncus enim.<br/>
                Pellentesque sodales, nisl sit amet vestibulum venenatis, justo est volutpat sem nec dictum quam<br/>
                lorem vitae augue. Vivamus dapibus facilisis libero eget pulvinar. <br/>
                Proin rhoncus pretium est, non egestas neque condimentum at.<br/>
                Vivamus aliquam mattis aliquet. Orci varius natoque penatibus et magnis dis parturient montes, <br/>
                nascetur ridiculus mus. Aliquam vehicula non elit vel varius. Nullam id vestibulum liberoPhasellus<br/>
                dignissim elit ipsum, non tempus erat malesuada sit amet. Phasellus efficitur, erat<br/>
                non efficitur lacinia, dolor risus hendrerit metus, et gravida dolor tortor a diam.</p>
                <h5 class="text-center pt-5">Nama Pemberi Testi, Pontianak</h5>
            </div>
          </div>
          <div class="swiper-slide testi-wrapper">
            <div class="p-5 testimoni_container">
              <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in mauris eget nulla dictum molestie.
                Cras rhoncus ullamcorper dignissim. Sed venenatis risus in leo dapibus molestie.<br/>
                Vivamus vel risus facilisis tellus efficitur interdum. Nunc in tempus nulla, feugiat rhoncus enim.<br/>
                Pellentesque sodales, nisl sit amet vestibulum venenatis, justo est volutpat sem nec dictum quam<br/>
                lorem vitae augue. Vivamus dapibus facilisis libero eget pulvinar. <br/>
                Proin rhoncus pretium est, non egestas neque condimentum at.<br/>
                Vivamus aliquam mattis aliquet. Orci varius natoque penatibus et magnis dis parturient montes, <br/>
                nascetur ridiculus mus. Aliquam vehicula non elit vel varius. Nullam id vestibulum liberoPhasellus<br/>
                dignissim elit ipsum, non tempus erat malesuada sit amet. Phasellus efficitur, erat<br/>
                non efficitur lacinia, dolor risus hendrerit metus, et gravida dolor tortor a diam.</p>
                <h5 class="text-center pt-5">Nama Pemberi Testi, Pontianak</h5>
            </div>
          </div>
          
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>
      </div>
      <!-- END Slider testimonials container -->
    </section>

    <h5 class="about mb-2">Services</h5>
    <h3 class="text-center mb-5">ACNE, SCARS, PIGMENTATION & MORE</h3>
    <div class="container mb-5">
      <section class="services_component mb-5">
        <div class="img-block" style="background-image: url('/images/services_1.png');background-size:contain;"></div>
        <div class="content">
          <h3 class="name my-3">LOREM IPSUM DOLOR SIT AMET</h3>
          <p class="description mb-5">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in mauris eget
            nulla dictum molestie. Cras rhoncus ullamcorper dignissim. Sed venenatis risus in leo
            dapibus molestie. Vivamus vel risus facilisis tellus efficitur interdum. Nunc in tempus nulla,
            feugiat rhoncus enim. Pellentesque sodales, nisl sit amet vestibulum venenatis, justo
            est volutpat sem nec dictum quam lorem vitae augue. Vivamus dapibus facilisis libero
            eget pulvinar. 
            <ul>
              <li>Skin pigmentation</li>
              <li>Hormonal skin pigmentation</li>
              <li>Melasma and blotchy skin treatment</li>
              <li>Sun damaged skin</li>
              <li>Freckles removal</li>
              <li>Photo rejuvenation</li>
            </ul>

          </p>
        </div>
      </section>
      <section class="services_component mb-5">
        <div class="content">
          <h3 class="name my-3">LOREM IPSUM DOLOR SIT AMET</h3>
          <p class="description mb-5">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in mauris eget
            nulla dictum molestie. Cras rhoncus ullamcorper dignissim. Sed venenatis risus in leo
            dapibus molestie. Vivamus vel risus facilisis tellus efficitur interdum. Nunc in tempus nulla,
            feugiat rhoncus enim. Pellentesque sodales, nisl sit amet vestibulum venenatis, justo
            est volutpat sem nec dictum quam lorem vitae augue. Vivamus dapibus facilisis libero
            eget pulvinar. 
            <ul>
              <li>Skin pigmentation</li>
              <li>Hormonal skin pigmentation</li>
              <li>Melasma and blotchy skin treatment</li>
              <li>Sun damaged skin</li>
              <li>Freckles removal</li>
              <li>Photo rejuvenation</li>
            </ul>

          </p>
        </div>
        <div class="img-block right" style="background-image: url('/images/services_2.png');background-size:contain;"></div>
      </section>
      <section class="services_component mb-5">
        <div class="img-block" style="background-image: url('/images/services_3.png');background-size:contain;"></div>
        <div class="content">
          <h3 class="name my-3">LOREM IPSUM DOLOR SIT AMET</h3>
          <p class="description mb-5">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in mauris eget
            nulla dictum molestie. Cras rhoncus ullamcorper dignissim. Sed venenatis risus in leo
            dapibus molestie. Vivamus vel risus facilisis tellus efficitur interdum. Nunc in tempus nulla,
            feugiat rhoncus enim. Pellentesque sodales, nisl sit amet vestibulum venenatis, justo
            est volutpat sem nec dictum quam lorem vitae augue. Vivamus dapibus facilisis libero
            eget pulvinar. 
            <ul>
              <li>Skin pigmentation</li>
              <li>Hormonal skin pigmentation</li>
              <li>Melasma and blotchy skin treatment</li>
              <li>Sun damaged skin</li>
              <li>Freckles removal</li>
              <li>Photo rejuvenation</li>
            </ul>

          </p>
        </div>
      </section>
    </div>

    <a href="#">
      <img src="/images/banner promo.png" class="promo-banner" />
    </a>

    <div class="embedsocial-hashtag" data-ref="39abddf76b9e56c1959b140a203fbd055d84f3a7"> <a class="feed-powered-by-es feed-powered-by-es-feed-new" href="https://embedsocial.com/social-media-aggregator/" target="_blank" title="Widget by EmbedSocial"> Widget by EmbedSocial<span>→</span> </a> </div> <script> (function(d, s, id) { var js; if (d.getElementById(id)) {return;} js = d.createElement(s); js.id = id; js.src = "https://embedsocial.com/cdn/ht.js"; d.getElementsByTagName("head")[0].appendChild(js); }(document, "script", "EmbedSocialHashtagScript")); </script>

@endsection

@push('javascript')
<script>
    const main_swiper = new Swiper('#main_slider', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    parallax: true,
    autoplay: {
        delay: 5000,
    },
    effect: 'fade',
    fadeEffect: {
        crossFade: true
    },

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: false
    });

    const testimonials_swiper = new Swiper('#testimonials_slider', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    parallax: true,
    autoplay: {
        delay: 5000,
    },

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: false
    });

    $("#year").text(new Date().getFullYear())
</script>
@endpush