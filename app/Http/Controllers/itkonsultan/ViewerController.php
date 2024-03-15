<?php

namespace App\Http\Controllers\itkonsultan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\itkonsultan\UserPhones;
use App\Models\itkonsultan\BusinessProduct;
use App\Models\itkonsultan\BusinessTransaction;

class ViewerController extends Controller
{

    function detail(Request $request){
        $data = $request->all();
        if($request->has('jap')){

            if($request->has('token')){

                $data['user'] = UserPhones::where([
                    'adminToken'=>$data['token'],
                    'isAdmin'=>1
                ])->first();

                $data['data'] = BusinessTransaction::where([
                    'id'=>$request->id
                ])->first();

            } else {
                $data['user'] = UserPhones::where('uid',$data['uid'])->first();
                
                $data['data'] = BusinessTransaction::where([
                    'user_phones_id'=>$data['user']->id,
                    'id'=>$request->id
                ])
                ->first();
            }

            if($data['data']->category === "nidi"){
                // dd($data['data']->metadata);
                $data['product'] = BusinessProduct::where('id',
                $data['data']->metadata['product_id']
                )
                ->first();
            }

            if($request->has('token')){
                return view('itkonsultan.jap-detail-admin',$data);
            } else {
                return view('itkonsultan.jap-detail',$data);
            }
        }
    }

    function profile(Request $request){
        $data = $request->all();
        if($request->has('jap')){
            $wc = new WilayahController;
            $provinsi = $wc->getData($request);
            $data['provinsi'] = $provinsi['status'] ? $provinsi['data'] : [];
            $data['user'] = UserPhones::where('uid',$data['uid'])->first();
            return view('itkonsultan.jap-profile',$data);
        }
    }

    function form(Request $request){
        $data = $request->all();
        if($request->has('jap')){
            $wc = new WilayahController;
            $provinsi = $wc->getData($request);
            $data['provinsi'] = $provinsi['status'] ? $provinsi['data'] : [];
            $data['user'] = UserPhones::where('uid',$data['uid'])->first();
            if(!empty($request->jap) && $request->jap === "nidi"){
                $data['products'] = BusinessProduct::all();
            }
            return view('itkonsultan.jap-form',$data);
        }
    }

    function landing_payment(Request $request){
        $data = $request->all();
        return view('itkonsultan.landing-payment',$data);
    }
}
