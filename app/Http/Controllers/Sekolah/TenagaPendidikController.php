<?php

namespace App\Http\Controllers\Sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use Excel;

use App\Models\Sekolah\Mapel;
use App\Models\Sekolah\TenagaPendidik;
use App\User;
use \App\Imports\TendikImport;


class TenagaPendidikController extends Controller
{

    public function checkNip(
        $username,
        $exclude_id = null,
        $exclude_user_id = null
    ) {
        $user = User::where('username',$username);
        if($exclude_user_id != null){
            $user = $user->where('id','!=',$exclude_user_id);
        }
        $tendik = TenagaPendidik::where('nik',$username);
        if($exclude_id != null){
            $tendik = $tendik->where('id','!=',$exclude_id);
        }

        if($user->first()){
            return "NIK sudah digunakan";
        }

        if($tendik->first())
            return "NIK sudah di gunakan";

        return false;
    }

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
            $validator = Validator::make($input, [
                'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        
            if ($validator->fails()) {
                $error_msg = $validator->errors()->first();
                return redirect()
                ->back()
                ->with('message', 'error|'.$error_msg);
            }

            if($request->foto){
                $input['foto'] = $request->foto->store('foto_tendik');
                $input['foto'] = '/uploads/'.$input['foto'];
            }

            $check = $this->checkNip($input['nik']);

            if($check){
                return redirect()
                ->back()
                ->with('message', "error|$check");
            }

            $business_id = $request->session()->get('user.business_id');
            $user_details['business_id'] = $business_id;
            $user = User::create([
                'first_name'=>$input['nama'],
                'username'=>$input['nik'],
                'business_id'=>$business_id,
                'password'=> bcrypt($input['nik'])
            ]);

            $input['user_id'] = $user->id;

            TenagaPendidik::create($input);

            return redirect()
            ->route('sekolah_sd.tendik.index')
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
        $data['data'] = TenagaPendidik::findorfail($id);
        try{
            $data['data']->mapel_id_list_array = json_decode($data['data']->mapel_id_list,true);
            if(empty($data['data']->mapel_id_list_array)) 
            $data['data']->mapel_id_list_array = [];
        } catch(Exception $e){
            $data['data']->mapel_id_list_array = [];
        }
        $data['list_mapel'] = Mapel::whereIn('id',$data['data']->mapel_id_list_array)->get();
        // dd($data['list_mapel']);
        return view('sekolah_sd.input.tendik.edit',$data);
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
        // try{
            $input = $request->all();
            // dd($input,$id);

            $tendik = TenagaPendidik::find($id);

            $validator = Validator::make($input, [
                'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        
            if ($validator->fails()) {
                $error_msg = $validator->errors()->first();
                return redirect()
                ->back()
                ->with('message', 'error|'.$error_msg);
            }

            if($request->foto){
                $input['foto'] = $request->foto->store('foto_tendik');
                $input['foto'] = '/uploads/'.$input['foto'];
            }

            $check = $this->checkNip(
                $input['nik'],
                $tendik->id,
                $tendik->user_id
            );

            if($check){
                return redirect()
                ->back()
                ->with('message', "error|$check");
            }

            // $business_id = $request->session()->get('user.business_id');
            // $user_details['business_id'] = $business_id;
            // $user = User::create([
            //     'first_name'=>$input['nama'],
            //     'username'=>$input['nip'],
            //     'business_id'=>$business_id,
            //     'password'=> bcrypt($input['nip'])
            // ]);

            // dd($input);
            $tendik->user()->update([
                'first_name'=>$input['nama'],
                'username'=>$input['nik']
            ]);

            $tendik->update($input);

            return redirect()
            ->route('sekolah_sd.tendik.index')
            ->with('message', 'success|Data berhasil disimpan');
        // } catch(Exception $e){
        //     $msg = $e->getMessage();
        //     return redirect()
        //     ->back()
        //     ->with('message', "error|$msg");
        // }
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
            $m = TenagaPendidik::findorfail($id);
            $m->delete();
            return ['success'=>true,'msg'=>'Data berhasil dihapus'];
        } catch(Exception $e){
            $msg = $e->getMessage();
            return ['success'=>false,'msg'=>$msg];
        }
    }

    function data(Request $request){
        $query = TenagaPendidik::orderBy('id','desc');
        return DataTables::of($query)->make(true);
    }

    public function import(Request $request) 
    {
        $business = $request->user()->business;
        Excel::import(
            new TendikImport(['business_id'=>$business->id]), 
            request()->file('import_file')
        );
        
        return redirect()
        ->back()
        ->with('success', 'All good!');
    }
}
