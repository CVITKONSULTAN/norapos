@extends('layouts.app')
@section('title', 'Manajemen Tema Kokurikuler')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .modal-header {
        background: #007bff;
        color: #fff;
        border-bottom: 2px solid #0069d9;
    }
    .modal-content {
        border-radius: 10px;
        overflow: hidden;
    }
    .modal-body {
        background: #f9f9f9;
        padding: 25px;
    }
    .form-group label {
        font-weight: 600;
        color: #333;
    }
    .select2-container .select2-selection--multiple {
        min-height: 42px;
        border: 1px solid #ccc !important;
        border-radius: 6px !important;
        padding: 6px;
        background: white;
    }
    .select2-selection__choice {
        background-color: #007bff !important;
        color: white !important;
        border: none !important;
        border-radius: 4px !important;
        padding: 3px 8px !important;
        margin-top: 4px !important;
    }
    .select2-selection__choice__remove {
        color: #fff !important;
        margin-right: 5px;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <h1>Tema Kokurikuler</h1>
</section>

<section class="content">
    <div class="text-right mb-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal_tema">
            <i class="fa fa-plus"></i> Tambah Tema
        </button>
    </div>

    <div class="box box-primary">
        <div class="box-body table-responsive">
            <table id="table_tema" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tema</th>
                        <th>Aspek Nilai</th>
                        <th>Dimensi</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<!-- 🔹 Modal Tambah/Edit -->
<div class="modal fade" id="modal_tema" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="modal_title_tema" class="modal-title">Tambah Tema</h4>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="form_tema">
          @csrf
          <input type="hidden" id="id_edit" name="id" value="0">

          <div class="form-group">
              <label>Tema</label>
              <input type="text" name="tema" id="tema" class="form-control" placeholder="Masukkan nama tema" required>
          </div>

          <div class="form-group">
              <label>Aspek Nilai</label>
              <textarea name="aspek_nilai" id="aspek_nilai" rows="3" class="form-control" placeholder="Masukkan aspek nilai"></textarea>
          </div>

          <div class="form-group">
              <label>Dimensi Terkait</label>
              <select name="dimensi_list[]" id="dimensi_list" class="form-control" multiple="multiple" required style="width:100%;"></select>
              <small class="text-muted">Pilih satu atau lebih dimensi terkait tema ini.</small>
          </div>

          <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Kelas</label>
                      <select name="kelas" id="kelas" class="form-control" required>
                          <option value="">-- Pilih Kelas --</option>
                          @foreach($level_kelas ?? [] as $kls)
                              <option value="{{ $kls }}">{{ $kls }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                      <label>Tahun Ajaran</label>
                      <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                          <option value="">-- Pilih Tahun Ajaran --</option>
                          @foreach($tahun_ajaran ?? [] as $ta)
                              <option value="{{ $ta }}">{{ $ta }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                      <label>Semester</label>
                      <select name="semester" id="semester" class="form-control" required>
                          <option value="">-- Pilih Semester --</option>
                          @foreach($semester ?? [] as $sem)
                              <option value="{{ $sem }}">{{ ucfirst($sem) }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
          </div>

          <div class="text-right mt-3">
              <button type="submit" class="btn btn-success px-4 py-2">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
let table;

$(document).ready(function(){

    // 🔹 Inisialisasi Select2 untuk dimensi_list
    $('#dimensi_list').select2({
        placeholder: 'Pilih Dimensi Terkait',
        allowClear: true,
        dropdownParent: $('#modal_tema'),
        ajax: {
            url: '/sekolah_sd/kokurikuler/dimensi/data',
            dataType: 'json',
            delay: 250,
            processResults: function (res) {
                const results = res.data
                    ? res.data.map(item => ({ id: item.profil, text: item.profil }))
                    : res.map(item => ({ id: item.profil, text: item.profil }));
                return { results };
            },
            cache: true
        }
    });

    // 🔹 Load DataTable
    table = $('#table_tema').DataTable({
        order: [],
        ajax: "{{ route('kokurikuler.tema.data') }}",
        columns: [
            { data: 'tema' },
            { data: 'aspek_nilai' },
            {
                data: 'dimensi_list',
                render: (d) => {
                    if (!d) return '<span class="text-muted">-</span>';
                    try {
                        // 🧹 Bersihkan HTML entity &quot; jadi tanda kutip biasa
                        const clean = d.replace(/&quot;/g, '"');

                        const arr = JSON.parse(clean);
                        if (!Array.isArray(arr) || arr.length === 0)
                            return '<span class="text-muted">-</span>';

                        // 🎨 Tampilkan dalam bentuk badge
                        return arr
                            .map(item => `<span class="badge badge-warning" style="margin:2px; font-size:11px;">${item}</span>`)
                            .join(' ');
                    } catch {
                        return `<span class="badge badge-info" style="margin:2px; font-size:11px;">${d}</span>`;
                    }
                }
            },
            { data: 'kelas' },
            { data: 'tahun_ajaran' },
            { data: 'semester' },
            { data: 'id', render:(id)=>`
                <button class="btn btn-info btn-xs" onclick="editTema(${id})"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-xs" onclick="hapusTema(${id})"><i class="fa fa-trash"></i></button>
            `}
        ]
    });

    // 🔹 Simpan Tambah/Edit
    $('#form_tema').on('submit', function(e){
        e.preventDefault();
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        const selectedDimensi = $('#dimensi_list').val();
        const formData = $(this).serializeArray();
        formData.push({ name: 'dimensi_list', value: JSON.stringify(selectedDimensi) });

        $.ajax({
            url: "{{ route('kokurikuler.tema.store') }}",
            method: 'POST',
            data: formData,
            complete: () => btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan'),
            success: (res) => {
                if(res.status){
                    toastr.success(res.message);
                    $('#modal_tema').modal('hide');
                    table.ajax.reload();
                    $('#form_tema')[0].reset();
                    $('#id_edit').val(0);
                    $('#dimensi_list').val(null).trigger('change');
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
$('[data-target="#modal_tema"]').on('click', function(){
    $('#modal_title_tema').text('Tambah Tema');
    $('#form_tema')[0].reset();
    $('#id_edit').val(0);
    $('#dimensi_list').val(null).trigger('change');
});

// 🔹 Edit data
function editTema(id){
    $.get(`/sekolah_sd/kokurikuler/tema/${id}`, function(res){
        if(res.status){
            const d = res.data;
            $('#modal_title_tema').text('Edit Tema');
            $('#id_edit').val(d.id);
            $('#tema').val(d.tema);
            $('#aspek_nilai').val(d.aspek_nilai);
            $('#kelas').val(d.kelas);
            $('#tahun_ajaran').val(d.tahun_ajaran);
            $('#semester').val(d.semester);

            $('#dimensi_list').empty().trigger('change');
            if (d.dimensi_list) {
                let selected = [];
                try { selected = JSON.parse(d.dimensi_list); }
                catch { selected = d.dimensi_list.split(','); }
                selected.forEach(dimensi => {
                    const option = new Option(dimensi, dimensi, true, true);
                    $('#dimensi_list').append(option);
                });
                $('#dimensi_list').trigger('change');
            }

            $('#modal_tema').modal('show');
        } else {
            toastr.error("Data tidak ditemukan");
        }
    });
}

// 🔹 Hapus data
function hapusTema(id){
    swal({
        title: "Hapus Tema?",
        text: "Data yang dihapus tidak bisa dikembalikan.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then(ok=>{
        if(ok){
            $.ajax({
                url:`/sekolah_sd/kokurikuler/tema/${id}`,
                method:"DELETE",
                data:{ _token:"{{ csrf_token() }}" },
                success:(res)=>{
                    if(res.status){
                        toastr.success("Tema dihapus!");
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
