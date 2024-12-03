<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use \Carbon\Carbon;

class AbsensiController extends Controller
{
    public function create()  
    {
        return view('absensi.create');
    }

    public function index()
    {
        return view('absensi.index');
    }

    public function data(Request $request)
    {
        $user = $request->user();
        $data = \App\Absensi::where('business_id', $user->business_id);
        // $check = $user->roles->filter(function ($item) { return false !== stristr($item->name, "admin"); })->count();
        $check = $user->checkAdmin();
        $checkHrd = $user->checkHRD();

        if(
            !$check && !$checkHrd
        ){
            $data = $data->where('user_id',$user->id);
        }

        return Datatables::of($data)
        ->addColumn("name",function($q){
            return $q->user->first_name." ".$q->user->last_name;
        })
        ->addColumn("total_hours",function($q){
            if($q->tipe === "masuk") return null;
            $check = \App\Absensi::where("tipe","masuk")
            ->whereDate("created_at",$q->created_at->format('Y-m-d'))->first();
            if(empty($check)) return null;
            $hours_time = $check->created_at->diff($q->created_at)->format('%H:%I:%S');
            return $hours_time;
        })
        ->make(true);
    }

    public function store(Request $request)
    {
        try {
            $input = $request->all();
            if($request->delete){
                \App\Absensi::where('id',$request->id)->delete();
                return [
                    "status"=>true,
                    "message"=>"Data berhasil dihapus",
                ];
            }
            $today = Carbon::now();
            $user = $request->user();
            $check = \App\Absensi::where('user_id',$user->id)
            ->whereDate("created_at",$today->format("Y-m-d"))->count();
            $input["tipe"] = $check === 0 ? "masuk" : "pulang";
            $input["user_id"] = $user->id;
            $input["business_id"] = $user->business_id;
            \App\Absensi::create($input);
            return [
                "status"=>true,
                "message"=>"Data berhasil disimpan",
            ];
        } catch (\Throwable $th) {
            return [
                "status"=>false,
                "message"=>$th->getMessage()." line:".$th->getLine(),
                "data"=>$request->user()
            ];
        }
    }
}
