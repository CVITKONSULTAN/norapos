<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class CardLogController extends Controller
{

    function index(Request $request){
        return view('hotel.card.index');
    }

    function data(Request $request) {
        $query = \App\CardLog::query()
        ->with('user','product','contact');
        return Datatables::of($query)->make(true);
    }

    function store(Request $request){

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        \App\CardLog::create($data);

        return ['status'=>true,"message"=>"Data saved successfully"];
    }
}
