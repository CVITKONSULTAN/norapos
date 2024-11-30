@php
    $total_dimensi = count($dimensi_list['dimensi'] ?? []);
    $total_subelemen = 0;
    foreach ($dimensi_list['dimensi'] ?? [] as $i => $val){
        $dimensi = $data_projek['dimensi'][$i] ?? [];
        foreach($val['subelemen_fase'] ??[] as $j => $v){
            $total_subelemen++;
        }
    }
@endphp
@extends('layouts.app')
@section('title', "Penilaian Project Siswa")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Penilaian Project Siswa</h1>
</section>

<!-- Main content -->
<div id="editor_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    LIHAT PROJECT SISWA
                </h4>
            </div>
            <div class="modal-body">
                <iframe 
                    height="750"
                    width="100%"
                    src="{{url('raport/rapot project.pdf')}}"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
              </div>
        </div>
    </div>
</div>

<section class="content">
{{-- 
    <div id="editor_modal_project" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
	                <h4 class="modal-title">
                        Form Data Project
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Project</label>
                        <input class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea rows="5" class="form-control"></textarea>
                    </div>
                    <hr />
                        <h3 class="text-center">Indikator Penilaian</h3>
                    <hr />
                    <div class="indikator_penilaian_container row">
                        <div class="form-group col-sm-6">
                            <label>Indikator 1.</label>
                            <textarea rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Indikator 2.</label>
                            <textarea rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                  </div>
            </div>
        </div>
    </div>
  --}}

    <div id="editor_modal_project" class="modal fade">
        <div class="modal-dialog">
            <form method="POST" class="modal-content" action="{{route('sekolah_sd.rapor_projek.storeNilai')}}" >
                @csrf
                {{-- {{dd($dimensi_list)}} --}}
                <input type="hidden" name="projek_id" value="{{ $dimensi_list['id'] ?? 0 }}" />
                <input type="hidden" name="projek_nama" value="{{ $dimensi_list['nama'] ?? 0 }}" />
                <input type="hidden" name="kelas_siswa_id" value="0" />
                <div class="modal-header">
	                <h4 class="modal-title">
                        Form Nilai Projek
                    </h4>
                </div>
                <div class="modal-body">
                    @foreach ($dimensi_list['dimensi'] ?? [] as $i => $item)
                        <input type="hidden" name="dimensi[{{$i}}][id]" value="{{$item['dimensi_id']}}" />
                        <input type="hidden" name="dimensi[{{$i}}][nama]" value="{{$item['dimensi_text']}}" />
                        <h4 class="text-center">Penilaian Dimensi</h4>
                        <div class="form-group">
                            <label>{{ $item['dimensi_text'] }}</label>
                            <select required class="form-control" name="dimensi[{{$i}}][nilai]">
                                <option value="BB">Belum Berkembang (BB)</option>
                                <option value="MB">Mulai Berkembang (MB)</option>
                                <option value="BSH">Berkembang Sesuai Harapan (BSH)</option>
                                <option value="SB">Sangat Baik (SB)</option>
                            </select>
                        </div>
                        @php
                            $subelemen = $item['subelemen_fase'] ??[];
                        @endphp
                        @if(count($subelemen) > 0)
                        <h4 class="text-center">Penilaian Subelemen</h4>
                        @endif
                        @foreach ($subelemen as $key => $val)
                            <div class="form-group">
                                <label>{{ $val['text'] }}</label>
                                <select required class="form-control" name="dimensi[{{$i}}][subelemen][{{ $key }}][nilai]">
                                    <option value="BB">Belum Berkembang (BB)</option>
                                    <option value="MB">Mulai Berkembang (MB)</option>
                                    <option value="BSH">Berkembang Sesuai Harapan (BSH)</option>
                                    <option value="SB">Sangat Baik (SB)</option>
                                </select>
                            </div>
                        @endforeach
                        <hr />
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
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Raport Project Siswa</a>
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
                                <label>Projek</label>
                                <select id="projek_select" class="form-control" name="index_projek" required>
                                    <option value="">-- Pilih --</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button style="margin-top: 25px;" type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                        @if(isset($dimensi_list['nama']))
                            <hr />
                            <div style="text-align: center;margin-bottom:10px;">
                                <h5 style="margin-block: 0px;">Kelas:</h5>
                                <b><h4>{{ $kelas->nama_kelas }}</h4></b>
                            </div>
                            <div style="text-align: center;margin-bottom:10px;">
                                <h5 style="margin-block: 0px;">Nama Projek:</h5>
                                <b><h4>{{ $dimensi_list['nama'] }}</h4></b>
                            </div>
                            {{-- <div class="text-right" style="margin-bottom: 10px;"> --}}
                                {{-- <a target="_blank" href="{{ route('sekolah_sd.project.create') }}" class="btn btn-primary">Tambah</a> --}}
                            {{-- </div> --}}
                            <div class="table-responsive">
                                <table width="100%" class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Nama</th>
                                            <th style="background: #1880ca;color:#000;" colspan="{{$total_dimensi}}" id="dimensi_header" class="text-center">Penilaian Dimensi</th>
                                            <th style="background: #55a3db;color:#000;" colspan="{{$total_subelemen}}" id="subelemen_header" class="text-center">Penilaian Subelemen</th>
                                            <th rowspan="2">Tindakan</th>
                                        </tr>
                                        <tr>
                                            @foreach ($dimensi_list['dimensi'] ?? [] as $item)
                                                <th class="text-center">{{ $item['dimensi_text'] }}</th>
                                                @foreach ($item['subelemen_fase'] ?? [] as $val)
                                                    <th class="text-center">{{ $val['text'] }}</th>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelas_siswa as $item)    
                                            <tr>
                                                <td>{{ $item->siswa->nama }}</td>
                                                
                                                @php
                                                    $nilai_projek = $item->nilai_projek ?? [];
                                                    $project_choices_id = $dimensi_list['id'] ?? 0;
                                                    $index_projek = array_search( $project_choices_id ,array_column( $nilai_projek , 'projek_id'));
                                                    $data_projek = [];

                                                    if(!empty($index_projek)) 
                                                    $data_projek = $nilai_projek[$index_projek] ?? [];
                                                
                                                @endphp

                                                @foreach ($dimensi_list['dimensi'] ?? [] as $i => $val)
                                                    @php
                                                        $dimensi = $data_projek['dimensi'][$i] ?? [];
                                                    @endphp
                                                    <td class="text-center">{{$dimensi['nilai'] ?? 0}}</td>
                                                @endforeach

                                                @foreach ($dimensi_list['dimensi'] ?? [] as $i => $val)
                                                    @php
                                                        $dimensi = $data_projek['dimensi'][$i] ?? [];
                                                    @endphp
                                                    @foreach ($val['subelemen_fase'] ??[] as $j => $val)
                                                        @php
                                                            $subelemen = $dimensi['subelemen'] ?? [];
                                                        @endphp
                                                        <td class="text-center">{{ $subelemen[$j]['nilai'] ?? 0 }}</td>
                                                    @endforeach
                                                @endforeach

                                                <td>
                                                    <button
                                                        onclick='editData({{$item->id}})'
                                                        class="btn btn-primary btn-xs"
                                                    >
                                                        Edit
                                                    </button>
                                                    {{-- <a 
                                                        href="#"
                                                        onclick='$("#editor_modal").modal("show")'
                                                        class="btn btn-primary btn-xs"
                                                    >
                                                        Lihat
                                                    </a> --}}
                                                    {{-- <a 
                                                        class="btn btn-danger btn-xs" 
                                                        href="#"
                                                        target="_blank"
                                                    >
                                                        Hapus
                                                    </a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    {{-- <div class="tab-pane" id="ekskul">
                        <div class="text-right" style="margin-bottom: 10px;">
                            <button onclick='$("#editor_modal_project").modal("show")' class="btn btn-primary">Tambah</button>
                        </div>
                        <div class="table-responsive">
                            <table width="100%" class="table table-bordered table-striped ajax_view hide-footer" id="ekskul_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Project</th>
                                        <th>Deskripsi</th>
                                        <th>Indikator Penilaian</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Membuat tas siaga Bencana</td>
                                        <td>Dengan project ini siswa diharapkan dapat...</td>
                                        <td>
                                            <ol>
                                                <li>Indikator penilaian pertama</li>
                                                <li>Indikator penilaian kedua</li>
                                                <li>Indikator penilaian ketiga</li>
                                            </ol>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-primary btn-xs" 
                                                onclick='$("#editor_modal_project").modal("show")'
                                            >
                                                Edit
                                        </button>
                                            <a 
                                                class="btn btn-danger btn-xs" 
                                                href="#"
                                                target="_blank"
                                            >
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">

        $(document).ready( function(){
            $('#ekskul_table').DataTable();
            product_table = $('#product_table').DataTable({
                columnDefs: [ {
                    "targets": [0],
                    "orderable": false,
                    "searchable": false
                } ],
                // processing: true,
                // serverSide: true,
                // "ajax": {
                //     "url": "/reservasi/data",
                //     "data": function ( d ) {
                //         d.datatable = 1;
                //         d.date = $("#tanggal_filter").val();

                //         d = __datatable_ajax_callback(d);
                //     }
                // },
                // columns: [
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                //     { data: 'ID'  },
                // ]
            });
            // Array to track the ids of the details displayed rows
            var detailRows = [];

            $('table#product_table tbody').on('click', 'a.delete-product', function(e){
                e.preventDefault();
                swal({
                  title: LANG.sure,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: "DELETE",
                            url: href,
                            dataType: "json",
                            success: function(result){
                                if(result.success == true){
                                    toastr.success(result.msg);
                                    product_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#delete-selected', function(e){
                e.preventDefault();
                var selected_rows = getSelectedRows();
                
                if(selected_rows.length > 0){
                    $('input#selected_rows').val(selected_rows);
                    swal({
                        title: LANG.sure,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $('form#mass_delete_form').submit();
                        }
                    });
                } else{
                    $('input#selected_rows').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            });

            $("#reset").click(()=>{
                $("#tanggal_filter").val("").trigger('change');
            })

            $(document).on('change', 
                '#tanggal_filter', 
                function() {
                    product_table.ajax.reload();
            });


        });

        function getSelectedRows() {
            var selected_rows = [];
            var i = 0;
            $('.row-select:checked').each(function () {
                selected_rows[i++] = $(this).val();
            });

            return selected_rows; 
        }

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
                        dom.append(`<option value="${item.id}" data-index="${index}">${item.nama_kelas}</option>`)
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
            val?.dimensi_list?.map((item,index)=>{
                dom_projek.append(`<option value="${index}">${item.nama}</option>`)
            })
        })

        const editData = (id) => {
            const modals = $("#editor_modal_project")
            $.ajax({
                url:`/sekolah_sd/kelas-siswa/${id}/detail`,
                success:res => {
                    console.log(res);
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