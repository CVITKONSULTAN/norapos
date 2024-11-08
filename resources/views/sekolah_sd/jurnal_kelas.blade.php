@extends('layouts.app')
@section('title', "Jurnal Kelas Siswa")

@section('css')
    <style>
        input[type="radio"]{
            height:30px; 
            width:30px; 
            vertical-align: middle;
        }
        /* .text-center{
            text-align: center;
            vertical-align: middle;
        } */
    </style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Jurnal Kelas Siswa</h1>
</section>

<!-- Main content -->

<section class="content">

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Data</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Mata Pelajaran</label>
                                <select id="mapel_id" class="form-control" name="mapel_id" required>
                                    @foreach ($mapel as $item)
                                        <option value="{{$item->id}}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Kelas</label>
                                <select id="kelas_id" class="form-control" name="kelas_id" required>
                                    @foreach ($kelas as $item)
                                        <option value="{{$item->id}}">{{ $item->nama_kelas }} (Semester {{$item->semester}} - {{$item->tahun_ajaran}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tanggal</label>
                                <input readonly class="form-control" type="date" required name="tanggal" value="{{$tgl}}" />
                            </div>
                        </div>
                        {{-- <div class="text-right" style="margin-bottom:20px;">
                            <button onclick="simpanData()" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Lengkap</th>
                                        <th>Hadir</th>
                                        <th>Izin</th>
                                        <th>Sakit</th>
                                        <th>Tanpa<br />Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <button onclick="simpanData()" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
<!-- /.content -->

@endsection

@section('javascript')
<script type="text/javascript">

    $(document).ready( function(){
        product_table = $('#product_table').DataTable({
            pageLength: -1,
            "paging": false,
            buttons: [],
            processing: true,
            serverSide: true,
            "ordering": false,
            "ajax": {
                "url": "{{ route('sekolah_sd.kelas.data') }}",
                "data": function ( d ) {
                    d.kelas_id = $('select[name=kelas_id]').val();
                    d.mapel_id = $('select[name=mapel_id]').val();
                    d = __datatable_ajax_callback(d);
                }
            },
            columns: [
                { searchable: false, data: 'id'  },
                { data: 'siswa.nama'  },
                { 
                    searchable: false, 
                    data: 'siswa.id',
                    className:"text-center",
                    render:(data)=> {
                        return `<input type="radio" name="masuk[${data}]" value="hadir" checked />`
                    }
                },
                { 
                    searchable: false, 
                    data: 'siswa.id',
                    className:"text-center",
                    render:(data)=> {
                        return `<input type="radio" name="masuk[${data}]" value="izin" />`
                    }
                },
                { 
                    searchable: false, 
                    data: 'siswa.id',
                    className:"text-center",
                    render:(data)=> {
                        return `<input type="radio" name="masuk[${data}]" value="sakit" />`
                    }
                },
                { 
                    searchable: false, 
                    data: 'siswa.id',
                    className:"text-center",
                    render:(data)=> {
                        return `<input type="radio" name="masuk[${data}]" value="tanpa keterangan" />`
                    }
                },
            ]
        });
    });

    $("#kelas_id").change(function(){
        product_table.ajax.reload();
    })

    const simpanData = () => {
        let json = {};
        let list_hadir = {};
        $('input[type="radio"]:checked').each(function() {
            let radioName = $(this).attr('name');
            radioName = radioName.replace(/\D/g, ''); 
            const radioValue = $(this).val();
            list_hadir[radioName] = radioValue;
        });
        json.kelas_id = $('select[name=kelas_id]').val();
        json.mapel_id = $('select[name=mapel_id]').val();
        json.tanggal = $('input[name=tanggal]').val();
        json.jurnal = list_hadir;
        console.log("json",json)
        $.ajax({
            url:"{{route('sekolah_sd.jurnal_kelas.store')}}",
            type:"POST",
            data:json,
            beforeSend:()=>{
                $('button').attr('disabled')
            },
            complete:()=>{
                $('button').removeAttr('disabled')
            },
            success:(result)=>{
                // console.log("res",result)
                if(result.success == true){
                    toastr.success(result.msg);
                } else {
                    toastr.error(result.msg);
                }
            }
        })
    }

</script>
@endsection