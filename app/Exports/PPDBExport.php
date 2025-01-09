<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use \App\Models\Sekolah\PPDBSekolah;

class PPDBExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = PPDBSekolah::orderBy('id','desc')->get();
        $result = [];
        foreach ($data as $key => $value) {
            $result[] = $value->detail;
        }
        return collect($result);
    }
}
