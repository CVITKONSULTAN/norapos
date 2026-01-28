<?php

namespace App\Models\CiptaKarya;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanPBG extends Model
{
    use SoftDeletes;
    
    protected $table = 'pengajuan'; // Jika tabel tidak otomatis plural

    protected $fillable = [
        'uid',
        'tipe',
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
        'nilai_retribusi',
        'ketinggian_bangunan',
        'koefisiensi_dasar',
        'koefisiensi_lantai',
        'koordinat_bangunan',
        'petugas_lapangan',
        'petugas_id',
        'answers',
        'questions',
        'list_foto',
        'photoMaps',
        'notes',
        'verified_at',
        'verified_by',
        'template_excel_retribusi',
        'tgl_penugasan',
        'kecamatan_id',
        'nama_kecamatan',
        'alsasan_tolak',
        'excel_retribusi',
        'pdf_retribusi',
        'foto_retribusi',
        'zip_retribusi',
    ];

    // Agar kolom JSON otomatis array saat diakses
    protected $casts = [
        'uploaded_files' => 'array',
        'petugas_lapangan' => 'array',
        'answers' => 'array',
        'questions' => 'array',
        'list_foto' => 'array',
        'photoMaps' => 'array',
        'verified_at' => 'datetime',
    ];

    function petugas(){
        return $this->belongsTo(PetugasLapangan::class,'petugas_id','id');
    }

    public function nextStage($role, $status)
    {
        $flow = [
            'admin_entry' => 'petugas',
            'petugas' => 'pemeriksa',
            'pemeriksa' => 'admin_retribusi',
            'admin_retribusi' => 'koordinator',
            'koordinator' => 'kabid',
            'kabid' => 'finish',
        ];

        if ($status == 'rejected') return 'revisi';

        return $flow[$role] ?? 'finish';
    }
}
