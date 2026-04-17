@extends('layouts.app')
@section('title', 'Tambah Booking Venue')

@section('content')
<section class="content-header">
    <h1>Tambah Booking Venue</h1>
</section>

<section class="content">
    {!! Form::open(['url' => action('VenueBookingController@store'), 'method' => 'post', 'id' => 'venue_booking_form']) !!}

    {{-- Info Venue & Event --}}
    @component('components.widget', ['class' => 'box-primary', 'title' => 'Informasi Venue & Event'])
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('venue_id', 'Venue *') !!}
                    <div class="input-group">
                        {!! Form::select('venue_id', $venues, null, ['class' => 'form-control select2', 'required', 'id' => 'venue_id', 'placeholder' => 'Pilih Venue']) !!}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" id="btn_manage_venues" title="Kelola Venue">
                                <i class="fa fa-cog"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('event_name', 'Nama Acara') !!}
                    {!! Form::text('event_name', null, ['class' => 'form-control', 'placeholder' => 'Contoh: Wedding Reception']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('event_date', 'Tanggal Event *') !!}
                    {!! Form::date('event_date', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('event_start_time', 'Jam Mulai') !!}
                    {!! Form::time('event_start_time', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('event_end_time', 'Jam Selesai') !!}
                    {!! Form::time('event_end_time', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('estimated_guests', 'Perkiraan Tamu') !!}
                    {!! Form::number('estimated_guests', 0, ['class' => 'form-control', 'min' => '0']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('pricing_type', 'Tipe Harga') !!}
                    {!! Form::select('pricing_type', [
                        'custom' => 'Custom',
                        'per_pax' => 'Per Pax',
                        'paket' => 'Paket',
                    ], 'custom', ['class' => 'form-control', 'id' => 'pricing_type']) !!}
                </div>
            </div>
        </div>
        <div class="row" id="price_per_pax_row" style="display: none;">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('price_per_pax', 'Harga Per Pax (Rp)') !!}
                    {!! Form::number('price_per_pax', 0, ['class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
                </div>
            </div>
        </div>
    @endcomponent

    {{-- Info Tamu / Customer --}}
    @component('components.widget', ['class' => 'box-info', 'title' => 'Data Tamu / Customer'])
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('contact_id', 'Customer Existing') !!}
                    {!! Form::select('contact_id', $contacts, null, ['class' => 'form-control select2', 'id' => 'contact_id']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('guest_name', 'Nama Tamu *') !!}
                    {!! Form::text('guest_name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Nama lengkap tamu']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('guest_phone', 'No. Telepon') !!}
                    {!! Form::text('guest_phone', null, ['class' => 'form-control', 'placeholder' => '08xxxxxxxxxx']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('guest_email', 'Email') !!}
                    {!! Form::email('guest_email', null, ['class' => 'form-control', 'placeholder' => 'email@example.com']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('guest_company', 'Instansi / Perusahaan') !!}
                    {!! Form::text('guest_company', null, ['class' => 'form-control', 'placeholder' => 'Nama instansi (opsional)']) !!}
                </div>
            </div>
        </div>
    @endcomponent

    {{-- PIC / Penanggung Jawab --}}
    @component('components.widget', ['class' => 'box-warning', 'title' => 'Penanggung Jawab / PIC'])
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('pic_name', 'Nama PIC') !!}
                    {!! Form::text('pic_name', null, ['class' => 'form-control', 'placeholder' => 'Nama penanggung jawab event']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('pic_phone', 'No. Telepon PIC') !!}
                    {!! Form::text('pic_phone', null, ['class' => 'form-control', 'placeholder' => '08xxxxxxxxxx']) !!}
                </div>
            </div>
        </div>
    @endcomponent

    {{-- Item Pesanan --}}
    @component('components.widget', ['class' => 'box-success', 'title' => 'Item Pesanan / Menu'])
        <table class="table table-bordered" id="items_table">
            <thead>
                <tr>
                    <th style="width: 30%;">Nama Item / Menu</th>
                    <th style="width: 10%;">Qty</th>
                    <th style="width: 12%;">Satuan</th>
                    <th style="width: 15%;">Harga (Rp)</th>
                    <th style="width: 15%;">Subtotal</th>
                    <th style="width: 13%;">Catatan</th>
                    <th style="width: 5%;"></th>
                </tr>
            </thead>
            <tbody id="items_body">
                <tr class="item-row">
                    <td><input type="text" name="items[0][item_name]" class="form-control" placeholder="Nama menu / item"></td>
                    <td><input type="number" name="items[0][quantity]" class="form-control item-qty" value="1" min="0" step="0.01"></td>
                    <td><input type="text" name="items[0][unit]" class="form-control" placeholder="pax, porsi"></td>
                    <td><input type="number" name="items[0][price]" class="form-control item-price" value="0" min="0" step="0.01"></td>
                    <td><span class="item-subtotal">0</span></td>
                    <td><input type="text" name="items[0][note]" class="form-control" placeholder="Catatan"></td>
                    <td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"><strong>Total:</strong></td>
                    <td><strong id="grand_total">0</strong></td>
                    <td colspan="2">
                        <button type="button" class="btn btn-success btn-sm" id="add_item_row">
                            <i class="fa fa-plus"></i> Tambah Item
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>
    @endcomponent

    {{-- DP / Pembayaran Awal --}}
    @component('components.widget', ['class' => 'box-default', 'title' => 'Down Payment (DP) Awal'])
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('dp_amount', 'Jumlah DP (Rp)') !!}
                    {!! Form::number('dp_amount', 0, ['class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('dp_method', 'Metode Bayar') !!}
                    {!! Form::select('dp_method', [
                        'cash' => 'Cash',
                        'transfer' => 'Transfer',
                        'card' => 'Kartu',
                        'other' => 'Lainnya',
                    ], 'cash', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('dp_payment_ref', 'No Referensi') !!}
                    {!! Form::text('dp_payment_ref', null, ['class' => 'form-control', 'placeholder' => 'No bukti transfer dll']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('dp_paid_at', 'Tanggal Bayar') !!}
                    {!! Form::date('dp_paid_at', date('Y-m-d'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    @endcomponent

    {{-- Catatan --}}
    @component('components.widget', ['class' => 'box-default', 'title' => 'Catatan'])
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('notes', 'Catatan / Hasil Negosiasi') !!}
                    {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Catatan tambahan, request khusus, hasil negosiasi harga, dll']) !!}
                </div>
            </div>
        </div>
    @endcomponent

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary pull-right btn-lg">
                <i class="fa fa-save"></i> Simpan Booking
            </button>
            <a href="{{ action('VenueBookingController@index') }}" class="btn btn-default pull-right btn-lg" style="margin-right: 10px;">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {!! Form::close() !!}
</section>

{{-- ============================================================ --}}
{{-- MODAL: Kelola Venue                                          --}}
{{-- ============================================================ --}}
<div class="modal fade" id="modal_venue_manager" tabindex="-1" role="dialog" aria-labelledby="modal_venue_manager_label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title" id="modal_venue_manager_label"><i class="fa fa-map-marker"></i> Kelola Venue</h4>
            </div>
            <div class="modal-body">

                {{-- Form Tambah / Edit --}}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" id="venue_form_title">Tambah Venue Baru</h3>
                    </div>
                    <div class="box-body">
                        <input type="hidden" id="venue_edit_id" value="">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Nama Venue <span class="text-danger">*</span></label>
                                    <input type="text" id="venue_name" class="form-control" placeholder="Contoh: Ballroom, Ponton, Kapal">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <input type="text" id="venue_description" class="form-control" placeholder="Keterangan singkat (opsional)">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Kapasitas (Orang)</label>
                                    <input type="number" id="venue_capacity" class="form-control" placeholder="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Harga Dasar (Rp)</label>
                                    <input type="number" id="venue_base_price" class="form-control" placeholder="0" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>&nbsp;</label><br>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="venue_is_active" checked> Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 text-right" style="padding-top:25px;">
                                <button type="button" class="btn btn-default btn-sm" id="btn_venue_cancel_edit" style="display:none;">
                                    <i class="fa fa-times"></i> Batal Edit
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" id="btn_venue_save">
                                    <i class="fa fa-save"></i> <span id="venue_save_label">Simpan Venue</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Daftar Venue --}}
                <table class="table table-bordered table-striped table-hover" id="venue_list_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Kapasitas</th>
                            <th>Harga Dasar</th>
                            <th>Status</th>
                            <th style="width:100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="venue_list_body">
                        <tr><td colspan="7" class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat...</td></tr>
                    </tbody>
                </table>

            </div>{{-- /modal-body --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
{{-- /MODAL Kelola Venue --}}

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        var itemIndex = 1;

        // Show/hide price_per_pax based on pricing_type
        $('#pricing_type').on('change', function() {
            if ($(this).val() === 'per_pax') {
                $('#price_per_pax_row').show();
            } else {
                $('#price_per_pax_row').hide();
            }
        });

        // Add item row
        $('#add_item_row').on('click', function() {
            var row = `<tr class="item-row">
                <td><input type="text" name="items[${itemIndex}][item_name]" class="form-control" placeholder="Nama menu / item"></td>
                <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control item-qty" value="1" min="0" step="0.01"></td>
                <td><input type="text" name="items[${itemIndex}][unit]" class="form-control" placeholder="pax, porsi"></td>
                <td><input type="number" name="items[${itemIndex}][price]" class="form-control item-price" value="0" min="0" step="0.01"></td>
                <td><span class="item-subtotal">0</span></td>
                <td><input type="text" name="items[${itemIndex}][note]" class="form-control" placeholder="Catatan"></td>
                <td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td>
            </tr>`;
            $('#items_body').append(row);
            itemIndex++;
        });

        // Remove item row
        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            calculateGrandTotal();
        });

        // Calculate subtotal on qty/price change
        $(document).on('input', '.item-qty, .item-price', function() {
            var row = $(this).closest('tr');
            var qty = parseFloat(row.find('.item-qty').val()) || 0;
            var price = parseFloat(row.find('.item-price').val()) || 0;
            var subtotal = qty * price;
            row.find('.item-subtotal').text(formatNumber(subtotal));
            calculateGrandTotal();
        });

        function calculateGrandTotal() {
            var total = 0;
            $('.item-row').each(function() {
                var qty = parseFloat($(this).find('.item-qty').val()) || 0;
                var price = parseFloat($(this).find('.item-price').val()) || 0;
                total += qty * price;
            });
            $('#grand_total').text(formatNumber(total));
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        // ====================================================
        // CRUD Venue Modal
        // ====================================================
        var venueApiUrl  = '{{ action("VenueController@index") }}';
        var venueStoreUrl = '{{ action("VenueController@store") }}';

        // Buka modal
        $('#btn_manage_venues').on('click', function() {
            resetVenueForm();
            loadVenueList();
            $('#modal_venue_manager').modal('show');
        });

        function loadVenueList() {
            $.get(venueApiUrl, function(data) {
                var html = '';
                if (data.length === 0) {
                    html = '<tr><td colspan="7" class="text-center text-muted">Belum ada venue.</td></tr>';
                } else {
                    $.each(data, function(i, v) {
                        html += '<tr>' +
                            '<td>' + (i+1) + '</td>' +
                            '<td>' + v.name + '</td>' +
                            '<td>' + (v.description || '-') + '</td>' +
                            '<td>' + (v.capacity || '-') + '</td>' +
                            '<td>Rp ' + new Intl.NumberFormat('id-ID').format(v.base_price) + '</td>' +
                            '<td>' + (v.is_active ? '<span class="label label-success">Aktif</span>' : '<span class="label label-default">Nonaktif</span>') + '</td>' +
                            '<td>' +
                                '<button type="button" class="btn btn-xs btn-warning btn-edit-venue" data-id="' + v.id + '" title="Edit"><i class="fa fa-edit"></i></button> ' +
                                '<button type="button" class="btn btn-xs btn-danger btn-delete-venue" data-id="' + v.id + '" data-name="' + v.name + '" title="Hapus"><i class="fa fa-trash"></i></button>' +
                            '</td>' +
                        '</tr>';
                    });
                }
                $('#venue_list_body').html(html);
            });
        }

        function resetVenueForm() {
            $('#venue_edit_id').val('');
            $('#venue_name').val('');
            $('#venue_description').val('');
            $('#venue_capacity').val('');
            $('#venue_base_price').val('');
            $('#venue_is_active').prop('checked', true);
            $('#venue_form_title').text('Tambah Venue Baru');
            $('#venue_save_label').text('Simpan Venue');
            $('#btn_venue_cancel_edit').hide();
        }

        // Simpan (store / update)
        $('#btn_venue_save').on('click', function() {
            var id = $('#venue_edit_id').val();
            var url  = id ? '{{ url("venues") }}/' + id : venueStoreUrl;
            var method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: {
                    _token: '{{ csrf_token() }}',
                    name: $('#venue_name').val(),
                    description: $('#venue_description').val(),
                    capacity: $('#venue_capacity').val(),
                    base_price: $('#venue_base_price').val(),
                    is_active: $('#venue_is_active').is(':checked') ? 1 : 0,
                },
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.msg);
                        resetVenueForm();
                        loadVenueList();
                        refreshVenueDropdown();
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON && xhr.responseJSON.errors;
                    if (errors) {
                        var msg = Object.values(errors).map(function(e){ return e[0]; }).join('<br>');
                        toastr.error(msg);
                    } else {
                        toastr.error('Terjadi kesalahan.');
                    }
                }
            });
        });

        // Tombol edit
        $(document).on('click', '.btn-edit-venue', function() {
            var id = $(this).data('id');
            $.get('{{ url("venues") }}/' + id, function(v) {
                $('#venue_edit_id').val(v.id);
                $('#venue_name').val(v.name);
                $('#venue_description').val(v.description || '');
                $('#venue_capacity').val(v.capacity || '');
                $('#venue_base_price').val(v.base_price || 0);
                $('#venue_is_active').prop('checked', v.is_active == 1);
                $('#venue_form_title').text('Edit Venue: ' + v.name);
                $('#venue_save_label').text('Update Venue');
                $('#btn_venue_cancel_edit').show();
                $('html, body').animate({ scrollTop: $('#modal_venue_manager .modal-body').offset().top }, 300);
            });
        });

        // Batal edit
        $('#btn_venue_cancel_edit').on('click', function() {
            resetVenueForm();
        });

        // Tombol hapus
        $(document).on('click', '.btn-delete-venue', function() {
            var id   = $(this).data('id');
            var name = $(this).data('name');
            if (!confirm('Hapus venue "' + name + '"? Tindakan ini tidak dapat dibatalkan.')) return;
            $.ajax({
                url: '{{ url("venues") }}/' + id,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.msg);
                        loadVenueList();
                        refreshVenueDropdown();
                    }
                },
                error: function() { toastr.error('Gagal menghapus venue.'); }
            });
        });

        // Refresh dropdown #venue_id setelah perubahan
        function refreshVenueDropdown() {
            $.get(venueApiUrl, function(data) {
                var selected = $('#venue_id').val();
                $('#venue_id').empty().append('<option value="">Pilih Venue</option>');
                $.each(data, function(i, v) {
                    if (v.is_active) {
                        $('#venue_id').append('<option value="' + v.id + '"' + (v.id == selected ? ' selected' : '') + '>' + v.name + '</option>');
                    }
                });
                $('#venue_id').trigger('change');
            });
        }

    });
</script>
@endsection
