<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Str;
use Hash;

use App\Helpers\Helper;

class APIController extends Controller
{
    public function data(Request $request)
    {
        $input = $request->all();
        $model = null;
        switch ($input["type"]) {
            case 'blog':
                // $model = \App\Blog::query();
                $model = \App\Blog::with("user:id,username");
                $max_length = 150;
                break;
            
            default:
                return abort(404);
                break;
        }
        if(empty($model)) return abort(404);

        if(isset($input["result_format"]) && $input["result_format"] === "blogpost"){
            $data = $model->where("slug",$input["slug"])->firstorfail();
            $seo_description = strip_tags($data->description);
            $data->seo_description = (strlen($seo_description) > $max_length) ? substr($seo_description, 0, $max_length) . '...' : $seo_description;
            return $data;
        }
        if(isset($input["result_format"]) && $input["result_format"] === "datatables"){
            $dt = DataTables::of($model);
            if($input["type"] === "blog"){
                $dt = $dt->editColumn("description",function($q){
                    $description = strip_tags($q->description);
                    return (strlen($description) > $max_length) ? substr($description, 0, $max_length) . '...' : $description;
                });
            }
            return $dt;
        }

        $take = isset($input["take"]) && is_numeric($input["take"]) ? $input["take"] : 10;
        $skip = isset($input["skip"]) && is_numeric($input["skip"]) ? $input["skip"] : 0;

        $model = $model->skip($skip)->take($take);

        $collection = $model->get();

        foreach ($collection as $key => $q) {
            if($input["type"] === "blog"){
                $description = strip_tags($q->description);
                $q->description = (strlen($description) > $max_length) ? substr($description, 0, $max_length) . '...' : $description;
                $collection[$key] = $q;
            }
        }

        return $collection;
    }

    function login(Request $request){
        try {
            $user = \App\User::where('username',$request->username)->first();
            if(empty($user)){
                return Helper::DataReturn(false,"Akun tidak ditemukan");
            }
            
            if (!Hash::check($request->password, $user->password)){
                return Helper::DataReturn(false,"Password anda salah");
            }
     
            $token = Str::random(60);
     
            $user->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();
    
            return Helper::DataReturn(true,"OK",["token" => $token]);
        } catch (\Throwable $th) {
            return Helper::DataReturn(false,$th->getMessage(),$request->all());
        }
    }
}
