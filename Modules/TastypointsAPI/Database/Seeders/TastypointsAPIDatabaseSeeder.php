<?php

namespace Modules\TastypointsAPI\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\TastypointsAPI\Entities\Tastyconfig;

class TastypointsAPIDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        // $this->call("ConfigSeederTableSeeder");

        Tastyconfig::create(
            [
                "link" => "https://tastypoints.io/akm/restapi.php"
            ]
        );
    }
}
