@extends('layouts.app')
@section('title', "Raport Project")

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
        div.container_deskripsi{
            border: 1px solid black;
            padding: 5px;
        }
        p.head_keterangan_nilai{
            font-weight: bold;
        }
        p.sub_ket_nilai{
            font-style: italic;
        }
        table.keterangan_table{
            margin-top: 10px;
        }
        table.keterangan_table tr td{
            vertical-align: middle;
        }
        table.tabel_projek {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        table.tabel_projek tr th{
            border: 1px solid black;
            padding: 2.5px 5px;
            text-align: center;
        }
        table.tabel_projek tr td{
            border: 1px solid black;
            padding: 2.5px 5px;
        }
        #printableArea{
            color: #000;
        }
        .dimensi_head{
            font-weight:bold;
            background: rgb(103, 172, 225);
            padding: 2.5px 10px;
        }
    </style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Raport Project</h1>
</section>

<!-- Main content -->

<section class="content">

    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> 
                            Raport Akhir Semester (Individu)
                        </a>
                    </li>
                    @if(!empty($kelas_siswa))
                        <li class="">
                            <a href="#ekskul" data-toggle="tab" aria-expanded="true"><i class="fa fa-list" aria-hidden="true"></i>
                                Cetak Raport Akhir Semester (Perkelas)
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
                                <select name="kelas_id" class="siswa_selection"></select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" style="margin-top:25px;"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </form>
                        <hr />
                        @if(!empty($kelas_siswa))
                            <div id="printableArea" class="row">
                                <div class="col-sm-6">
                                    <table class="head_table">
                                        <tr>
                                            <td>NISN</td>
                                            <td>:</td>
                                            <td>{{ $kelas_siswa->siswa->nisn ?? "" }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Peserta Didik</td>
                                            <td>:</td>
                                            <td>{{ $kelas_siswa->siswa->nama ?? "" }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Sekolah</td>
                                            <td>:</td>
                                            <td>{{ $business->name }}</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: top">Alamat Sekolah</td>
                                            <td style="vertical-align: top">:</td>
                                            <td>{!! $alamat !!}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <table class="head_table">
                                        <tr>
                                            <td>Kelas</td>
                                            <td>:</td>
                                            <td>{{ $kelas_siswa->kelas->nama_kelas ?? "" }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fase</td>
                                            <td>:</td>
                                            <td>{{$fase}}</td>
                                        </tr>
                                        <tr>
                                            <td>Semester</td>
                                            <td>:</td>
                                            <td>{{ $kelas_siswa->kelas->semester ?? "" }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tahun Pelajaran</td>
                                            <td>:</td>
                                            <td>{{ $kelas_siswa->kelas->tahun_ajaran ?? "" }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    @php
                                        $list_dimensi = [];
                                    @endphp
                                    @foreach ($kelas_siswa->nilai_projek ?? [] as $i => $item)
                                        @php
                                            $project = \App\Models\Sekolah\RaporProjek::find($item['projek_id']);
                                            // dd($item);
                                            foreach ($item['dimensi'] ?? [] as $key => $value) {
                                                $list_dimensi[$value['id']] = $value['nama'];
                                            }
                                        @endphp
                                        <h4>Projek {{$i+1}} | {{ $item['projek_nama'] }}</h4>
                                        <div class="container_deskripsi">
                                            {{$project->deskripsi}}
                                        </div>
                                    @endforeach
                                    <table class="keterangan_table" width="100%">
                                        <tr>
                                            <td>
                                                <p class="head_keterangan_nilai">BB. Belum Berkembang</p>
                                            </td>
                                            <td>
                                                <p class="head_keterangan_nilai">MB. Mulai Berkembang</p>
                                            </td>
                                            <td>
                                                <p class="head_keterangan_nilai">BSH. Berkembang Sesuai Harapan</p>
                                            </td>
                                            <td>
                                                <p class="head_keterangan_nilai">SB. Sangat Berkembang</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="sub_ket_nilai">Siswa masih membutuhkan
                                                    bimbingan dalam
                                                    mengembangkan kemampuan</p>
                                            </td>
                                            <td>
                                                <p class="sub_ket_nilai">Siswa mulai
                                                    mengembangkan
                                                    kemampuan namun masih
                                                    belum ajek</p>
                                            </td>
                                            <td>
                                                <p class="sub_ket_nilai">Siswa telah mengembangkan
                                                    kemampuan hingga berada
                                                    dalam tahap ajek</p>
                                            </td>
                                            <td>
                                                <p class="sub_ket_nilai">Siswa mengembangkan
                                                    kemampuannya melampaui
                                                    harapan</p>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="tabel_projek">
                                        <thead>
                                            <tr>
                                                <th>Projek Kelas {{ $kelas_siswa->kelas->nama_kelas ?? "" }}</th>
                                                @foreach ($list_dimensi as $v)
                                                    <th>{{ $v }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kelas_siswa->nilai_projek ?? [] as $i => $item)
                                                <tr>
                                                    <td>{{ $item['projek_nama'] }}</td>
                                                    @foreach ($list_dimensi as $k => $v)
                                                        @foreach ($item['dimensi'] as $value)
                                                            @if($value['id'] == $k)
                                                                <td class="text-center">{{$value['nilai']}}</td>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @php
                                        $dimensi_list = $kelas_siswa->kelas->dimensi_list ?? [];
                                        $nilai_projek = $kelas_siswa->nilai_projek ?? []
                                    @endphp
                                    @foreach ($nilai_projek ?? [] as $i => $item)
                                        <table style="margin-top: 20px;" class="tabel_projek">
                                            <thead>
                                                <tr>
                                                    <th>{{ $item['projek_nama'] ?? "" }}</th>
                                                    <th>BB</th>
                                                    <th>MB</th>
                                                    <th>BSH</th>
                                                    <th>SB</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item['dimensi'] ?? [] as $j => $value)
                                                @php
                                                    // dd($dimensi_list[$i]['dimensi'][$j]);
                                                    $subelemen_fase = $dimensi_list[$i]['dimensi'][$j]['subelemen_fase'] ?? [];
                                                @endphp
                                                <tr>
                                                    <td class="dimensi_head" colspan="5">{{ $value['nama'] }}</td>
                                                </tr>
                                                @foreach ($value['subelemen'] ?? [] as $k => $val)
                                                    {{-- {{dd($val['nilai'])}} --}}
                                                    <tr>
                                                        <td>
                                                            <p style="font-weight: bold;">{{$subelemen_fase[$k]['text'] ?? ""}}</p>
                                                            <p>{{$subelemen_fase[$k]['target'] ?? ""}}</p>
                                                        </td>
                                                        <td class="text-center">{{ $val['nilai'] == 'BB' ? 'V' : '' }}</td>
                                                        <td class="text-center">{{ $val['nilai'] == 'MB' ? 'V' : '' }}</td>
                                                        <td class="text-center">{{ $val['nilai'] == 'BSH' ? 'V' : '' }}</td>
                                                        <td class="text-center">{{ $val['nilai'] == 'SB' ? 'V' : '' }}</td>
                                                    </tr>
                                                @endforeach
                                                {{-- {{dd($value,$dimensi_list)}} --}}
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                </div>
                            </div>
                            <div class="text-center" style="margin-top:10px;">
                                <a href="{{ route('sekolah_sd.raport_project.print', $kelas_siswa->id ?? 0 ) }}" type="button" class="btn btn-success">Cetak</a>
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

        let selectizeInstanceSiswa;

        $(function () {
            selectizeInstanceSiswa = $(".siswa_selection").selectize({
                placeholder: 'Cari disini...',
                maxItems: 1,
                create: false,
                valueField: 'id',         // Field to use as the value
                labelField: 'name',       // Field to use as the label
                searchField: 'name',      // Field to use for searching
                load: function(query, callback) {
                    if (!query.length) return callback();
                    const tahun_ajaran = $("#filter_tahun_ajaran").val();
                    const semester = $("#filter_semester").val();
                    const kelas = $("#filter_kelas").val();
                    const url = '/sekolah_sd/kelas-siswa/data?draw=30&columns%5B0%5D%5Bdata%5D=id&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=siswa.nisn&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=siswa.nama&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=kelas.nama_kelas&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=kelas.tahun_ajaran&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B5%5D%5Bdata%5D=id&columns%5B5%5D%5Bname%5D=&columns%5B5%5D%5Bsearchable%5D=true&columns%5B5%5D%5Borderable%5D=true&columns%5B5%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B5%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&start=0&length=25&search%5Bvalue%5D='+query+
                        '&filter_tahun_ajaran='+tahun_ajaran+
                        '&filter_semester='+semester+
                        '&filter_kelas='+kelas;
                    // console.log("url",url)
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            selectizeInstanceSiswa[0].selectize.clearOptions();
                        },
                        error: function(error) {
                            console.log(error)
                            callback();
                        },
                        success: function(res) {
                            const results = res.data.map(item => ({
                                id: item.id,
                                name: `${item.siswa.nama} (${item.siswa.nisn})`
                            }));
                            // console.log(results)
                            callback(results);
                        }
                    });
                }
            })

            const clearSelectize = () => {
                selectizeInstanceSiswa[0].selectize.setValue(null);
                selectizeInstanceSiswa[0].selectize.clearOptions();
            }

            $("#filter_tahun_ajaran").change(clearSelectize);
            $("#filter_semester").change(clearSelectize);
            $("#filter_kelas").change(clearSelectize);

        })

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

        const loadEkskul = () => {
            $.ajax({
                type:"GET",
                url:`{{ route('sekolah_sd.ekskul-siswa.show') }}`,
                data:{
                    kelas_id:"{{$kelas_siswa->kelas_id ?? 0}}",
                    siswa_id:"{{$kelas_siswa->siswa_id ?? 0}}",
                },
                beforeSend:function(){
                    $("#ekskul_list").empty();
                },
                complete:function(){

                },
                success:function(result){
                    // console.log("result",result);
                    if(!result.success) return;
                    for(const k in result.data){
                        const val = result.data[k]
                        const template = `
                        <tr>
                            <td class="text-center">${parseInt(k)+1}</td>
                            <td>${val.ekskul.nama}</td>
                            <td>${val.keterangan}</td>
                            <td class="text-center">
                                <button onclick="editEkskul(this,${val.id})" class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i></button>
                                <button onclick="deleteEkskul(this,${val.id})" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        `;
                        $("#ekskul_list").append(template);
                    }
                },
                error:function(error){

                },
            })
        }

        const tambahEkskul = () => {
            const modals = $("#ekskul_modal");
            modals.find('input[name=insert]').val(1);
            modals.find('input[name=update]').val(0);
            modals.find('input[name=id]').val(0);
            $("#form_kelas_siswa_store").trigger("reset");
            modals.modal("show");
        }

        $(document).ready(function(){
            loadEkskul();
        })

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

        const deleteEkskul = (elm,id) => {
            const btn = $(elm)
            $.ajax({
                url: "{{route('sekolah_sd.ekskul-siswa.store')}}",
                type: "POST",
                data: {delete:1,id:id},
                beforeSend:function(){
                    btn.attr('disabled')
                },
                complete:function(){
                    btn.removeAttr('disabled')
                },
                success: function(result) {
                    console.log("result",result);
                    if(result.success == true){
                        loadEkskul();
                        toastr.success(result.msg);
                    } else {
                        toastr.error(result.msg);
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }

        const editEkskul = (elm,id) => {
            const btn = $(elm)
            const form = $("#form_kelas_siswa_store")
            $.ajax({
                url: "{{route('sekolah_sd.ekskul-siswa.store')}}",
                type: "POST",
                data: {show:1,id:id},
                beforeSend:function(){
                    btn.attr('disabled')
                },
                complete:function(){
                    btn.removeAttr('disabled')
                },
                success: function(result) {

                    console.log("result",result);

                    if(!result.success)
                    return toastr.error(result.msg);

                    const {data} = result

                    form.find('input[name=insert]').val(0);
                    form.find('input[name=update]').val(1);
                    form.find('input[name=id]').val(data.id);

                    form.find('select[name=ekskul_id]').val(data.ekskul_id);
                    form.find('input[name=nilai]').val(data.nilai);
                    form.find('textarea[name=keterangan]').val(data.keterangan);
                    $("#ekskul_modal").modal("show");
                    
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }


    </script>
@endsection
