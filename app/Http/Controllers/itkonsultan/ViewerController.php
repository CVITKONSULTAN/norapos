<?php

namespace App\Http\Controllers\itkonsultan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\itkonsultan\UserPhones;
use App\Models\itkonsultan\BusinessProduct;

class ViewerController extends Controller
{
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
            // dd($data);
            return view('itkonsultan.jap-form',$data);
        }
    }

    function landing_payment(Request $request){
        $data = $request->all();
        return view('itkonsultan.landing-payment',$data);
    }
}
