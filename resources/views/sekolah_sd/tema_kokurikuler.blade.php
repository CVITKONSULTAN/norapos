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
    <div class="box box-primary">
        <div class="box-header with-border d-flex justify-content-between align-items-center">
            <div class="form-inline">
                <label for="filter_lvl_kelas" class="mr-2 font-weight-bold">Level Kelas:</label>
                <select id="filter_lvl_kelas" class="form-control" style="width:150px; margin-right:10px;">
                    @foreach($level_kelas ?? [] as $ta)
                        <option value="{{ $ta }}">{{ $ta }}</option>
                    @endforeach
                </select>

                <label for="filter_tahun" class="mr-2 font-weight-bold">Tahun Ajaran:</label>
                <select id="filter_tahun" class="form-control" style="width:150px; margin-right:10px;">
                    @foreach($tahun_ajaran ?? [] as $ta)
                        <option value="{{ $ta }}">{{ $ta }}</option>
                    @endforeach
                </select>

                <label for="filter_semester" class="mr-2 font-weight-bold">Semester:</label>
                <select id="filter_semester" class="form-control" style="width:120px;">
                    @foreach($semester ?? [] as $sem)
                        <option value="{{ $sem }}">{{ ucfirst($sem) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modal_tema">
                    <i class="fa fa-plus"></i> Tambah Tema
                </button>
                <button class="btn btn-success" onclick="applyTema()">
                    <i class="fa fa-check"></i> Apply Tema
                </button>
            </div>
        </div>

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
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="form_tema">
          @csrf
          <input type="hidden" id="id_edit" name="id" value="0">
          <div class="form-group">
              <label>Tema</label>
              <input type="text" name="tema" id="tema" class="form-control" required>
          </div>
          <div class="form-group">
              <label>Aspek Nilai</label>
              <textarea name="aspek_nilai" id="aspek_nilai" rows="3" class="form-control"></textarea>
          </div>
          <div class="form-group">
              <label>Dimensi Terkait</label>
              <select name="dimensi_list[]" id="dimensi_list" class="form-control" multiple="multiple" style="width:100%;" required></select>
              <small class="text-muted">Pilih satu atau lebih dimensi.</small>
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

<!-- 🔹 Modal Apply -->
<div class="modal fade" id="modal_apply" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h4 class="modal-title">Konfirmasi Apply Tema</h4>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <p id="apply_message" class="lead mb-4"></p>
        <button id="btn_confirm_apply" class="btn btn-success px-4 py-2">
          <i class="fa fa-check"></i> Ya, Apply Sekarang
        </button>
      </div>
    </div>
  </div>
</div>

<!-- 🔹 Modal History Apply -->
<div class="modal fade" id="modal_history" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <h4 class="modal-title">Riwayat Apply Tema</h4>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <ul id="history_list" class="list-group"></ul>
        <div id="no_history" class="text-center text-muted" style="display:none;">Belum ada riwayat apply.</div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
let table, currentApplyId = null;

$(document).ready(function(){

    // 🔹 Select2
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
            }
        }
    });

    // 🔹 DataTables
    table = $('#table_tema').DataTable({
        order: [],
        ajax: {
            url: "{{ route('kokurikuler.tema.data') }}",
            data: d => {
                d.lvl_kelas = $('#filter_lvl_kelas').val();
                d.tahun_ajaran = $('#filter_tahun').val();
                d.semester = $('#filter_semester').val();
            }
        },
        columns: [
            { data: 'tema' },
            { data: 'aspek_nilai' },
            {
                data: 'dimensi_list',
                render: d => {
                    if (!d) return '<span class="text-muted">-</span>';
                    try {
                        const arr = typeof d === 'string' ? JSON.parse(d.replace(/&quot;/g,'"')) : d;
                        if (!arr.length) return '<span class="text-muted">-</span>';
                        return arr.map(x => `<span class="badge badge-warning" style="margin:2px;">${x}</span>`).join(' ');
                    } catch {
                        return `<span class="badge badge-info">${d}</span>`;
                    }
                }
            },
            { data: 'kelas' },
            { data: 'tahun_ajaran' },
            { data: 'semester' },
            {
                data: 'id',
                render: (id, _, row) => `
                    <button class="btn btn-secondary btn-xs" data-toggle="tooltip" title="Lihat Riwayat Apply"
                        onclick="lihatHistory(${id})">
                        <i class="fa fa-history"></i>
                    </button>
                    <button class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit Tema"
                        onclick="editTema(${id})">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Hapus Tema"
                        onclick="hapusTema(${id})">
                        <i class="fa fa-trash"></i>
                    </button>
                `
            }
        ]
    });

    table.on('draw', function() {
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body',
            placement: 'top',
            trigger: 'hover'
        });
    });

    // 🔹 Reload tabel saat filter berubah
    $('#filter_tahun, #filter_semester, #filter_lvl_kelas').on('change', () => table.ajax.reload());

    // 🔹 Form simpan
    $('#form_tema').on('submit', function(e){
        e.preventDefault();
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
        const selectedDimensi = $('#dimensi_list').val();
        const formData = $(this).serializeArray();
        formData.push({ name: 'dimensi_list', value: JSON.stringify(selectedDimensi) });
        $.post("{{ route('kokurikuler.tema.store') }}", formData)
            .done(res => {
                if(res.status){
                    toastr.success(res.message);
                    $('#modal_tema').modal('hide');
                    table.ajax.reload();
                    $('#form_tema')[0].reset();
                    $('#id_edit').val(0);
                    $('#dimensi_list').val(null).trigger('change');
                } else toastr.error(res.message);
            })
            .fail(()=>toastr.error("Terjadi kesalahan"))
            .always(()=>btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan'));
    });
});

// 🔹 Reset modal tambah
$('[data-target="#modal_tema"]').on('click', function(){
    $('#modal_title_tema').text('Tambah Tema');
    $('#form_tema')[0].reset();
    $('#id_edit').val(0);
    $('#dimensi_list').val(null).trigger('change');
});

// 🔹 Apply Tema
function applyTema() {
    const kelas = $('#filter_lvl_kelas').val();
    const tahun = $('#filter_tahun').val();
    const semester = $('#filter_semester').val();

    currentApplyId = {
        kelas:kelas,
        tahun:tahun,
        semester:semester,
    };
    $('#apply_message').html(`
        Apakah Anda yakin ingin <strong>menerapkan semua tema yang ada pada tabel</strong><br>
        untuk <strong> Kelas ${kelas} (${tahun} Semester ${semester})</strong>?
    `);
    $('#modal_apply').modal('show');
}

$('#btn_confirm_apply').on('click', function(){
    if (!currentApplyId) return;
    const btn = $(this);
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
    $.post(`/sekolah_sd/kokurikuler/tema/apply`, { 
        _token: '{{ csrf_token() }}',
        ...currentApplyId
    })
        .done(res => {
            if (res.status) {
                toastr.success(res.message);
                $('#modal_apply').modal('hide');
            } else toastr.error(res.message);
        })
        .fail(()=>toastr.error("Gagal apply tema."))
        .always(()=>btn.prop('disabled', false).html('<i class="fa fa-check"></i> Ya, Apply Sekarang'));
});

// 🔹 Lihat History Apply
function lihatHistory(id){
    $('#history_list').empty();
    $('#no_history').hide();
    $.get(`/sekolah_sd/kokurikuler/tema/${id}`, function(res){
        if(res.status && res.data.history_apply && res.data.history_apply.length){
            res.data.history_apply.forEach(log=>{
                $('#history_list').append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${log.nama_user}</strong><br>
                            <small class="text-muted">${log.datetime}</small>
                        </div>
                        <span class="badge badge-success">✔</span>
                    </li>
                `);
            });
        } else $('#no_history').show();
        $('#modal_history').modal('show');
    });
}

// 🔹 Edit data Tema
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

            // Kosongkan select2 lalu isi ulang dengan data yang tersimpan
            $('#dimensi_list').empty().trigger('change');
            if (d.dimensi_list) {
                let selected = [];
                try { 
                    selected = Array.isArray(d.dimensi_list)
                        ? d.dimensi_list 
                        : JSON.parse(d.dimensi_list.replace(/&quot;/g,'"'));
                } catch {
                    selected = d.dimensi_list.split(',');
                }

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
    }).fail(()=>{
        toastr.error("Gagal memuat data tema");
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
