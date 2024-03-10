<?php

namespace App\Http\Controllers\itkonsultan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;

use App\Helpers\Helper;
use App\Models\itkonsultan\UserPhones;
use App\Models\itkonsultan\BusinessTransaction;
use App\Models\itkonsultan\BusinessProduct;

class DataController extends Controller
{
    function store_data_phone(Request $request){

        $data = $request->all();

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

    function midtrans_notify(Request $request){
        info($request->all());
    }

    function store_transaction(Request $request){

        $user = UserPhones::where('uid',$request->uid)
        ->first();

        if($user->transaction()->count() === 0){
            $user->update($request->all());
        }

        $input = [
            'user_phones_id' => $user->id,
            'metadata'=>json_encode($request->all()),
            'category'=>$request->category,
            'title'=>$request->title
        ];

        $b = BusinessTransaction::create($input);
        
        if($request->category === "nidi"){

            $product = BusinessProduct::find($request->product_id);

            $client = new \GuzzleHttp\Client();
            $endpoint = "https://2cca-27-124-95-229.ngrok-free.app/midtrans/index.php";
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
            $metadata = json_decode($b->metadata,true);
            $metadata['midtrans'] = json_decode($response,true);
            $metadata['midtrans']['redirect'] = true;
            $b->metadata = json_encode($metadata);
            $b->save();
            return Helper::DataReturn(true,"Lanjutkan proses pembayaran...",[
                'redirect'=>true,
                'data'=> json_decode($response,true)
            ]);
        }

        return Helper::DataReturn(true,"Data berhasil ditambahkan",$b);

    }
}
