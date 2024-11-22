<?php

namespace App\Imports;

use App\Models\Sekolah\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $nama = empty($row['nama']) ? $row['panggilan'] : $row['nama'];
            $nisn = empty($row['nisn']) ? $row['nis'] : $row['nisn'];
            $ttl = explode(",",$row['tempat_tanggal_lahir']);
            $detail = [
                "nis" => $row['nis'],
                "nama_panggilan" => $row['panggilan'],
                "tempat_lahir" => $ttl[0] ?? null,
                "tanggal_lahir" => $ttl[1] ?? null,
                "jenis_kelamin" => $row['jenis_kelamin'],
                "agama" => $row['agama'],
                "pendidikan_sebelumnya" => $row['pendidikan_sebelumnya'],
                "alamat" => $row['alamat_peserta_didik'],
                "nama_ayah" => $row['ayah'],
                "nama_ibu" => $row['ibu'],
                "pekerjaan_ayah" => $row['pekerjaan_ayah'],
                "pekerjaan_ibu" => $row['pekerjaan_ibu'],
                "alamat_orang_tua" => $row['jalan'],
                "kontak_orang_tua" => null,
                "kontak_keluarga" => null,
                "wali" => "tidak",
                "nama_wali" => $row['nama_wali'],
                "pekerjaan_wali" => $row["pekerjaan_wali"],
                "alamat_wali" => $row["alamat_wali"],
                "kontak_wali" => null,
            ];

            $insert = [
                'nisn'=>$nisn,
                'nama'=>$nama,
                'detail'=>$detail
            ];
            
            if(Siswa::where('nisn',$nisn)->first()){
                return;
            }

            return new Siswa($insert);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
