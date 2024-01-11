<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title',env('APP_TITLE'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
        @media (min-width: 992px){
            .navbar-expand-lg .navbar-nav .nav-link {
                margin-right: 2rem;
                margin-left: 2rem;
            }
        }
    </style>
    @stack('styles')
  </head>
  <body>
    @include('website.layouts.partials.header')
    @yield('main')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
  </body>
</html>