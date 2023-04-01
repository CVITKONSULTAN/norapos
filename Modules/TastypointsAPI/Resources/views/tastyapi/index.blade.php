@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | '.__('tastypointsapi::lang.dashboard') )

@section('content')
@include('tastypointsapi::layouts.nav')

<input type="hidden" name="session_id" value="{{ Request::get("session")->session_id }}" />

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'tastypointsapi::lang.dashboard' )
        <small>@lang( 'tastypointsapi::lang.api_usage' )</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><span class="total_usage">&nbsp;</span></h3>

              <p> @lang('tastypointsapi::lang.total_usage')</p>
            </div>
            <div class="icon">
              <i class="fa fa-exchange-alt"></i>
            </div>
            <a 
                href="#" 
                class="small-box-footer">
                @lang('tastypointsapi::lang.more_info') 
                <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><span class="total_usage">&nbsp;</span></h3>

              <p> @lang('tastypointsapi::lang.total_usage')</p>
            </div>
            <div class="icon">
              <i class="fa fa-exchange-alt"></i>
            </div>
            <a 
                href="#" 
                class="small-box-footer">
                @lang('tastypointsapi::lang.more_info') 
                <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><span class="total_usage">&nbsp;</span></h3>

              <p> @lang('tastypointsapi::lang.total_usage')</p>
            </div>
            <div class="icon">
              <i class="fa fa-exchange-alt"></i>
            </div>
            <a 
                href="#" 
                class="small-box-footer">
                @lang('tastypointsapi::lang.more_info') 
                <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->

    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')

<script type="text/javascript">
  
  function update_statistics(){
    $(".total_usage").html(0);
  }

  $(document).ready(()=>{
      update_statistics();
  });

</script>

@endsection