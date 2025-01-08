@extends('layouts.app')
@section('title', "Peserta didik baru")

@section('css')
<style>
    .table_profile_dashboard_sekolah{
        border-collapse: collapse;
        border: 1px solid black;
        border-radius: 5px;
    }
    .table_profile_dashboard_sekolah tr {
        border: 1px solid black;
    }
    .table_profile_dashboard_sekolah tr td {
        padding: 10px;
    }
</style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Peserta didik baru</h1>
</section>

<!-- Main content -->

<section class="content">

    <div id="detail_ppdb_popup" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
	                <h4 class="modal-title">
                        Detail PPDB
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table_profile_dashboard_sekolah" id="data_detail_table"></table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
           <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true">
                            <i class="fa fa-cubes" aria-hidden="true"></i>Semua Data
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
                                        <th>Nama</th>
                                        <th>Tgl Lahir</th>
                                        <th>No. HP</th>
                                        <th>Jarak</th>
                                        <th>Waktu Tempuh</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
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
    <script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">

    const HitungTglLahir = (tgl_lahir) => {
        if(!tgl_lahir || tgl_lahir == null) return '-';
        // Tanggal lahir
        const birthDate = moment(tgl_lahir, 'YYYY-MM-DD');
        // Tanggal saat ini
        const currentDate = moment();

        // Hitung selisih tahun dan bulan
        const years = currentDate.diff(birthDate, 'years');
        const months = currentDate.diff(birthDate.add(years, 'years'), 'months');

        // Output
        // console.log(`Umur: ${years} tahun dan ${months} bulan.`);
        return `${years} tahun ${months} bulan`;
    }

    const detailData = (id) => {
        const image_attribute_list = [
            'bukti_bayar_ppdb',
            'kartu_keluarga',
            'akta_lahir',
            'pas_foto',
        ];
        $.ajax({
            url:`/sekolah_sd/ppdb/${id}`,
            success:(response)=>{
                // return console.log("response",response);
                if(!response.status) 
                return toastr.error(response.message);
                $("#data_detail_table").empty();
                if(response.data.detail){
                    for(const k in response.data.detail){
                        const val = response.data.detail[k]
                        let str = val;
                        if(val == null) str = '-';
                        if(image_attribute_list.includes(k))
                        str = `<img class="img-responsive" src="${val}" />`

                        if(k == 'tanggal_lahir'){
                            const hitung = HitungTglLahir(val);
                            str = `${val} (${hitung})`
                        }

                        const template = `<tr>
                            <td>${k}</td>
                            <td>:</td>
                            <td>${str}</td>
                        </tr>`
                        $("#data_detail_table").append(template);
                    }
                }
            }
        });
        $("#detail_ppdb_popup").modal('show');
    }

        $(document).ready( function(){
            
            product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('sekolah_sd.ppdb.data') }}"
                },
                columns: [
                    {data:'id'},
                    {data:'nama'},
                    {
                        searchable: false,
                        data:'id',
                        render:(data,type,row)=> {
                            if(!row.detail.tanggal_lahir) return '-';
                            const hitung = HitungTglLahir(row.detail.tanggal_lahir);
                            const tgl = moment(row.detail.tanggal_lahir).format('D/M/Y');
                            return `${tgl} (${hitung})`
                        }
                    },
                    {
                        searchable: false,
                        data:'id',
                        render:(data,type,row)=> {
                            return row.detail.no_hp ?? "-";
                        }
                    },
                    {
                        searchable: false,
                        data:'id',
                        render:(data,type,row)=> {
                            return row.detail.jarak_ke_sekolah ?? "-";
                        }
                    },
                    {
                        searchable: false,
                        data:'id',
                        render:(data,type,row)=> {
                            return row.detail.waktu_tempuh_ke_sekolah ?? "-";
                        }
                    },
                    {
                        searchable: false,
                        data: 'id',
                        className:"text-center",
                        render:(data,type,row)=> {
                            const template = `
                                <button 
                                    class="btn btn-primary btn-xs" 
                                    onclick="detailData(${data})"
                                >
                                    Detail
                                </button>
                                <a 
                                    class="btn btn-danger btn-xs delete-product" 
                                    onclick="deleteData(${data})"
                                >
                                    Hapus
                                </a>
                            `
                            return template;
                        }
                    }
                ]
            });

        });

        const deleteData = (id) => {
            swal({
                title: LANG.sure,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: "POST",
                        url: `/sekolah_sd/ppdb/${id}`,
                        data:{delete:1},
                        dataType: "json",
                        success: function(response){
                            if(response.status){
                                product_table.ajax.reload();
                            }
                        }
                    });
                }
            });
        } 

    </script>
@endsection
