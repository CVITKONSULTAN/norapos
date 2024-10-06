@extends('layouts.app')
@section('title', "Mata Pelajaran")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Mata Pelajaran</h1>
</section>

<!-- Main content -->

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
                        <a 
                            target="_blank" 
                            href="{{ route('sekolah_sd.mapel.create') }}"
                        >
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
                                        <th>ID</th>
                                        <th>Mapel</th>
                                        <th>Kategori</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
{{-- 
                                    <tr>
                                        <td>1</td>
                                        <td>Agama Islam</td>
                                        <td>Wajib</td>
                                        <td>
                                            <a 
                                                class="btn btn-primary btn-xs" 
                                                href="{{ route('sekolah_sd.mapel.create') }}"
                                                target="_blank"
                                            >
                                                Edit
                                            </a>
                                            <a 
                                                class="btn btn-primary btn-xs" 
                                                href="{{ route('sekolah_sd.mapel.create') }}"
                                                target="_blank"
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
                columnDefs: [
                    {
                        "targets": [0],
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "targets": [3],
                        "orderable": false,
                        "searchable": false
                    },
                ],
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('sekolah_sd.mapel.data') }}",
                },
                columns: [
                    { data: 'id'  },
                    { data: 'nama'  },
                    { data: 'kategori'  },
                    { 
                        data: 'id',
                        className:"text-center",
                        render:(data)=> {
                            const template = `
                                <a 
                                    class="btn btn-primary btn-xs" 
                                    href="{{ route('sekolah_sd.mapel.index') }}/${data}/edit"
                                    target="_blank"
                                >
                                    Edit
                                </a>
                                <a 
                                    class="btn btn-primary btn-xs" 
                                    href="{{ route('sekolah_sd.mapel.create') }}"
                                    target="_blank"
                                >
                                    Melihat
                                </a>
                                <a 
                                    class="btn btn-danger btn-xs delete-product" 
                                    href="{{ route('sekolah_sd.mapel.index') }}/${data}"
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