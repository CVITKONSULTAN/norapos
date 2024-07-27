<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardLogController extends Controller
{
    function store(Request $request){

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        \App\CardLog::create($data);

        return ['status'=>true,"message"=>"Data saved successfully"];
    }
}
