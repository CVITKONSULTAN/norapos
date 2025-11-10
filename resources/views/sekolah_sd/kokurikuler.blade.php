@php
    if(isset($tema_kokurikuler['dimensi_list'])) 
    $tema_kokurikuler['dimensi_list'] = json_decode($tema_kokurikuler['dimensi_list'],true);
    $total_dimensi = count($tema_kokurikuler['dimensi_list'] ?? []);
@endphp
@extends('layouts.app')
@section('title', "Penilaian Kokurikuler")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Penilaian Kokurikuler</h1>
</section>

<section class="content">

    <div id="editor_modal_project" class="modal fade">
        <div class="modal-dialog">
            <form method="POST" class="modal-content" 
                action="{{route('kokurikuler.storeNilai')}}"
            >
                @csrf
                <input type="hidden" name="kokurikuler_id" value="{{ $tema_kokurikuler['id'] ?? 0 }}" />
                <input type="hidden" name="kokurikuler_tema" value="{{ $tema_kokurikuler['tema'] ?? 0 }}" />
                <input type="hidden" name="kelas_siswa_id" value="0" />
                <div class="modal-header">
	                <h4 class="modal-title">
                        Form Nilai Kokurikuler
                    </h4>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">Penilaian Dimensi</h4>
                    <h4 class="text-center"><span id="detail_siswa"></span></h4>
                    @foreach ($tema_kokurikuler['dimensi_list'] ?? [] as $i => $item)
                        <input type="hidden" name="dimensi[{{$i}}][id]" value="{{ $i }}" />
                        <input type="hidden" name="dimensi[{{$i}}][nama]" value="{{$item}}" />
                        <div class="form-group">
                            <label>{{ $item }}</label>
                            <select required class="form-control" name="dimensi[{{$i}}][nilai]">
                                <option value="SB">Sangat Baik (SB)</option>
                                <option value="B">Baik (B)</option>
                                <option value="C">Cukup (C)</option>
                                <option value="K">Kurang (K)</option>
                            </select>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                  </div>
            </form>
        </div>
    </div>
 
    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Kokurikuler</a>
                    </li>
                    {{-- <li class="">
                        <a href="#ekskul" data-toggle="tab" aria-expanded="true"><i class="fa fa-list" aria-hidden="true"></i> Data Project</a>
                    </li> --}}
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <form class="row">
                            <div class="form-group col-md-3">
                                <label>Kelas</label>
                                <select id="kelas_select" class="form-control" name="kelas" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($level_kelas as $i)
                                        <option value="{{$i}}">Kelas {{$i}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Nama Kelas</label>
                                <select id="nama_kelas_select" class="form-control" name="kelas_id" required>
                                    <option value="">-- Pilih --</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tema Kokurikuler</label>
                                <select id="projek_select" class="form-control" name="index_projek" required>
                                    <option value="">-- Pilih --</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button style="margin-top: 25px;" type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                        @if(isset($tema_kokurikuler['tema']))
                            <hr />
                            <div style="text-align: center;margin-bottom:10px;">
                                <h5 style="margin-block: 0px;">Kelas:</h5>
                                <b><h4>{{ $kelas->nama_kelas }}</h4></b>
                            </div>
                            <div style="text-align: center;margin-bottom:10px;">
                                <h5 style="margin-block: 0px;">Nama Tema Kokurikuler:</h5>
                                <b><h4>{{ $tema_kokurikuler['tema'] }}</h4></b>
                            </div>
                            {{-- <div class="text-right" style="margin-bottom: 10px;"> --}}
                                {{-- <a target="_blank" href="{{ route('sekolah_sd.project.create') }}" class="btn btn-primary">Tambah</a> --}}
                            {{-- </div> --}}
                            <div class="table-responsive">
                                <table width="100%" class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">NIS</th>
                                            <th rowspan="2">Nama</th>
                                            <th style="background: #1880ca;color:#000;" colspan="{{$total_dimensi}}" id="dimensi_header" class="text-center">Penilaian Dimensi</th>
                                            <th rowspan="2">Tindakan</th>
                                        </tr>
                                        <tr>
                                            @foreach ($tema_kokurikuler['dimensi_list'] ?? [] as $item)
                                                <th class="text-center">{{ $item }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelas_siswa as $item)    
                                            <tr>
                                                <td>{{ $item->siswa->detail['nis'] ?? '' }}</td>
                                                <td>{{ $item->siswa->nama }}</td>
                                                @php
                                                    $nilai_kokurikuler = $item->nilai_kokurikuler ?? [];
                                                    
                                                    $project_choices_id = $tema_kokurikuler['id'] ?? 0;
                                                    $index_projek = array_search( $project_choices_id , array_column( $nilai_kokurikuler , 'kokurikuler_id'));
                                                    $data_projek = [];

                                                    if($index_projek !== false && $index_projek >= 0) 
                                                    $data_projek = $nilai_kokurikuler[$index_projek] ?? [];

                                                @endphp

                                                @foreach ($tema_kokurikuler['dimensi_list'] ?? [] as $i => $val)
                                                    @php
                                                        $dimensi = $data_projek['dimensi'][$i] ?? [];
                                                    @endphp
                                                    <td class="text-center">{{$dimensi['nilai'] ?? "-"}}</td>
                                                @endforeach

                                                <td>
                                                    <button
                                                        onclick='editData("{{ $item->siswa->detail['nis'] ?? '' }}","{{ $item->siswa->nama }}",{{$item->id}})'
                                                        class="btn btn-primary btn-xs"
                                                    >
                                                        Edit
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
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
                paging: false,       // 🔹 tampilkan semua data tanpa halaman
                info: false,         // 🔹 sembunyikan "Showing X to Y of Z entries"
                lengthChange: false  // 🔹 hilangkan dropdown jumlah baris
            });
        });

        let kelas = [];
        $("#kelas_select").change(function(){
            $.ajax({
                url:"{{route('sekolah_sd.kelas_repo.data')}}",
                data:{kelas:$(this).val()},
                success: res => {
                    console.log("res",res)
                    const dom = $("#nama_kelas_select")
                    dom.empty();
                    dom.append(`<option value="">-- Pilih --</option>`)
                    kelas = res.data
                    res.data.map((item,index)=>{
                        dom.append(`<option value="${item.id}" data-index="${index}">${item.nama_kelas} (Semester ${item.semester} - ${item.tahun_ajaran})</option>`)
                    })
                }
            })
        })

        $("#nama_kelas_select").change(function(){
            const index = $(this).find(':selected').data('index')
            const val = kelas[index];
            const dom_projek = $("#projek_select")
            dom_projek.empty();
            dom_projek.append(`<option value="">-- Pilih --</option>`)
            val?.tema_kokurikuler?.map((item,index)=>{
                dom_projek.append(`<option value="${index}">${item.tema}</option>`)
            })
        })

        const editData = (nis,nama,id) => {
            const modals = $("#editor_modal_project");
            $("#detail_siswa").text(`${nama} (${nis})`);
            $.ajax({
                url:`/sekolah_sd/kelas-siswa/${id}/detail`,
                success:res => {
                    modals.find('[name=kelas_siswa_id]').val(id);
                    modals.modal("show")
                }
            })
        }

        @if($total_dimensi > 0)
            $("#dimensi_header").attr("colspan",{{$total_dimensi}});
        @endif

    </script>
@endsection