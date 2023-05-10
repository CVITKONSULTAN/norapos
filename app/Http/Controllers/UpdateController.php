<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Carbon\Carbon;
use Spatie\Permission\Models\Permission;

class UpdateController extends Controller
{
    public function update()
    {
        if(Permission::count() === 88 || Permission::count() === 89){
            // add permission for absensi here
            $data = [
                ['name' => 'absensi.create'],
                ['name' => 'absensi.view'],
    
                ['name' => 'absensi.view_all'],
                ['name' => 'absensi.update'],
                ['name' => 'absensi.delete'],
            ];
    
            $insert_data = [];
            $time_stamp = Carbon::now()->toDateTimeString();
            foreach ($data as $d) {
                $d['guard_name'] = 'web';
                $d['created_at'] = $time_stamp;
                $insert_data[] = $d;
            }
            Permission::insert($insert_data);
        }
        return "OK";
    }
}
