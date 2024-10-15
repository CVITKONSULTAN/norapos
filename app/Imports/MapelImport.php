<?php

namespace App\Imports;

use App\Models\Sekolah\Mapel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MapelImport implements ToModel, WithHeadingRow
{

    private $business_id = null;
    private $kategori = "wajib";

    function __construct($data){
        $this->business_id = $data['business_id'];
        $this->kategori = $data['kategori'];
    }

    /**
     * @param array $row
     *
     * @return Mapel|null
     */
    public function model(array $row)
    {
        try {
            $lm = explode("@",$row['lingkup_materi_lm']);
            $tp = explode("@",$row['tujuan_pembelajaran_tp']);
    
            $insert = [
                'nama' => $row['nama_mapel'] ,
                'kategori' => $this->kategori,
                'lingkup_materi' => $lm,
                'tujuan_pembelajaran'=> $tp,
                'business_id'=>$this->business_id
            ];
    
            return new Mapel($insert);

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}