<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;


class HotelController extends Controller
{
    function reservasi_list(Request $request){
        $page = $request->page ?? 1;
        if($page < 0) $page = 1;
        $take = $request->take ?? 10;
        $skip = ($page - 1) * 10;

        $query  = \App\HotelReservasi::query()
        ->skip($skip)
        ->take($take)
        ->orderBy('id','desc')
        ->get();

        return response()->json(
            Helper::DataReturn(true,"OK",$query), 
        200); 
    }

    function reservasi_store(Request $request){
        $data = $request->all();
        if($request->insert){
            try {
                $c = \App\Contact::find($request->contact_id);
                if(empty($c)){
                    return response()->json(
                        Helper::DataReturn(false,"Contact not found"), 
                    400); 
                }
                $result = \App\HotelReservasi::create($data);
                return response()->json(
                    Helper::DataReturn(true,"Data berhasil ditambahkan",$result), 
                200); 
            } catch (\Throwable $th) {
                return response()->json(
                    Helper::DataReturn(false,"Internal Server Error",$th->getMessage()), 
                400); 
            }
        }
        if($request->update){
            try {
                $hr = \App\HotelReservasi::find($request->id);
                if(empty($hr)){
                    return response()->json(
                        Helper::DataReturn(false,"Hotel Reservasi not found"), 
                    400); 
                }

                $c = \App\Contact::find($request->contact_id);
                if(empty($c)){
                    return response()->json(
                        Helper::DataReturn(false,"Contact not found"), 
                    400); 
                }

                $hr->update($data);

                return response()->json(
                    Helper::DataReturn(true,"Data berhasil diubah"), 
                200); 

            } catch (\Throwable $th) {
                return response()->json(
                    Helper::DataReturn(false,"Internal Server Error",$th->getMessage()), 
                400); 
            }
        }
        if($request->delete){
            try {
                $hr = \App\HotelReservasi::find($request->id);
                if(empty($hr)){
                    return response()->json(
                        Helper::DataReturn(false,"Hotel Reservasi not found"), 
                    400); 
                }
                $hr->delete();
                return response()->json(
                    Helper::DataReturn(true,"Data berhasil dihapus"), 
                200); 
            } catch (\Throwable $th) {
                return response()->json(
                    Helper::DataReturn(false,"Internal Server Error",$th->getMessage()), 
                400); 
            }
        }
    }
}
