@extends('layouts.app')
@section('title', "Rekap Absen Siswa")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Rekap Absen Siswa</h1>
</section>

<!-- Main content -->
<div id="editor_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Form Rekap Absen
                </h4>
            </div>
            <form id="form_absen" method="POST" action="{{route('sekolah_sd.kelas.store')}}">
                @csrf
                <input type="hidden" name="update" value="1" />
                <input type="hidden" name="id" value="0" />
                <div class="modal-body">
                    {{-- <div class="form-group">
                        <label>Cari NISN/Nama Siswa</label>
                        <input class="form-control" placeholder="Cari disini..." />
                    </div> --}}
                    <div class="form-group">
                        <label>NISN</label>
                        <input name="nisn" readonly class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <input name="nama" readonly class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Sakit</label>
                        <input min="0" name="sakit" required type="number" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Izin</label>
                        <input min="0" name="izin" required type="number" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Tanpa Keterangan</label>
                        <input min="0" name="tanpa_keterangan" required type="number" class="form-control" />
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

<section class="content">

    <div class="row">
        <div class="col-md-12">
        @component('components.filters', ['title' => __('report.filters')])
        
            {{-- <div class="col-md-3">
                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas" type="text" class="form-control">
                        <option>4 A</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tahun Ajaran</label>
                    <select name="kelas" type="text" class="form-control">
                        <option>2024/2025 (Semester 1)</option>
                        <option>2024/2025 (Semester 2)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div style="margin-top: 2.5rem;">
                    <button class="btn btn-primary" id="cari"><i class="fa fa-search"></i> CARI</button>
                    <button class="btn btn-primary" id="reset">RESET</button>
                </div>
            </div> --}}

            <div class="form-group col-md-3">
                <label>Kelas</label>
                <select id="kelas_id" class="form-control" name="kelas_id" required>
                    @foreach ($kelas as $item)
                        <option value="{{$item->id}}">{{ $item->nama_kelas }} (Semester {{$item->semester}} - {{$item->tahun_ajaran}})</option>
                    @endforeach
                </select>
            </div>

        
        @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Semua Data</a>
                    </li>
                    {{-- <li>
                        <a 
                            href="#"
                            onclick='$("#editor_modal").modal("show")'
                        >
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data
                        </a>
                    </li> --}}
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th>Sakit</th>
                                        <th>Izin</th>
                                        <th>Tanpa Keterangan</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>1</td>
                                        <td>123</td>
                                        <td>Juliani Okta Farida</td>
                                        <td>13</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>
                                            <a 
                                                class="btn btn-primary btn-xs" 
                                                href="#"
                                                onclick='$("#editor_modal").modal("show")'
                                            >
                                                Edit
                                            </a>
                                            <a 
                                                class="btn btn-danger btn-xs" 
                                                href="#"
                                                target="_blank"
                                            >
                                                Hapus
                                            </a>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
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
                { data: 'siswa.nisn'  },
                { data: 'siswa.nama'  },
                { data: 'sakit'  },
                { data: 'izin'  },
                { data: 'tanpa_keterangan'  },
                { 
                    searchable: false, 
                    data: 'id',
                    className:"text-center",
                    render:(data)=> {
                        return `<a 
                            class="btn btn-primary btn-xs" 
                            href="#"
                            onclick='editData(${data})'
                        >
                            Edit
                        </a>`
                    }
                },
            ]
        });
    });

    
    const editData = (id) => {
        const modals_dom = $("#editor_modal");
        const href = "{{route('sekolah_sd.kelas.store')}}";
        $.ajax({
            method: "POST",
            url: href,
            data: {
                show:1,
                id:id
            },
            dataType: "json",
            beforeSend: () => {
                modals_dom.find('input:not([type=hidden])').attr('disabled');
                modals_dom.find('button').attr('disabled');
            },
            complete: () => {
                modals_dom.find('input:not([type=hidden])').removeAttr('disabled');
                modals_dom.find('button').removeAttr('disabled');
            },
            success: function(result){
                const {data} = result;
                if(!data) return;
                modals_dom.find('input[name=nisn]').val( data.siswa.nisn );
                modals_dom.find('input[name=nama]').val( data.siswa.nama );
                modals_dom.find('input[name=sakit]').val( data.sakit );
                modals_dom.find('input[name=izin]').val( data.izin );
                modals_dom.find('input[name=tanpa_keterangan]').val( data.tanpa_keterangan );
            }
        })
        modals_dom.find('input[name=id]').val(id);
        modals_dom.modal('show');
    }

    $("#kelas_id").change(function(){
        product_table.ajax.reload();
    })

    $("#form_absen").on('submit', (function(e) {
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
                    toastr.success(result.msg);
                    product_table.ajax.reload();
                } else {
                    toastr.error(result.msg);
                }
                $("#form_absen").trigger("reset"); // to reset form input fields
                $("#editor_modal").modal("hide");
            },
            error: function(e) {
                console.log(e);
            }
        });
    }));

</script>
@endsection