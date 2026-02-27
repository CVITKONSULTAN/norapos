@extends('layouts.app')
@section('title', 'Tambah Pembelian Bahan')

@section('content')
<section class="content-header">
    <h1>Tambah Pembelian Bahan
        <small>Input penerimaan bahan dari supplier</small>
    </h1>
</section>

<section class="content">
    {{-- OCR Upload --}}
    @component('components.widget', ['class' => 'box-info', 'title' => 'Scan Struk / Nota (OCR)'])
        @slot('icon')
            <i class="fa fa-camera"></i>
        @endslot
        <div class="row">
            <div class="col-sm-7">
                <div class="form-group">
                    <label>Upload PDF atau Foto Struk dari Supplier</label>
                    <input type="file" id="receipt_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    <p class="help-block text-muted"><i class="fa fa-info-circle"></i> Format: PDF, JPG, PNG. Maks 10MB. Struk akan di-scan otomatis mengisi form di bawah.</p>
                </div>
            </div>
            <div class="col-sm-3" style="padding-top: 25px;">
                <button type="button" class="btn btn-info btn-block btn-lg" id="btn_process_ocr" disabled>
                    <i class="fa fa-magic"></i> Proses OCR
                </button>
            </div>
            <div class="col-sm-2" style="padding-top: 25px;">
                <button type="button" class="btn btn-default btn-block" id="btn_toggle_raw" style="display:none;">
                    <i class="fa fa-file-text-o"></i> Teks OCR
                </button>
            </div>
        </div>
        <div id="ocr_progress" style="display: none;">
            <div class="progress progress-sm active" style="margin-bottom: 5px;">
                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" style="width: 100%"></div>
            </div>
            <p class="text-center text-muted"><i class="fa fa-spinner fa-spin"></i> Sedang memproses OCR, mohon tunggu...</p>
        </div>
        <div id="ocr_result_box" style="display: none;">
            <div class="callout callout-success" style="margin-bottom: 0;">
                <h4><i class="fa fa-check-circle"></i> OCR Berhasil</h4>
                <p id="ocr_result_info"></p>
            </div>
        </div>
        <div id="ocr_error_box" style="display: none;">
            <div class="callout callout-danger" style="margin-bottom: 0;">
                <h4><i class="fa fa-times-circle"></i> Gagal</h4>
                <p id="ocr_error_msg"></p>
            </div>
        </div>
        <div id="ocr_raw_text_box" style="display: none; margin-top: 10px;">
            <label>Raw OCR Text:</label>
            <pre id="ocr_raw_text" style="max-height: 200px; overflow-y: auto; font-size: 11px; background: #f9f9f9; padding: 10px; border: 1px solid #ddd;"></pre>
        </div>
    @endcomponent

    {!! Form::open(['url' => action('IngredientPurchaseController@store'), 'method' => 'post', 'id' => 'purchase_form']) !!}

    {{-- Header --}}
    @component('components.widget', ['class' => 'box-primary', 'title' => 'Info Pembelian'])
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Tanggal Pembelian *</label>
                    <input type="date" name="purchase_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>No Referensi</label>
                    <input type="text" name="ref_no" class="form-control" placeholder="No faktur / nota">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Supplier</label>
                    <div class="input-group">
                        {!! Form::select('contact_id', $suppliers, null, ['class' => 'form-control select2', 'id' => 'supplier_id', 'placeholder' => 'Pilih supplier']) !!}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_add_supplier" title="Tambah Supplier Baru">
                                <i class="fa fa-plus"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Lokasi *</label>
                    {!! Form::select('location_id', $locations, null, ['class' => 'form-control select2', 'required', 'placeholder' => 'Pilih lokasi']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
                </div>
            </div>
        </div>
    @endcomponent

    {{-- Detail Bahan --}}
    @component('components.widget', ['class' => 'box-success', 'title' => 'Daftar Bahan yang Dibeli'])
        <table class="table table-bordered" id="ingredient_lines">
            <thead>
                <tr class="bg-gray">
                    <th width="35%">Bahan Baku</th>
                    <th width="15%">Qty</th>
                    <th width="15%">Satuan</th>
                    <th width="15%">Harga Satuan</th>
                    <th width="15%">Subtotal</th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody id="lines_body">
                <tr class="ingredient-row" data-row="0">
                    <td>
                        <select name="ingredients[0][ingredient_id]" class="form-control select2 ingredient-select">
                            <option value="">Pilih bahan</option>
                            @foreach($ingredients as $ing)
                                <option value="{{ $ing->id }}" data-unit="{{ $ing->unit->short_name ?? '-' }}">{{ $ing->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="ingredients[0][nota_name]" class="nota-name-input" value="">
                        <input type="hidden" name="ingredients[0][is_new]" class="is-new-input" value="0">
                    </td>
                    <td><input type="number" name="ingredients[0][quantity]" class="form-control qty-input" step="0.01" min="0.01" required placeholder="0"></td>
                    <td class="unit-label text-center" style="vertical-align: middle;">-</td>
                    <td><input type="number" name="ingredients[0][unit_price]" class="form-control price-input" step="1" min="0" value="0" placeholder="0"></td>
                    <td class="subtotal text-right" style="vertical-align: middle;">Rp 0</td>
                    <td><button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-times"></i></button></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"><strong>Total:</strong></td>
                    <td class="text-right"><strong id="grand_total">Rp 0</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <button type="button" class="btn btn-info btn-sm" id="btn_add_row">
            <i class="fa fa-plus"></i> Tambah Baris
        </button>
    @endcomponent

    {{-- Pembayaran --}}
    @component('components.widget', ['class' => 'box-warning', 'title' => 'Pembayaran'])
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Total Belanja</label>
                    <div class="input-group">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" id="display_total" class="form-control" readonly value="0" style="background: #f5f5f5; font-weight: bold;">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Jumlah Dibayar</label>
                    <div class="input-group">
                        <span class="input-group-addon">Rp</span>
                        <input type="number" name="paid_amount" id="paid_amount" class="form-control" step="1" min="0" value="0" placeholder="0">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Status</label>
                    <div id="payment_status_preview" style="padding-top: 5px;">
                        <span class="label label-danger" style="font-size: 14px;">Belum Bayar</span>
                    </div>
                </div>
            </div>
        </div>
    @endcomponent

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary btn-lg pull-right">
                <i class="fa fa-save"></i> Simpan Pembelian
            </button>
        </div>
    </div>

    {!! Form::close() !!}
</section>

<!-- Modal Tambah Supplier -->
<div class="modal fade" id="modal_add_supplier" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Supplier Baru</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Supplier *</label>
                    <input type="text" id="sup_first_name" class="form-control" placeholder="Nama supplier" required>
                </div>
                <div class="form-group">
                    <label>Nama Usaha</label>
                    <input type="text" id="sup_business_name" class="form-control" placeholder="Nama perusahaan / usaha">
                </div>
                <div class="form-group">
                    <label>No HP / Telepon</label>
                    <input type="text" id="sup_mobile" class="form-control" placeholder="08xxxxxxxxxx">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea id="sup_address" class="form-control" rows="2" placeholder="Alamat supplier"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn_save_supplier">
                    <i class="fa fa-save"></i> Simpan Supplier
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var rowIndex = 1;

    // Ingredient options HTML (untuk reuse)
    var ingredientOptions = '<option value="">Pilih bahan</option>';
    @foreach($ingredients as $ing)
        ingredientOptions += '<option value="{{ $ing->id }}" data-unit="{{ $ing->unit->short_name ?? "-" }}">{{ $ing->name }}</option>';
    @endforeach

    // Tambah baris
    $('#btn_add_row').click(function() {
        var newRow = `
        <tr class="ingredient-row" data-row="${rowIndex}">
            <td>
                <select name="ingredients[${rowIndex}][ingredient_id]" class="form-control ingredient-select">
                    ${ingredientOptions}
                </select>
                <input type="hidden" name="ingredients[${rowIndex}][nota_name]" class="nota-name-input" value="">
                <input type="hidden" name="ingredients[${rowIndex}][is_new]" class="is-new-input" value="0">
            </td>
            <td><input type="number" name="ingredients[${rowIndex}][quantity]" class="form-control qty-input" step="0.01" min="0.01" required placeholder="0"></td>
            <td class="unit-label text-center" style="vertical-align: middle;">-</td>
            <td><input type="number" name="ingredients[${rowIndex}][unit_price]" class="form-control price-input" step="1" min="0" value="0" placeholder="0"></td>
            <td class="subtotal text-right" style="vertical-align: middle;">Rp 0</td>
            <td><button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-times"></i></button></td>
        </tr>`;
        $('#lines_body').append(newRow);
        // Init select2 on new row
        $('#lines_body tr:last .ingredient-select').select2();
        rowIndex++;
    });

    // Hapus baris
    $(document).on('click', '.remove-row', function() {
        if ($('.ingredient-row').length > 1) {
            $(this).closest('tr').remove();
            calcGrandTotal();
        } else {
            toastr.warning('Minimal 1 baris bahan');
        }
    });

    // Update satuan saat pilih bahan
    $(document).on('change', '.ingredient-select', function() {
        var unit = $(this).find(':selected').data('unit') || '-';
        $(this).closest('tr').find('.unit-label').text(unit);
    });

    // Hitung subtotal
    $(document).on('input', '.qty-input, .price-input', function() {
        var row = $(this).closest('tr');
        var qty = parseFloat(row.find('.qty-input').val()) || 0;
        var price = parseFloat(row.find('.price-input').val()) || 0;
        var subtotal = qty * price;
        row.find('.subtotal').text('Rp ' + subtotal.toLocaleString('id-ID'));
        calcGrandTotal();
    });

    function calcGrandTotal() {
        var total = 0;
        $('.ingredient-row').each(function() {
            var qty = parseFloat($(this).find('.qty-input').val()) || 0;
            var price = parseFloat($(this).find('.price-input').val()) || 0;
            total += qty * price;
        });
        $('#grand_total').text('Rp ' + total.toLocaleString('id-ID'));
        $('#display_total').val(total.toLocaleString('id-ID'));
        updatePaymentStatus();
    }

    function updatePaymentStatus() {
        var total = 0;
        $('.ingredient-row').each(function() {
            var qty = parseFloat($(this).find('.qty-input').val()) || 0;
            var price = parseFloat($(this).find('.price-input').val()) || 0;
            total += qty * price;
        });
        var paid = parseFloat($('#paid_amount').val()) || 0;
        var preview = $('#payment_status_preview');

        if (paid >= total && total > 0) {
            preview.html('<span class="label label-success" style="font-size: 14px;">Lunas</span>');
        } else if (paid > 0) {
            preview.html('<span class="label label-warning" style="font-size: 14px;">Sebagian</span> <small class="text-muted">Sisa: Rp ' + (total - paid).toLocaleString('id-ID') + '</small>');
        } else {
            preview.html('<span class="label label-danger" style="font-size: 14px;">Belum Bayar</span>');
        }
    }

    // Update status saat paid_amount berubah
    $(document).on('input', '#paid_amount', function() {
        updatePaymentStatus();
    });

    // Init select2
    $('.select2').select2();
    $('.ingredient-select').select2();

    // Simpan supplier baru via modal
    $('#btn_save_supplier').click(function() {
        var name = $('#sup_first_name').val();
        if (!name) {
            toastr.error('Nama supplier wajib diisi');
            return;
        }

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            method: 'POST',
            url: '/contacts',
            data: {
                type: 'supplier',
                first_name: name,
                supplier_business_name: $('#sup_business_name').val(),
                mobile: $('#sup_mobile').val(),
                address_line_1: $('#sup_address').val()
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    toastr.success(result.msg);
                    // Tambahkan ke dropdown & select
                    var label = name;
                    if ($('#sup_business_name').val()) {
                        label += ' - ' + $('#sup_business_name').val();
                    }
                    var newOption = new Option(label, result.data.id, true, true);
                    $('#supplier_id').append(newOption).trigger('change');

                    // Reset & tutup modal
                    $('#sup_first_name').val('');
                    $('#sup_business_name').val('');
                    $('#sup_mobile').val('');
                    $('#sup_address').val('');
                    $('#modal_add_supplier').modal('hide');
                } else {
                    toastr.error(result.msg);
                }
            },
            error: function() {
                toastr.error('Gagal menyimpan supplier');
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Supplier');
            }
        });
    });

    // ============ OCR Upload ============

    // Enable/disable OCR button based on file selection
    $('#receipt_file').on('change', function() {
        $('#btn_process_ocr').prop('disabled', !this.files.length);
        // Reset results
        $('#ocr_result_box, #ocr_error_box, #ocr_raw_text_box').hide();
        $('#btn_toggle_raw').hide();
    });

    // Toggle raw OCR text
    $('#btn_toggle_raw').click(function() {
        $('#ocr_raw_text_box').toggle();
    });

    // Process OCR
    $('#btn_process_ocr').click(function() {
        var fileInput = document.getElementById('receipt_file');
        if (!fileInput.files.length) {
            toastr.error('Pilih file terlebih dahulu');
            return;
        }

        var formData = new FormData();
        formData.append('receipt_file', fileInput.files[0]);

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
        $('#ocr_progress').show();
        $('#ocr_result_box, #ocr_error_box, #ocr_raw_text_box').hide();

        $.ajax({
            url: '{{ route("ingredient_purchases.process_ocr") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            timeout: 120000, // 2 menit timeout
            success: function(response) {
                if (response.success && response.data) {
                    var data = response.data;
                    populateFromOcr(data);

                    // Show success
                    var info = 'Ditemukan <strong>' + data.items.length + ' item</strong>';
                    if (data.supplier_name) info += ' dari <strong>' + data.supplier_name + '</strong>';
                    if (data.date) info += ', tanggal ' + data.date;
                    if (data.payment_status === 'paid') info += ' <span class="label label-success">TUNAI</span>';
                    else info += ' <span class="label label-warning">KREDIT</span>';

                    var unmatched = data.items.filter(function(i) { return !i.ingredient_id; }).length;
                    if (unmatched > 0) {
                        info += '<br><small class="text-warning"><i class="fa fa-exclamation-triangle"></i> ' + unmatched + ' item belum cocok dengan database bahan — silakan pilih manual.</small>';
                    }

                    $('#ocr_result_info').html(info);
                    $('#ocr_result_box').show();

                    // Show raw text button
                    if (data.raw_text) {
                        $('#ocr_raw_text').text(data.raw_text);
                        $('#btn_toggle_raw').show();
                    }

                    toastr.success('OCR berhasil! ' + data.items.length + ' item ditemukan');
                } else {
                    $('#ocr_error_msg').text(response.msg || 'Gagal memproses OCR');
                    $('#ocr_error_box').show();
                    toastr.error(response.msg || 'Gagal memproses OCR');
                }
            },
            error: function(xhr) {
                var msg = 'Gagal memproses file';
                if (xhr.responseJSON && xhr.responseJSON.msg) msg = xhr.responseJSON.msg;
                else if (xhr.status === 0) msg = 'Request timeout — file terlalu besar atau server sibuk';
                $('#ocr_error_msg').text(msg);
                $('#ocr_error_box').show();
                toastr.error(msg);
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fa fa-magic"></i> Proses OCR');
                $('#ocr_progress').hide();
            }
        });
    });

    /**
     * Populate form fields from OCR result
     */
    function populateFromOcr(data) {
        // Fill header fields
        if (data.date) {
            $('input[name="purchase_date"]').val(data.date);
        }
        if (data.ref_no) {
            $('input[name="ref_no"]').val(data.ref_no);
        }
        if (data.supplier_id) {
            $('#supplier_id').val(data.supplier_id).trigger('change');
        }

        // Payment
        if (data.payment_status === 'paid' && data.total > 0) {
            $('#paid_amount').val(data.total);
        } else {
            $('#paid_amount').val(0);
        }

        // Populate ingredient lines
        if (data.items && data.items.length > 0) {
            // Clear existing rows
            $('#lines_body').empty();

            data.items.forEach(function(item, index) {
                var isMatched = !!item.ingredient_id;
                var ocrName = item.ocr_name || item.name || '';
                var escapedOcrName = $('<div>').text(ocrName).html();

                // Build nota info display
                var notaInfo = '';
                if (isMatched) {
                    if (item.match_type === 'alias') {
                        notaInfo = '<small class="text-success"><i class="fa fa-link"></i> Nota: ' + escapedOcrName + ' (alias tersimpan)</small>';
                    } else if (item.match_score < 80) {
                        notaInfo = '<small class="text-info"><i class="fa fa-info-circle"></i> Nota: ' + escapedOcrName + ' (' + item.match_score + '% cocok)</small>';
                    } else {
                        notaInfo = '<small class="text-muted"><i class="fa fa-file-text-o"></i> Nota: ' + escapedOcrName + '</small>';
                    }
                } else {
                    notaInfo = '<div style="margin-top:4px;"><small class="text-danger"><i class="fa fa-exclamation-circle"></i> Nota: <strong>' + escapedOcrName + '</strong> — tidak ditemukan</small>'
                        + '<br><label style="font-weight:normal; margin-top:3px; cursor:pointer;"><input type="checkbox" class="is-new-checkbox" data-row="' + index + '"> <small>Tambah sebagai bahan baru</small></label></div>';
                }

                var rowHtml = `
                <tr class="ingredient-row" data-row="${index}">
                    <td>
                        <select name="ingredients[${index}][ingredient_id]" class="form-control ingredient-select" ${isMatched ? '' : ''}>
                            ${ingredientOptions}
                        </select>
                        <input type="hidden" name="ingredients[${index}][nota_name]" class="nota-name-input" value="${escapedOcrName}">
                        <input type="hidden" name="ingredients[${index}][is_new]" class="is-new-input" value="0">
                        ${notaInfo}
                    </td>
                    <td><input type="number" name="ingredients[${index}][quantity]" class="form-control qty-input" step="0.01" min="0.01" required placeholder="0" value="${item.quantity || ''}"></td>
                    <td class="unit-label text-center" style="vertical-align: middle;">-</td>
                    <td><input type="number" name="ingredients[${index}][unit_price]" class="form-control price-input" step="1" min="0" value="${item.unit_price || 0}" placeholder="0"></td>
                    <td class="subtotal text-right" style="vertical-align: middle;">Rp ${((item.quantity || 0) * (item.unit_price || 0)).toLocaleString('id-ID')}</td>
                    <td><button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-times"></i></button></td>
                </tr>`;
                $('#lines_body').append(rowHtml);

                var row = $('#lines_body tr:last');
                var select = row.find('.ingredient-select');
                select.select2();

                // Set matched ingredient
                if (isMatched) {
                    select.val(item.ingredient_id).trigger('change');
                }
            });

            rowIndex = data.items.length;
            calcGrandTotal();
        }
    }

    // Handle "Tambah sebagai bahan baru" checkbox
    $(document).on('change', '.is-new-checkbox', function() {
        var row = $(this).closest('tr');
        var select = row.find('.ingredient-select');
        var isNewInput = row.find('.is-new-input');

        if ($(this).is(':checked')) {
            // Mark as new — disable select (will use nota_name to create)
            isNewInput.val('1');
            select.prop('disabled', true).trigger('change');
            select.closest('td').find('.select2-container').css('opacity', '0.4');
        } else {
            isNewInput.val('0');
            select.prop('disabled', false);
            select.closest('td').find('.select2-container').css('opacity', '1');
        }
    });

    // Re-enable disabled selects before form submit (so they get submitted)
    $('#purchase_form').on('submit', function() {
        $(this).find('.ingredient-select:disabled').each(function() {
            $(this).prop('disabled', false);
        });
    });
});
</script>
@endsection
