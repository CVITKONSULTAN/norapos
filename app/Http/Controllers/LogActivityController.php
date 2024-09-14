<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\LogActivity;

class LogActivityController extends Controller
{
    public function data(Request $request) {
        $data = LogActivity::with('user');
        if($request->column && $request->search){
            $kolom = $request->column ?? [];
            $nilai = $request->search ?? [];
            foreach($kolom as $k => $val){
                $search = $nilai[$k] ?? "";
                $data->where($val,$search);
            }
        }
        return DataTables::of($data)->make(true);
    }
}
