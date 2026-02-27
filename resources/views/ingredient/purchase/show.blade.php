@extends('layouts.app')
@section('title', 'Detail Pembelian Bahan')

@section('content')
<section class="content-header">
    <h1>Detail Pembelian Bahan
        <small>#{{ $purchase->ref_no ?? $purchase->id }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ action('IngredientPurchaseController@index') }}">Pembelian Bahan</a></li>
        <li class="active">Detail</li>
    </ol>
</section>

<section class="content">
    {{-- Info Header --}}
    @component('components.widget', ['class' => 'box-primary', 'title' => 'Info Pembelian'])
        <div class="row">
            <div class="col-sm-3">
                <strong>Tanggal:</strong><br>
                {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}
            </div>
            <div class="col-sm-3">
                <strong>No Referensi:</strong><br>
                {{ $purchase->ref_no ?? '-' }}
            </div>
            <div class="col-sm-3">
                <strong>Supplier:</strong><br>
                {{ $purchase->supplier->name ?? '-' }}
                @if($purchase->supplier && $purchase->supplier->supplier_business_name)
                    <br><small class="text-muted">{{ $purchase->supplier->supplier_business_name }}</small>
                @endif
            </div>
            <div class="col-sm-3">
                <strong>Lokasi:</strong><br>
                {{ $purchase->location->name ?? '-' }}
            </div>
        </div>
        @if($purchase->notes)
        <div class="row" style="margin-top: 10px;">
            <div class="col-sm-12">
                <strong>Catatan:</strong><br>
                {{ $purchase->notes }}
            </div>
        </div>
        @endif
        <div class="row" style="margin-top: 10px;">
            <div class="col-sm-12">
                <small class="text-muted">Dibuat oleh: {{ $purchase->createdBy->first_name ?? '-' }} pada {{ $purchase->created_at->format('d/m/Y H:i') }}</small>
            </div>
        </div>
    @endcomponent

    {{-- Detail Bahan --}}
    @component('components.widget', ['class' => 'box-success', 'title' => 'Daftar Bahan'])
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bahan Baku</th>
                    <th>Nama di Nota</th>
                    <th class="text-right">Qty</th>
                    <th>Satuan</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $grand_total = 0; @endphp
                @foreach($purchase->lines as $i => $line)
                @php $grand_total += $line->total_price; @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $line->ingredient->name ?? '-' }}</td>
                    <td>
                        @if($line->nota_name && $line->nota_name !== ($line->ingredient->name ?? ''))
                            <small class="text-muted"><i class="fa fa-file-text-o"></i> {{ $line->nota_name }}</small>
                        @else
                            <small class="text-muted">-</small>
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($line->quantity, 2) }}</td>
                    <td>{{ $line->ingredient->unit->short_name ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($line->unit_price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($line->total_price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right"><strong>Total:</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($grand_total, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    @endcomponent

    {{-- Info Pembayaran --}}
    @php
        $totalAmount = $purchase->total_amount > 0 ? $purchase->total_amount : $grand_total;
        $paidAmount = $purchase->paid_amount ?? 0;
        $remaining = $totalAmount - $paidAmount;
        $paymentStatus = $purchase->payment_status ?? 'unpaid';
    @endphp
    @component('components.widget', ['class' => 'box-warning', 'title' => 'Info Pembayaran'])
        <div class="row">
            <div class="col-sm-3">
                <strong>Status:</strong><br>
                @if($paymentStatus === 'paid')
                    <span class="label label-success" style="font-size: 14px;">Lunas</span>
                @elseif($paymentStatus === 'partial')
                    <span class="label label-warning" style="font-size: 14px;">Sebagian</span>
                @else
                    <span class="label label-danger" style="font-size: 14px;">Belum Bayar</span>
                @endif
            </div>
            <div class="col-sm-3">
                <strong>Total Belanja:</strong><br>
                <span style="font-size: 16px;">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
            </div>
            <div class="col-sm-3">
                <strong>Sudah Dibayar:</strong><br>
                <span style="font-size: 16px; color: #27ae60;">Rp {{ number_format($paidAmount, 0, ',', '.') }}</span>
            </div>
            <div class="col-sm-3">
                <strong>Sisa Hutang:</strong><br>
                <span style="font-size: 16px; color: {{ $remaining > 0 ? '#e74c3c' : '#27ae60' }};">Rp {{ number_format($remaining, 0, ',', '.') }}</span>
            </div>
        </div>
        @if($paymentStatus !== 'paid')
        <div class="row" style="margin-top: 15px;">
            <div class="col-sm-12">
                <button type="button" class="btn btn-success" id="btn_show_pay" data-id="{{ $purchase->id }}" data-total="{{ $totalAmount }}" data-paid="{{ $paidAmount }}">
                    <i class="fa fa-money"></i> Catat Pembayaran
                </button>
            </div>
        </div>
        @endif
    @endcomponent

    <a href="{{ action('IngredientPurchaseController@index') }}" class="btn btn-default">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>
</section>

{{-- Modal Bayar --}}
<div class="modal fade" id="modal_pay_show" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-money"></i> Catat Pembayaran</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal_pay_id">
                <table class="table table-condensed no-border">
                    <tr>
                        <td>Total Belanja:</td>
                        <td class="text-right"><strong id="modal_total_label">-</strong></td>
                    </tr>
                    <tr>
                        <td>Sudah Dibayar:</td>
                        <td class="text-right"><strong id="modal_paid_label">-</strong></td>
                    </tr>
                    <tr class="bg-warning">
                        <td><strong>Sisa:</strong></td>
                        <td class="text-right"><strong id="modal_remaining_label">-</strong></td>
                    </tr>
                </table>
                <div class="form-group" style="margin-top: 15px;">
                    <label>Jumlah Bayar *</label>
                    <div class="input-group">
                        <span class="input-group-addon">Rp</span>
                        <input type="number" id="modal_pay_amount" class="form-control" step="1" min="1" placeholder="0">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="btn_do_pay">
                    <i class="fa fa-check"></i> Bayar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    $('#btn_show_pay').click(function() {
        var total = parseFloat($(this).data('total')) || 0;
        var paid = parseFloat($(this).data('paid')) || 0;
        var remaining = total - paid;

        $('#modal_pay_id').val($(this).data('id'));
        $('#modal_total_label').text('Rp ' + total.toLocaleString('id-ID'));
        $('#modal_paid_label').text('Rp ' + paid.toLocaleString('id-ID'));
        $('#modal_remaining_label').text('Rp ' + remaining.toLocaleString('id-ID'));
        $('#modal_pay_amount').val(remaining > 0 ? remaining : 0).attr('max', remaining);
        $('#modal_pay_show').modal('show');
    });

    $('#btn_do_pay').click(function() {
        var id = $('#modal_pay_id').val();
        var amount = parseFloat($('#modal_pay_amount').val()) || 0;

        if (amount <= 0) {
            toastr.error('Jumlah bayar harus lebih dari 0');
            return;
        }

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');

        $.ajax({
            method: 'POST',
            url: '/ingredient-purchases/' + id + '/pay',
            data: { amount: amount },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    toastr.success(result.msg);
                    // Reload halaman untuk update info
                    location.reload();
                } else {
                    toastr.error(result.msg);
                }
            },
            error: function() {
                toastr.error('Gagal mencatat pembayaran');
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fa fa-check"></i> Bayar');
            }
        });
    });
});
</script>
@endsection
