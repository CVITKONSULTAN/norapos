<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            InputBusinessProductSeeder::class,
            // JaplinSeeder::class,
                    // BarcodesTableSeeder::class,
                    // PermissionsTableSeeder::class,
                    // CurrenciesTableSeeder::class
        ]);
    }
}
