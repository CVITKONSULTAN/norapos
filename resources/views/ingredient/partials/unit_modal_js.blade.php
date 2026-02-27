<script>
$(document).ready(function() {
    $('#btn_save_unit').click(function() {
        var name = $('#modal_unit_name').val();
        var short = $('#modal_unit_short').val();
        var decimal = $('#modal_unit_decimal').is(':checked') ? 1 : 0;

        if (!name || !short) {
            toastr.error('Nama dan singkatan satuan wajib diisi');
            return;
        }

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            method: 'POST',
            url: '/units',
            data: {
                actual_name: name,
                short_name: short,
                allow_decimal: decimal
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    toastr.success(result.msg);

                    // Tambahkan option baru ke dropdown unit_id
                    var newOption = new Option(
                        result.data.actual_name + ' (' + result.data.short_name + ')',
                        result.data.id,
                        true, true
                    );
                    $('#unit_id').append(newOption).trigger('change');

                    // Reset & tutup modal
                    $('#modal_unit_name').val('');
                    $('#modal_unit_short').val('');
                    $('#modal_unit_decimal').prop('checked', false);
                    $('#modal_add_unit').modal('hide');
                } else {
                    toastr.error(result.msg);
                }
            },
            error: function() {
                toastr.error('Gagal menyimpan satuan');
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Satuan');
            }
        });
    });
});
</script>
