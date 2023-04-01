@extends('layouts.app')

@section( 'title')
{{__('tastypointsapi::lang.tastypoints')}} | @yield('page_name')
@endsection

@section('css')
    <style>
        .sidebar-nav .navbar li.active > a {
            color: #fff !important;
            background-color:  #005ebf !important;
            font-weight: bold;
        }
        .section_navbar{
          margin-top: 25px;
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

@include('tastypointsapi::layouts.nav')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('content-header')
        {{-- <small>@lang('tastypointsapi::lang.tpadmin_desc')</small> --}}
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
                <div class="col-sm-3">
                  <div class="sidebar-nav">
                    <div class="navbar navbar-default" role="navigation" id="navigation-custom">
                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </button>
                        <span class="visible-xs navbar-brand">@lang('tastypointsapi::lang.tpadmin') MENU</span>
                      </div>

                      <div class="navbar-collapse collapse sidebar-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="{{Request::URL() == route("stripe.index") ? "active" : "" }}">
                              <a href="{{ route("stripe.index") }}">List Payment Intent</a>
                            </li>
                            <li class="{{Request::URL() == route("stripe.customer") ? "active" : "" }}">
                              <a href="{{ route("stripe.customer") }}">List Customer</a>
                            </li>
                            <li class="{{Request::URL() == route("stripe.payout") ? "active" : "" }}">
                              <a href="{{ route("stripe.payout") }}">List Payout</a>
                            </li>
                            <li class="{{Request::URL() == route("stripe.customer_test") ? "active" : "" }}">
                              <a href="{{ route("stripe.customer_test") }}">Customer Wallet Apps</a>
                            </li>
                            <li class="{{Request::URL() == route("stripe.customer_log_test") ? "active" : "" }}">
                              <a href="{{ route("stripe.customer_log_test") }}">Customer Wallet Logs Apps</a>
                            </li>
                            <li class="{{Request::URL() == route("stripe.paypal_log") ? "active" : "" }}">
                              <a href="{{ route("stripe.paypal_log") }}">Paypal Logs</a>
                            </li>
                            {{-- <li class="{{Request::URL() == route("login") ? "active" : "" }}">
                              <a href="{{ route("stripe.index") }}">List Cardholder</a>
                            </li> --}}
                        </ul>
                      </div><!--/.nav-collapse -->
                      
                    </div>
                  </div>
                </div>
                <div class="col-sm-9">
                    <div class="box box-primary">
                        <div class="box-body">
                            @yield('main_content')
                        </div>
                    </div>
                </div>
              </div>
        </div>
    </div>
</section>
@stop