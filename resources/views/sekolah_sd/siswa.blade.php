@extends('layouts.app')
@section('title', "Data / Identitas Siswa")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Data / Identitas Siswa</h1>
</section>

<!-- Main content -->

<section class="content">

    <div id="import_modal" class="modal fade">
        <div class="modal-dialog">
            <form enctype="multipart/form-data" method="POST" action="{{route('sekolah_sd.siswa.import')}}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">
                        Import Siswa
                    </h4>
                </div>
                <div class="modal-body">
                   <div class="form-group">
                        <label>File</label>
                        <input required class="form-control" type="file" name="import_file" />
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                  </div>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Semua Data</a>
                    </li>
                    <li>
                        <a target="_blank" href="{{ route('sekolah_sd.siswa.create') }}">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="text-right" style="margin-bottom:20px;">
                            <button onclick="$('#import_modal').modal('show')" class="btn btn-primary">Import</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NISN</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nama Panggilan</th>
                                        <th>Tempat / Tanggal Lahir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Agama</th>
                                        <th>Pendidikan Sebelumnya</th>
                                        <th>Alamat Peserta Didik</th>
                                        <th>Ayah</th>
                                        <th>Ibu</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
{{-- 
                                    <tr>
                                        <td>1</td>
                                        <td>123</td>
                                        <td>Juliani Okta Farida</td>
                                        <td>Ani</td>
                                        <td>Sandai, 13 Oktober 1995</td>
                                        <td>Perempuan</td>
                                        <td>Lainnya</td>
                                        <td>PAUD</td>
                                        <td>Parit mayor</td>
                                        <td>Fabullah</td>
                                        <td>Dahlia</td>
                                        <td>
                                            <a 
                                                class="btn btn-primary btn-xs" 
                                                href="{{ route('sekolah_sd.tendik.create') }}"
                                                target="_blank"
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
                                    </tr>
  --}}
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
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "{{ route('sekolah_sd.siswa.data') }}",
            },
            columns: [
                { searchable: false, data: 'id'  },
                { data: 'nisn'  },
                { data: 'nama'  },
                { searchable: false, data: 'detail.nama_panggilan'  },
                { 
                    searchable: false,
                    data: 'id',
                    render:(data,type,row)=> {
                        const tl = row.detail.tempat_lahir ?? ""
                        const ttl = row.detail.tanggal_lahir ?? ""
                        return `${tl} / ${ttl}`;
                    }
                },
                { searchable: false, data: 'detail.jenis_kelamin'  },
                { searchable: false, data: 'detail.agama'  },
                { searchable: false, data: 'detail.pendidikan_sebelumnya'  },
                { searchable: false, data: 'detail.alamat'  },
                { searchable: false, data: 'detail.nama_ayah'  },
                { searchable: false, data: 'detail.nama_ibu'  },
                { 
                    searchable: false,
                    data: 'id',
                    className:"text-center",
                    render:(data)=> {
                        const template = `
                            <a 
                                class="btn btn-primary btn-xs" 
                                href="{{ route('sekolah_sd.siswa.index') }}/${data}/edit"
                                target="_blank"
                            >
                                Edit
                            </a>
                            <a 
                                class="btn btn-danger btn-xs delete-product" 
                                href="{{ route('sekolah_sd.siswa.index') }}/${data}"
                                target="_blank"
                            >
                                Hapus
                            </a>
                        `
                        return template;
                    }
                },
            ]
        });

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


    });

    function getSelectedRows() {
        var selected_rows = [];
        var i = 0;
        $('.row-select:checked').each(function () {
            selected_rows[i++] = $(this).val();
        });

        return selected_rows; 
    }

</script>
@endsection