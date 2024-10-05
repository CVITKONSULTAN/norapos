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
    <script>
        const LMLIST = $(".lingkup_materi_list")
        let LM_INDEX = {{count($data['lingkup_materi'])}};
        const addLingkupMateri = () => {
            LM_INDEX++;
            const template_lingkup_materi = `
                <div class="input-group input_mb">
                    <div class="input-group-addon">LM${LM_INDEX}</div>
                    <input name="lingkup_materi[]" required placeholder="Lingkup materi..." type="text" class="form-control">
                </div>
            `
            LMLIST.append(template_lingkup_materi);
        }

        const TPLIST = $(".tujuan_pembelajaran_list")
        let TP_INDEX = {{count($data['tujuan_pembelajaran'])}};
        const addTujuanPembelajaran = () => {
            TP_INDEX++;
            const template_lingkup_materi = `
                <div class="input-group input_mb">
                    <div class="input-group-addon">TP${TP_INDEX}</div>
                    <input name="tujuan_pembelajaran[]" required placeholder="Tujuan Pembelajaran..." type="text" class="form-control">
                </div>
            `
            TPLIST.append(template_lingkup_materi);
        }
    </script>
@endsection