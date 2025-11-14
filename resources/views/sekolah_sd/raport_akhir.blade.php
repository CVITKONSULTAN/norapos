@extends('layouts.app')
@section('title', "Raport Akhir Semester")

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
    <h1>Raport Akhir Semester</h1>
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
                            <select id="nama_ekskul" required class="form-control" name="ekskul_id">
                                <option value="">-- Pilih Ekskul --</option>
                                @foreach ($ekskul as $key => $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nilai</label>
                            {{-- <input id="nilai_ekskul" maxlength="1" class="form-control" name="nilai" required /> --}}
                            <select name="nilai" id="nilai_ekskul" class="form-control" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea id="keterangan_ekskul" rows="5" required class="form-control" name="keterangan"></textarea>
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
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                                <table class="tabel_penilaian">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Nilai Akhir</th>
                                            <th>Capaian Kompetensi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nilai_list as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key+1 }}</td>
                                                {{-- <td>{{ $item->mapel->nama ?? "" }}</td> --}}
                                                <td>{{ $item->nama ?? "" }}</td>
                                                <td class="text-center">{{ $item->nilai_rapor }}</td>
                                                <td style="padding:0px;">
                                                    @if(!empty($item->catatan_max_tp))
                                                    <div style="
                                                    @if(!empty($item->catatan_min_tp))
                                                    border-bottom: 1px solid black;
                                                    @endif
                                                    padding: 3px 5px;
                                                    text-align:justify;
                                                    ">{{ $item->catatan_max_tp }}</div>
                                                    @endif
                                                    @if(!empty($item->catatan_min_tp))
                                                    <div style="
                                                    padding: 3px 5px;
                                                    text-align:justify;
                                                    ">{{ $item->catatan_min_tp }}</div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <table class="tabel_penilaian">
                                    <thead>
                                        <tr>
                                            <th>Kokurikuler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                                <td>
                                                    @foreach ($nilai_kokurikuler as $item)    
                                                        <p>{{ $item['kokurikuler_desc'] ?? "" }}</p>
                                                    @endforeach
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>

                                <div class="text-right" style="margin-top: 10px;">
                                    <button onclick="tambahEkskul()" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Ekskul</button>
                                </div>
                                <table class="tabel_penilaian">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Ekstrakurikuler</th>
                                            <th>Nilai</th>
                                            <th>Keterangan</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ekskul_list"></tbody>
                                </table>

                                <table class="tabel_penilaian">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Ketidakhadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sakit</td>
                                            <td>:</td>
                                            <td>{{$kelas_siswa->sakit ?? 0}} hari</td>
                                        </tr>
                                        <tr>
                                            <td>Izin</td>
                                            <td>:</td>
                                            <td>{{$kelas_siswa->izin ?? 0}} hari</td>
                                        </tr>
                                        <tr>
                                            <td>Tanpa Keterangan</td>
                                            <td>:</td>
                                            <td>{{$kelas_siswa->tanpa_keterangan ?? 0}} hari</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="tabel_penilaian">
                                    <thead>
                                        <tr>
                                            <th>Catatan Guru</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <textarea 
                                                    rows="5"
                                                    class="form-control" 
                                                    placeholder="Tulis catatan disini..."
                                                    id="catatan_akhir"
                                                >{{$kelas_siswa->catatan_akhir ?? ""}}</textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                {{-- <table class="tabel_penilaian">
                                    <thead>
                                        <tr>
                                            <th>Kesimpulan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <textarea 
                                                    rows="5"
                                                    class="form-control" 
                                                    placeholder="Tulis catatan disini..."
                                                    id="kesimpulan"
                                                >{{$kelas_siswa->kesimpulan ?? ""}}</textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> --}}

                            </div>
                        </div>
                        <div class="text-center" style="margin-top:10px;">
                            <button onclick="simpanRaport(this,'{{$kelas_siswa->id ?? 0}}')" type="button" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('sekolah_sd.raport_akhir.print', $kelas_siswa->id ?? 0 ) }}" type="button" class="btn btn-success">Cetak</a>
                        </div>
                        @endif
                    </div>
                    @if(!empty($kelas_siswa))
                        <div class="tab-pane" id="ekskul">    
                            <form action="{{route('sekolah_sd.raport_akhir.print.perkelas')}}" class="row">
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
                                <div class="col-md-2">
                                    <button style="margin-top:25px;" type="submit" class="btn btn-primary btn-block">Cetak</button>
                                </div>
                            </form>
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
            // const kesimpulan = $('#kesimpulan').val();
            const catatan_akhir = $('#catatan_akhir').val();
            $.ajax({
                type:"POST",
                url:"{{route('sekolah_sd.kelas.store')}}",
                data:{
                    "update":1,
                    // "kesimpulan":kesimpulan,
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
                        // console.log("val.ekskul",val)
                        const template = `
                        <tr>
                            <td class="text-center">${parseInt(k)+1}</td>
                            <td>${val.ekskul.nama}</td>
                            <td class="text-center">${val.nilai}</td>
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

        $("#nilai_ekskul").change(function(){
            const val = $(this).val();
            let str = '';
            switch (val) {
                case "A":
                    str += "Sangat aktif dalam mengikuti ekskul"
                    break;
                case "B":
                    str += "Aktif mengikuti ekskul"
                    break;
                case "C":
                    str += "Kurang aktif dalam mengikuti ekskul"
                    break;
            }
            const nama_ekskul = $("#nama_ekskul option:selected").text();
            str += " "+nama_ekskul;
            $("#keterangan_ekskul").text(str)
        })

        $("#nama_ekskul").change(function(){
            const val = $("#nilai_ekskul").val();
            let str = '';
            switch (val) {
                case "A":
                    str += "Sangat aktif dalam mengikuti ekskul"
                    break;
                case "B":
                    str += "Aktif mengikuti ekskul"
                    break;
                case "C":
                    str += "Kurang aktif dalam mengikuti ekskul"
                    break;
            }
            const nama_ekskul = $("#nama_ekskul option:selected").text();
            str += " "+nama_ekskul;
            $("#keterangan_ekskul").text(str)
        })

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
                    form.find('select[name=nilai]').val(data.nilai);
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
