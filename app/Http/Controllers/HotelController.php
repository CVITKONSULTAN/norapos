<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;
use Yajra\DataTables\Facades\DataTables;

use App\Brands;
use App\Product;
use Illuminate\Support\Str;


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
            "c.name as NAMA",
            "c.mobile as NO HP",
            "durasi as LAMA MENGINAP",
            "checkin as CHECK IN",
            "checkout as CHECK OUT",
            "brand_name as TIPE KAMAR",
            "metode_pembayaran as PEMBAYARAN",
            "deposit as DEPOSIT",
            "hotel_reservasis.contact_id as CID",
        )
        ->orderBy('id','desc');

        if($request->date){
            $query = $query->whereRaw("'$request->date' BETWEEN checkin AND checkout");
        }
        if($request->datatable){
            return Datatables::of($query)->make(true);
        }

        $query = $query->skip($skip)->take($take);

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

    function availablity_kamar(Request $request){
        
        $business_id = $request->business_id ?? 11;

        $query = Product::leftJoin('brands', 'products.brand_id', '=', 'brands.id')
        ->join('units', 'products.unit_id', '=', 'units.id')
        ->leftJoin('categories as c1', 'products.category_id', '=', 'c1.id')
        ->leftJoin('categories as c2', 'products.sub_category_id', '=', 'c2.id')
        ->leftJoin('tax_rates', 'products.tax', '=', 'tax_rates.id')
        ->join('variations as v', 'v.product_id', '=', 'products.id')
        ->leftJoin('variation_location_details as vld', 'vld.variation_id', '=', 'v.id')
        ->where('products.business_id', $business_id)
        ->where('products.type', '!=', 'modifier')
        ->select(
            'products.id',
            'products.name as product',
            'products.type',
            'c1.name as category',
            'c2.name as sub_category',
            'units.actual_name as unit',
            'brands.name as brand',
            'tax_rates.name as tax',
            'products.sku',
            'products.image',
            'products.enable_stock',
            'products.is_inactive',
            'products.not_for_selling',
            'products.product_custom_field1',
            'products.product_custom_field2',
            'products.product_custom_field3',
            'products.product_custom_field4'
        )
        ->groupBy('products.id')
        ->get();

        $groupBrand = $query->groupBy('brand');
        $res = [];
        $stats = [
            'superior' => 0,
            'riverside' => 0,
        ];
        foreach ($groupBrand as $key => $value) {
            $total = $value->count();
            $avail = $value->whereIn('product_custom_field2', ['VCI','VC'])->count();

            $riverside = $value
            ->whereIn('product_custom_field2', ['VCI','VC'])
            ->filter(function ($item) {
                return Str::contains($item->brand, 'Riverside');
            })->count();
            $superior = $value
            ->whereIn('product_custom_field2', ['VCI','VC'])
            ->filter(function ($item) {
                return Str::contains($item->brand, 'Superior');
            })->count();

            $stats['superior'] += $superior;
            $stats['riverside'] += $riverside;

            $res[] = [
                "brand" => $key,
                "total" => $total,
                "available" => $avail
            ];
        }
        return [
            'status'=>true,
            'data'=>$res,
            'stats'=>$stats
        ];

    }

    function avail_display(Request $request){
        return view('hotel.frontend-ketersediaan');
    }

    function RoomAllotmentsList(Request $request){

        $business_id = $request->business_id ?? 11;

         $query = Product::leftJoin('brands', 'products.brand_id', '=', 'brands.id')
        ->join('units', 'products.unit_id', '=', 'units.id')
        ->leftJoin('categories as c1', 'products.category_id', '=', 'c1.id')
        ->leftJoin('categories as c2', 'products.sub_category_id', '=', 'c2.id')
        ->leftJoin('tax_rates', 'products.tax', '=', 'tax_rates.id')
        ->join('variations as v', 'v.product_id', '=', 'products.id')
        ->leftJoin('variation_location_details as vld', 'vld.variation_id', '=', 'v.id')
        ->where('products.business_id', $business_id)
        ->where('products.type', '!=', 'modifier')
        ->select(
            'products.id',
            'products.name as product',
            'products.type',
            'c1.name as category',
            'c2.name as sub_category',
            'units.actual_name as unit',
            'brands.name as brand',
            'tax_rates.name as tax',
            'products.sku',
            'products.image',
            'products.enable_stock',
            'products.is_inactive',
            'products.not_for_selling',
            'products.product_custom_field1',
            'products.product_custom_field2',
            'products.product_custom_field3',
            'products.product_custom_field4'
        )
        ->groupBy('products.id')
        ->get();

        $groupBrand = $query->groupBy('brand');
        
        $result = [];

        $qty_date = $request->check_in_date ?? date('Y-m-d');

        foreach ($groupBrand as $key => $value) {
            $data = \App\RoomAllotments::where('business_id', $business_id)
            ->where('qty_date', $qty_date)
            ->where('room_category', $request->room_category)
            ->first();
            $result[] = [
                'photo' => [
                    'https://development.norapos.com/img/default.png',
                    'https://development.norapos.com/img/default.png',
                    'https://development.norapos.com/img/default.png'
                ],
                'brand' => $key,
                'qty_room' => $data ? $data->qty_room : 0,
                'price' => $data ? $data->price : 0,
                'close_out' => $data ? $data->close_out : false,
            ];
        }

        return response()->json(
                Helper::DataReturn(true,"OK",$result), 
            200);
    }

    function RoomAllotmentsStore(Request $request)
    {
        try {

            $business_id = $request->business_id ?? 11;

            $input = [
                'business_id' => $business_id,
                'qty_date' => $request->qty_date,
                'room_category' => $request->room_category,
                'price' => $request->price,
            ];

            $check = \App\RoomAllotments::where([
                'business_id' => $business_id,
                'qty_date' => $request->qty_date,
                'room_category' => $request->room_category
            ])->first();
            
            if($check){
                $check->qty_room = $request->qty_room;
                $check->price = $request->price;
                $check->close_out = $request->close_out ?? 0;
                $check->save();
            } else {
                \App\RoomAllotments::create($input);
            }
            
            return response()->json(
                Helper::DataReturn(true,"Data berhasil disimpan"), 
            200);             
        } catch (\Throwable $th) {
            return response()->json(
                Helper::DataReturn(false,"Akun tidak ditemukan"), 
            400); 
        }
    }

    function bookingMobile(Request $request){
        $business_id = $request->business_id ?? 11;


        return response()->json(
            Helper::DataReturn(true,"OK",[
                'link'=> route('hotel.webview_payment')
            ]), 
        200); 
    }

    function paymentMobile(Request $request){
        $link = "https://wa.me/6282255985321?text=Hallo+%20Kartika%20Hotel%2C%20saya%20ingin%20melakukan%20pemesanan%20kamar.%0A%0A";
        return redirect()->to($link);
    }

}
