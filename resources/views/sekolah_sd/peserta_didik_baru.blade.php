@extends('layouts.app')
@section('title', "Peserta Didik Baru")

@section('css')
<style>
    .table_profile_dashboard_sekolah {
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
    <h1>Peserta Didik Baru</h1>
</section>

<!-- Main content -->
<section class="content">

    {{-- 🔹 Informasi Pengaturan PPDB --}}
    @if(isset($ppdb_setting))
    <div class="alert alert-warning">
        <h4>Informasi PPDB {{ $ppdb_setting->tahun_ajaran }}</h4>
        <p>
            <strong>Status:</strong> 
            @if($ppdb_setting->close_ppdb)
                <span class="label label-danger">Ditutup</span>
            @else
                <span class="label label-success">Dibuka</span>
            @endif
            <br>
            <strong>Tanggal Penerimaan:</strong> {{ \Carbon\Carbon::parse($ppdb_setting->tgl_penerimaan)->translatedFormat('d F Y') }}<br>
            <strong>Biaya Pendaftaran:</strong> Rp {{ number_format($ppdb_setting->jumlah_tagihan, 0, ',', '.') }}<br>
            <strong>Rekening:</strong> {{ $ppdb_setting->nama_bank }} - {{ $ppdb_setting->no_rek }} a.n {{ $ppdb_setting->atas_nama }}
        </p>
    </div>
    @endif

    {{-- 🔹 Modal Detail Data --}}
    <div id="detail_ppdb_popup" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
	                <h4 class="modal-title">Detail PPDB</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table_profile_dashboard_sekolah" id="data_detail_table"></table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 DataTable --}}
    <div class="row">
        <div class="col-md-12">
           <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product_list_tab" data-toggle="tab" aria-expanded="true">
                            <i class="fa fa-users" aria-hidden="true"></i> Semua Data
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="product_list_tab">
                        <div class="text-right mb-2">
                            <a href="{{ route('sekolah_sd.ppdb.export') }}" class="btn btn-primary">
                                <i class="fa fa-upload"></i> Ekspor
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view hide-footer" id="product_table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat / Tgl Lahir</th>
                                        <th>Total Bayar</th>
                                        <th>Status Bayar</th>
                                        <th>Validasi Oleh</th>
                                        <th>Tanggal Validasi</th>
                                        <th>Tanggal Registrasi</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>

</section>
@endsection

@section('javascript')
<script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
<script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
<script type="text/javascript">
    const HitungTglLahir = (tgl_lahir) => {
        if(!tgl_lahir) return '-';
        const birthDate = moment(tgl_lahir, 'YYYY-MM-DD');
        const currentDate = moment();
        const years = currentDate.diff(birthDate, 'years');
        const months = currentDate.diff(birthDate.add(years, 'years'), 'months');
        return `${years} tahun ${months} bulan`;
    }

    const detailData = (id) => {
        const image_attribute_list = ['bukti_bayar_ppdb','kartu_keluarga','akta_lahir','pas_foto'];
        $.ajax({
            url:`/sekolah_sd/ppdb/${id}`,
            success:(response)=>{
                if(!response.status) return toastr.error(response.message);
                $("#data_detail_table").empty();
                if(response.data.detail){
                    for(const k in response.data.detail){
                        const val = response.data.detail[k];
                        let str = val ?? '-';
                        if(image_attribute_list.includes(k)) str = `<img class="img-responsive" src="${val}" />`;
                        if(k == 'tanggal_lahir'){
                            const hitung = HitungTglLahir(val);
                            str = `${val} (${hitung})`
                        }
                        const template = `<tr><td>${k}</td><td>:</td><td>${str}</td></tr>`;
                        $("#data_detail_table").append(template);
                    }
                }
            }
        });
        $("#detail_ppdb_popup").modal('show');
    }

    const validasiBayar = (id) => {
        swal({
            title: "Validasi pembayaran?",
            icon: "info",
            buttons: true,
        }).then((ok) => {
            if(ok){
                $.ajax({
                    method: "POST",
                    url: `/sekolah_sd/ppdb/${id}/validasi`,
                    dataType: "json",
                    success: function(res){
                        if(res.status){
                            toastr.success("Pembayaran telah divalidasi!");
                            product_table.ajax.reload();
                        } else {
                            toastr.error(res.message);
                        }
                    }
                });
            }
        });
    }

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

    const cetakData = (id) => {
        const url = `/ppdb-simuda/print/${id}`;
        window.open(url, '_blank');
    }

    $(document).ready(function(){
        product_table = $('#product_table').DataTable({
            processing: true,
            serverSide: true,
            order:[],
            dom: 'Bfrtip',
            buttons: [],
            ajax: { url: "{{ route('sekolah_sd.ppdb.data') }}" },
            columns: [
                {
                    data:'id',
                    render:(data,type,row)=> row.detail.nama ?? '-'
                },
                {
                    data:'id',
                    render:(data,type,row)=> row.detail['jenis-kelamin'] ?? '-'
                },
                {
                    data:'id',
                    render:(data,type,row)=>{
                        const tempat = row.detail['tempat-lahir'] ?? '-';
                        const tgl = row.detail['tanggal-lahir']
                            ? moment(row.detail['tanggal-lahir']).format('D/M/Y')
                            : '-';
                        const umur = row.detail['tanggal-lahir']
                            ? HitungTglLahir(row.detail['tanggal-lahir'])
                            : '';
                        return `${tempat}, ${tgl} (${umur})`;
                    }
                },
                {
                    data:'id',
                    render:(data,type,row)=>{
                        const total = row.detail.total_bayar ?? 0;
                        return `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
                    }
                },
                {
                    data:'status_bayar',
                    render:(data)=>{
                        const color = data === 'sudah' ? 'green' : 'red';
                        const label = data ? data.toUpperCase() : 'BELUM';
                        return `<span style="color:${color}; font-weight:bold;">${label}</span>`;
                    }
                },
                {
                    data:'validator',
                    render:(data,type,row)=> row.validator?.name ?? '-'
                },
                {
                    data:'validated_at',
                    render:(data)=>{
                        return data ? moment(data).format('DD/MM/YYYY HH:mm') : '-';
                    }
                },
                {
                    data:'created_at',
                    render:(data)=>{
                        return data ? moment(data).format('DD/MM/YYYY HH:mm') : '-';
                    }
                },
                {
                    data:'id',
                    className:"text-center",
                    render:(data,type,row)=>{
                        const validBtn = row.status_bayar === 'belum'
                            ? `<button class="btn btn-success btn-xs" onclick="validasiBayar(${data})">Validasi</button>`
                            : '';
                        return `
                            ${validBtn}
                            <button class="btn btn-primary btn-xs" onclick="cetakData(${data})">Cetak</button>
                            <button class="btn btn-info btn-xs" onclick="detailData(${data})">Detail</button>
                            <button class="btn btn-danger btn-xs" onclick="deleteData(${data})">Hapus</button>
                        `;
                    }
                }
            ]
        });
    });
</script>
@endsection
