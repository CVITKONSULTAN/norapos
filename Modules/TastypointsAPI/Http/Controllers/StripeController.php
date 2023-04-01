<?php

namespace Modules\TastypointsAPI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\TastypointsAPI\Entities\WalletUserTest;
use Modules\TastypointsAPI\Entities\WalletUserLogTest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use Validator;

class StripeController extends Controller
{
    protected $key = "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";

    public function list(Request $request)
    {
            $limit = $request->limit ?? 100;

            $type = $request->type ?? "customers";

            if(isset($request->delete)){
                $command = "curl https://api.stripe.com/v1/customers/".$request->customer_id." -u ".$this->key.": -X DELETE";
                $result = shell_exec($command);
                return $result;
            }

            $command = "curl https://api.stripe.com/v1/".$type." -u ".$this->key.":  -d limit=".$limit." ";
            if(isset($request->starting_after)){
                $command .= "-d starting_after=".json_encode($request->starting_after);
                DD($command);
            }
            $command .= "-G";
            $result = shell_exec($command);

            if($type == "payouts"){
                $command = "curl https://api.stripe.com/v1/balance -u ".$this->key.": -G";
                $x = shell_exec($command);
                $x = \json_decode($x,true);
                $result = \json_decode($result,true);
                $result["balance"] = $x;
                $result = \json_encode($result);
            }
            

            return $result;
    }

    public function customers(Request $request)
    {
        try{
            $data = $request->all();
            $validator = Validator::make($data,[
                "user_id"=>"required",
                "stripe_key"=>"required",
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return ["status"=>false,"message"=>$error];
            }

            $user = WalletUserTest::where("user_id",$request->user_id)
            ->first();

            if(!empty($user)){
                $data = $user;
            } else {
                $data["balance"] = 0;
                $data = WalletUserTest::create($data);
            }

            return ["status"=>true,"message"=>"OK","data"=>$data];
        } catch(\Exception $e){
            return ["status"=>false,"message"=>$e->getMessage()];
        }
    }

    public function update_balance(Request $request)
    {
        try{
            $data = $request->all();
            $validator = Validator::make($data,[
                "user_id"=>"required",
                "stripe_key"=>"required",
                "balance"=>"required"
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return ["status"=>false,"message"=>$error];
            }

            $user = WalletUserTest::where([
                "user_id"=>$request->user_id
            ])
            ->first();

            if(empty($user)){
                return ["status"=>false,"message"=>"user_not_found","data"=>$data];
            }

            $user->balance = $user->balance + floatval($request->balance);
            $user->save();

            return ["status"=>true,"message"=>"OK"];
        } catch(\Exception $e){
            return ["status"=>false,"message"=>$e->getMessage()];
        }
    }
    public function update_response(Request $request)
    {
        try{
            $data = $request->all();
            $validator = Validator::make($data,[
                "user_id"=>"required",
                "type"=>"required",
                "response"=>"required",
            ]);

            $user = WalletUserTest::where([
                "user_id"=>$request->user_id,
            ])
            ->first();

            if(empty($user)){
                return ["status"=>false,"message"=>"user_not_found","data"=>$data];
            }
            $data["response"] = json_encode($data["response"]);
            WalletUserLogTest::create($data);

            return ["status"=>true,"message"=>"OK"];
        } catch(\Exception $e){
            return ["status"=>false,"message"=>$e->getMessage()];
        }
    }

    public function list_test(Request $request)
    {
        $data = [];

        if(!$request->has("type")) 
        return["status"=>false,"message"=>"Bad Request"];

        switch ($request->type) {
            case 'customers':
                $data = WalletUserTest::all();
                break;
            case 'customers-logs':
                    $data = WalletUserLogTest::orderBy("created_at","desc");
                    if($request->has("user_id")){
                        $data = $data->where("user_id",$request->user_id);
                    }
                    $data = $data->get();
                break;
            
            default:
                return["status"=>false,"message"=>"Bad Request"];
                break;
        }
        return ["status"=>true,"message"=>"OK","data"=>$data];
    }

    public function test()
    {
        WalletUserTest::truncate();
        return true;
    }

    public function paypal_log_data(Request $request)
    {
        return datatables()
        ->of(WalletUserLogTest::where("origin","Paypal")->orderBy("id","desc"))
        ->editColumn("response",function($q){
            // DD($q->response);
            return \json_decode($q->response,true);
        })
        ->toJson(true);
    }

}
