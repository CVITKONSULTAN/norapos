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
                    {!! Form::select('venue_id', $venues, null, ['class' => 'form-control select2', 'required', 'placeholder' => 'Pilih Venue']) !!}
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
    });
</script>
@endsection
