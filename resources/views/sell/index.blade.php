@extends('layouts.app')
@section('title', __( 'lang_v1.all_sales'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang( 'sale.sells')
    </h1>
</section>

<!-- Main content -->
<section class="content no-print">
    @component('components.filters', ['title' => __('report.filters')])
        @include('sell.partials.sell_list_filters')
        @if($is_woocommerce)
            <div class="col-md-3">
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                          {!! Form::checkbox('only_woocommerce_sells', 1, false, 
                          [ 'class' => 'input-icheck', 'id' => 'synced_from_woocommerce']); !!} {{ __('lang_v1.synced_from_woocommerce') }}
                        </label>
                    </div>
                </div>
            </div>
        @endif
    @endcomponent
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'lang_v1.all_sales')])
        @can('sell.create')
            @slot('tool')
                <div class="box-tools">
                    <a class="btn btn-block btn-primary" href="{{action('SellController@create')}}">
                    <i class="fa fa-plus"></i> @lang('messages.add')</a>
                </div>
            @endslot
        @endcan
        @if(auth()->user()->can('direct_sell.access') ||  auth()->user()->can('view_own_sell_only'))
        @php
            $custom_labels = json_decode(session('business.custom_labels'), true);
         @endphp
            <table class="table table-bordered table-striped ajax_view" id="sell_table">
                <thead>
                    <tr>
                        <th>@lang('messages.action')</th>
                        <th>@lang('messages.date')</th>
                        <th>@lang('sale.invoice_no')</th>
                        <th>@lang('sale.customer_name')</th>
                        <th>@lang('lang_v1.contact_no')</th>
                        <th>@lang('sale.location')</th>
                        <th>@lang('sale.payment_status')</th>
                        <th>@lang('lang_v1.payment_method')</th>
                        <th>@lang('sale.total_amount')</th>
                        <th>@lang('sale.total_paid')</th>
                        <th>@lang('lang_v1.sell_due')</th>
                        <th>@lang('lang_v1.sell_return_due')</th>
                        <th>@lang('lang_v1.shipping_status')</th>
                        <th>@lang('lang_v1.total_items')</th>
                        <th>@lang('lang_v1.types_of_service')</th>
                        <th>{{ $custom_labels['types_of_service']['custom_field_1'] ?? __('lang_v1.service_custom_field_1' )}}</th>
                        <th>@lang('lang_v1.added_by')</th>
                        <th>@lang('sale.sell_note')</th>
                        <th>@lang('sale.staff_note')</th>
                        <th>@lang('sale.shipping_details')</th>
                        <th>@lang('restaurant.table')</th>
                        <th>@lang('restaurant.service_staff')</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr class="bg-gray font-17 footer-total text-center">
                        <td colspan="6"><strong>@lang('sale.total'):</strong></td>
                        <td class="footer_payment_status_count"></td>
                        <td class="payment_method_count"></td>
                        <td class="footer_sale_total"></td>
                        <td class="footer_total_paid"></td>
                        <td class="footer_total_remaining"></td>
                        <td class="footer_total_sell_return_due"></td>
                        <td colspan="2"></td>
                        <td class="service_type_count"></td>
                        <td colspan="7"></td>
                    </tr>
                </tfoot>
            </table>
        @endif
    @endcomponent
</section>
<!-- /.content -->
<div class="modal fade payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

<div class="modal fade history_print" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog modal-xl no-print" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="modalTitle">
                    Riwayat Cetak Invoice
                </h4>
            </div>
            <div class="modal-body">
                <table width="100%" class="table table-bordered table-striped ajax_view" id="history_cetak_table">
                    <thead>
                        <tr>
                            <td>Waktu</td>
                            <td>Pengguna</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default no-print" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- This will be printed -->
<!-- <section class="invoice print_section" id="receipt_section">
</section> -->

@stop

@section('javascript')
<script type="text/javascript">

let history_cetak_table;
let list_status_filter = [];

$(document).ready( function(){
    //Date range as a button
    $('#sell_list_filter_date_range').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            $('#sell_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            sell_table.ajax.reload();
        }
    );
    $('#sell_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
        $('#sell_list_filter_date_range').val('');
        sell_table.ajax.reload();
    });

    sell_table = $('#sell_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, 'desc']],
        "ajax": {
            "url": "/sells",
            "data": function ( d ) {
                if($('#sell_list_filter_date_range').val()) {
                    var start = $('#sell_list_filter_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    var end = $('#sell_list_filter_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    d.start_date = start;
                    d.end_date = end;
                }
                d.is_direct_sale = 1;

                d.location_id = $('#sell_list_filter_location_id').val();
                d.customer_id = $('#sell_list_filter_customer_id').val();
                d.payment_status = $('#sell_list_filter_payment_status').val();
                d.created_by = $('#created_by').val();
                d.sales_cmsn_agnt = $('#sales_cmsn_agnt').val();
                d.service_staffs = $('#service_staffs').val();

                console.log("list_status_filter",list_status_filter)

                d.list_status_filter = list_status_filter;
                
                @if($is_woocommerce)
                    if($('#synced_from_woocommerce').is(':checked')) {
                        d.only_woocommerce_sells = 1;
                    }
                @endif

                if($('#only_subscriptions').is(':checked')) {
                    d.only_subscriptions = 1;
                }

                d = __datatable_ajax_callback(d);
            }
        },
        scrollY:        "500px",
        scrollX:        true,
        scrollCollapse: true,
        columns: [
            { data: 'action', name: 'action', orderable: false, "searchable": false},
            { data: 'transaction_date', name: 'transaction_date'  },
            { data: 'invoice_no', name: 'invoice_no'},
            { data: 'name', name: 'contacts.name'},
            { data: 'mobile', name: 'contacts.mobile'},
            { data: 'business_location', name: 'bl.name'},
            { data: 'payment_status', name: 'payment_status'},
            { data: 'payment_methods', orderable: false, "searchable": false},
            { data: 'final_total', name: 'final_total'},
            { data: 'total_paid', name: 'total_paid', "searchable": false},
            { data: 'total_remaining', name: 'total_remaining'},
            { data: 'return_due', orderable: false, "searchable": false,
                @if(auth()->user()->business->id == 11) "visible":false @endif
            },
            { data: 'shipping_status', name: 'shipping_status',
                @if(auth()->user()->business->id == 11) "visible":false @endif
            },
            { data: 'total_items', name: 'total_items', "searchable": false,
                @if(auth()->user()->business->id == 11) "visible":false @endif
            },
            { data: 'types_of_service_name', name: 'tos.name', @if(empty($is_types_service_enabled)) visible: false @endif},
            { data: 'service_custom_field_1', name: 'service_custom_field_1', @if(empty($is_types_service_enabled)) visible: false @endif},
            { data: 'added_by', name: 'u.first_name'},
            { data: 'additional_notes', name: 'additional_notes'},
            { data: 'staff_note', name: 'staff_note'},
            { data: 'shipping_details', name: 'shipping_details',
                @if(auth()->user()->business->id == 11) "visible":false @endif
            },
            { data: 'table_name', name: 'tables.name', @if(empty($is_tables_enabled)) visible: false @endif },
            { data: 'waiter', name: 'ss.first_name', @if(empty($is_service_staff_enabled)) visible: false @endif },
        ],
        "fnDrawCallback": function (oSettings) {
            __currency_convert_recursively($('#sell_table'));
        },
        "footerCallback": function ( row, data, start, end, display ) {
            var footer_sale_total = 0;
            var footer_total_paid = 0;
            var footer_total_remaining = 0;
            var footer_total_sell_return_due = 0;
            for (var r in data){
                let total_paid_row = typeof($(data[r].total_paid).data('orig-value')) != 'undefined' ? parseFloat($(data[r].total_paid).data('orig-value')) : 0;
                total_paid_row = isNaN(total_paid_row) ? 0 : total_paid_row;
                // console.log("total_paid_row",r,total_paid_row);
                footer_sale_total += typeof($(data[r].final_total).data('orig-value')) != 'undefined' ? parseFloat($(data[r].final_total).data('orig-value')) : 0;
                footer_total_paid += total_paid_row;
                footer_total_remaining += typeof($(data[r].total_remaining).data('orig-value')) != 'undefined' ? parseFloat($(data[r].total_remaining).data('orig-value')) : 0;
                footer_total_sell_return_due += typeof($(data[r].return_due).data('orig-value')) != 'undefined' ? parseFloat($(data[r].return_due).data('orig-value')) : 0;
            }

            $('.footer_total_sell_return_due').html(__currency_trans_from_en(footer_total_sell_return_due));
            $('.footer_total_remaining').html(__currency_trans_from_en(footer_total_remaining));
            $('.footer_total_paid').html(__currency_trans_from_en(footer_total_paid));
            $('.footer_sale_total').html(__currency_trans_from_en(footer_sale_total));

            $('.footer_payment_status_count').html(__count_status(data, 'payment_status'));
            $('.service_type_count').html(__count_status(data, 'types_of_service_name'));
            $('.payment_method_count').html(__count_status(data, 'payment_methods'));
        },
        createdRow: function( row, data, dataIndex ) {
            $( row ).find('td:eq(6)').attr('class', 'clickable_td');
        }
    });

    history_cetak_table = $('#history_cetak_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[1, 'desc']],
        "ajax": {"url": "/log_activity/data"},
        scrollY:        "500px",
        scrollX:        true,
        scrollCollapse: true,
        columns:[
            { data: 'tgl_buat', name: 'tgl_buat', orderable: false, "searchable": false},
            { 
                data: 'name', 
                name: 'user.username',
                render: function (data, type, row, meta) {
                    if(!row.user) return "-";
                    const fs = row.user.first_name ?? ""
                    let ls = row.user.last_name ?? ""
                    if(ls != "") ls = " "+ls

                    const username = row.user.username ?? ''
                    return username+" ("+fs+ls+")";
                }
            },
        ]
    })

    $(document).on('change', '#sell_list_filter_location_id, #sell_list_filter_customer_id, #sell_list_filter_payment_status, #created_by, #sales_cmsn_agnt, #service_staffs',  function() {
        sell_table.ajax.reload();
    });
    @if($is_woocommerce)
        $('#synced_from_woocommerce').on('ifChanged', function(event){
            sell_table.ajax.reload();
        });
    @endif

    $('#only_subscriptions').on('ifChanged', function(event){
        sell_table.ajax.reload();
    });
});

$(document).ready(function () {
    // Inisialisasi iCheck pada elemen checkbox
    $(".check_status_input").iCheck({
        checkboxClass: 'icheckbox_square-blue', // Kelas iCheck yang digunakan
    });

    // Event handler untuk checkbox yang aktif
    $(".check_status_input").on('ifChanged', function () {

         // Cek jika checkbox dengan ID 'overdue' diaktifkan
         if ($(this).attr("id") === "overdue" && $(this).is(":checked")) {
            // Uncheck semua checkbox kecuali 'overdue'
            $(".check_status_input").not("#overdue").iCheck('uncheck');
        } else if ($(this).attr("id") !== "overdue") {
            // Jika checkbox lain dicentang, uncheck 'overdue'
            $("#overdue").iCheck('uncheck');
        }

        // Dapatkan semua nilai checkbox yang aktif
        const activeValues = $(".check_status_input:checked").map(function () {
            return $(this).val();
        }).get();

        // Tampilkan hasil di konsol
        // console.log("Checkbox aktif:", activeValues);
        list_status_filter = activeValues;
        sell_table.ajax.reload();

    });
});



$(document).on('click','.detail_history_cetak_modal', function(){
    const id = $(this).data('id')
    // console.log(id,$(this));
    const link = `/log_activity/data?column[]=actions&search[]=printInvoice&column[]=action_reference&search[]=transaction&column[]=relation_id&search[]=${id}`
    history_cetak_table.ajax.url(link).load();
    $('.history_print').modal('show')
})
</script>
<script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
@endsection