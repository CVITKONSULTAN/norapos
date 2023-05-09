<?php

namespace App\Http\Controllers;

use App\Media;
use Storage;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $user = $request->user();
            $result = Media::uploadMedia($user->business_id, $user, request(), 'file_data', true);
            if(empty($result) && $request->has('file_data') && $request->has('absensi')){
                $file_name = '/media/file_data-'.time() . '_' . mt_rand().'.png';
                $image = str_replace('data:image/png;base64,', '', $request->file_data);
                $image = str_replace(' ', '+', $image);
                $callback = Storage::put($file_name, base64_decode($image));
                if($callback){
                    $result = url('/uploads'.$file_name);
                }
            }
            return [
                "status"=>true,
                "data"=>$result,
            ];
        } catch (\Throwable $th) {
            //throw $th;
            return [
                "status"=>false,
                "message"=>$th->getMessage(),
            ];
        }
    }
}
