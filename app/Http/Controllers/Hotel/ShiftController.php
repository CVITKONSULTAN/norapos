<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use DB;
use App\Models\Hotel\ShiftLog;

class ShiftController extends Controller
{
    public function create()  
    {
        return view('shift.create');
    }

    public function index()
    {
        return view('shift.index');
    }

    function index_all(Request $request){
        return view('shift.index_all');
    }

    public function data(Request $request)
    {
        $user = $request->user();
        
        $data = ShiftLog::where('business_id', $user->business_id)
        ->orderBy('created_at','desc')
        ->select('*');
        
        $check = $user->checkAdmin();
        $checkHrd = $user->checkHRD();

        if(
            !$check && !$checkHrd
        ){
            $data = $data->where('user_id',$user->id);
        }

        if(!empty($request->start) && !empty($request->end)){
            $between = [$request->start,$request->end];
            $data = $data->whereBetween('created_at',$between);
        }

        return Datatables::of($data)
        ->addColumn("name",function($q){
            return $q->user->first_name." ".$q->user->last_name;
        })
        ->addColumn("reviewer_name",function($q){
            if(empty($q->reviewed)) return null;
            return $q->reviewed->first_name." ".$q->reviewed->last_name;
        })
        ->make(true);
    }

    public function store(Request $request)
    {
        try {

            $user = $request->user();
            
            if($request->accepted){
                $data = ShiftLog::where('id',$request->id)->first();
                if(empty($data))
                return [
                    "status"=>false,
                    "message"=>"Data not found",
                ];

                $data->reviewed_by = $user->id;
                $data->save();

                return [
                    "status"=>true,
                    "message"=>"Data berhasil disimpan",
                ];
            }

            if($request->delete){
                ShiftLog::where('id',$request->id)->delete();
                return [
                    "status"=>true,
                    "message"=>"Data berhasil dihapus",
                ];
            }


            $filepath = $request->filePath->store('shiftlog');
            $filepath = "/uploads/$filepath";
            
            $input["file_path"] = $filepath;
            $input["user_id"] = $user->id;
            $input["business_id"] = $user->business_id;
            ShiftLog::create($input);
            return redirect()->back();
            // return [
            //     "status"=>true,
            //     "message"=>"Data berhasil disimpan",
            // ];
        } catch (\Throwable $th) {
            return [
                "status"=>false,
                "message"=>$th->getMessage()." line:".$th->getLine(),
                "data"=>$request->user()
            ];
        }
    }

}
