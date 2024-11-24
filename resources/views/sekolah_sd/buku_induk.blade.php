@extends('layouts.app')
@section('title', "Buku Induk Siswa")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Buku Induk Siswa</h1>
</section>

<!-- Main content -->
<div id="editor_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    LIHAT BUKU INDUK SISWA
                </h4>
            </div>
            <div class="modal-body">
                <iframe 
                    height="750"
                    width="100%"
                    src="{{url('raport/buku induk siswa format.pdf')}}"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
              </div>
        </div>
    </div>
</div>

<section class="content">

    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-cubes" aria-hidden="true"></i> Semua Data</a>
                    </li>
                    <li>
                        {{-- <a 
                            target="_blank" 
                            href="{{ route('sekolah_sd.buku_induk.create') }}"
                        >
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data
                        </a> --}}
                    </li>
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
                                        {{-- <th>Kewarganegaraan</th> --}}
                                        {{-- <th>Anak Ke</th> --}}
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
{{-- 
                                    <tr>
                                        <td>1</td>
                                        <td>123</td>
                                        <td>Juliani Okta Farida</td>
                                        <td>WNI</td>
                                        <td>1</td>
                                        <td>
                                            <a 
                                                class="btn btn-primary btn-xs" 
                                                href="{{ route('sekolah_sd.buku_induk.create') }}"
                                                target="_blank"
                                            >
                                                Edit
                                            </a>
                                            <a 
                                                class="btn btn-primary btn-xs" 
                                                href="#"
                                                onclick='$("#editor_modal").modal("show")'
                                            >
                                                Melihat
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
                    { 
                        searchable: false,
                        data: 'id',
                        className:"text-center",
                        render:(data)=> {
                            const template = `
                                <a 
                                    class="btn btn-primary btn-xs" 
                                    href="/sekolah_sd/buku-induk/${data}/print"
                                    target="_blank"
                                >
                                    Lihat
                                </a>
                            `
                            return template;
                        }
                    },
                ]
            });


        });

    </script>
@endsection