@extends('layouts.app')
@section('title', 'Manajemen Dimensi Kokurikuler')

@section('css')
<style>
    .modal-header { background: #007bff; color: white; }
    .status-active { color: green; font-weight: bold; }
</style>
@endsection

@section('content')
<section class="content-header">
    <h1>Dimensi Kokurikuler</h1>
</section>

<section class="content">
    <div class="text-right mb-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal_dimensi">
            <i class="fa fa-plus"></i> Tambah Dimensi
        </button>
    </div>

    <div class="box box-primary">
        <div class="box-body table-responsive">
            <table id="table_dimensi" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Dimensi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<!-- 🔹 Modal Tambah/Edit -->
<div class="modal fade" id="modal_dimensi" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="modal_title_dimensi" class="modal-title">Tambah Dimensi</h4>
      </div>
      <div class="modal-body">
        <form id="form_dimensi">
          @csrf
          <input type="hidden" id="id_edit" name="id" value="0">

          <div class="form-group">
              <label>Nama Dimensi</label>
              <input type="text" name="profil" id="nama" class="form-control" required>
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
    // 🔹 Load DataTable
    table = $('#table_dimensi').DataTable({
        order:[],
        ajax: "{{ route('kokurikuler.dimensi.data') }}",
        columns: [
            { data: 'profil' },
            { data: 'id', render:(id)=>`
                <button class="btn btn-info btn-xs" onclick="editDimensi(${id})"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-xs" onclick="hapusDimensi(${id})"><i class="fa fa-trash"></i></button>
            `}
        ]
    });

    // 🔹 Simpan Tambah/Edit
    $('#form_dimensi').on('submit', function(e){
        e.preventDefault();
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: "{{ route('kokurikuler.dimensi.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            complete: () => btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan'),
            success: (res) => {
                if(res.status){
                    toastr.success(res.message);
                    $('#modal_dimensi').modal('hide');
                    table.ajax.reload();
                    $('#form_dimensi')[0].reset();
                    $('#id_edit').val(0);
                } else {
                    toastr.error(res.message);
                }
            },
            error: ()=>{
                toastr.error("Terjadi kesalahan saat menyimpan data");
            }
        });
    });
});

// 🔹 Reset saat tambah baru
$('[data-target="#modal_dimensi"]').on('click', function(){
    $('#modal_title_dimensi').text('Tambah Dimensi');
    $('#form_dimensi')[0].reset();
    $('#id_edit').val(0);
});

// 🔹 Edit data
function editDimensi(id){
    $.get(`/sekolah_sd/kokurikuler/dimensi/${id}`, function(res){
        if(res.status){
            const d = res.data;
            $('#modal_title_dimensi').text('Edit Dimensi');
            $('#id_edit').val(d.id);
            $('#nama').val(d.profil);
            $('#modal_dimensi').modal('show');
        } else {
            toastr.error("Data tidak ditemukan");
        }
    });
}

// 🔹 Hapus data
function hapusDimensi(id){
    swal({
        title: "Hapus Dimensi?",
        text: "Data yang dihapus tidak bisa dikembalikan.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then(ok=>{
        if(ok){
            $.ajax({
                url:`/sekolah_sd/kokurikuler/dimensi/${id}`,
                method:"DELETE",
                data:{ _token:"{{ csrf_token() }}" },
                success:(res)=>{
                    if(res.status){
                        toastr.success("Dimensi dihapus!");
                        table.ajax.reload();
                    }else toastr.error(res.message);
                },
                error:()=>{
                    toastr.error("Gagal menghapus data");
                }
            });
        }
    });
}
</script>
@endsection
