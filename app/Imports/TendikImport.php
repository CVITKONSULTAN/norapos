<?php

namespace App\Imports;

use App\Models\Sekolah\TenagaPendidik;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Carbon\Carbon;
use App\Http\Controllers\Sekolah\TenagaPendidikController;
use App\User;

class TendikImport implements ToModel, WithHeadingRow
{

    private $tpcontrol = null;
    private $business_id = null;

    function __construct($data){
        $this->business_id = $data['business_id'];
        $this->tpcontrol = new TenagaPendidikController();
    }

    function parsingTanggal($text){
        $text = ltrim($text);
        // Buat array untuk mengganti nama bulan dalam bahasa Indonesia dengan angka
        $months = [
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12',
        ];

        // Ganti nama bulan dengan angka
        foreach ($months as $indonesia => $number) {
            $text = str_replace(
                $indonesia, 
                $number, 
                $text
            );
        }
        $split = explode(" ",$text);
        $text = $split[2]."-".$split[1]."-".$split[0];
        // $text = str_replace(" ",'-',$text);
        return $text;
    }

    /**
     * @param array $row
     *
     * @return TenagaPendidik|null
     */
    public function model(array $row)
    {
        try {    
            $ttl = explode(',',$row['tempat_dan_tgl_lahir']);
            $tgl = $this->parsingTanggal($ttl[1]);

            $timestamp = ($row['mulai_bertugas'] - 25569) * 86400;
            $mulai_bertugas = Carbon::createFromTimestamp($timestamp)->format('Y-m-d');

            $check = $this->tpcontrol->checkNip($row['nik']);
            if($check)
                return;

            $insert_user = [
                'first_name'=>$row['nama_guru'],
                'username'=>$row['nik'],
                'business_id'=>$this->business_id,
                'password'=> bcrypt($row['nik'])
            ];
            $user = User::create($insert_user);

            $insert = [
                'user_id'=>$user->id,
                'nip'=> $row['nip_nrg'],
                'nama'=> $row['nama_guru'],
                'no_hp'=> $row['no_hp'],
                'tempat_lahir'=> $ttl[0] ?? "",
                'tanggal_lahir'=> $tgl,
                'jenis_kelamin'=> $row['lp'],
                'bidang_studi'=> $row['jurusan'],
                'status'=> 'tetap',
                'alamat'=> $row['alamat'],
                'pendidikan_terakhir'=> $row['pendidikan_terakhir'],
                'nik'=> $row['nik'],
                'tahun_sertifikasi' => $row['tahun_sertifikasi'],
                'nbm' => $row['nbm'],
                'nuptk' => $row['nuptk'],
                'pangkat_golongan' => $row['pangkat_golongan'],
                'jabatan' => $row['jabatan'],
                'mulai_bertugas' => $mulai_bertugas,
                'status_perkawinan' => $row['statusperkawinan'],
                'status_kepegawaian' => $row['status_kepegawaian']
            ];
    
            $result = TenagaPendidik::create($insert);
            // dd($result);
            return $result;
            // return new TenagaPendidik($insert);

        } catch (\Throwable $th) {
            // return $th->getMessage();
            dd($th->getMessage(),$row);
            return;
        }
    }
}