<tr class="product_row">
    <td>
        {{$product->product_name}}
        <br/>
        {{$product->sub_sku}}

        @if( session()->get('business.enable_lot_number') == 1 || session()->get('business.enable_product_expiry') == 1)
        @php
            $lot_enabled = session()->get('business.enable_lot_number');
            $exp_enabled = session()->get('business.enable_product_expiry');
            $lot_no_line_id = '';
            if(!empty($product->lot_no_line_id)){
                $lot_no_line_id = $product->lot_no_line_id;
            }
        @endphp
        @if(!empty($product->lot_numbers))
            <select class="form-control lot_number" name="products[{{$row_index}}][lot_no_line_id]">
                <option value="">@lang('lang_v1.lot_n_expiry')</option>
                @foreach($product->lot_numbers as $lot_number)
                    @php
                        $selected = "";
                        if($lot_number->purchase_line_id == $lot_no_line_id){
                            $selected = "selected";

                            $max_qty_rule = $lot_number->qty_available;
                            $max_qty_msg = __('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit  ]);
                        }

                        $expiry_text = '';
                        if($exp_enabled == 1 && !empty($lot_number->exp_date)){
                            if( \Carbon::now()->gt(\Carbon::createFromFormat('Y-m-d', $lot_number->exp_date)) ){
                                $expiry_text = '(' . __('report.expired') . ')';
                            }
                        }
                    @endphp
                    <option value="{{$lot_number->purchase_line_id}}" data-qty_available="{{$lot_number->qty_available}}" data-msg-max="@lang('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit  ])" {{$selected}}>@if(!empty($lot_number->lot_number) && $lot_enabled == 1){{$lot_number->lot_number}} @endif @if($lot_enabled == 1 && $exp_enabled == 1) - @endif @if($exp_enabled == 1 && !empty($lot_number->exp_date)) @lang('product.exp_date'): {{@format_date($lot_number->exp_date)}} @endif {{$expiry_text}}</option>
                @endforeach
            </select>
        @endif
    @endif
    </td>
    <td>
        {{-- If edit then transaction sell lines will be present --}}
        @if(!empty($product->transaction_sell_lines_id))
            <input type="hidden" name="products[{{$row_index}}][transaction_sell_lines_id]" class="form-control" value="{{$product->transaction_sell_lines_id}}">
        @endif

        <input type="hidden" name="products[{{$row_index}}][product_id]" class="form-control product_id" value="{{$product->product_id}}">

        <input type="hidden" value="{{$product->variation_id}}" 
            name="products[{{$row_index}}][variation_id]">

        <input type="hidden" value="{{$product->enable_stock}}" 
            name="products[{{$row_index}}][enable_stock]">
        
        @if(empty($product->quantity_ordered))
            @php
                $product->quantity_ordered = 1;
            @endphp
        @endif

        @php
            $default_stock_in = 0;
            $default_stock_out = (float)$product->quantity_ordered;
            if ((float)$product->quantity_ordered < 0) {
                $default_stock_in = abs((float)$product->quantity_ordered);
                $default_stock_out = 0;
            }
        @endphp

        <input type="hidden" class="form-control product_quantity input_number" value="{{number_format(($default_stock_out - $default_stock_in), 2, '.', '')}}" name="products[{{$row_index}}][quantity]"
        data-rule-required="true" data-msg-required="@lang('validation.custom-messages.this_field_is_required')" @if($product->enable_stock) data-qty_available="{{$product->qty_available}}"
        data-msg_max_default="@lang('validation.custom-messages.quantity_not_available', ['qty'=> $product->formatted_qty_available, 'unit' => $product->unit  ])"
         @endif >

        <div class="input-group" style="margin-bottom: 5px;">
            <span class="input-group-addon">@lang('stock_adjustment.stock_in')</span>
            <input type="text" class="form-control stock_in_quantity input_number" value="{{number_format($default_stock_in, 2, '.', '')}}" name="products[{{$row_index}}][stock_in_quantity]"
            @if($product->unit_allow_decimal == 1) data-decimal="1" @else data-rule-abs_digit="true" data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')" data-decimal="0" @endif
            data-rule-min="0">
            <span class="input-group-addon">{{$product->unit}}</span>
        </div>
        <div class="input-group">
            <span class="input-group-addon">@lang('stock_adjustment.stock_out')</span>
            <input type="text" class="form-control stock_out_quantity input_number" value="{{number_format($default_stock_out, 2, '.', '')}}" name="products[{{$row_index}}][stock_out_quantity]"
            @if($product->unit_allow_decimal == 1) data-decimal="1" @else data-rule-abs_digit="true" data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')" data-decimal="0" @endif
            data-rule-min="0">
            <span class="input-group-addon">{{$product->unit}}</span>
        </div>
    </td>
    <td>
        <input type="text" name="products[{{$row_index}}][unit_price]" class="form-control product_unit_price input_number" value="{{@num_format($product->last_purchased_price)}}">
    </td>
    <td>
        <input type="text" readonly name="products[{{$row_index}}][price]" class="form-control product_line_total" value="{{@num_format($product->quantity_ordered*$product->last_purchased_price)}}">
    </td>
    <td class="text-center">
        <i class="fa fa-trash remove_product_row cursor-pointer" aria-hidden="true"></i>
    </td>
</tr>