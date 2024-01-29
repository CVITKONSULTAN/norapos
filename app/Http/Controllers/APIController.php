<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Str;
use Hash;
use DB;


use App\Helpers\Helper;

use App\BusinessLocation;

use App\Charts\CommonChart;
use App\Currency;
use App\Transaction;
use App\Utils\BusinessUtil;

use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use App\VariationLocationDetails;
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
        Util $commonUtil
    ) {
        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
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


}
