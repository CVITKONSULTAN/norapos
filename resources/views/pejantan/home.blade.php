@extends('layouts.app')
@section('title', __('home.home'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header content-header-custom">
    <h1>{{ __('home.welcome_message', ['name' => Session::get('user.first_name')]) }}
    </h1>
</section>
@if(auth()->user()->can('dashboard.data'))
<!-- Main content -->
<section class="content content-custom no-print">
  <br>
    <div class="row row-custom">
		<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
            <div class="info-box info-box-new-style">
              <span class="info-box-icon bg-aqua"><i class="fa fa-database"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Data Jalan</span>
                <span class="info-box-number total_jalan">
                    <i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
		<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
            <div class="info-box info-box-new-style">
              <span class="info-box-icon bg-aqua"><i class="fa fa-database"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Data Jembatan</span>
                <span class="info-box-number total_jembatan">
                    <i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
	</div>
</section>
<!-- /.content -->
@stop
@section('javascript')
    <script src="{{ asset('js/home.js?v=' . $asset_v) }}"></script>
    <script>
        $(document).ready(function(){
            getDataDashboard();
        });

        const getDataDashboard = () => {
            $.ajax({
                url:"{{route('pejantan.home')}}",
                beforeSend:() => {
                    $('.total_murid').html('<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                },
                success: response => {
                    console.log("response",response)
                    if(!response.status) return;
                    const {data} = response;
                    $(".total_jalan").html(data.jalan);
                    $(".total_jembatan").html(data.jembatan);
                }
            })
        }
    </script>
@endif
@endsection

