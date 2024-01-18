<!doctype html>
<html lang="@yield('language','id')">
  <head>
    <title>@yield('title','Beauty Pro Clinic Pontianak')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('description','Beauty Pro Clinic Pontianak')" />
    <meta property="og:locale" content="@yield('language','id')" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Grow your Business Digitally | In Hyderabad" />
    <meta property="og:description" content="@yield('description','Beauty Pro Clinic Pontianak')" />
    <meta property="og:url" content="{{ Request::fullUrl() }}" />
    <meta property="og:site_name" content="@yield('description','Beauty Pro Clinic Pontianak')" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('title','Beauty Pro Clinic Pontianak')" />
    <meta name="twitter:description" content="@yield('description','Beauty Pro Clinic Pontianak')" />
    <meta name="twitter:image" content="@yield('main_image', Request::url().'/compro/beutypro/Logo.png' )" />
    <meta name="theme-color" content="#C88B09" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
    />

    <style>
      /* variable */
        :root {
            --font-family-sans-serif:'Poppins', sans-serif;
            --font-family-monospace:'Poppins', sans-serif;
            --primary:#C88B09;
            --white:#FFF;
        }
        body{
            font-family: 'Poppins', sans-serif;
        }
        @font-face {
          font-family: 'Scriptina';
          src: URL('./fonts/scriptina/SCRIPTIN.ttf') format('truetype');
        }
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
        .dropdown-item.active, .dropdown-item:active {
          background-color:var(--primary);
        }

        /* Footer  */
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

        /* in desktop */
        @media (min-width: 992px){
            .navbar-expand-lg .navbar-nav .nav-link {
            padding:.5rem 2rem;
            }
            nav.navbar-custom{
            padding: 1rem 3rem;
            }
        }
    </style>
    
    @stack('style')

  </head>
  <body>

    @include('compro.beautypro.layouts.navbar')

    <!-- MAIN section -->
        
    @yield('main')

    <!-- MAIN section -->

    @include('compro.beautypro.layouts.footer')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>

    <!-- Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script>
      $("#year").text(new Date().getFullYear())
    </script>

    @stack('javascript')
  </body>
</html>