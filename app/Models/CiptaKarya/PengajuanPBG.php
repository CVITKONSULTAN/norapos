<?php

namespace App\Models\CiptaKarya;

use Illuminate\Database\Eloquent\Model;

class PengajuanPBG extends Model
{
    protected $table = 'pengajuan'; // Jika tabel tidak otomatis plural

    protected $fillable = [
        'no_permohonan',
        'no_krk',
        'nama_pemohon',
        'nik',
        'alamat',
        'fungsi_bangunan',
        'nama_bangunan',
        'jumlah_bangunan',
        'jumlah_lantai',
        'luas_bangunan',
        'lokasi_bangunan',
        'no_persil',
        'luas_tanah',
        'pemilik_tanah',
        'gbs_min',
        'kdh_min',
        'kdb_max',
        'uploaded_files', // simpan JSON dropzone
        'status',
        'nilai_retribusi'
    ];

    // Agar kolom JSON otomatis array saat diakses
    protected $casts = [
        'uploaded_files' => 'array',
    ];
}
