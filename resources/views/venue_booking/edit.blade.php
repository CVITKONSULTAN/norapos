@extends('layouts.app')
@section('title', 'Edit Booking Venue')

@section('content')
<section class="content-header">
    <h1>Edit Booking Venue <small>{{ $booking->booking_ref }}</small></h1>
</section>

<section class="content">
    {!! Form::open(['url' => action('VenueBookingController@update', [$booking->id]), 'method' => 'put', 'id' => 'venue_booking_form']) !!}

    {{-- Info Venue & Event --}}
    @component('components.widget', ['class' => 'box-primary', 'title' => 'Informasi Venue & Event'])
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('venue_id', 'Venue *') !!}
                    {!! Form::select('venue_id', $venues, $booking->venue_id, ['class' => 'form-control select2', 'required', 'placeholder' => 'Pilih Venue']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('event_name', 'Nama Acara') !!}
                    {!! Form::text('event_name', $booking->event_name, ['class' => 'form-control', 'placeholder' => 'Contoh: Wedding Reception']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('event_date', 'Tanggal Event *') !!}
                    {!! Form::date('event_date', $booking->event_date ? $booking->event_date->format('Y-m-d') : null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('event_start_time', 'Jam Mulai') !!}
                    {!! Form::time('event_start_time', $booking->event_start_time, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('event_end_time', 'Jam Selesai') !!}
                    {!! Form::time('event_end_time', $booking->event_end_time, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('estimated_guests', 'Perkiraan Tamu') !!}
                    {!! Form::number('estimated_guests', $booking->estimated_guests, ['class' => 'form-control', 'id' => 'estimated_guests_input', 'min' => '0']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('pricing_type', 'Tipe Harga') !!}
                    {!! Form::select('pricing_type', [
                        'custom' => 'Custom',
                        'per_pax' => 'Per Pax',
                        'paket' => 'Paket',
                    ], $booking->pricing_type, ['class' => 'form-control', 'id' => 'pricing_type']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4" id="price_per_pax_row" style="{{ $booking->pricing_type === 'per_pax' ? '' : 'display: none;' }}">
                <div class="form-group">
                    {!! Form::label('price_per_pax', 'Harga Per Pax (Rp)') !!}
                    {!! Form::number('price_per_pax', $booking->price_per_pax, ['class' => 'form-control', 'id' => 'price_per_pax_input', 'step' => '0.01', 'min' => '0']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('total_amount', 'Total (Rp)') !!}
                    {!! Form::number('total_amount', $booking->total_amount, ['class' => 'form-control', 'id' => 'total_amount_input', 'step' => '0.01', 'min' => '0', 'placeholder' => '0']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('status', 'Status') !!}
                    {!! Form::select('status', [
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ], $booking->status, ['class' => 'form-control']) !!}
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
                    {!! Form::select('contact_id', $contacts, $booking->contact_id, ['class' => 'form-control select2', 'id' => 'contact_id']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('guest_name', 'Nama Tamu *') !!}
                    {!! Form::text('guest_name', $booking->guest_name, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('guest_phone', 'No. Telepon') !!}
                    {!! Form::text('guest_phone', $booking->guest_phone, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('guest_email', 'Email') !!}
                    {!! Form::email('guest_email', $booking->guest_email, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('guest_company', 'Instansi / Perusahaan') !!}
                    {!! Form::text('guest_company', $booking->guest_company, ['class' => 'form-control']) !!}
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
                    {!! Form::text('pic_name', $booking->pic_name, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('pic_phone', 'No. Telepon PIC') !!}
                    {!! Form::text('pic_phone', $booking->pic_phone, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    @endcomponent

    {{-- Item Pesanan --}}
    @component('components.widget', ['class' => 'box-success', 'title' => 'Item Pesanan / Menu'])
        <p class="text-muted"><small><i class="fa fa-info-circle"></i> Isi nama menu / item yang akan disajikan. Rincian bahan baku akan diisi oleh tim purchasing setelah booking tersimpan.</small></p>
        <table class="table table-bordered" id="items_table">
            <thead>
                <tr>
                    <th>Nama Menu / Item</th>
                    <th style="width: 50px;"></th>
                </tr>
            </thead>
            <tbody id="items_body">
                @forelse($booking->items as $i => $item)
                <tr class="item-row">
                    <td><input type="text" name="items[{{ $i }}][item_name]" class="form-control" value="{{ $item->item_name }}"></td>
                    <td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td>
                </tr>
                @empty
                <tr class="item-row">
                    <td><input type="text" name="items[0][item_name]" class="form-control" placeholder="Contoh: Nasi Goreng, Sate Ayam, Jus Alpukat"></td>
                    <td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" id="add_item_row">
                            <i class="fa fa-plus"></i> Tambah Item
                        </button>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    @endcomponent

    {{-- Catatan --}}
    @component('components.widget', ['class' => 'box-default', 'title' => 'Catatan'])
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('notes', 'Catatan / Hasil Negosiasi') !!}
                    {!! Form::textarea('notes', $booking->notes, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
            </div>
        </div>
    @endcomponent

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary pull-right btn-lg">
                <i class="fa fa-save"></i> Update Booking
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
        var itemIndex = {{ $booking->items->count() ?: 1 }};

        $('#pricing_type').on('change', function() {
            if ($(this).val() === 'per_pax') {
                $('#price_per_pax_row').show();
            } else {
                $('#price_per_pax_row').hide();
            }
            calculatePerPaxTotal();
        });

        $(document).on('input', '#price_per_pax_input, #estimated_guests_input', function() {
            calculatePerPaxTotal();
        });

        function calculatePerPaxTotal() {
            if ($('#pricing_type').val() !== 'per_pax') {
                return;
            }

            var pax = parseFloat($('#estimated_guests_input').val()) || 0;
            var price = parseFloat($('#price_per_pax_input').val()) || 0;
            $('#total_amount_input').val(pax * price);
        }

        $('#add_item_row').on('click', function() {
            var row = `<tr class="item-row">
                <td><input type="text" name="items[${itemIndex}][item_name]" class="form-control" placeholder="Contoh: Nasi Goreng, Sate Ayam, Jus Alpukat"></td>
                <td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td>
            </tr>`;
            $('#items_body').append(row);
            itemIndex++;
        });

        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
        });

        calculatePerPaxTotal();
    });
</script>
@endsection
