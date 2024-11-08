<?php

use Illuminate\Database\Seeder;

use \App\Models\Sekolah\NilaiIntervalKeyword;

class NilaiIntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nilai_minimum' => 0,
                'nilai_maksimum' => 30.5,
                'formatter_string' => "@nama@ Perlu bimbingan dalam @tp_nama@",
                'tipe' => 'terendah'
            ],
            [
                'nilai_minimum' => 30.5,
                'nilai_maksimum' => 61,
                'formatter_string' => "@nama@ Perlu bantuan dalam @tp_nama@",
                'tipe' => 'terendah'
            ],
            [
                'nilai_minimum' => 61,
                'nilai_maksimum' => 68,
                'formatter_string' => "@nama@ Perlu pembinaan dalam @tp_nama@",
                'tipe' => 'terendah'
            ],
            [
                'nilai_minimum' => 68,
                'nilai_maksimum' => 74,
                'formatter_string' => "@nama@ Perlu pendampingan dalam @tp_nama@",
                'tipe' => 'terendah'
            ],
            [
                'nilai_minimum' => 74,
                'nilai_maksimum' => 81,
                'formatter_string' => "@nama@ Menunjukan penguasaan dalam @tp_nama@",
                'tipe' => 'tertinggi'
            ],
            [
                'nilai_minimum' => 81,
                'nilai_maksimum' => 87,
                'formatter_string' => "@nama@ Menunjukan penguasaan yang sangat baik dalam @tp_nama@",
                'tipe' => 'tertinggi'
            ],
            [
                'nilai_minimum' => 87,
                'nilai_maksimum' => 94,
                'formatter_string' => "@nama@ Menunjukan pemahaman dalam @tp_nama@",
                'tipe' => 'tertinggi'
            ],
            [
                'nilai_minimum' => 94,
                'nilai_maksimum' => 100,
                'formatter_string' => "@nama@ Menunjukan pemahaman yang sangat baik dalam @tp_nama@",
                'tipe' => 'tertinggi'
            ]
        ];

        NilaiIntervalKeyword::insert($data);
    }
}
