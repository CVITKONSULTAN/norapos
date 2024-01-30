<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title',env('APP_TITLE'))</title>
    <meta name="description" content="{{env('APP_TITLE')}}" />
    <link defer href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link defer href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style type="text/css">
        :root{
            --bs-font-sans-serif:'Poppins', sans-serif;
            --bs-primary:#6312AE;
            --btn-disabled-color-primary: #300558;
        }
        .btn-primary{
            --bs-btn-color: #fff;
            --bs-btn-bg: var(--bs-primary);
            --bs-btn-border-color: var(--bs-primary);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #7b17d9;
            --bs-btn-hover-border-color: #7b17d9;
            --bs-btn-focus-shadow-rgb: 49,132,253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #7b17d9;
            --bs-btn-active-border-color: #7b17d9;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: var(--btn-disabled-color-primary);
            --bs-btn-disabled-border-color: var(--btn-disabled-color-primary);
        }
        .btn-outline-primary {
            --bs-btn-color: var(--bs-primary);
            --bs-btn-border-color: var(--bs-primary);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: var(--bs-primary);
            --bs-btn-hover-border-color: var(--bs-primary);
            --bs-btn-focus-shadow-rgb: 13,110,253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: var(--bs-primary);
            --bs-btn-active-border-color: var(--bs-primary);
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: var(--btn-disabled-color-primary);
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: var(--btn-disabled-color-primary);
            --bs-gradient: none;
        }
        footer{
            background: #44047C;
            padding-bottom: 2rem;
            font-weight: 200;
        }
        footer div.logo_download_container img{
            height: 8vh;
            margin: 1.5rem 0;
        }
        footer div.logo_download_container{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        footer p {
            color: #FFF;
            text-transform: capitalize;
            font-size: 18pt;
        }
        footer img.logo_footer{
            height: 8vh;
        }
        footer input.email_input{
            border-radius: 70px 0px 0px 70px !important;
            min-height: 5vh;
            text-align: center;
        }
        footer button.input_submit{
            width: 50%;
            border-radius: 0px 70px 70px 0px !important;
        }
        nav.navbar{
            background: #FFF;
        }

        .bahasa_container .label{
            display: none;
        }

        @media (min-width: 992px){
            .navbar-expand-lg .navbar-nav .nav-link {
                margin-right: 2rem;
                margin-left: 2rem;
            }
        }

        @media (max-width: 992px){
            .bahasa_container .label{
                display: flex;
                flex-grow: 1;
            }
            .bahasa_container {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            #navItemContainer{
                margin-right: 0px !important;
                display: block;
                width: 100%;
            }
            #navItemContainer .nav-item.line {
                border-bottom: 1px solid #797676;
                margin-bottom: 10px;
            }
            #navItemContainer .nav-item {
                width: 100%;
            }
            #navItemContainer .btn {
                width: 100%;
                margin-bottom: 0.3rem;
            }
            .scrolled .navbar-toggler{
                border-color: #000;
            }
            .scrolled .navbar-toggler-icon{
                background-image: url("./img/webp/menu-black.svg");
            }
            .navbar-toggler-icon{
                background-image: url("./img/webp/menu.svg");
            }
            .navbar-toggler{
                border-color: #FFF;
            }
            .navbar-collapse.collapse.show{
                background: #FFF;
            }
            nav.navbar{
                background: transparent;
            }
            nav.navbar.scrolled{
                background: #FFF;
            }
            footer img.logo_footer{
                height: 4vh;
            }
            footer div.logo_download_container img {
                height: 4vh;
            }
            footer p{
                font-size: 10pt;
            }
        }

    </style>
    @stack('styles')
  </head>
  <body>
    @include('website.layouts.partials.header')
    @yield('main')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const navbarElm = $("#navbar_header");
        const logoElm = $("#logo_img");
        let scrollPosition = 0;
        $(window).scroll(function (event) {
            const scroll = $(window).scrollTop();
            const widthScreen = $(window).width();
            collapsed = $(this).hasClass("collapsed");
            if(scroll > 10){
                navbarElm.addClass("scrolled");
                if(widthScreen <= 992){
                    logoElm.attr("src","/img/logo.svg")
                }
            }else{
                if(collapsed){
                    navbarElm.removeClass("scrolled");
                    if(widthScreen <= 992){
                        logoElm.attr("src","/img/webp/logo-white.svg")
                    }
                }
            }
            scrollPosition = scroll;
        });
        let collapsed = false;
        $(".navbar-toggler").click(function(e){
            collapsed = $(this).hasClass("collapsed");
            const widthScreen = $(window).width();
            if(!collapsed){
                if(scrollPosition <= 0){
                    navbarElm.addClass("scrolled");
                    if(widthScreen <= 992){
                        logoElm.attr("src","/img/logo.svg")
                    }
                }
            } else {
                if(scrollPosition <= 0){
                    navbarElm.removeClass("scrolled");
                    if(widthScreen <= 992){
                        logoElm.attr("src","/img/webp/logo-white.svg")
                    }
                }
            }
        })
        $(document).ready(function(){
            const widthScreen = $(window).width();
            if(widthScreen <= 992){
                logoElm.attr("src","/img/webp/logo-white.svg")
            }
        })
    </script>
    @stack('scripts')
  </body>
</html>