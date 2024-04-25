<!doctype html>
{{-- <html lang="id"> --}}
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','JAP PROFILE')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error{
            color: red;
            font-size: 10pt;
        }
        .form-group{
            margin-bottom: 5px;
        }
        .btn-norapos:hover{
          background-color: #6312AE;
          color: #FFF;
          font-weight: 500;
        }
        .btn-norapos{
          background-color: #6312AE;
          color: #FFF;
        }
    </style>
    @stack('styles')
  </head>
  <body>
    @yield('main')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    @stack('js')
  </body>
</html>