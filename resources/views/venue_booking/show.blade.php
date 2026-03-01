@extends('layouts.app')
@section('title', 'Detail Booking Venue')

@section('content')
<section class="content-header">
    <h1>Detail Booking
        <small>{{ $booking->booking_ref }}</small>
    </h1>
</section>

<section class="content">
    <div class="row">
        {{-- Left Column --}}
        <div class="col-sm-8">
            {{-- Info Venue & Event --}}
            @component('components.widget', ['class' => 'box-primary', 'title' => 'Informasi Event'])
                <div class="row">
                    <div class="col-sm-6">
                        <table class="table table-condensed">
                            <tr>
                                <td><strong>Ref Booking</strong></td>
                                <td>{{ $booking->booking_ref }}</td>
                            </tr>
                            <tr>
                                <td><strong>Venue</strong></td>
                                <td>{{ $booking->venue->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Acara</strong></td>
                                <td>{{ $booking->event_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Event</strong></td>
                                <td>{{ $booking->event_date ? $booking->event_date->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Waktu</strong></td>
                                <td>{{ $booking->event_start_time ?? '-' }} - {{ $booking->event_end_time ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Estimasi Tamu</strong></td>
                                <td>{{ $booking->estimated_guests }} orang</td>
                            </tr>
                            <tr>
                                <td><strong>Tipe Harga</strong></td>
                                <td>{{ $booking->pricing_type_label }}</td>
                            </tr>
                            @if($booking->pricing_type === 'per_pax')
                            <tr>
                                <td><strong>Harga Per Pax</strong></td>
                                <td>Rp {{ number_format($booking->price_per_pax, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <table class="table table-condensed">
                            <tr>
                                <td><strong>Nama Tamu</strong></td>
                                <td>{{ $booking->guest_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon</strong></td>
                                <td>{{ $booking->guest_phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ $booking->guest_email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Instansi</strong></td>
                                <td>{{ $booking->guest_company ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>PIC</strong></td>
                                <td>{{ $booking->pic_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon PIC</strong></td>
                                <td>{{ $booking->pic_phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>{!! $booking->status_label !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($booking->notes)
                <div class="row">
                    <div class="col-sm-12">
                        <div class="callout callout-info">
                            <h4><i class="fa fa-sticky-note"></i> Catatan / Negosiasi:</h4>
                            <p>{{ $booking->notes }}</p>
                        </div>
                    </div>
                </div>
                @endif
            @endcomponent

            {{-- Item Pesanan --}}
            @component('components.widget', ['class' => 'box-success', 'title' => 'Item Pesanan / Menu'])
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item / Menu</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->items as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ rtrim(rtrim(number_format($item->quantity, 4), '0'), '.') }}</td>
                            <td>{{ $item->unit ?? '-' }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td>{{ $item->note ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada item pesanan</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total</strong></td>
                            <td><strong>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            @endcomponent

            {{-- Riwayat Pembayaran --}}
            @component('components.widget', ['class' => 'box-warning', 'title' => 'Riwayat Pembayaran'])
                @can('venue_booking.payment')
                @slot('tool')
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_payment_modal">
                            <i class="fa fa-plus"></i> Tambah Pembayaran
                        </button>
                    </div>
                @endslot
                @endcan

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Referensi</th>
                            <th>Catatan</th>
                            <th>Oleh</th>
                            @can('venue_booking.payment')
                            <th>Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->payments as $i => $payment)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $payment->paid_at ? $payment->paid_at->format('d/m/Y') : '-' }}</td>
                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>{{ $payment->method_label }}</td>
                            <td>{{ $payment->payment_ref ?? '-' }}</td>
                            <td>{{ $payment->note ?? '-' }}</td>
                            <td>{{ $payment->createdBy->first_name ?? '-' }}</td>
                            @can('venue_booking.payment')
                            <td>
                                <button class="btn btn-danger btn-xs delete-payment"
                                    data-href="{{ action('VenueBookingController@deletePayment', [$booking->id, $payment->id]) }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                            @endcan
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->can('venue_booking.payment') ? 8 : 7 }}" class="text-center text-muted">Belum ada pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            @endcomponent
        </div>

        {{-- Right Column: Summary --}}
        <div class="col-sm-4">
            @component('components.widget', ['class' => 'box-default', 'title' => 'Ringkasan Keuangan'])
                <table class="table">
                    <tr>
                        <td><strong>Total Booking</strong></td>
                        <td class="text-right"><h4>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</h4></td>
                    </tr>
                    <tr class="text-success">
                        <td><strong>Total Dibayar (DP)</strong></td>
                        <td class="text-right"><h4>Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</h4></td>
                    </tr>
                    <tr class="text-danger">
                        <td><strong>Sisa</strong></td>
                        <td class="text-right"><h4>Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</h4></td>
                    </tr>
                </table>
            @endcomponent

            @component('components.widget', ['class' => 'box-default', 'title' => 'Update Status'])
                <div class="form-group">
                    {!! Form::select('update_status', [
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ], $booking->status, ['class' => 'form-control', 'id' => 'update_status']) !!}
                </div>
                <button type="button" class="btn btn-primary btn-block" id="btn_update_status">
                    <i class="fa fa-refresh"></i> Update Status
                </button>
            @endcomponent

            <div class="row">
                <div class="col-sm-12">
                    @can('venue_booking.update')
                    <a href="{{ action('VenueBookingController@edit', [$booking->id]) }}" class="btn btn-warning btn-block" style="margin-bottom: 5px;">
                        <i class="fa fa-edit"></i> Edit Booking
                    </a>
                    @endcan
                    <a href="{{ action('VenueBookingController@index') }}" class="btn btn-default btn-block">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modal Tambah Pembayaran --}}
<div class="modal fade" id="add_payment_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['url' => action('VenueBookingController@addPayment', [$booking->id]), 'method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Tambah Pembayaran</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('amount', 'Jumlah (Rp) *') !!}
                    {!! Form::number('amount', null, ['class' => 'form-control', 'required', 'step' => '0.01', 'min' => '0', 'placeholder' => 'Jumlah pembayaran']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('method', 'Metode Bayar') !!}
                    {!! Form::select('method', [
                        'cash' => 'Cash',
                        'transfer' => 'Transfer',
                        'card' => 'Kartu',
                        'other' => 'Lainnya',
                    ], 'cash', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('payment_ref', 'No Referensi') !!}
                    {!! Form::text('payment_ref', null, ['class' => 'form-control', 'placeholder' => 'No bukti transfer / referensi']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('paid_at', 'Tanggal Bayar') !!}
                    {!! Form::date('paid_at', date('Y-m-d'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('note', 'Catatan') !!}
                    {!! Form::text('note', null, ['class' => 'form-control', 'placeholder' => 'Catatan pembayaran']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan Pembayaran
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        // Update Status
        $('#btn_update_status').on('click', function() {
            var status = $('#update_status').val();
            $.ajax({
                method: "POST",
                url: '{{ action("VenueBookingController@updateStatus", [$booking->id]) }}',
                data: { status: status },
                dataType: "json",
                success: function(result) {
                    if (result.success) {
                        toastr.success(result.msg);
                        location.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                }
            });
        });

        // Delete Payment
        $(document).on('click', '.delete-payment', function(e) {
            e.preventDefault();
            swal({
                title: LANG.sure,
                text: 'Pembayaran akan dihapus!',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var href = $(this).data('href');
                    $.ajax({
                        method: "DELETE",
                        url: href,
                        dataType: "json",
                        success: function(result) {
                            if (result.success) {
                                toastr.success(result.msg);
                                location.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
