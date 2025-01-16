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
use App\Media;
use App\FCMToken;

use App\Utils\BusinessUtil;
use App\Utils\ProductUtil;
use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use App\Utils\CashRegisterUtil;
use App\Utils\ContactUtil;
use App\Utils\NotificationUtil;

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
    protected $cashRegisterUtil;
    protected $contactUtil;
    protected $notificationUtil;

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
        ProductUtil $productUtil,
        ContactUtil $contactUtil,
        CashRegisterUtil $cashRegisterUtil,
        NotificationUtil $notificationUtil
    ) {
        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
        $this->productUtil = $productUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;
        $this->contactUtil = $contactUtil;
        $this->notificationUtil = $notificationUtil;
    }

      /**
     * Returns the content for the receipt
     *
     * @param  int  $business_id
     * @param  int  $location_id
     * @param  int  $transaction_id
     * @param string $printer_type = null
     *
     * @return array
     */
    private function receiptContent(
        $business_id,
        $location_id,
        $transaction_id,
        $printer_type = null,
        $is_package_slip = false,
        $from_pos_screen = true,
        $invoice_layout_id = null
    ) {
        $output = ['is_enabled' => false,
                    'print_type' => 'browser',
                    'html_content' => null,
                    'printer_config' => [],
                    'data' => []
                ];


        $business_details = $this->businessUtil->getDetails($business_id);
        $location_details = BusinessLocation::find($location_id);
        
        if ($from_pos_screen && $location_details->print_receipt_on_invoice != 1) {
            return $output;
        }
        //Check if printing of invoice is enabled or not.
        //If enabled, get print type.
        $output['is_enabled'] = true;

        $invoice_layout_id = !empty($invoice_layout_id) ? $invoice_layout_id : $location_details->invoice_layout_id;
        $invoice_layout = $this->businessUtil->invoiceLayout($business_id, $location_id, $invoice_layout_id);

        //Check if printer setting is provided.
        $receipt_printer_type = is_null($printer_type) ? $location_details->receipt_printer_type : $printer_type;

        $receipt_details = $this->transactionUtil->getReceiptDetails($transaction_id, $location_id, $invoice_layout, $business_details, $location_details, $receipt_printer_type);

        $currency_details = [
            'symbol' => $business_details->currency_symbol,
            'thousand_separator' => $business_details->thousand_separator,
            'decimal_separator' => $business_details->decimal_separator,
        ];
        $receipt_details->currency = $currency_details;
        
        if ($is_package_slip) {
            $output['html_content'] = view('sale_pos.receipts.packing_slip', compact('receipt_details'))->render();
            return $output;
        }
        //If print type browser - return the content, printer - return printer config data, and invoice format config
        if ($receipt_printer_type == 'printer') {
            $output['print_type'] = 'printer';
            $output['printer_config'] = $this->businessUtil->printerConfig($business_id, $location_details->printer_id);
            $output['data'] = $receipt_details;
        } else {
            $layout = !empty($receipt_details->design) ? 'sale_pos.receipts.' . $receipt_details->design : 'sale_pos.receipts.classic';

            $output['html_content'] = view($layout, compact('receipt_details'))->render();
        }
        
        return $output;
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
                return response()->json(
                    Helper::DataReturn(false,"Akun tidak ditemukan"), 
                400); 
            }

            if($user->status !== "active"){
                return response()->json(
                    Helper::DataReturn(false,"Akun tidak ditemukan"), 
                400); 
            }
            
            if (!Hash::check($request->password, $user->password)){
                return response()->json(
                    Helper::DataReturn(false,"Password anda salah"),
                400); 
            }
     
            $token = Str::random(60);
     
            $user->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();

            $role = [];
            $list_role = $user->roles()->select('name')->get()->pluck('name');
            foreach ($list_role as $key => $value) {
                $role_arr = explode("#",$value);
                $role[] = $role_arr[0];
            }
    
            return Helper::DataReturn(true,"OK",[
                "token" => $token,
                "role" => $role,
                "user_id" => $user->id
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                Helper::DataReturn(false,$th->getMessage(),$request->all()),
            500); 
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
    public function getProducts(Request $request)
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

        $business_type = request()->get('business_type', null);

        $search_fields = request()->get('search_fields', ['name', 'sku']);
        if (in_array('sku', $search_fields)) {
            $search_fields[] = 'sub_sku';
        }

        if($business_type == "hotel"){

            $query = \App\Product::where('products.business_id',$business->id);

            if($request->not_for_selling){
                $query = $query->where("products.not_for_selling",0);
            }

            if($request->brand_id){
                $query = $query->where('products.brand_id',$request->brand_id);
            }

            if($request->kebersihan){
                $query = $query->where('products.product_custom_field2','like',"%$request->kebersihan%");
            }
            
            $query = $query->leftjoin('variations', 'products.id', '=', 'variations.product_id')
            ->leftjoin('brands', 'brands.id', '=', 'products.brand_id')
            ->leftjoin('transaction_sell_lines', 'transaction_sell_lines.product_id', '=', 'products.id')
            ->orderBy('transaction_sell_lines.created_at','desc');

            $result = $query
            ->select(
                'products.id as id',
                'products.name as ROOM NAME',
                'products.not_for_selling as NOT FOR SELL',
                'products.product_custom_field1 as KET. KERUSAKAN',
                'products.product_custom_field2 as KEBERSIHAN',
                "brands.name as TIPE KAMAR",
                "transaction_sell_lines.created_at as LAST CHECK IN",
                'variations.sell_price_inc_tax as selling_price',
                'products.sku as SKU'
            )
            ->groupBy('id')
            ->orderBy('id','asc')
            ->get();
            
            foreach ($result as $key => $value) {
                $result[$key]['selling_price'] = intval($value->selling_price);
                $result[$key]['PRICE'] = number_format($value->selling_price,0,",",".");

                $check = \App\TransactionSellLine::where([
                    'product_id'=>$value['id'],
                ])
                ->whereHas('transaction',function($q){
                    return $q->whereNull('shipping_status');
                })
                ->first();

                $result[$key]['TODAY AVAILABLE'] = empty($check) ? 1 : 0;
                // unset($result[$key]['image_url']);
                // dd($result[$key]);
            }
            
        } else {
            $result = $this->productUtil->filterProductAPI($business_id, $search_term, $location_id, $not_for_selling, $price_group_id, $product_types, $search_fields, $check_qty);
    
            if(env("APP_LOCALE") === "id"){
                foreach ($result as $key => $value) {
                    $result[$key]["selling_price"] = number_format($value->selling_price,0,",",".");
                }
            }
        }

        return response()->json(
            Helper::DataReturn(true,"OK",$result)
            ,200);
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
        return response()->json(
            Helper::DataReturn(true,"OK",$business)
            ,200);
    }

    /**
     * Retrieves list of customers, if filter is passed then filter it accordingly.
     *
     * @param  string  $q
     * @return JSON
     */
    public function getCustomers(Request $request)
    {
        $term = request()->input('q', '');

        $user = request()->user();
        $business = $user->business ?? false;

        $business_id = $business->id;
        $user_id = $user->id;

        $contacts = Contact::where('business_id', $business_id)
                        ->orderBy('id',"desc")
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

        if($request->hotel){ 
            $contacts->select(
                'contacts.id as ID',
                'contacts.name as NAME',
                'mobile as NO HP',
                'address_line_1 as ALAMAT',
                'city as KOTA',
                'state as PROVINSI',
                'landline as NIK'
            )
                    ->onlyCustomers();
        } else {
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
            if (request()->session()->get('business.enable_rp') == 1) {
                $contacts->addSelect('total_rp');
            }
        }

        $contacts = $contacts->get();
        return response()->json(
            Helper::DataReturn(true,"OK",$contacts)
            ,200);
    }

    function storeCustomer(Request $request){
        try {

            $user = request()->user();
            $business = $user->business ?? false;

            $business_id = $business->id;
            $user_id = $user->id;
            $nik = $request->nik ?? "";

            $data = $request->only(['name', 'email','mobile',"address_line_1","city","state"]);

            if($request->insert){
                $customer = Contact::where('business_id', $business_id)
                            ->where('mobile', $data['mobile'])
                            ->whereIn('type', ['customer', 'both'])
                            ->first();
    
                if (!empty($customer)) {
                    return response()->json(
                        Helper::DataReturn(false,"User/Mobile is already registered")
                        ,400);
                }
                    $data['type'] = 'customer';
                    $data['business_id'] = $business_id;
                    $data['created_by'] = $user_id;
                    $data['credit_limit'] = null;
                    $data['landline'] = $nik;
                    // $data['mobile'] = 0;
    
                    $ref_count = $this->commonUtil->setAndGetReferenceCount('contacts', $business_id);
    
                    $data['contact_id'] = $this->commonUtil->generateReferenceNumber('contacts', $ref_count, $business_id);
    
                    $customer = Contact::create($data);
                    return response()->json(
                        Helper::DataReturn(true,"OK")
                    ,200);
            }

            if($request->update){
                $customer = Contact::find($request->id ?? 0);
                if(empty($customer)){
                    return response()->json(
                        Helper::DataReturn(false,"User not found")
                        ,400);
                }
                $data['landline'] = $nik;
                $customer->update($data);
                return response()->json(
                    Helper::DataReturn(true,"OK")
                ,200);
            }

            if($request->delete){
                $customer = Contact::find($request->id ?? 0);
                if(empty($customer)){
                    return response()->json(
                        Helper::DataReturn(false,"User not found")
                        ,400);
                }
                $customer->delete();
                return response()->json(
                    Helper::DataReturn(true,"OK")
                ,200);
            }

            return response()->json(
                Helper::DataReturn(true,"COMMAND NOT FOUND")
            ,400);

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            return response()->json(
                Helper::DataReturn(false,$e->getMessage())
                ,500);
        }
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

    public function store_POS(Request $request)
    {
        $input = $request->except('_token');
        $user = $request->user();
        $business = request()->user()->business;
        $business_id = $business->id;
        $is_direct_sale = false;

        if($request->has('hotel')){

            $product = $request->products[0] ?? null;

            if(empty($product))
            return response()->json(
                Helper::DataReturn(false,"Product not found"), 
            400); 

            $check = \App\TransactionSellLine::where([
                'product_id'=>$product['product_id'],
            ])
            ->whereHas('transaction',function($q){
                return $q->whereNull('shipping_status');
            })
            // ->where('created_at','like', "%".date('Y-m-d')."%" )
            ->first();

            if($check)
            return response()->json(
                Helper::DataReturn(false,"Room sudah ada yang checkin..."), 
            400); 

            $p = \App\Product::where([
                'id'=>$product['product_id'],
                // 'not_for_selling'=> 1
            ])->first();

            if(empty($p) || $p->not_for_selling == 1)
            return response()->json(
                Helper::DataReturn(false,"Room out of service..."), 
            400); 

            $vid = $p->variations()->first()->id ?? 0;

            $p->product_custom_field2 = "OC";
            $p->save();

            $input['products'][0]['variation_id'] = $vid;
        }


        if(!isset($input['location_id']) || empty($input['location_id'])){
            $input['location_id'] = 0;
            $location = $business->locations()->first();
            if(!empty($location))
            $input['location_id'] = $location->id;
        }


        if (!empty($request->input('is_direct_sale'))) {
            $is_direct_sale = true;
        }

        //Check if there is a open register, if no then redirect to Create Register screen.
        if (!$is_direct_sale && $this->cashRegisterUtil->countOpenedRegister() == 0) {
            return Helper::DataReturn(false,"Belum ada buka kasir");
        }

        try {

            //Check Customer credit limit
            $is_credit_limit_exeeded = $this->transactionUtil->isCustomerCreditLimitExeeded($input);

            if ($is_credit_limit_exeeded !== false) {
                $credit_limit_amount = $this->transactionUtil->num_f($is_credit_limit_exeeded, true);
                $output = ['success' => 0,
                            'msg' => __('lang_v1.cutomer_credit_limit_exeeded', ['credit_limit' => $credit_limit_amount])
                        ];
                if (!$is_direct_sale) {
                    return $output;
                } else {
                    return Helper::DataReturn(false,$output["msg"] ?? "");
                }
            }

            $input['is_quotation'] = 0;
            //status is send as quotation from Add sales screen.
            if ($input['status'] == 'quotation') {
                $input['status'] = 'draft';
                $input['is_quotation'] = 1;
            }

            if (!empty($input['products'])) {

                //Check if subscribed or not, then check for users quota
                if (!$this->moduleUtil->isSubscribed($business_id)) {
                    return $this->moduleUtil->expiredResponse(null,1);
                } elseif (!$this->moduleUtil->isQuotaAvailable('invoices', $business_id)) {
                    return $this->moduleUtil->quotaExpiredResponse('invoices', $business_id, null);
                }
        
                $user_id = $user->id;

                $discount = [
                        'discount_type' => $input['discount_type'],
                        'discount_amount' => $input['discount_amount']
                ];
                $invoice_total = $this->productUtil->calculateInvoiceTotal($input['products'], $input['tax_rate_id'], $discount);

                DB::beginTransaction();

                if (empty($request->input('transaction_date'))) {
                    $input['transaction_date'] =  \Carbon::now();
                } else {
                    $input['transaction_date'] = $this->productUtil->uf_date($request->input('transaction_date'), true);
                }
                if ($is_direct_sale) {
                    $input['is_direct_sale'] = 1;
                }

                //Set commission agent
                $input['commission_agent'] = !empty($request->input('commission_agent')) ? $request->input('commission_agent') : null;

                // return $business;
                // $commsn_agnt_setting = $request->session()->get('business.sales_cmsn_agnt');
                $commsn_agnt_setting = $business->sales_cmsn_agnt;

                if ($commsn_agnt_setting == 'logged_in_user') {
                    $input['commission_agent'] = $user_id;
                }

                if (isset($input['exchange_rate']) && $this->transactionUtil->num_uf($input['exchange_rate']) == 0) {
                    $input['exchange_rate'] = 1;
                }

                //Customer group details
                $contact_id = $request->get('contact_id', null);
                $cg = $this->contactUtil->getCustomerGroup($business_id, $contact_id);
                $input['customer_group_id'] = (empty($cg) || empty($cg->id)) ? null : $cg->id;

                //set selling price group id
                $price_group_id = $request->has('price_group') ? $request->input('price_group') : null;

                //If default price group for the location exists
                $price_group_id = $price_group_id == 0 && $request->has('default_price_group') ? $request->input('default_price_group') : $price_group_id;

                $input['is_suspend'] = isset($input['is_suspend']) && 1 == $input['is_suspend']  ? 1 : 0;
                if ($input['is_suspend']) {
                    $input['sale_note'] = !empty($input['additional_notes']) ? $input['additional_notes'] : null;
                }

                //Generate reference number
                if (!empty($input['is_recurring'])) {
                    //Update reference count
                    $ref_count = $this->transactionUtil->setAndGetReferenceCount('subscription');
                    $input['subscription_no'] = $this->transactionUtil->generateReferenceNumber('subscription', $ref_count);
                }

                if (!empty($request->input('invoice_scheme_id'))) {
                    $input['invoice_scheme_id'] = $request->input('invoice_scheme_id');
                }

                //Types of service
                if ($this->moduleUtil->isModuleEnabled('types_of_service')) {
                    $input['types_of_service_id'] = $request->input('types_of_service_id');
                    $price_group_id = !empty($request->input('types_of_service_price_group')) ? $request->input('types_of_service_price_group') : $price_group_id;
                    $input['packing_charge'] = !empty($request->input('packing_charge')) ?
                    $this->transactionUtil->num_uf($request->input('packing_charge')) : 0;
                    $input['packing_charge_type'] = $request->input('packing_charge_type');
                    $input['service_custom_field_1'] = !empty($request->input('service_custom_field_1')) ?
                    $request->input('service_custom_field_1') : null;
                    $input['service_custom_field_2'] = !empty($request->input('service_custom_field_2')) ?
                    $request->input('service_custom_field_2') : null;
                    $input['service_custom_field_3'] = !empty($request->input('service_custom_field_3')) ?
                    $request->input('service_custom_field_3') : null;
                    $input['service_custom_field_4'] = !empty($request->input('service_custom_field_4')) ?
                    $request->input('service_custom_field_4') : null;
                }

                $input['selling_price_group_id'] = $price_group_id;

                if ($this->transactionUtil->isModuleEnabled('tables')) {
                    $input['res_table_id'] = request()->get('res_table_id');
                }
                if ($this->transactionUtil->isModuleEnabled('service_staff')) {
                    $input['res_waiter_id'] = request()->get('res_waiter_id');
                }

                $ref_no = null;
                if($request->has('hotel')){
                    $latest = \App\Transaction::where([
                        'business_id'=>$business_id,
                        "type"=>"sell"
                    ])
                    ->orderBy('id','desc')
                    ->first();
                    $ref_no = empty($latest) || empty($latest->ref_no) ? 1 : $latest->ref_no + 1;
                    if($request->has('reservation_id') && !empty($request->reservation_id)){
                        $reservasi = \App\HotelReservasi::find($request->reservation_id ?? 0);
                        if(!empty($reservasi)){
                            $reservasi->status = "check in";
                            $reservasi->save();
                        }
                    }
                }

                $transaction = $this->transactionUtil->createSellTransaction($business_id, $input, $invoice_total, $user_id);

                if($request->has('hotel')){
                    $transaction->ref_no = $ref_no;
                    $transaction->save();
                }


                $this->transactionUtil->createOrUpdateSellLines($transaction, $input['products'], $input['location_id']);
                
                if (!$is_direct_sale) {
                    //Add change return
                    $change_return = $this->dummyPaymentLine;
                    $change_return['amount'] = $input['change_return'];
                    $change_return['is_return'] = 1;
                    $input['payment'][] = $change_return;
                }

                $is_credit_sale = isset($input['is_credit_sale']) && $input['is_credit_sale'] == 1 ? true : false;

                if (!$transaction->is_suspend && !empty($input['payment']) && !$is_credit_sale) {
                    $this->transactionUtil->createOrUpdatePaymentLines($transaction, $input['payment']);
                }

                $amount = $transaction->final_total;

                if(isset($input['amount'])){
                    $amount = intval( $input['amount'] );
                }

                //Check for final and do some processing.
                if ($input['status'] == 'final') {
                    //update product stock
                    foreach ($input['products'] as $product) {
                        $decrease_qty = $this->productUtil
                                    ->num_uf($product['quantity']);
                        if (!empty($product['base_unit_multiplier'])) {
                            $decrease_qty = $decrease_qty * $product['base_unit_multiplier'];
                        }

                        if ($product['enable_stock']) {
                            $this->productUtil->decreaseProductQuantity(
                                $product['product_id'],
                                $product['variation_id'],
                                $input['location_id'],
                                $decrease_qty
                            );
                        }

                        if ($product['product_type'] == 'combo') {
                            //Decrease quantity of combo as well.
                            $this->productUtil
                                ->decreaseProductQuantityCombo(
                                    $product['combo'],
                                    $input['location_id']
                                );
                        }
                    }

                    //Add payments to Cash Register
                    if (!$is_direct_sale && !$transaction->is_suspend && !empty($input['payment']) && !$is_credit_sale) {
                        $this->cashRegisterUtil->addSellPayments($transaction, $input['payment']);
                    }

                    //Update payment status
                    $this->transactionUtil->updatePaymentStatus($transaction->id, $amount);

                    if ($business->enable_rp == 1) {
                        $redeemed = !empty($input['rp_redeemed']) ? $input['rp_redeemed'] : 0;
                        $this->transactionUtil->updateCustomerRewardPoints($contact_id, $transaction->rp_earned, 0, $redeemed);
                    }

                    //Allocate the quantity from purchase and add mapping of
                    //purchase & sell lines in
                    //transaction_sell_lines_purchase_lines table
                    $business_details = $this->businessUtil->getDetails($business_id);
                    $pos_settings = empty($business_details->pos_settings) ? $this->businessUtil->defaultPosSettings() : json_decode($business_details->pos_settings, true);

                    $business = ['id' => $business_id,
                                    'accounting_method' => $business->accounting_method,
                                    'location_id' => $input['location_id'],
                                    'pos_settings' => $pos_settings
                                ];
                    // dd($business,$transaction->sell_lines);
                    // return $transaction->sell_lines;
                    $this->transactionUtil->mapPurchaseSell($business, $transaction->sell_lines, 'purchase',true,null,'mobile');

                    //Auto send notification
                    $this->notificationUtil->autoSendNotification($business_id, 'new_sale', $transaction, $transaction->contact);
                }

                //Set Module fields
                if (!empty($input['has_module_data'])) {
                    $this->moduleUtil->getModuleData('after_sale_saved', ['transaction' => $transaction, 'input' => $input]);
                }

                Media::uploadMedia($business_id, $transaction, $request, 'documents');

                // activity()
                // ->performedOn($transaction)
                // ->log('added');

                // dd('commited');
                DB::commit();

                if ($request->input('is_save_and_print') == 1) {
                    $url = $this->transactionUtil->getInvoiceUrl($transaction->id, $business_id);
                    $output['data'] = $url;
                    // return redirect()->to($url . '?print_on_load=true');
                }

                $msg = trans("sale.pos_sale_added");
                $receipt = '';
                $invoice_layout_id = $request->input('invoice_layout_id');
                $print_invoice = $request->print ?? false;
                if (!$is_direct_sale) {
                    if ($input['status'] == 'draft') {
                        $msg = trans("sale.draft_added");

                        if ($input['is_quotation'] == 1) {
                            $msg = trans("lang_v1.quotation_added");
                            $print_invoice = true;
                        }
                    } elseif ($input['status'] == 'final') {
                        $print_invoice = true;
                    }
                }

                if ($transaction->is_suspend == 1 && empty($pos_settings['print_on_suspend'])) {
                    $print_invoice = false;
                }
                
                if ($print_invoice) {
                    $receipt = $this->receiptContent($business_id, $input['location_id'], $transaction->id, null, false, true, $invoice_layout_id);
                }

                $output = Helper::DataReturn(true,$msg,["receipt" => $receipt]);
            } else {
                $output = Helper::DataReturn(false,trans("messages.something_went_wrong"));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $msg = trans("messages.something_went_wrong");
                
            if (get_class($e) == \App\Exceptions\PurchaseSellMismatch::class) {
                $msg = $e->getMessage();
            }

            $output = Helper::DataReturn(false,$msg);
        }

        return $output;
    }

    function list_blog(Request $request){
        $page = $request->page ?? 0;
        $take = 10;
        $skip = (intval($page) - 1) * $take;
        $business_id = $request->user()->business->id ?? 0;
        if($request->business){
            $business_id = $request->business;
        }
        $data = \App\Blog::where('business_id',$business_id)
        ->orderBy('id','DESC')
        ->skip($skip)
        ->take(10)
        ->get();
        return Helper::DataReturn(true,"OK",$data);
    }

    function getCheckin(Request $request){

        $date = $request->date ?? date("Y-m-d");
        $status = $request->status ?? null;

        $business_id = $request->user()->business->id ?? 0;
        
        $data = \App\Transaction::with('contact')
        ->with(['sell_lines.product' => function($query) {
            return $query->orderBy('id', 'DESC');
        }])
        ->select("*",
        DB::raw('(SELECT SUM(IF(TP.is_return = 1,-1*TP.amount,TP.amount)) FROM transaction_payments AS TP WHERE
                        TP.transaction_id=transactions.id) as total_paid'),
        )
        ->where('transactions.business_id',$business_id)
        ->where('transactions.type','!=', 'expense')
        ->orderBy('id','desc');

        
        if($status != "all"){
            $data = $data->where("transactions.shipping_status",$status);
        }

        if($request->date){
            $data = $data->where("transactions.transaction_date",'like',"%$date%");
        }
        if($request->history){
            $data = $data->where('shipping_status','delivered');
        }

        if($request->contact_name){
            $name = $request->contact_name ?? "";
            $data = $data->whereHas('contact',function($q) use($name) {
                return $q->where('name','like',"%$name%");
            });
        }

        if($request->start && $request->end){
            $data = $data->whereBetween("transactions.transaction_date",[$request->start,$request->end]);
            // dd($data->count(),$data->toSql());
        }

        $data = $data->get();

        $res = [];

        foreach ($data as $key => $value) {
            $room_name = $value["sell_lines"][0]["product"]["name"] ?? "";
            $contact_name = $value["contact"]["name"] ?? "";

            if($request->history){
                $checkout = \Carbon::parse($value["checkout_at"])->format("d/m/Y");
            } else {
                $checkout = \Carbon::parse($value['transaction_date'])->addDays($value["pay_term_number"])->format("d/m/Y");
            }

            $res[] = [
                "ID"=>$value["id"],
                // "STATUS"=> $value['shipping_status'] == "delivered" ? "Out" : "In",
                "DEPOSIT"=> number_format($value['service_custom_field_3'],0,",","."),
                "TAGIHAN"=> number_format($value["final_total"],0,",","."),
                "DIBAYAR"=> number_format($value["total_paid"],0,",","."),
                "SISA"=> number_format(($value["final_total"] - $value["total_paid"]),0,",","."),
                "METODE PEMBAYARAN"=> $value['service_custom_field_1'],
                "OTA"=> $value['service_custom_field_2'],
                "TGL CHECKIN"=> \Carbon::parse($value['transaction_date'])->format("d/m/Y"),
                "LAMA MENGINAP"=>$value["pay_term_number"],
                "NO KAMAR"=>$room_name,
                "TAMU"=>$contact_name,
                // "No. PAJAK"=>$value['ref_no'],
                "CHECKOUT"=> $checkout,
                "CATATAN"=>$value['staff_note'],
            ];
        }
        
        return Helper::DataReturn(true,"OK",$res);
        
    }

    function checkinList(Request $request){

            $business_id = $request->user()->business->id ?? 0;

            $payment_types = $this->transactionUtil->payment_types(null, true, $business_id);

            $with = [];
            $shipping_statuses = $this->transactionUtil->shipping_statuses();
            $sells = $this->transactionUtil->getListSells($business_id);

            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $sells->whereIn('transactions.location_id', $permitted_locations);
            }

            //Add condition for created_by,used in sales representative sales report
            if (request()->has('created_by')) {
                $created_by = request()->get('created_by');
                if (!empty($created_by)) {
                    $sells->where('transactions.created_by', $created_by);
                }
            }

            if (!empty(request()->input('payment_status')) && request()->input('payment_status') != 'overdue') {
                $sells->where('transactions.payment_status', request()->input('payment_status'));
            } elseif (request()->input('payment_status') == 'overdue') {
                $sells->whereIn('transactions.payment_status', ['due', 'partial'])
                    ->whereNotNull('transactions.pay_term_number')
                    ->whereNotNull('transactions.pay_term_type')
                    ->whereRaw("IF(transactions.pay_term_type='days', DATE_ADD(transactions.transaction_date, INTERVAL transactions.pay_term_number DAY) < CURDATE(), DATE_ADD(transactions.transaction_date, INTERVAL transactions.pay_term_number MONTH) < CURDATE())");
            }

            //Add condition for location,used in sales representative expense report
            if (request()->has('location_id')) {
                $location_id = request()->get('location_id');
                if (!empty($location_id)) {
                    $sells->where('transactions.location_id', $location_id);
                }
            }

            if (!empty(request()->customer_id)) {
                $customer_id = request()->customer_id;
                $sells->where('contacts.id', $customer_id);
            }

            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $sells->whereDate('transactions.transaction_date', '>=', $start)
                            ->whereDate('transactions.transaction_date', '<=', $end);
            }

            if (!empty(request()->input('sub_type'))) {
                $sells->where('transactions.sub_type', request()->input('sub_type'));
            }

            if (!empty(request()->input('created_by'))) {
                $sells->where('transactions.created_by', request()->input('created_by'));
            }

            if (!empty(request()->input('sales_cmsn_agnt'))) {
                $sells->where('transactions.commission_agent', request()->input('sales_cmsn_agnt'));
            }

            if (!empty(request()->input('service_staffs'))) {
                $sells->where('transactions.res_waiter_id', request()->input('service_staffs'));
            }
            $only_shipments = request()->only_shipments == 'true' ? true : false;
            if ($only_shipments && auth()->user()->can('access_shipping')) {
                $sells->whereNotNull('transactions.shipping_status');
            }

            if (!empty(request()->input('shipping_status'))) {
                $sells->where('transactions.shipping_status', request()->input('shipping_status'));
            }
            
            $sells->groupBy('transactions.id');

            $with[] = 'payment_lines';
            if (!empty($with)) {
                $sells->with($with);
            }
            return Helper::DataReturn(true,"OK",$sells->get());
    }

    function checkoutStore(Request $request){
        $t = \App\Transaction::where("id",$request->id)
        ->whereNull('shipping_status')
        ->first();
        if(empty($t))
        return Helper::DataReturn(false,"Data not found");

        $deposit_return = $request->deposit_return ?? 0;
        $amount = $request->amount ?? 0;
        $notes = $request->notes ?? "";

        $payment = [
            "amount"=>$amount,
            "method"=>"cash",
            "note"=>$notes
        ];

        $this->transactionUtil->createOrUpdatePaymentLines($t, [$payment]);
        $this->transactionUtil->updatePaymentStatus($t->id, $amount);

        $total_depo = intval($t->service_custom_field_3) - intval($deposit_return);
        
        $product = $t->sell_lines[0]->product ?? null;

        if(!empty($product)){
            $product->product_custom_field2 = "VD";
            $product->save();
        }



        $t->update([
            "shipping_status"=>"delivered",
            "additional_notes"=>$notes,
            "service_custom_field_3"=>$total_depo,
            "checkout_at"=> \Carbon::now()->format('Y-m-d'),
            "misc_note"=> $request->misc_note ?? null,
            "misc_cost"=> $request->misc_cost ?? 0
        ]);


        return Helper::DataReturn(true,"Data berhasil disimpan!");
    }

    function checkinUpdate(Request $request){
        $t = \App\Transaction::where("id",$request->id)
        ->whereNull('shipping_status')
        ->first();
        if(empty($t))
        return Helper::DataReturn(false,"Data not found");


        $amount = $request->amount ?? 0;
        $notes = $request->notes ?? "";
        $product_id = $request->product_id ?? 0;

        $business_id = $request->user()->business->id ?? 0;
        $location_id = $request->user()->business->locations->first()->id ?? 0;

        $payment = [
            "amount"=>$amount,
            "method"=>"cash",
            "note"=>$notes
        ];

        $product = \App\Product::join('variations', 'products.id', '=', 'variations.product_id')
            ->active()
            ->whereNull('variations.deleted_at')
            ->where('products.id',$product_id)
            ->leftjoin('units as U', 'products.unit_id', '=', 'U.id')
            ->leftjoin(
                'variation_location_details AS VLD',
                function ($join) use ($location_id) {
                    $join->on('variations.id', '=', 'VLD.variation_id');

                    //Include Location
                    if (!empty($location_id)) {
                        $join->where(function ($query) use ($location_id) {
                            $query->where('VLD.location_id', '=', $location_id);
                            //Check null to show products even if no quantity is available in a location.
                            //TODO: Maybe add a settings to show product not available at a location or not.
                            $query->orWhereNull('VLD.location_id');
                        });
                        ;
                    }
                }
            )
            ->select(
                'products.id as product_id',
                'products.name',
                'products.type',
                'products.enable_stock',
                'products.type as product_type',
                'products.unit_id as product_unit_id',
                'products.sub_unit_ids as sub_unit_id',
                'products.tax as tax_id',
                'variations.id as variation_id',
                'variations.name as variation',
                'VLD.qty_available',
                'variations.sell_price_inc_tax as selling_price',
                'variations.sell_price_inc_tax as unit_price',
                'variations.sell_price_inc_tax as unit_price_inc_tax',
                'variations.sub_sku',
                'U.short_name as unit'
            )
            ->groupBy('variations.id')
            ->first();

        $sell_lines = $t->sell_lines()->first();
        $sell_lines->update([
            'product_id'=> $product_id,
            "unit_price_before_discount"=> $product->selling_price,
            "unit_price"=> $product->selling_price,
            "unit_price_inc_tax"=> $product->selling_price
        ]);
        // $t->payment_lines()->delete();
        $this->transactionUtil->createOrUpdatePaymentLines($t, [$payment]);
        $this->transactionUtil->updatePaymentStatus($t->id, $amount);

        if($request->service_custom_field_3){
            $t->update([
                "deposit"=> $request->service_custom_field_3
            ]);
        }

        return Helper::DataReturn(true,"Data berhasil di ubah");

    }

    function hotel_ota(){
        $data = [
            [
                'label'=>"Walk In",
                'value'=>"Walk In"
            ],
            [
                'label'=>"-- Non Aktif --",
                'value'=>"-- Non Aktif --"
            ],
            [
                'label'=>"Traveloka",
                'value'=>"Traveloka"
            ],
            [
                'label'=>"Tiket.com",
                'value'=>"Tiket.com"
            ],
            [
                'label'=>"Agoda",
                'value'=>"Agoda"
            ],
            [
                'label'=>"Booking.com",
                'value'=>"Booking.com"
            ],
            [
                'label'=>"Trivago",
                'value'=>"Trivago"
            ],
            [
                'label'=>"Airbnb",
                'value'=>"Airbnb"
            ],
            [
                'label'=>"TripAdvisor",
                'value'=>"TripAdvisor"
            ],
            [
                'label'=>"Nusatrip",
                'value'=>"Nusatrip"
            ],
            [
                'label'=>"Skyscanner",
                'value'=>"Skyscanner"
            ],
            [
                'label'=>"Expedia",
                'value'=>"Expedia"
            ]
        ];
        return Helper::DataReturn(
            true,
            "OK",
            $data
        );
    }

    function hotel_payment(){
        $data = [
            [
                'label'=>"Cash",
                'value'=>"Cash"
            ],
            [
                'label'=>"Transfer",
                'value'=>"Transfer"
            ],
            // [
            //     'label'=>"Lainnya",
            //     'value'=>"Lainnya"
            // ],
        ];
        return Helper::DataReturn(
            true,
            "OK",
            $data
        );
    }

    function kebersihan_list(){
        $data = [
            [
                'id'=>"OC",
                'name'=>"Ocupied Clean"
            ],
            [
                'id'=>"OD",
                'name'=>"Ocupied Dirty"
            ],
            [
                'id'=>"VC",
                'name'=>"Vacant Clean"
            ],
            [
                'id'=>"VCI",
                'name'=>"Vacant Clean Inspected"
            ],
            [
                'id'=>"VD",
                'name'=>"Vacant Dirty"
            ],
        ];
        return Helper::DataReturn(
            true,
            "OK",
            $data
        );
    }

    function print_trx_id(Request $request){

        $business = request()->user()->business;
        $business_id = request()->user()->business->id;

        $trx_id = $request->trx_id ?? 0;
        $transaction = \App\Transaction::find($trx_id);

        $input = $request->all();

        if(empty($transaction))
        return response()->json(
                Helper::DataReturn(false,"Transaksi tidak ditemukan"), 
            400); 

        if(!isset($input['location_id']) || empty($input['location_id'])){
            $input['location_id'] = 0;
            $location = $business->locations()->first();
            if(!empty($location))
            $input['location_id'] = $location->id;
        }

        $invoice_layout_id = $request->input('invoice_layout_id');

        $receipt = $this->receiptContent(
            $business_id, 
            $input['location_id'], 
            $transaction->id, null, false, true, 
            $invoice_layout_id);
        
        return Helper::DataReturn(
            true,
            "OK",
            $receipt
        );
    }

    function room_update(Request $request){
        $id = $request->id ?? 0;
        $p = \App\Product::find($id);
        if(empty($p))
        return response()->json(
                Helper::DataReturn(false,"Kamar tidak ditemukan"), 
            400); 
        $p->update([
            "not_for_selling" => $request->not_for_selling ?? "",
            "product_custom_field1" => $request->product_custom_field1 ?? "",
            "product_custom_field2" => $request->product_custom_field2 ?? ""
        ]);
        return Helper::DataReturn(
            true,
            "Data berhasil diubah",
            $p
        );
    }

    function hotel_print(Request $request){

        if(!$request->id) return abort(404);
        
        if($request->bill){

            $data['business'] = \App\Business::where('name','like','%kartika%')->first();
            if(empty($data['business']))
            return abort(404);

            $data['transaction'] = \App\Transaction::where([
                "id"=>$request->id,
                "business_id"=> $data['business']->id
            ])
            ->select("*",
            DB::raw('(SELECT SUM(IF(TP.is_return = 1,-1*TP.amount,TP.amount)) FROM transaction_payments AS TP WHERE
                            TP.transaction_id=transactions.id) as total_paid'),
            )
            ->first();
            
            if(empty($data['transaction']))
            return abort(404);
    
            // $data['business'] = $data['transaction']->business;
            $data['location'] = $data['business']->locations()->first();
    
            $data['transaction_sell_line'] = $data['transaction']->sell_lines;
    
            $data['contact'] = DB::table('contacts')->find($data['transaction']->contact_id);

            $data['just'] = $request->just ?? null;

            return view('hotel.print.bill',$data);
        }

        $data['business'] = \App\Business::where('name','like','%kartika%')->first();
        if(empty($data['business']))
        return abort(404);
        $data['location'] = $data['business']->locations()->first();

        if($request->checkin){

            $data['transaction'] = \App\Transaction::find($request->id);
            
            return view('hotel.print.checkin_card',$data);
        }

        $data['reservasi'] = \App\HotelReservasi::find($request->id);
        if(empty($data['reservasi']))
        return abort(404);

        return view('hotel.print.registered_card',$data);
    }

    function hotel_room_print(Request $request){
        $query = \App\Product::where('products.business_id',$request->business_id);

        if($request->not_for_selling){
            $query = $query->where("products.not_for_selling",0);
        }

        if($request->brand_id){
            $query = $query->where('products.brand_id',$request->brand_id);
        }

        if($request->kebersihan){
            $query = $query->where('products.product_custom_field2','like',"%$request->kebersihan%");
        }
        
        $query = $query->leftjoin('variations', 'products.id', '=', 'variations.product_id')
        ->leftjoin('brands', 'brands.id', '=', 'products.brand_id')
        ->leftjoin('transaction_sell_lines', 'transaction_sell_lines.product_id', '=', 'products.id')
        ->orderBy('transaction_sell_lines.created_at','desc');

        $result = $query
        ->select(
            'products.id as id',
            'products.name as ROOM NAME',
            'products.not_for_selling as NOT FOR SELL',
            'products.product_custom_field1 as KET. KERUSAKAN',
            'products.product_custom_field2 as KEBERSIHAN',
            "brands.name as TIPE KAMAR",
            "transaction_sell_lines.created_at as LAST CHECK IN",
            'variations.sell_price_inc_tax as selling_price',
            'products.sku as SKU'
        )
        ->groupBy('id')
        ->orderBy('id','asc')
        ->get();
        
        foreach ($result as $key => $value) {
            $result[$key]['selling_price'] = intval($value->selling_price);
            $result[$key]['PRICE'] = number_format($value->selling_price,0,",",".");

            $check = \App\TransactionSellLine::where([
                'product_id'=>$value['id'],
            ])
            ->whereHas('transaction',function($q){
                return $q->whereNull('shipping_status');
            })
            ->first();

            $result[$key]['TODAY AVAILABLE'] = empty($check) ? 1 : 0;
            // unset($result[$key]['image_url']);
            // dd($result[$key]);
        }

        $data['result'] = $result->toArray();
        
        return view('hotel.print.room',$data);
    }

    function brands_list(Request $request){
        $business_id = request()->user()->business->id;
        $list = \App\Brands::where('business_id',$business_id)->get();
        return response()->json(
            Helper::DataReturn(true,"OK",$list), 
        200); 
    }

    function fcm_token_store(Request $request) {
        $input = $request->all();
        $user = $request->user() ?? null;
        $new_data = [
            'token' => $input['token'],
            'devices' => json_encode($input['devices'] ?? null),
            'business_id' => $user->business->id ?? null,
            'user_id' => $user->id ?? null,
        ];
        FCMToken::create($new_data);
        return response()->json(
            Helper::DataReturn(true,"OK"), 
        200); 
    }
    
    // function hotel_print(Request $request){

    //     if(!$request->id) return abort(404);
        
    //     if($request->bill){

    //         $data['business'] = \App\Business::where('name','like','%kartika%')->first();
    //         if(empty($data['business']))
    //         return abort(404);

    //         $data['transaction'] = \App\Transaction::where([
    //             "id"=>$request->id,
    //             "business_id"=> $data['business']->id
    //         ])
    //         ->select("*",
    //         DB::raw('(SELECT SUM(IF(TP.is_return = 1,-1*TP.amount,TP.amount)) FROM transaction_payments AS TP WHERE
    //                         TP.transaction_id=transactions.id) as total_paid'),
    //         )
    //         ->first();
            
    //         if(empty($data['transaction']))
    //         return abort(404);
    
    //         // $data['business'] = $data['transaction']->business;
    //         $data['location'] = $data['business']->locations()->first();
    
    //         $data['transaction_sell_line'] = $data['transaction']->sell_lines;
    
    //         $data['contact'] = DB::table('contacts')->find($data['transaction']->contact_id);
    //         return view('hotel.print.bill',$data);
    //     }

    //     $data['business'] = \App\Business::where('name','like','%kartika%')->first();
    //     if(empty($data['business']))
    //     return abort(404);
    //     $data['location'] = $data['business']->locations()->first();

    //     if($request->checkin){

    //         $data['transaction'] = \App\Transaction::find($request->id);

    //         return view('hotel.print.checkin_card',$data);
    //     }
        
    //     $data['reservasi'] = \App\HotelReservasi::find($request->id);
    //     if(empty($data['reservasi']))
    //     return abort(404);

    //     return view('hotel.print.registered_card',$data);
    // }

    public function checkInvoiceNo(Request $request){
        // return "OK";
        // dd($request->all());
        if(
            !$request->has('invoice_no') ||
            empty($request->invoice_no)
        ){
            return ['status'=>false,'msg'=>'Bad request'];
        }
        $business = $request->user()->business;
        $location_id = $request->location_id ?? null;
        $exclude = $request->exclude ?? null;
        return $this->transactionUtil->checkInvoiceNo(
            $request->invoice_no,
            $business->id,
            $location_id,
            $exclude
        );
    }

    function deleteAccount(Request $request){
        try {
            
            $user = $request->user();
            $user->status = 'terminated';
            $user->save();
            return response()->json(
                Helper::DataReturn(true,"Akun berhasil di hapus..."), 
            200);             
        } catch (\Throwable $th) {
            return response()->json(
                Helper::DataReturn(false,"Akun tidak ditemukan"), 
            400); 
        }
    }


}
