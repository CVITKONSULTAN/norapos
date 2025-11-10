@extends('layouts.app')
@section('title', 'Manajemen Periode PPDB')

@section('css')
<style>
    .modal-header { background: #007bff; color: white; }
    .status-open { color: green; font-weight: bold; }
    .status-close { color: red; font-weight: bold; }
</style>
@endsection

@section('content')
<section class="content-header">
    <h1>Manajemen Periode PPDB</h1>
</section>

<section class="content">

    <div class="text-right mb-3" style="margin-bottom:50px;">
        {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#modal_ppdb_setting"> --}}
        <button class="btn btn-primary" id="tambah">
            <i class="fa fa-plus"></i> Tambah Periode
        </button>
    </div>

    <div class="box box-primary">
        <div class="box-body table-responsive">
            <table id="table_setting" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <th>Tanggal Penerimaan</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th>Rekening</th>
                        <th>Tanggal Tes</th>
                        <th>Tempat Tes</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</section>

<!-- 🔹 Modal Tambah/Edit -->
<div class="modal fade" id="modal_ppdb_setting" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah / Perbarui Periode PPDB</h4>
      </div>
      <div class="modal-body">
        <form id="form_setting">
            @csrf
            <input type="hidden" id="id_edit" name="id">

            <div class="form-group">
                <label>Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Tanggal Penerimaan</label>
                <input type="date" name="tgl_penerimaan" id="tgl_penerimaan" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Biaya Pendaftaran (Rp)</label>
                <input type="number" name="jumlah_tagihan" id="jumlah_tagihan" class="form-control" min="0" required>
            </div>

            <div class="form-group">
                <label>Nama Bank</label>
                <input type="text" name="nama_bank" id="nama_bank" class="form-control">
            </div>

            <div class="form-group">
                <label>No. Rekening</label>
                <input type="text" name="no_rek" id="no_rek" class="form-control">
            </div>

            <div class="form-group">
                <label>Atas Nama</label>
                <input type="text" name="atas_nama" id="atas_nama" class="form-control">
            </div>

            <div class="form-group">
                <label>Tanggal Tes</label>
                <input type="date" name="tanggal_tes" id="tanggal_tes" class="form-control">
            </div>

            <div class="form-group">
                <label>Tempat Tes</label>
                <input type="text" name="tempat_tes" id="tempat_tes" class="form-control">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection


@section('javascript')
<script>
let table;

$(document).ready(function(){
    // 🔹 Load data tabel
    table = $('#table_setting').DataTable({
        order:[],
        ajax: "{{ route('sekolah_sd.ppdb.setting.data') }}",
        columns: [
            { data: 'tahun_ajaran' },
            { data: 'tgl_penerimaan', render:(d)=> d ? moment(d).format('DD/MM/YYYY') : '-' },
            { data: 'jumlah_tagihan', render:(d)=> 'Rp ' + new Intl.NumberFormat('id-ID').format(d) },
            { data: 'close_ppdb', render:(v)=> v ? '<span class="status-close">Tertutup</span>' : '<span class="status-open">Dibuka</span>' },
            { data: null, render:(r)=> `${r.nama_bank ?? '-'}<br><small>${r.no_rek ?? ''}</small>` },
            { data: 'tanggal_tes', render:(d)=> d ? moment(d).format('DD/MM/YYYY') : '-' },
            { data: 'tempat_tes' },
            { data: 'id', render:(id,_,row)=>{
                const btnOpen = row.close_ppdb ? `<button class="btn btn-success btn-xs" onclick="toggleStatus(${id},0)"><i class='fa fa-unlock'></i> Buka</button>` : '';
                const btnClose = !row.close_ppdb ? `<button class="btn btn-warning btn-xs" onclick="toggleStatus(${id},1)"><i class='fa fa-lock'></i> Tutup</button>` : '';
                return `
                    ${btnOpen} ${btnClose}
                    <button class="btn btn-info btn-xs" onclick="editData(${id})"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-danger btn-xs" onclick="deleteData(${id})"><i class="fa fa-trash"></i></button>
                `;
            }}
        ]
    });

    $('#tambah').click(()=>{
        $('#id_edit').val(0);
        $('#tahun_ajaran').val("");
        $('#jumlah_tagihan').val("");
        $('#nama_bank').val("");
        $('#no_rek').val("");
        $('#atas_nama').val("");
        $('#tempat_tes').val("");
        $('#tanggal_tes').val("");
    
        $('#tgl_penerimaan').val("");

        $('#modal_ppdb_setting').modal('show');
    })

    // 🔹 Simpan data
    $('#form_setting').on('submit', function(e){
        e.preventDefault();
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: "{{ route('sekolah_sd.ppdb.setting.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            complete: function(){
                btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
            },
            success: function(res){
                if(res.status){
                    toastr.success(res.message);
                    $('#modal_ppdb_setting').modal('hide');
                    table.ajax.reload();
                    $('#form_setting')[0].reset();
                    $('#id_edit').val('');
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(){
                toastr.error("Terjadi kesalahan saat menyimpan data");
            }
        });
    });
});


// 🔹 Edit data
function editData(id){
    $.get(`/sekolah_sd/ppdb/setting/${id}`, function(res){
        if(res.status){
            const d = res.data;
            $('#id_edit').val(d.id);
            $('#tahun_ajaran').val(d.tahun_ajaran);
            $('#jumlah_tagihan').val(d.jumlah_tagihan);
            $('#nama_bank').val(d.nama_bank);
            $('#no_rek').val(d.no_rek);
            $('#atas_nama').val(d.atas_nama);
            $('#tempat_tes').val(d.tempat_tes);
            $('#tanggal_tes').val(d.tanggal_tes ? moment(d.tanggal_tes).format('YYYY-MM-DD') : '');
            
            // ✅ Format tanggal penerimaan agar tampil
            $('#tgl_penerimaan').val(d.tgl_penerimaan ? moment(d.tgl_penerimaan).format('YYYY-MM-DD') : '');

            $('#modal_ppdb_setting').modal('show');
        } else {
            toastr.error("Data tidak ditemukan");
        }
    });
}


// 🔹 Toggle status open/close (hanya 1 yang boleh dibuka)
function toggleStatus(id, close){
    $.post('{{ route("sekolah_sd.ppdb.setting.toggle") }}', {
        id,
        close_ppdb: close,
        _token: "{{ csrf_token() }}"
    }, function(res){
        if(res.status){
            toastr.success(res.message);
            table.ajax.reload();
        } else {
            toastr.error(res.message);
        }
    });
}


// 🔹 Hapus data
function deleteData(id){
    swal({
        title: "Hapus Periode?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then(ok=>{
        if(ok){
            $.ajax({
                url:`/sekolah_sd/ppdb/setting/${id}`,
                method:"DELETE",
                data:{ _token:"{{ csrf_token() }}" },
                success:(res)=>{
                    if(res.status){
                        toastr.success("Periode dihapus!");
                        table.ajax.reload();
                    }else toastr.error(res.message);
                },
                error:()=>{
                    toastr.error("Gagal menghapus data");
                }
            })
        }
    })
}
</script>
@endsection
