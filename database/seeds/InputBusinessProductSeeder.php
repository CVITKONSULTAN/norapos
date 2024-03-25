<?php

use Illuminate\Database\Seeder;
use \App\Models\itkonsultan\BusinessProduct;

class InputBusinessProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BusinessProduct::whereNull('category_slug')->update(['category_slug'=>'nidi']);
        BusinessProduct::create([
            'name' => 'Panggilan Konsleting Listrik',
            'description' => 'Panggilan Konsleting Listrik',
            'price' => 70000,
            'business_id' => 1,
            'category_slug' => 'panggilan-listrik',
        ]);
        BusinessProduct::create([
            'name' => 'Instalasi Listrik',
            'description' => 'Instalasi Listrik',
            'price' => 70000,
            'business_id' => 1,
            'category_slug' => 'instalasi-listrik',
        ]);
    }
}
