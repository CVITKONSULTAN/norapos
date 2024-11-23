@extends('layouts.app')
@section('title', "Raport Project Siswa")

@section('css')
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    />
    <style>
        table.head_table tr td{
            padding: 5px 10px;
        }
        table.tabel_penilaian{
            margin-top: 10px;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }
        table.tabel_penilaian tr td {
            border: 1px solid black;
            padding: 5px 10px;
            /* vertical-align: top; */
        }
        table.tabel_penilaian tr th
        {
            background-color: rgb(199, 199, 199);
            color: black;
            border: 1px solid black;
            text-align: center;
            padding: 5px 10px;
        }
    </style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Raport Project Siswa</h1>
</section>

<!-- Main content -->

<section class="content">

    @if(!empty($kelas_siswa))
    <div id="ekskul_modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_kelas_siswa_store" method="POST" action="{{route('sekolah_sd.ekskul-siswa.store')}}">
                    @csrf
                    <input value="1" type="hidden" name="insert" />
                    <input value="0" type="hidden" name="update" />
                    <input value="0" type="hidden" name="id" />
                    <input type="hidden" name="kelas_id" value="{{$kelas_siswa->kelas_id ?? 0}}" />
                    <input type="hidden" name="siswa_id" value="{{$kelas_siswa->siswa_id ?? 0}}" />

                    <div class="modal-header">
                        <h4 class="modal-title">
                            Form Ekskul
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Ekstrakurikuler</label>
                            <select required class="form-control" name="ekskul_id">
                                <option value="">-- Pilih Ekskul --</option>
                                @foreach ($ekskul as $key => $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nilai</label>
                            <input maxlength="1" class="form-control" name="nilai" required />
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea rows="5" required class="form-control" name="keterangan"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> 
                            Raport Project Siswa (Individu)
                        </a>
                    </li>
                    @if(!empty($kelas_siswa))
                        <li class="">
                            <a href="#ekskul" data-toggle="tab" aria-expanded="true"><i class="fa fa-list" aria-hidden="true"></i>
                                Cetak Raport Raport Project Siswa (Perkelas)
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <form class="row">
                            <div class="form-group col-md-2">
                                <label>Tahun Ajaran</label>
                                <select id="filter_tahun_ajaran" class="form-control" name="tahun_ajaran">
                                    @foreach ($tahun_ajaran as $item)
                                        <option>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Semester</label>
                                <select id="filter_semester" class="form-control" name="semester">
                                    @foreach ($semester as $item)
                                        <option>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Kelas</label>
                                <select id="filter_kelas" class="form-control" name="kelas">
                                    @foreach ($nama_kelas as $item)
                                        <option>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Cari NISN/Nama Siswa</label>
                                {{-- <input type="search" placeholder="Tulis disini..." class="form-control" name="cari" placeholder="" /> --}}
                                <select name="kelas_id" class="siswa_selection"></select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" style="margin-top:25px;"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </form>
                        <hr />
                        @if(!empty($kelas_siswa))
                        <div id="printableArea" class="row">
                            
                        </div>
                        <div class="text-center" style="margin-top:10px;">
                            <button onclick="simpanRaport(this,'{{$kelas_siswa->id ?? 0}}')" type="button" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('sekolah_sd.raport_akhir.print', $kelas_siswa->id ?? 0 ) }}" type="button" class="btn btn-success">Cetak</a>
                        </div>
                        @endif
                    </div>
                    @if(!empty($kelas_siswa))
                        <div class="tab-pane" id="ekskul">
                            
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Kelas</label>
                                    <select class="form-control">
                                        <option>4 A</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tahun Pelajaran</label>
                                    <select class="form-control">
                                        <option>2024/2025</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Semester</label>
                                    <select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-block">Cetak</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    ></script>
    <script type="text/javascript">
    
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        const simpanRaport = (elm,id) => {
            const btn = $(elm)
            const kesimpulan = $('#kesimpulan').val();
            const catatan_akhir = $('#catatan_akhir').val();
            $.ajax({
                type:"POST",
                url:"{{route('sekolah_sd.kelas.store')}}",
                data:{
                    "update":1,
                    "kesimpulan":kesimpulan,
                    "catatan_akhir":catatan_akhir,
                    "id":id
                },
                beforeSend:function(){
                    btn.attr('disabled')
                },
                complete:function(){
                    btn.removeAttr('disabled')
                },
                success:function(result){
                    if(result.success == true){
                        toastr.success(result.msg);
                    } else {
                        toastr.error(result.msg);
                    }
                },
                error:function(error){
                    console.log("error",error)
                }
            })
        }

        $("#form_kelas_siswa_store").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    console.log("result",result);
                    if(result.success == true){
                        loadEkskul();
                        toastr.success(result.msg);
                    } else {
                        toastr.error(result.msg);
                    }
                    $("#form_kelas_siswa_store").trigger("reset");
                    $("#ekskul_modal").modal("hide");
                },
                error: function(e) {
                    console.log(e);
                },
                complete:()=>{
                    $(this).find('button').removeAttr('disabled')
                }
            });
        }));

    </script>
@endsection
