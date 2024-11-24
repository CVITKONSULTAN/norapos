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
    private $kelas = null;

    function __construct($data){
        // dd($data);
        $this->business_id = $data['business_id'];
        $this->kelas = $data['kelas'];
        $this->kategori = $data['kategori'];
    }

    /**
     * @param array $row
     *
     * @return Mapel|null
     */
    public function model(array $row)
    {
        // try {
            $lm = explode("@",$row['lingkup_materi_lm']);
            $tp = explode("@",$row['tujuan_pembelajaran_tp']);
    
            $insert = [
                'nama' => $row['nama_mapel'] ,
                'kategori' => $this->kategori,
                'lingkup_materi' => $lm,
                'tujuan_pembelajaran'=> $tp,
                'business_id'=>$this->business_id,
                'kelas'=>$this->kelas,
            ];

            return Mapel::where([
                'nama'=>$insert['nama'],
                'kelas'=>$insert['kelas']
            ])->firstorCreate($insert);

            // return new Mapel($insert);

        // } catch (\Throwable $th) {
        //     dd($th->getMessage());
        //     return $th->getMessage();
        // }
    }
}