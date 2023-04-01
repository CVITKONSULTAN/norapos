@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | Page Builder' )

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.16.30/css/grapes.min.css" />
@endsection

@section('content')
{{-- @include('tastypointsapi::layouts.nav') --}}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Page Builder
        {{-- <small>@lang( 'tastypointsapi::lang.api_usage' )</small> --}}
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div id="gjs">
        <div class="txt-red">Hello world!</div>
        <style>.txt-red{color: red}</style>
    </div>
</section>
<!-- /.content -->

@endsection

@section('javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.16.30/grapes.min.js"></script>

<script type="text/javascript">
  
  var editor = grapesjs.init({
      container : '#gjs',
      fromElement: true,
  });

</script>

@endsection