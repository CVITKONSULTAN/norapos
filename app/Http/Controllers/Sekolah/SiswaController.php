<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Models\Sekolah\Siswa;
use DataTables;
use Excel;

use \App\Imports\SiswaImport;
class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display all data of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        $query = Siswa::query();

        return DataTables::of($query)
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $input = $request->all();
            Siswa::create($input);

            return redirect()
            ->route('sekolah_sd.siswa.index')
            ->with('message', 'success|Data berhasil disimpan');
        } catch(Exception $e){
            $msg = $e->getMessage();
            return redirect()
            ->back()
            ->with('message', "error|$msg");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['data'] = Siswa::findorfail($id);
        return view('sekolah_sd.input.siswa.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $m = Siswa::findorfail($id);
            $input = $request->all();
            $m->update($input);
            return redirect()
            ->route('sekolah_sd.siswa.index')
            ->with('message', 'success|Data berhasil disimpan');
        } catch(Exception $e){
            $msg = $e->getMessage();
            return redirect()
            ->back()
            ->with('message', "error|$msg");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $m = Siswa::findorfail($id);
            $m->delete();
            return ['success'=>true,'msg'=>'Data berhasil dihapus'];
        } catch(Exception $e){
            $msg = $e->getMessage();
            return ['success'=>false,'msg'=>$msg];
        }
    }

    public function import(Request $request) 
    {
        $business = $request->user()->business;
        Excel::import(
            new SiswaImport(), 
            request()->file('import_file')
        );
        
        return redirect()
        ->back()
        ->with('success', 'All good!');
    }
}
