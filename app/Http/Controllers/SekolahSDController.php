<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SekolahSDController extends Controller
{
    function dashboard(Request $request){
        return view('sekolah_sd.dashboard');
    }
    function kelas_index(Request $request){
        return view('sekolah_sd.ruang_kelas');
    }

    function data_siswa_index(Request $request){
        return view('sekolah_sd.siswa');
    }
    function data_siswa_create(Request $request){
        return view('sekolah_sd.input.siswa.create');
    }
    
    function data_mapel_index(Request $request){
        return view('sekolah_sd.mapel');
    }
    function data_rekap_nilai_index(Request $request){
        return view('sekolah_sd.rekap_nilai_formatif');
    }
    function data_rekap_nilai_sumatif_index(Request $request){
        return view('sekolah_sd.rekap_nilai_sumatif');
    }
    function data_ekskul_index(Request $request){
        return view('sekolah_sd.ekstrakurikuler');
    }

    function data_tendik_index(Request $request){
        return view('sekolah_sd.tendik');
    }
    function data_tendik_create(Request $request){
        return view('sekolah_sd.input.tendik.create');
    }
}
