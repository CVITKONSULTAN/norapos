<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Sekolah\Siswa;
use Log;

class SiswaImportDapodik implements ToCollection, WithHeadingRow, WithStartRow
{
    public function headingRow(): int
    {
        return 6; // baris header (judul kolom)
    }

    public function startRow(): int
    {
        return 7; // mulai baca data dari baris ke-7
    }

    protected $business_id  = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->business_id = $data['business_id'];
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $transform = [];
        $res = [];
        $res_nisn_not_found = [];
        // $res_trouble_nisn = [];
        foreach ($rows as $row) {
            // $row adalah Collection dari satu baris (index numerik)
            
            try {
                $val = [
                    'nama'      => $row["nama"],
                    'nis'       => $row["nis"],
                    'jk'        => $row["jk"],
                    'nisn'      => $row["nisn"],
                    'kelas'     => $row["kls"],
                    'tempat_lahir' => $row["tempat_lahir"],
                    'tanggal_lahir' => $row["tanggal_lahir"], // Pastikan ini format tanggal
                    'nik'       => $row["nik"],
                    'agama'     => $row["agama"],
                    'alamat'    => $row["alamat"],
                    'ayah'      => $row['ayah'] ?? null,
                    'ibu'       => $row['ibu'] ?? null,
                ];
                $transform[] = $val;
            } catch (\Exception $e) {
                Log::error('Error converting row to array: ' . $e->getMessage());
                Log::info("Error row data: " . json_encode($row));
                continue; // skip this row if conversion fails
            }

            $siswa = Siswa::where('nisn',$val['nisn'])->first();

            if(!empty($siswa)){
                similar_text(
                    strtolower( $siswa->nama ), 
                    strtolower($val['nama']), 
                    $percent);
                $percent = round($percent, 2);
                if($percent < 90){
                    $res[] = $val['nama']." = ".$siswa->nama.$percent;
                }
                $siswa->nisn = $val['nisn'];
                $detail_siswa = $siswa->detail ?? [];
                $detail_siswa['nis'] = $val['nis'];
                $siswa->nisn = $val['nisn'];
                $siswa->detail = $detail_siswa;
                $siswa->save();
                continue;
            }

            if(empty($siswa)){
                $nama = strtolower($val['nama']);
                
                $siswa = Siswa::whereRaw('LOWER(nama) LIKE ?', 
                ['%' . strtolower($nama) . '%'])
                ->first();
                if(
                    empty($val['nisn']) &&
                    !empty($val['nis'])
                ){
                    $detail_siswa = $siswa->detail ?? [];
                    $detail_siswa['nis'] = $val['nis'];
                    $siswa->nisn = $val['nis'];
                    $siswa->detail = $detail_siswa;
                    $siswa->save();
                    continue;
                }

                if(!empty($siswa) && $siswa->nisn !== $val['nisn']){
                    $siswa->nisn = $val['nisn'];
                    $detail_siswa = $siswa->detail ?? [];
                    $detail_siswa['nis'] = $val['nis'];
                    $siswa->nisn = $val['nisn'];
                    $siswa->detail = $detail_siswa;
                    $siswa->save();
                    continue;
                }

                if(empty($siswa)){
                    Log::error('error import siswa dapodik : '. json_encode($val) ." \n ". json_encode($siswa));
                }
            }
        }
        return;
    }
}
