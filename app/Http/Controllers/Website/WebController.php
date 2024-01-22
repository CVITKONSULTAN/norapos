<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index(Request $request){
        //web langdingpages
        $data['payment_channel'] = collect([
            [
                'type'=>'main',
                'image'=>asset('img/main_BCA.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/logo bni.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/logo mandiri.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/BANK_BRI_logo.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/Bank-Permata.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/Logo_Panin_Bank.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/Danamon.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/SeaBank.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/ewalelt_dana.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/LinkAja.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/logo_gopay.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/Logo_ovo_purple 1.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/logo_shopeepay.png')
            ],
        ]);
        return view('website.index',$data);
    }
}
