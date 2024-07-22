<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;


class HotelController extends Controller
{
    function reservasi_list(Request $request){
        $page = $request->page ?? 1;
        if($page < 0) $page = 1;
        $take = $request->take ?? 500;
        $skip = ($page - 1) * $take;

        $query  = \App\HotelReservasi::query()
        ->where('status','reservasi')
        ->leftjoin('contacts as c', 'hotel_reservasis.contact_id', '=', 'c.id')
        ->select(
            "hotel_reservasis.id as ID",
            "harga as HARGA",
            "ota as OTA",
            "hotel_reservasis.contact_id as CID",
            "c.name as NAMA",
            "c.mobile as NO HP",
            "durasi as LAMA MENGINAP",
            "checkin as CHECK IN",
            "checkout as CHECK OUT",
        )
        ->skip($skip)
        ->take($take)
        ->orderBy('id','desc');

        if($request->date){
            $query = $query->whereRaw("'$request->date' BETWEEN checkin AND checkout");
        }
        // dd($query->toSql());

        $data = $query->get();

        return response()->json(
            Helper::DataReturn(true,"OK",$data), 
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
