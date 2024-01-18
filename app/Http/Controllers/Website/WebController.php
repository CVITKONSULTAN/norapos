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
                'type'=>'ewallet',
                'image'=>asset('img/ewalelt_dana.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/main_BCA.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/ewalelt_dana.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/main_BCA.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/ewalelt_dana.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/main_BCA.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/ewalelt_dana.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/main_BCA.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/ewalelt_dana.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/main_BCA.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/ewalelt_dana.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/main_BCA.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/ewalelt_dana.png')
            ],
            [
                'type'=>'main',
                'image'=>asset('img/main_BCA.png')
            ],
            [
                'type'=>'ewallet',
                'image'=>asset('img/ewalelt_dana.png')
            ],
        ]);
        return view('website.index',$data);
    }
}
