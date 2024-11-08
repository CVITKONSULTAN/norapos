@extends('layouts.app')
@section('title', "Edit Mata Pelajaran")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Edit Mata Pelajaran</h1>
</section>

<!-- Main content -->

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid" id="accordion">
                <div class="box-header with-border" style="cursor: pointer;">
                    <h3 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
                        Edit Mata Pelajaran
                    </a>
                    </h3>
                </div>
                <div id="collapseFilter" class="panel-collapse active collapse in" aria-expanded="true">
                    <div class="box-body">
                        <form method="POST" action="{{route('sekolah_sd.mapel.update',$data->id)}}">
                            @csrf
                            {{ method_field('PUT') }}
                            <input type="hidden" name="business_id" value="{{Auth::user()->business->id}}" />
                            @include('sekolah_sd.forms.mapel.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@endsection

@section('javascript')
    
@endsection