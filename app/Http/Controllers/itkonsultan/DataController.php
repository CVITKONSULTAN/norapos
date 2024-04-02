<?php

namespace App\Http\Controllers\itkonsultan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;
use Hash;
use Log;

use App\Helpers\Helper;
use App\Models\itkonsultan\UserPhones;
use App\Models\itkonsultan\BusinessTransaction;
use App\Models\itkonsultan\BusinessProduct;
use App\Models\itkonsultan\BusinessDomain;

class DataController extends Controller
{
    function store_data_phone(Request $request){

        $data = $request->all();

        if(!$request->has('business_domain_id')){
            $business = BusinessDomain::where('domain','https://listrikanda.com/')->first();
            if(!empty($business)){
                $data['business_domain_id'] = $business->id;
            }
        }

        $user = UserPhones::where('uid',$request->uid)
        ->orWhere('fcmToken',$request->fcmToken)
        ->first();

        if(empty($user)) {
            $user = UserPhones::create($data);
            return Helper::DataReturn(true,"OK",$user);
        }

        if($request->has('delete')){
            $user->update(['deleted_at'=>date('Y-m-d H:i:s')]);
            return Helper::DataReturn(true,"Data berhasil dihapus",$user);
        }

        unset($data['uid']);

        $user->update($data);

        return Helper::DataReturn(true,"Data berhasil diubah",$user);
    }

    function store_transaction(Request $request){

        $user = UserPhones::where('uid',$request->uid)
        ->first();

        if($user->transaction()->count() === 0){
            $user->update($request->all());
        }

        $input = [
            'user_phones_id' => $user->id,
            'metadata'=>$request->all(),
            'category'=>$request->category,
            'title'=>$request->title,
            'status'=>'proses'
        ];

        $b = BusinessTransaction::create($input);
        
        $product = BusinessProduct::find($request->product_id ?? null);

        if(
            !empty($product)
            // $request->category === "nidi"
        ){


            $client = new \GuzzleHttp\Client();
            $endpoint = "https://development.norapos.com/midtrans/index.php";
            $request = $client->request('POST', $endpoint, [
                'form_params' => [
                    "data" => [
                        "customer_details" => [
                            'first_name'       => $request->name,
                            'last_name'        => " ",
                            'email'            => $request->email,
                            'phone'            => $request->nohp,
                        ],
                        "transaction_details" => [
                            'order_id'    => $b->id,
                            'gross_amount'  => $product->price
                        ]
                    ]
                ]
            ]);
            $response = $request->getBody()->getContents();
            // return $b;
            // $metadata = json_decode($b->metadata ?? "[]",true);
            $metadata = $b->metadata ?? [];
            $metadata['midtrans'] = json_decode($response,true);
            $metadata['midtrans']['redirect'] = true;
            $b->metadata = $metadata;
            $b->status = 'menunggu pembayaran';
            $b->save();
            return Helper::DataReturn(true,"Lanjutkan proses pembayaran...",[
                'redirect'=>true,
                'data'=> json_decode($response,true)
            ]);
        }

        $tmp = $b->created_at->format('d/m/Y H:i');
        $status = strtoupper($b->status);
        $user = UserPhones::where('isAdmin',1)
        ->first();

        Helper::sendPush([
            'token'=>$user->fcmToken,
            'title'=>"Pesanan masuk $b->title #$b->id - $tmp",
            'body' => "Silahkan proses pesanan $b->title",
            "payload"=>[
                'title'=>"Pesanan masuk $b->title #$b->id - $tmp",
                'body' => "Silahkan proses pesanan $b->title",
                'type' => 'admin'
            ]
        ]);

        return Helper::DataReturn(true,"Data berhasil ditambahkan",$b);

    }

    function store_profile(Request $request){

        $user = UserPhones::where('uid',$request->uid)
        ->first();

        if(empty($user))
        return Helper::DataReturn(false,"Data not found");

        $data = $request->all();

        $user->update($data);

        return Helper::DataReturn(true,"Data berhasil disimpan");

    }

    function seed_japlin(){
        BusinessProduct::whereNull('category_slug')->update(['category_slug'=>'nidi']);
        BusinessProduct::create([
            'name' => 'Panggilan Konsleting Listrik',
            'description' => 'Panggilan Konsleting Listrik',
            'price' => 70000,
            'business_id' => 1,
            'category_slug' => 'panggilan-listrik',
        ]);
        BusinessProduct::create([
            'name' => 'Instalasi Listrik',
            'description' => 'Instalasi Listrik',
            'price' => 70000,
            'business_id' => 1,
            'category_slug' => 'instalasi-listrik',
        ]);
        return "OK";
    }

    function history_transaction(Request $request){

        if($request->has('adminToken')){

            $user = UserPhones::where([
                'isAdmin'=>1,
                'adminToken'=> $request->adminToken
            ])
            ->first();

            if(empty($user))
            return Helper::DataReturn(false,"User not found");

            $data = BusinessTransaction::whereIn('status',$request->status);

        } else {
            $user = UserPhones::where('uid',$request->uid)
            ->first();
            $data = BusinessTransaction::where('user_phones_id',$user->id);
        }

        $take = 10;
        $page = $request->page ?? 1;
        $skip = $take * (intval($page) - 1);
        $data = $data->orderBy('id','desc')->skip($skip)->take($take)->get();

        return Helper::DataReturn(true,"OK",$data);
    }

    function next_payment(Request $request){
        $data['user'] = UserPhones::where('uid',$request->uid)
        ->first();
        $data['data'] = BusinessTransaction::where([
            'user_phones_id'=>$data['user']->id,
            'id'=>$request->id
        ])->first();

        if(!isset($data['data']->metadata['midtrans']))
        return redirect()->back()->with([
            'status'=>'error',
            'message'=> 'Invalid mid-trans'
        ]);

        $midtrans = $data['data']->metadata['midtrans'];
        return redirect()->to($midtrans['token_url']);
    }

    function setup_admin(Request $request){

        $email = "admin@itkonsultan.co.id";
        $data['user'] = UserPhones::where('email',$email)
        ->first();
        // dd($data['user']);
        $data['user']->password = bcrypt($data['user']->password);
        $data['user']->save();

        return $data;

    }

    function login_admin(Request $request){
        $user = UserPhones::where('email',$request->email)
        ->first();

        if(empty($user))
        return Helper::DataReturn(false,"Email tidak ditemukan..");

        if(Hash::check($request->password,$user->password))
        return Helper::DataReturn(false,"Password salah, periksa kembali...");

        $data['adminToken'] = Str::uuid()->toString();

        $log_uid = [];
        try {
            $log_uid = json_decode($user->log_uid,true);
        } catch (\Throwable $th) {
            $log_uid = [];
        }
        $log_uid[] = $request->all();
        $data['log_uid'] =  json_encode($log_uid);

        if($request->has("fcmToken")){
            $data['fcmToken'] = $request->fcmToken;
        }

        $user->update($data);
        
        return Helper::DataReturn(true,"OK",["token"=>$data['adminToken']]);

    }

    function admin_change_status(Request $request){
        $user = UserPhones::where([
            'isAdmin'=>1,
            'adminToken'=> $request->adminToken
        ])
        ->first();

        if(empty($user))
        return Helper::DataReturn(false,"User not found");

        $data = BusinessTransaction::find($request->id);

        
        if(empty($data))
        return Helper::DataReturn(false,"Data not found");

        $data->status = $request->status;
        $data->save();

        $tmp = $data->created_at->format('d/m/Y H:i');
        $status = strtoupper($request->status);
        Helper::sendPush([
            'token'=>$data->user->fcmToken,
            'title'=>"PESANAN $status #$data->id - $tmp",
            'body' => "$data->title telah dinyatakan $status",
            "payload"=>[
                'title'=>"PESANAN $status #$data->id - $tmp",
                'body' => "$data->title telah dinyatakan $status",
                'type' => 'user'
            ]
        ]);
        
        return Helper::DataReturn(true,"Data berhasil disimpan",$data);
    }

    function history_transaction_rekap(Request $request){


        $user = UserPhones::where([
            'isAdmin'=>1,
            'adminToken'=> $request->adminToken
        ])
        ->first();

        if(empty($user))
        return Helper::DataReturn(false,"User not found");

        $data = [
            'menunggu pembayaran' => 0,
            'proses' => 0,
            'selesai' => 0,
            'batal' => 0,
            'total' => BusinessTransaction::count(),
        ];
        foreach ($data as $key => $value) {
            if($key === "total") continue;
            $data[$key] = BusinessTransaction::where('status',$key)->count();
        }

        return Helper::DataReturn(true,"OK",$data);
    }

    function midtrans_notify(Request $request){

        $data = $request->all();
        $serverkey = 'SB-Mid-server-LOrTnklwFV5riW1uZxbpncvT';
        // $headers = collect($request->header())->transform(function ($item) {
        //     return $item[0];
        // });
        // Log::info( "midtrans callback headers >> ".json_encode($headers));
        Log::info( "midtrans callback >> ".json_encode($data));
        $gross_amount = $request->gross_amount ?? "";
        $status_code = $request->status_code ?? "";
        $order_id = $request->order_id ?? "";

        $str = $order_id.$status_code.$gross_amount.$serverkey;
        $hash = hash('sha512', $str);
        if($hash !== $request->signature_key) return [
            'status'=>false,
            'message'=>"Bad Request (403)"
        ];

        $data = BusinessTransaction::where('id',$order_id)->first();
        
        if(empty($data)) return [
            'status'=>false,
            'message'=>"Data not found (403)"
        ];

        $success = [
            // 'settlement',
            'capture'
        ];
        
        if(in_array($request->transaction_status,$success)){
            $data->status = 'proses';
            $data->save();

            //get admin
            $user = UserPhones::where('isAdmin',1)
            ->first();
            $tmp = $data->created_at->format('d/m/Y H:i');
            $status = strtoupper($data->status);
            Helper::sendPush([
                'token'=>$user->fcmToken,
                'title'=>"Pesanan masuk $data->title #$data->id - $tmp",
                'body' => "Silahkan proses pesanan $data->title",
                "payload"=>[
                    'title'=>"Pesanan masuk $data->title #$data->id - $tmp",
                'body' => "Silahkan proses pesanan $data->title",
                    'type' => 'admin'
                ]
            ]);
            // end admin notif

        } else
        if($request->transaction_status === 'pending' || $request->transaction_status === 'authorize'){
            $data->status = 'menunggu pembayaran';
            $data->save();
        } else {
            $data->status = 'batal';
            $data->save();
            //get user notif
            $user = $data->user;
            $tmp = $data->created_at->format('d/m/Y H:i');
            $status = strtoupper($data->status);
            Helper::sendPush([
                'token'=>$user->fcmToken,
                'title'=>"Pesanan $status $data->title #$data->id - $tmp",
                'body' => "$data->title telah berakhir...",
                "payload"=>[
                    'title'=>"Pesanan $status $data->title #$data->id - $tmp",
                    'body' => "$data->title telah berakhir...",
                    'type' => 'user'
                ]
            ]);
            // end user notif
        }

    }

    function seed_norapos(){
        $business = BusinessDomain::where('domain','https://listrikanda.com/')->first();
        if(empty($business)) return "business not found";
        UserPhones::whereNull('business_domain_id')->update(['business_domain_id'=> $business->id]);
        $business = BusinessDomain::create([
            'domain' => 'https://norapos.com',
            'business_name' => 'norapos_mobile',
        ]);
        return "OK";
    }

}
