@extends('layouts.app')
@section('title', 'Pembelian Bahan Baku')

@section('content')
<section class="content-header">
    <h1>Pembelian Bahan Baku
        <small>Riwayat penerimaan bahan dari supplier</small>
    </h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        @slot('tool')
            <div class="box-tools">
                <a class="btn btn-block btn-primary" href="{{ action('IngredientPurchaseController@create') }}">
                    <i class="fa fa-plus"></i> Tambah Pembelian
                </a>
            </div>
        @endslot

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="purchase_table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No Ref</th>
                        <th>Supplier</th>
                        <th>Lokasi</th>
                        <th>Jumlah Item</th>
                        <th>Total Biaya</th>
                        <th>Status Bayar</th>
                        <th>Dibuat Oleh</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent
</section>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var purchase_table = $('#purchase_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ action("IngredientPurchaseController@index") }}',
        columns: [
            { data: 'purchase_date', name: 'purchase_date' },
            { data: 'ref_no', name: 'ref_no' },
            { data: 'supplier_name', name: 'supplier_name', orderable: false, searchable: false },
            { data: 'location_name', name: 'location_name', orderable: false, searchable: false },
            { data: 'total_items', name: 'total_items', orderable: false, searchable: false },
            { data: 'total_cost', name: 'total_cost', orderable: false, searchable: false },
            { data: 'payment_status_label', name: 'payment_status_label', orderable: false, searchable: false },
            { data: 'created_by_name', name: 'created_by_name', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        order: [[0, 'desc']],
    });

    // Hapus pembelian
    $(document).on('click', '.delete-purchase', function(e) {
        e.preventDefault();
        swal({
            title: LANG.sure,
            text: 'Stok bahan akan dikembalikan (dikurangi)',
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
                            purchase_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            }
        });
    });

    // Modal bayar
    $(document).on('click', '.btn-pay-purchase', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var total = parseFloat($(this).data('total')) || 0;
        var paid = parseFloat($(this).data('paid')) || 0;
        var remaining = total - paid;
        var ref = $(this).data('ref');

        $('#pay_purchase_id').val(id);
        $('#pay_ref_label').text('#' + ref);
        $('#pay_total_label').text('Rp ' + total.toLocaleString('id-ID'));
        $('#pay_paid_label').text('Rp ' + paid.toLocaleString('id-ID'));
        $('#pay_remaining_label').text('Rp ' + remaining.toLocaleString('id-ID'));
        $('#pay_amount').val(remaining > 0 ? remaining : 0).attr('max', remaining);
        $('#modal_pay_purchase').modal('show');
    });

    // Submit pembayaran
    $('#btn_submit_payment').click(function() {
        var id = $('#pay_purchase_id').val();
        var amount = parseFloat($('#pay_amount').val()) || 0;

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
                    purchase_table.ajax.reload();
                    $('#modal_pay_purchase').modal('hide');
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

<!-- Modal Bayar -->
<div class="modal fade" id="modal_pay_purchase" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-money"></i> Catat Pembayaran <span id="pay_ref_label"></span></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="pay_purchase_id">
                <table class="table table-condensed no-border">
                    <tr>
                        <td>Total Belanja:</td>
                        <td class="text-right"><strong id="pay_total_label">-</strong></td>
                    </tr>
                    <tr>
                        <td>Sudah Dibayar:</td>
                        <td class="text-right"><strong id="pay_paid_label">-</strong></td>
                    </tr>
                    <tr class="bg-warning">
                        <td><strong>Sisa:</strong></td>
                        <td class="text-right"><strong id="pay_remaining_label">-</strong></td>
                    </tr>
                </table>
                <div class="form-group" style="margin-top: 15px;">
                    <label>Jumlah Bayar Sekarang *</label>
                    <div class="input-group">
                        <span class="input-group-addon">Rp</span>
                        <input type="number" id="pay_amount" class="form-control" step="1" min="1" placeholder="0">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="btn_submit_payment">
                    <i class="fa fa-check"></i> Bayar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
