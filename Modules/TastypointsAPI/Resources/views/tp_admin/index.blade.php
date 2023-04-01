@extends('layouts.app')
@section('title', __('tastypointsapi::lang.tastypoints') . ' | '. __('tastypointsapi::lang.tpadmin'))

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
@endsection

@section('content')

@include('tastypointsapi::layouts.nav')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('tastypointsapi::lang.tpadmin')<small>
        @lang('tastypointsapi::lang.tpadmin_desc')
    </small></h1>
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
                            <li class="active">
                              <a href="{{ route("tpadmin.language") }}">@lang('tastypointsapi::lang.language')</a>
                            </li>
                            <li>
                              <a href="#">@lang('tastypointsapi::lang.country')</a>
                            </li>
                            <li>
                                <a href="#">@lang('tastypointsapi::lang.smsmanage')</a>
                            </li>
                            <li>
                                <a href="#">@lang('tastypointsapi::lang.areadots')</a>
                            </li>
                            <li>
                                <a href="#">@lang('tastypointsapi::lang.cur_business')</a>
                            </li>
                            <li>
                                <a href="#">@lang('tastypointsapi::lang.test_labs')</a>
                            </li>
                            <li>
                                <a href="#">@lang('tastypointsapi::lang.sidemenu')</a>
                            </li>
                            <li>
                                <a href="#">@lang('tastypointsapi::lang.sessions')</a>
                            </li>
                            
                        </ul>
                      </div><!--/.nav-collapse -->
                    </div>
                  </div>
                </div>
                <div class="col-sm-9">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3>Language</h3>
                        </div>
                        <div class="box-body">
                            <p>Content is here... <span id="counter"></span> seconds</p>
                        </div>
                    </div>
                </div>
              </div>
        </div>
    </div>
</section>
@stop
@section('javascript')
<script>
    let i = 0;
    $(document).ready(()=>{
        setInterval(()=>{
            i++;
            $("#counter").html(i);
        },1000);
    });
</script>
@endsection