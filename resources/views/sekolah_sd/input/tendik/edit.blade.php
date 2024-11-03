@extends('layouts.app')
@section('title', "Ubah Data Tenaga Pendidik")

@section('css')
    <style>
        img.foto{
            max-height: 200px;
        }
    </style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Ubah Data Tenaga Pendidik</h1>
</section>

<!-- Main content -->

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid" id="accordion">
                <div class="box-header with-border" style="cursor: pointer;">
                    <h3 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
                        Ubah Data Tenaga Pendidik
                    </a>
                    </h3>
                </div>
                <div id="collapseFilter" class="panel-collapse active collapse in" aria-expanded="true">
                    <div class="box-body">
                        <form class="row" action="{{route('sekolah_sd.tendik.store')}}" enctype="multipart/form-data" method="POST">
                        @include('sekolah_sd.forms.tendik.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@endsection