<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;

use \App\Models\Sekolah\Siswa;
use \App\Models\Sekolah\Kelas;
use \App\Models\Sekolah\KelasSiswa;

use \App\Http\Controllers\Sekolah\KelasController;

class KelasSiswaImport implements ToModel, WithHeadingRow
{
    use RemembersRowNumber;

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
        $rowNumber = $this->getRowNumber();
        $nisn = trim((string) ($row['nisn'] ?? ''));

        if ($nisn === '') {
            throw new \Exception("Import gagal pada baris {$rowNumber}: kolom 'nisn' kosong.");
        }

        $siswa = Siswa::where('nisn', $nisn)->first();
        if (empty($siswa)) {
            throw new \Exception("Import gagal pada baris {$rowNumber}: NISN '{$nisn}' tidak ditemukan pada data siswa.");
        }

        $input = [
            'siswa_id' => $siswa->id,
            'kelas_id' => $this->kelas_id,
        ];

        $k = KelasSiswa::where($input)->firstOrCreate($input);

        $kelas_data = Kelas::find($this->kelas_id);
        if (empty($kelas_data)) {
            throw new \Exception("Import gagal pada baris {$rowNumber}: kelas tujuan tidak ditemukan.");
        }

        $kelas = new KelasController();
        $kelas->storeKelasMapel($k, $kelas_data->kelas);

        return $k;
    }
}
