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

    const detailData = (id) => {
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
                        const template = `<tr>
                            <td>${k}</td>
                            <td>:</td>
                            <td>${val}</td>
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
                                <button 
                                    class="btn btn-primary btn-xs" 
                                    onclick="editData(${data})"
                                >
                                    Edit
                                </button>
                                <a 
                                    class="btn btn-danger btn-xs delete-product" 
                                    href="{{ route('sekolah_sd.ekskul.store') }}/${data}"
                                    data-id="${data}"
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

    </script>
@endsection
