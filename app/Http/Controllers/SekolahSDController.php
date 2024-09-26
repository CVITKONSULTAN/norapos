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
    function data_mapel_create(Request $request){
        return view('sekolah_sd.input.mapel.create');
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
    function data_ekskul_create(Request $request){
        return view('sekolah_sd.input.ekskul.create');
    }

    function data_tendik_index(Request $request){
        return view('sekolah_sd.tendik');
    }
    function data_tendik_create(Request $request){
        return view('sekolah_sd.input.tendik.create');
    }

    function data_rekap_absen_index(Request $request){
        return view('sekolah_sd.rekap_absen');
    }

    function buku_induk_index(Request $request){
        return view('sekolah_sd.buku_induk');
    }
    function buku_induk_create(Request $request){
        return view('sekolah_sd.input.buku_induk.create');
    }

    function project_index(Request $request){
        return view('sekolah_sd.project');
    }
    function project_create(Request $request){
        return view('sekolah_sd.input.project.create');

    }

    function raport_tengah_index(Request $request){
        return view('sekolah_sd.raport_tengah');
    }
    function raport_akhir_index(Request $request){
        return view('sekolah_sd.raport_akhir');
    }
}
