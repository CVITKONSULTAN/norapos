@extends('layouts.app')

@section( 'title')
@yield('page_name')
@endsection

@section('css')
    <style>
        .sidebar-nav .navbar li.active > a {
            color: #fff !important;
            background-color:  #005ebf !important;
            font-weight: bold;
        }
        /* make sidebar nav vertical */
        @media (min-width: 768px) {
            .sidebar-nav .navbar .navbar-collapse {
                padding: 0;
                max-height: none;
            }
            .sidebar-nav .navbar ul {
                float: none;
            }
            .sidebar-nav .navbar ul:not {
                display: block;
            }
            .sidebar-nav .navbar li {
                float: none;
                display: block;
            }
            .sidebar-nav .navbar li a {
                padding-top: 12px;
                padding-bottom: 12px;
            }
        }
    </style>
    @yield('page_css')
@endsection

@section('content')

@include('tastypointsapi::partner.partials.nav')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('content-header')
        @yield('content-subheader')
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content" style="padding-top: 0px;">
    <br>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                @yield('new-box')
                <div class="col-sm-12">
                    <div class="box box-solid">
                        <div class="box-body">
                            @yield('main_content')
                        </div>
                    </div>
                </div>
              </div>
        </div>
    </div>
</section>

<script>
    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }
</script>
@stop