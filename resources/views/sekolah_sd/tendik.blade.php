@extends('layouts.app')
@section('title', "Tenaga Pendidik")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Tenaga Pendidik</h1>
</section>

<!-- Main content -->
{{-- 
<section class="content">
<div class="row">
    <div class="col-md-12">
    @component('components.filters', ['title' => __('report.filters')])
    
        <div class="col-md-3">
            <div class="form-group">
                <label>Tanggal</label>
                <input id="tanggal_filter" name="date" type="date" class="form-control" />
            </div>
            <button class="btn btn-primary" id="reset">RESET</button>
        </div>

       
    @endcomponent
    </div>
</div>
 --}}

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Semua Data</a>
                    </li>
                    <li>
                        <a target="_blank" href="{{ route('sekolah_sd.tendik.create') }}">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>NIP</td>
                                        <td>Nama Lengkap</td>
                                        <td>Tempat / Tanggal Lahir</td>
                                        <td>Alamat</td>
                                        <td>No. Telpon</td>
                                        <td>Jenis Kelamin</td>
                                        <td>Nama Bidang Studi</td>
                                        <td>Status</td>
                                        <td>Keterangan Lain</td>
                                        <td>Foto Profil</td>
                                        <td>Tindakan</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>1</td>
                                        <td>123</td>
                                        <td>Juliani Okta Farida</td>
                                        <td>Sandai, 13 Oktober 1995</td>
                                        <td>Parit Mayor</td>
                                        <td>081254197359</td>
                                        <td>Perempuan</td>
                                        <td>Agama Islam</td>
                                        <td>Kontrak</td>
                                        <td></td>
                                        <td></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
<script type="text/javascript">

    $(document).ready( function(){
        product_table = $('#product_table').DataTable({
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "{{ route('sekolah_sd.tendik.data') }}",
            },
            columns: [
                { searchable: false, data: 'id'  },
                { data: 'nip'  },
                { data: 'nama'  },
                { 
                    data: 'tempat_lahir',
                    render:(data,type,row)=> {
                        const tgl_lahir = moment(row.tanggal_lahir).format("DD/MM/YYYY");
                        return `${row.tempat_lahir}, ${tgl_lahir}`;
                    }
                },
                { data: 'alamat'  },
                { data: 'no_hp'  },
                { data: 'jenis_kelamin'  },
                { data: 'bidang_studi'  },
                { data: 'status'  },
                { data: 'keterangan'  },
                { 
                    data: 'foto',
                    render:(data)=> {
                        if(!data)
                        return '';
                        return `<img width="50" height="50" src="${data}" />`;
                    }
                },
                { 
                    searchable: false,
                    data: 'id',
                    className:"text-center",
                    render:(data)=> {
                        const template = `
                            <a 
                                class="btn btn-primary btn-xs" 
                                href="{{ route('sekolah_sd.tendik.index') }}/${data}/edit"
                                target="_blank"
                            >
                                Edit
                            </a>
                            <a 
                                class="btn btn-danger btn-xs delete-product" 
                                href="{{ route('sekolah_sd.tendik.index') }}/${data}"
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