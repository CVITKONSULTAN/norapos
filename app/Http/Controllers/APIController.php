<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Str;
use Hash;
use DB;


use App\Helpers\Helper;

use App\Charts\CommonChart;

use App\BusinessLocation;
use App\Currency;
use App\Transaction;
use App\VariationLocationDetails;
use App\Contact;
use App\User;

use App\Utils\BusinessUtil;
use App\Utils\ProductUtil;
use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;

class APIController extends Controller
{

     /**
     * All Utils instance.
     *
     */
    protected $businessUtil;
    protected $transactionUtil;
    protected $moduleUtil;
    protected $commonUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BusinessUtil $businessUtil,
        TransactionUtil $transactionUtil,
        ModuleUtil $moduleUtil,
        Util $commonUtil,
        ProductUtil $productUtil
    ) {
        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
    }

    public function data(Request $request)
    {
        $input = $request->all();
        $model = null;
        switch ($input["type"]) {
            case 'blog':
                // $model = \App\Blog::query();
                $model = \App\Blog::with("user:id,username");
                $max_length = 150;
                break;
            
            default:
                return abort(404);
                break;
        }
        if(empty($model)) return abort(404);

        if(isset($input["result_format"]) && $input["result_format"] === "blogpost"){
            $data = $model->where("slug",$input["slug"])->firstorfail();
            $seo_description = strip_tags($data->description);
            $data->seo_description = (strlen($seo_description) > $max_length) ? substr($seo_description, 0, $max_length) . '...' : $seo_description;
            return $data;
        }
        if(isset($input["result_format"]) && $input["result_format"] === "datatables"){
            $dt = DataTables::of($model);
            if($input["type"] === "blog"){
                $dt = $dt->editColumn("description",function($q){
                    $description = strip_tags($q->description);
                    return (strlen($description) > $max_length) ? substr($description, 0, $max_length) . '...' : $description;
                });
            }
            return $dt;
        }

        $take = isset($input["take"]) && is_numeric($input["take"]) ? $input["take"] : 10;
        $skip = isset($input["skip"]) && is_numeric($input["skip"]) ? $input["skip"] : 0;

        $model = $model->skip($skip)->take($take);

        $collection = $model->get();

        foreach ($collection as $key => $q) {
            if($input["type"] === "blog"){
                $description = strip_tags($q->description);
                $q->description = (strlen($description) > $max_length) ? substr($description, 0, $max_length) . '...' : $description;
                $collection[$key] = $q;
            }
        }

        return $collection;
    }

    function login(Request $request){
        try {
            $user = \App\User::where('username',$request->username)->first();
            if(empty($user)){
                return Helper::DataReturn(false,"Akun tidak ditemukan");
            }
            
            if (!Hash::check($request->password, $user->password)){
                return Helper::DataReturn(false,"Password anda salah");
            }
     
            $token = Str::random(60);
     
            $user->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();
    
            return Helper::DataReturn(true,"OK",["token" => $token]);
        } catch (\Throwable $th) {
            return Helper::DataReturn(false,$th->getMessage(),$request->all());
        }
    }

    function forget_password(Request $request){
        try{
            $user = \App\User::where('email',$request->email)->first();
            if(empty($user)){
                return Helper::DataReturn(false,"Akun tidak ditemukan");
            }
            $token = Str::random(60);
            $user->sendPasswordResetNotification($token);
            return Helper::DataReturn(true,"Silahkan cek kotak masuk (inbox) email anda");
        } catch (\Throwable $th) {
            return Helper::DataReturn(false,$th->getMessage(),$request->all());
        }
    }

    /**
     * Retrieves purchase and sell details for a given time period.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotals(Request $request)
    {
        $start = request()->start;
        $end = request()->end;
        $location_id = request()->location_id;
        $business_id = request()->user()->business->id;

        $purchase_details = $this->transactionUtil->getPurchaseTotals($business_id, $start, $end, $location_id);

        $sell_details = $this->transactionUtil->getSellTotals($business_id, $start, $end, $location_id);

        $transaction_types = [
            'purchase_return', 'sell_return', 'expense'
        ];

        $transaction_totals = $this->transactionUtil->getTransactionTotals(
            $business_id,
            $transaction_types,
            $start,
            $end
        );

        $total_purchase_inc_tax = !empty($purchase_details['total_purchase_inc_tax']) ? $purchase_details['total_purchase_inc_tax'] : 0;
        $total_purchase_return_inc_tax = $transaction_totals['total_purchase_return_inc_tax'];

        $total_purchase = $total_purchase_inc_tax - $total_purchase_return_inc_tax;
        $output = $purchase_details;
        $output['total_purchase'] = $total_purchase;

        $total_sell_inc_tax = !empty($sell_details['total_sell_inc_tax']) ? $sell_details['total_sell_inc_tax'] : 0;
        $total_sell_return_inc_tax = !empty($transaction_totals['total_sell_return_inc_tax']) ? $transaction_totals['total_sell_return_inc_tax'] : 0;

        $output['total_sell'] = $total_sell_inc_tax - $total_sell_return_inc_tax;

        $output['invoice_due'] = $sell_details['invoice_due'];
        $output['total_expense'] = $transaction_totals['total_expense'];
        
        return $output;
    }

    function getChart(Request $request){

        $business = request()->user()->business;
        $business_id = $business->id;
        $cur_id = $business->currency_id;

        $fy = $this->businessUtil->getCurrentFinancialYear($business_id);
        $date_filters['this_fy'] = $fy;
        $date_filters['this_month']['start'] = date('Y-m-01');
        $date_filters['this_month']['end'] = date('Y-m-t');
        $date_filters['this_week']['start'] = date('Y-m-d', strtotime('monday this week'));
        $date_filters['this_week']['end'] = date('Y-m-d', strtotime('sunday this week'));

        $currency = Currency::where('id', $cur_id)->first();
        
        //Chart for sells last 30 days
        $sells_last_30_days = $this->transactionUtil->getSellsLast30Days($business_id);
        $labels = [];
        $all_sell_values = [];
        $dates = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = \Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;

            $labels[] = date('j M Y', strtotime($date));

            if (!empty($sells_last_30_days[$date])) {
                $all_sell_values[] = (float) $sells_last_30_days[$date];
            } else {
                $all_sell_values[] = 0;
            }
        }

        $all_locations = BusinessLocation::forDropdown($business_id)->toArray();
        $location_sells = [];
        $sells_by_location = $this->transactionUtil->getSellsLast30Days($business_id, true);
        foreach ($all_locations as $loc_id => $loc_name) {
            $values = [];
            foreach ($dates as $date) {
                $sell = $sells_by_location->first(function ($item) use ($loc_id, $date) {
                    return $item->date == $date &&
                        $item->location_id == $loc_id;
                });
                
                if (!empty($sell)) {
                    $values[] = (float) $sell->total_sells;
                } else {
                    $values[] = 0;
                }
            }
            $location_sells[$loc_id]['loc_label'] = $loc_name;
            $location_sells[$loc_id]['values'] = $values;
        }

        return [
            'dates'=>$dates,
            'location_sells'=>$location_sells,
        ];
    }

    function recreate_token(Request $request){

        $token = $request->token;
        $api_token = hash('sha256', $token);
        $user = \App\User::where('api_token',$api_token)->first();

        if(empty($user)){
            return Helper::DataReturn(false,"Akun tidak ditemukan");
        }

        $token = Str::random(60);
     
        $user->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return Helper::DataReturn(true,"OK",["token" => $token]);        
    }

    /**
     * Retrieves products list.
     *
     * @param  string  $q
     * @param  boolean  $check_qty
     *
     * @return JSON
     */
    public function getProducts()
    {
        $business = request()->user()->business;
        $business_id = $business->id;
        
        $search_term = request()->input('term', '');
        $location_id = request()->input('location_id', null);
        $check_qty = request()->input('check_qty', false);
        $price_group_id = request()->input('price_group', null);
        $not_for_selling = request()->get('not_for_selling', null);
        $price_group_id = request()->input('price_group', '');
        $product_types = request()->get('product_types', []);

        $search_fields = request()->get('search_fields', ['name', 'sku']);
        if (in_array('sku', $search_fields)) {
            $search_fields[] = 'sub_sku';
        }

        $result = $this->productUtil->filterProductAPI($business_id, $search_term, $location_id, $not_for_selling, $price_group_id, $product_types, $search_fields, $check_qty);

        if(env("APP_LOCALE") === "id"){
            foreach ($result as $key => $value) {
                $result[$key]["selling_price"] = number_format($value->selling_price,0,",",".");
            }
        }

        return $result;
    }

    function getBusiness(){
        $user = request()->user();
        $business = $user->business ?? false;
        if($business){
            $business = $business->toArray();
            $business['user'] = $user->toArray();
            $business['user']['profile_photo'] = $user->media ?? "";
            unset(
                $business['user']['business'],
                $business['user']['bank_details'],
                $business['user']['api_token'],
            );
        }
        return $business;
    }

    /**
     * Retrieves list of customers, if filter is passed then filter it accordingly.
     *
     * @param  string  $q
     * @return JSON
     */
    public function getCustomers()
    {
        $term = request()->input('q', '');

        $user = request()->user();
        $business = $user->business ?? false;

        $business_id = $business->id;
        $user_id = $user->id;

        $contacts = Contact::where('business_id', $business_id)
                        ->active();

        $selected_contacts = User::isSelectedContacts($user_id);
        if ($selected_contacts) {
            $contacts->join('user_contact_access AS uca', 'contacts.id', 'uca.contact_id')
            ->where('uca.user_id', $user_id);
        }

        if (!empty($term)) {
            $contacts->where(function ($query) use ($term) {
                $query->where('name', 'like', '%' . $term .'%')
                    ->orWhere('supplier_business_name', 'like', '%' . $term .'%')
                    ->orWhere('mobile', 'like', '%' . $term .'%')
                    ->orWhere('contacts.contact_id', 'like', '%' . $term .'%');
            });
        }

        $contacts->select(
            'contacts.id',
            DB::raw("IF(contacts.contact_id IS NULL OR contacts.contact_id='', name, CONCAT(name, ' (', contacts.contact_id, ')')) AS text"),
            'mobile',
            'address_line_1',
            'city',
            'state',
            'pay_term_number',
            'pay_term_type',
            'balance'
        )
                ->onlyCustomers();

        // if (request()->session()->get('business.enable_rp') == 1) {
            $contacts->addSelect('total_rp');
        // }
        $contacts = $contacts->get();
        return json_encode($contacts);
    }

    function getProductRow($variation_id,$location_id){
        $output = [];

        try {
            $row_count = request()->get('product_row');
            $row_count = $row_count + 1;
            $is_direct_sell = false;
            if (request()->get('is_direct_sell') == 'true') {
                $is_direct_sell = true;
            }

            $business_id = request()->session()->get('user.business_id');

            $business_details = $this->businessUtil->getDetails($business_id);
            $quantity = 1;

            //Check for weighing scale barcode
            $weighing_barcode = request()->get('weighing_scale_barcode');
            if ($variation_id == 'null' && !empty($weighing_barcode)) {
                $product_details = $this->__parseWeighingBarcode($weighing_barcode);
                if ($product_details['success']) {
                    $variation_id = $product_details['variation_id'];
                    $quantity = $product_details['qty'];
                } else {
                    $output['success'] = false;
                    $output['msg'] = $product_details['msg'];
                    return $output;
                }
            }

            $pos_settings = empty($business_details->pos_settings) ? $this->businessUtil->defaultPosSettings() : json_decode($business_details->pos_settings, true);

            $check_qty = !empty($pos_settings['allow_overselling']) ? false : true;
            $product = $this->productUtil->getDetailsFromVariation($variation_id, $business_id, $location_id, $check_qty);
            if (!isset($product->quantity_ordered)) {
                $product->quantity_ordered = $quantity;
            }

            $product->formatted_qty_available = $this->productUtil->num_f($product->qty_available, false, null, true);

            $sub_units = $this->productUtil->getSubUnits($business_id, $product->unit_id, false, $product->product_id);

            //Get customer group and change the price accordingly
            $customer_id = request()->get('customer_id', null);
            $cg = $this->contactUtil->getCustomerGroup($business_id, $customer_id);
            $percent = (empty($cg) || empty($cg->amount)) ? 0 : $cg->amount;
            $product->default_sell_price = $product->default_sell_price + ($percent * $product->default_sell_price / 100);
            $product->sell_price_inc_tax = $product->sell_price_inc_tax + ($percent * $product->sell_price_inc_tax / 100);

            $tax_dropdown = TaxRate::forBusinessDropdown($business_id, true, true);

            $enabled_modules = $this->transactionUtil->allModulesEnabled();

            //Get lot number dropdown if enabled
            $lot_numbers = [];
            if (request()->session()->get('business.enable_lot_number') == 1 || request()->session()->get('business.enable_product_expiry') == 1) {
                $lot_number_obj = $this->transactionUtil->getLotNumbersFromVariation($variation_id, $business_id, $location_id, true);
                foreach ($lot_number_obj as $lot_number) {
                    $lot_number->qty_formated = $this->productUtil->num_f($lot_number->qty_available);
                    $lot_numbers[] = $lot_number;
                }
            }
            $product->lot_numbers = $lot_numbers;

            $purchase_line_id = request()->get('purchase_line_id');

            $price_group = request()->input('price_group');
            if (!empty($price_group)) {
                $variation_group_prices = $this->productUtil->getVariationGroupPrice($variation_id, $price_group, $product->tax_id);
                
                if (!empty($variation_group_prices['price_inc_tax'])) {
                    $product->sell_price_inc_tax = $variation_group_prices['price_inc_tax'];
                    $product->default_sell_price = $variation_group_prices['price_exc_tax'];
                }
            }

            $warranties = $this->__getwarranties();

            $output['success'] = true;

            $waiters = [];
            if ($this->productUtil->isModuleEnabled('service_staff') && !empty($pos_settings['inline_service_staff'])) {
                $waiters_enabled = true;
                $waiters = $this->productUtil->serviceStaffDropdown($business_id, $location_id);
            }

            if (request()->get('type') == 'sell-return') {
                $output['html_content'] =  view('sell_return.partials.product_row')
                            ->with(compact('product', 'row_count', 'tax_dropdown', 'enabled_modules', 'sub_units'))
                            ->render();
            } else {
                $is_cg = !empty($cg->id) ? true : false;
                $is_pg = !empty($price_group) ? true : false;
                $discount = $this->productUtil->getProductDiscount($product, $business_id, $location_id, $is_cg, $is_pg, $variation_id);
                
                if ($is_direct_sell) {
                    $edit_discount = auth()->user()->can('edit_product_discount_from_sale_screen');
                    $edit_price = auth()->user()->can('edit_product_price_from_sale_screen');
                } else {
                    $edit_discount = auth()->user()->can('edit_product_discount_from_pos_screen');
                    $edit_price = auth()->user()->can('edit_product_price_from_pos_screen');
                }

                $output['html_content'] =  view('sale_pos.product_row')
                            ->with(compact('product', 'row_count', 'tax_dropdown', 'enabled_modules', 'pos_settings', 'sub_units', 'discount', 'waiters', 'edit_discount', 'edit_price', 'purchase_line_id', 'warranties', 'quantity'))
                            ->render();
            }
            
            $output['enable_sr_no'] = $product->enable_sr_no;

            if ($this->transactionUtil->isModuleEnabled('modifiers')  && !$is_direct_sell) {
                $this_product = Product::where('business_id', $business_id)
                                        ->find($product->product_id);
                if (count($this_product->modifier_sets) > 0) {
                    $product_ms = $this_product->modifier_sets;
                    $output['html_modifier'] =  view('restaurant.product_modifier_set.modifier_for_product')
                    ->with(compact('product_ms', 'row_count'))->render();
                }
            }
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output['success'] = false;
            $output['msg'] = __('lang_v1.item_out_of_stock');
        }

        return $output;
    }


}
