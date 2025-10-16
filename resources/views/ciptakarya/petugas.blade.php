@extends('layouts.app')
@section('title', 'Data Petugas Lapangan')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Data Petugas Lapangan</h1>
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => ""])
        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
                <button class="btn btn-success btn-block btn-lg"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data Petugas Baru</button>
            </div>
        </div>
    @endcomponent
    @component('components.widget', ['class' => 'box-primary', 'title' => "Daftar Petugas"])
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="product_table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Nama Lengkap</th>
                            <th>Bidang</th>
                            <th>Jabatan / Golongan</th>
                            <th>NIP</th>
                            <th>NIK</th>
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
    @endcomponent
</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script>
        const product_table = $('#product_table').DataTable({
            // processing: true,
            // serverSide: true,
            // dom: 'lBfrtip', // Menampilkan tombol export
            // paging: true,   // Mengaktifkan paging (pagination)
            // buttons: [
            //     {
            //         extend: 'excelHtml5',
            //         text: 'Export ke Excel',
            //         title: 'Data Pegawai',
            //         className: 'btn btn-success' // Tambahkan class Bootstrap jika perlu
            //     }
            // ],
            // lengthMenu: [[-1, 10, 25, 50], ["Semua", 10, 25, 50]],
            // pageLength: -1,
            // ajax: {
            //         url:'{{ route("absensi.data") }}',
            //         "data": function ( d ) {
            //             d.start = $("#filter_start").val();
            //             d.end = $("#filter_end").val();
            //             d = __datatable_ajax_callback(d);
            //         }
            // },
            // columnDefs: [ {
            //     "orderable": false,
            //     "searchable": false
            // } ],
            // "columns":[
            //     {
            //         "data":"created_at",
            //         "render":(data,type,row,meta) => {
            //             let string = moment(data).format('dddd')+", "+moment(data).format(moment_date_format)+" "+moment(data).format(moment_time_format)+
            //             "<br/>Tipe: <b>"+row.tipe.toUpperCase()+"</b>";
            //             if(row.tipe === "pulang"){
            //                 string += "<br/>Jam Kerja: "+row.total_hours;
            //             }
            //             return string;
            //         }
            //     },
            //     {
            //         "data":"name"
            //     },
            //     {
            //         "data":"picture",
            //         "render":(data,type,row,meta) => {
            //             return `<a target="_blank" href="${data}"><img class="img img-responsive absensi_picture" src="${data}" /></a>`;
            //         }
            //     },
            //     {
            //         "data":"coordinates",
            //         "render":(data,type,row,meta) => {
            //             let string = '<a target="_blank" href="https://maps.google.com/?q='+data.latitude+','+data.longitude+'">'+data.latitude+','+data.longitude+'</a>'
            //             if(data.accuracy){
            //                 string += '<br/>Akurasi: '+parseFloat(data.accuracy).toFixed(2)+' m'
            //             }
            //             return string;
            //         }
            //     },
            //     @can('absensi.delete')
            //     {
            //         "data":"id",
            //         "render":(data,type,row,meta) => {
            //             let str = '';
            //                 str = `<button data-id="${data}" class="btn btn-danger delete_user_button">Hapus</button>`;
            //             return str;
            //         }
            //     }
            //     @endcan
            // ]
        });


            $(document).on('click', 'button.delete_user_button', function(){
                swal({
                title: LANG.sure,
                text: LANG.confirm_delete_user,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        const href = "{{ route('absensi.store') }}";
                        const id = $(this).data('id');
                        $.ajax({
                            method: "POST",
                            url: href,
                            dataType: "json",
                            data: {delete:1,id:id},
                            success: function(result){
                                if(result.status){
                                    toastr.success(result.message);
                                    product_table.ajax.reload();
                                } else {
                                    toastr.error(result.message);
                                }
                            }
                        });
                    }
                });
            });

        // $("#filter_start").change(function(){
        //     product_table.ajax.reload();
        // })
        // $("#filter_end").change(function(){
        //     product_table.ajax.reload();
        // })
    </script>
@endsection
