@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | Embed' )

@section('css')
    
@endsection

@section('content')
@include('tastypointsapi::marketing.partials.nav')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Embed Tester</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="embed-responsive embed-responsive-4by3 preview_template">
        <iframe class="embed-responsive-item" src="https://valerii15298.github.io/flow-builder/demo/" allowfullscreen></iframe>
    </div>
</section>
<!-- /.content -->

@endsection

@section('javascript')


@endsection