<?php

use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Seed venue master data.
     */
    public function run()
    {
        $business_id = 1; // Default business

        $venues = [
            [
                'business_id' => $business_id,
                'name' => 'Ponton',
                'description' => 'Area ponton di tepi air, cocok untuk acara outdoor romantis dan intimate.',
                'capacity' => 100,
                'base_price' => 5000000,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_id' => $business_id,
                'name' => 'Ballroom',
                'description' => 'Ruangan ballroom indoor dengan kapasitas besar untuk resepsi dan gala dinner.',
                'capacity' => 500,
                'base_price' => 15000000,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_id' => $business_id,
                'name' => 'Kapal',
                'description' => 'Area kapal untuk acara unik di atas air.',
                'capacity' => 50,
                'base_price' => 8000000,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'business_id' => $business_id,
                'name' => 'Selasar Resto',
                'description' => 'Area selasar resto semi-outdoor, cocok untuk gathering dan meeting.',
                'capacity' => 150,
                'base_price' => 7000000,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        \DB::table('venues')->insert($venues);
    }
}
