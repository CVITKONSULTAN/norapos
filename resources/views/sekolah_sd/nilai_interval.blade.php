@extends('layouts.app')
@section('title', 'Interval Nilai')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1>Manajemen Interval Nilai</h1>
</section>

<section class="content">
    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">Daftar Interval Nilai</h3>
        </div>

        <div class="box-body">

            <table id="interval_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nilai Minimum</th>
                        <th>Nilai Maksimum</th>
                        <th>Formatter String</th>
                        <th>Tipe</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</section>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <form id="formEdit">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Edit Interval Nilai</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="form-group">
                        <label>Nilai Minimum</label>
                        <input type="number" name="nilai_minimum" id="edit_min" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Nilai Maksimum</label>
                        <input type="number" name="nilai_maksimum" id="edit_max" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Formatter String</label>
                        <input type="text" name="formatter_string" id="edit_formatter" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Tipe</label>
                        <input type="text" name="tipe" id="edit_tipe" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button id="sbmt_btn" type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection

@section('javascript')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {

    const table = $('#interval_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('sekolah_sd.interval.data') }}",
        columns: [
            { data: 'id' },
            { data: 'nilai_minimum' },
            { data: 'nilai_maksimum' },
            { data: 'formatter_string' },
            { data: 'tipe' },
            { 
                data: 'id',
                render: function(id) {
                    return `
                        <button class="btn btn-warning btn-sm btn-edit" data-id="${id}">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                    `;
                }
            }
        ]
    });

    // tombol edit ditekan
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');

        $.ajax({
            url: "{{ route('sekolah_sd.interval.data') }}?id="+id,
            success: function(res) {

                let row = res.data.find(x => x.id == id);
                if (!row) return alert("Data tidak ditemukan");

                $('#edit_id').val(row.id);
                $('#edit_min').val(row.nilai_minimum);
                $('#edit_max').val(row.nilai_maksimum);
                $('#edit_formatter').val(row.formatter_string);
                $('#edit_tipe').val(row.tipe);

                $("#sbmt_btn").removeAttr('disabled');

                $('#modalEdit').modal('show');
            }
        });
    });

    // submit form edit
    $('#formEdit').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ url('sekolah_sd/interval/store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (!res.status) return alert('Gagal menyimpan');


                $('#modalEdit').modal('hide');
                table.ajax.reload();
            },
            error: function(err) {
                alert("Validasi gagal!");
            }
        });
    });
});
</script>
@endsection
