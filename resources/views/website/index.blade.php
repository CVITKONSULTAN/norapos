@extends('website.layouts.app')

@push('styles')
    <style>
          /*         
                HERU
                script for homescreen start from here
        */

        #jumbotron{
            background: url("./img/bg-jumbotron.png");
        }
        #jumbotron .bg_jumbo h1{
            color: #6312AE;
        }
        #jumbotron .bg_jumbo{
                background-color: #6312ae35;
        }
        @media (min-width: 992px){
            .navbar-expand-lg .navbar-nav .nav-link {
                margin-right: 2rem;
                margin-left: 2rem;
            }
            #jumbotron .bg_jumbo{
                padding-top: 8rem;
                padding-bottom: 22rem;
                padding-left: 10rem;
            }
        }
    </style>
@endpush

@section('main')
    <div class="mb-4 bg-body-tertiary rounded-3" id="jumbotron">
        <div class="bg_jumbo">
            <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">NAIK KAN OMSET <br/>& PROFIT BISNIS ANDA</h1>
            <p class="col-md-8 fs-4 py-5">
                Mulai bisnis jadi mudah dengan <br />online kapanpun & dari mana saja
            </p>
            <div class="button_container">
                <button class="btn btn-primary btn-lg" type="button">Uji Coba Gratis Sekarang!</button>
                <button class="btn btn-outline-primary btn-lg" type="button">Masuk</button>
            </div>
            </div>
        </div>
    </div>
@endsection