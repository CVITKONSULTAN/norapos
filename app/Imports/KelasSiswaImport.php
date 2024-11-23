<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use \App\Models\Sekolah\Siswa;
use \App\Models\Sekolah\Kelas;
use \App\Models\Sekolah\KelasSiswa;

use \App\Http\Controllers\Sekolah\KelasController;

class KelasSiswaImport implements ToModel, WithHeadingRow
{
    private $kelas_id = null;

    function __construct($data){
        $this->kelas_id = $data['kelas_id'];
    }

    /**
     * @param array $row
     *
     * @return KelasSiswa|null
     */
    public function model(array $row)
    {
        // try {
            // dd($row);

            $siswa = Siswa::where('nisn',$row['nisn'])->first();
            if(empty($siswa)){
                dd("nisn not found",$siswa,$row);
            }

            $input = [
                'siswa_id' => $siswa->id,
                'kelas_id' => $this->kelas_id,
            ];

            $k = KelasSiswa::where($input)->firstOrCreate($input);
            $kelas = new KelasController();
            $kelas->storeKelasMapel($k);
            // dd($k);
            return $k;
        // } catch (\Throwable $th) {
            //throw $th;
            // return ['message'=> $th->getMessage()];
            return;
        // }
    }
}
