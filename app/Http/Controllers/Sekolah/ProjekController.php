<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Imports\ProjekImport;
use Excel;
use App\Models\Sekolah\FaseDimensi;
use DataTables;

class ProjekController extends Controller
{
    function import_dimensi_projek(Request $request){
        $business = $request->user()->business;
        Excel::import(
            new ProjekImport(), 
            request()->file('import_file')
        );
        
        return redirect()
        ->back()
        ->with('success', 'All good!');
    }

    function data_dimensi_projek(Request $request){
        $query = FaseDimensi::with([
            'elemen' => function($q){
                return $q->select('id','elemen','dimensi_id');
            },
            'elemen.dimensi' => function($q){
                return $q->select('id','keterangan');
            },
        ]);
        return DataTables::of($query)
        ->make(true);
    }
}
