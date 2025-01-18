<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;


class MakeSiswaUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siswa:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat user dari siswa table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Membuat user dari siswas table \n";
        $siswas = \App\Models\Sekolah\Siswa::all();
        $business = \App\Business::where('business_category','sekolah_sd')->first();
        $role = Role::where('business_id', $business->id)
        ->where('name','like','%orang tua%')
        ->first();
        if(empty($role)){
            echo "Role orang tua tidak ditemukan \n";
            return;
        }
        foreach ($siswas as $k => $siswa) {
            $u = \App\User::where('username',$siswa->nisn)->first();
            if(!empty($u)){
                $u->assignRole($role->name);
                echo "User dengan username ".$siswa->nisn." sudah ada \n";
                continue;
            }
            $user = new \App\User;
            $user->first_name = $siswa->nama;
            $user->username = $siswa->nisn;
            $user->email = $siswa->nisn.'@koneksiedu.com';
            $user->password = bcrypt($siswa->nisn);
            $user->business_id = $business->id;
            $user->save();
            $user->assignRole($role->name);
        }
        echo "User berhasil dibuat \n";
        echo "Selesai ($k) \n";
    }
}
