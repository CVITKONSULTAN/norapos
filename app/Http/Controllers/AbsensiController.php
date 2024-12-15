<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use DB;

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
        
        $data = \App\Absensi::where('business_id', $user->business_id)
        ->orderBy('id','desc')
        ->select('*');

        if($request->grouping){

            $date = Carbon::now()->format("Y-m-d");
            $filter_tanggal = $request->filter_tanggal ?? $date;
            
            $data = $data->addSelect(DB::raw('DATE(created_at) as created_date'))
                    ->having('created_date', '=', $filter_tanggal);

            $data = $data->get()->groupBy('user_id');

            $row = [];
            foreach ($data as $key => $value) {

                // dd();
                // $nama = $value[0]->user->name ?? "";
                $nama = $value[0]->user->getUserFullNameAttribute() ?? "";

                $masuk_data = $value->where('tipe','masuk')->first();
                $pulang_data = $value->where('tipe','pulang')->first();

                $row[] = [
                    "created_at" => $key,
                    "nama"=>$nama,
                    "jam_masuk"=> $masuk_data->created_at->format("H:i:s") ?? null,
                    "foto_masuk"=> $masuk_data->picture ?? null,
                    "koordinat_masuk"=> $masuk_data->coordinates ?? null,
                    "jam_pulang"=> $pulang_data->created_at->format("H:i:s") ?? null,
                    "foto_pulang"=> $pulang_data->picture ?? null,
                    "koordinat_pulang"=> $pulang_data->coordinates ?? null,
                ];
            }
            return Datatables::of($row)->make(true);
        }
        
        $check = $user->checkAdmin();
        $checkHrd = $user->checkHRD();

        if(
            !$check && !$checkHrd
        ){
            $data = $data->where('user_id',$user->id);
        }

        // dd( $data->groupBy('created_at')->get() );

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
