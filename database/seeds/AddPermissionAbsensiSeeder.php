<?php

use Illuminate\Database\Seeder;

class AddPermissionAbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'absensi.create'],
            ['name' => 'absensi.view'],

            ['name' => 'absensi.view_all'],
            ['name' => 'absensi.update'],
            ['name' => 'absensi.delete'],
        ];

        $insert_data = [];
        $time_stamp = \Carbon::now()->toDateTimeString();
        foreach ($data as $d) {
            $d['guard_name'] = 'web';
            $d['created_at'] = $time_stamp;
            $insert_data[] = $d;
        }
        Permission::insert($insert_data);
    }
}
