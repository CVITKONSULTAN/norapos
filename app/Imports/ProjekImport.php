<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\Sekolah\DataDimensiID;
use App\Models\Sekolah\DimensiProjek;
use App\Models\Sekolah\FaseDimensi;


class ProjekImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $dimensi = DataDimensiID::where('keterangan',$row['dimensi'])
            ->FirstorCreate(['keterangan'=>$row['dimensi']]);
            // dd($dimensi);

            $elemen = DimensiProjek::where('elemen',$row['elemen'])
            ->FirstorCreate([
                'dimensi_id'=>$dimensi->id,
                'elemen'=>$row['elemen']
            ]);
            $subelemen = FaseDimensi::create([
                'elemen_id'=>$elemen->id,
                'subelemen'=>$row['subelemen'],
                'fase_a' => $row['fase_a'],
                'fase_b' => $row['fase_b'],
                'fase_c' => $row['fase_c']
            ]);
            
            return $subelemen;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
