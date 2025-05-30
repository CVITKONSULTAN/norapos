<?php

use Illuminate\Database\Seeder;

use App\Models\itkonsultan\BusinessDomain;
use App\Models\itkonsultan\BusinessProduct;

class JaplinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            'business_name'=>'PT. JASA  PEMERIKSAAN LISTRIK INDONESIA (JAPLIN)',
            'domain' => 'https://listrikanda.com/',
            'details' => null,
            'expired_at' => null
        ];
        $business = BusinessDomain::where('domain',$input['domain'])->first();
        if(empty($business)){
            $business = BusinessDomain::create($input);
        }
        $business_id = $business->id;
        if(BusinessProduct::where('business_id',$business_id)->count() > 0 ) return;

        $product = [
            [
                'name'=>'Daya 450 - SLO - NIDI',
                'description'=>'Daya 450 - SLO Rp. 40.000 - NIDI Rp. 150.000 - Total Biaya Rp. 190.000',
                'price'=>190000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 900 - SLO - NIDI',
                'description'=>'Daya 900 - SLO Rp. 60.000 - NIDI Rp. 150.000 - Total Biaya Rp. 210.000',
                'price'=>210000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 1300 - SLO - NIDI',
                'description'=>'Daya 1300 - SLO Rp. 95.000 - NIDI Rp. 150.000 - Total Biaya Rp. 245.000',
                'price'=>245000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 2200 - SLO - NIDI',
                'description'=>'Daya 2200 - SLO Rp. 110.000 - NIDI Rp. 150.000 - Total Biaya Rp. 260.000',
                'price'=>260000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 3500 - SLO - NIDI',
                'description'=>'Daya 3500 - SLO Rp. 105.000 - NIDI Rp. 250.000 - Total Biaya Rp. 355.000',
                'price'=>355000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 4400 - SLO - NIDI',
                'description'=>'Daya 4400 - SLO Rp. 132.000 - NIDI Rp. 250.000 - Total Biaya Rp. 382.000',
                'price'=>382000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 5500 - SLO - NIDI',
                'description'=>'Daya 5500 - SLO Rp. 165.000 - NIDI Rp. 250.000 - Total Biaya Rp. 415.000',
                'price'=>415000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 6600 - SLO - NIDI',
                'description'=>'Daya 6600 - SLO Rp. 198.000 - NIDI Rp. 528.000 - Total Biaya Rp. 726.000',
                'price'=>726000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 7700 - SLO - NIDI',
                'description'=>'Daya 7700 - SLO Rp. 231.000 - NIDI Rp. 616.000 - Total Biaya Rp. 847.000',
                'price'=>847000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 10.600 - SLO - NIDI',
                'description'=>'Daya 10.600 - SLO Rp. 265.000 - NIDI Rp. 616.000 - Total Biaya Rp. 1.07.000',
                'price'=>1007000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 11.000 - SLO - NIDI',
                'description'=>'Daya 11.000 - SLO Rp. 275.000 - NIDI Rp. 770.000 - Total Biaya Rp. 1.045.000',
                'price'=>1045000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 13.200 - SLO - NIDI',
                'description'=>'Daya 13.200 - SLO Rp. 330.000 - NIDI Rp. 924.000 - Total Biaya Rp. 1.254.000',
                'price'=>1254000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 16.500 - SLO - NIDI',
                'description'=>'Daya 16.500 - SLO Rp. 412.000 - NIDI Rp. 1.155.000 - Total Biaya Rp. 1.567.000',
                'price'=>1567000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 23.000 - SLO - NIDI',
                'description'=>'Daya 23.000 - SLO Rp. 575.000 - NIDI Rp. 1.610.000 - Total Biaya Rp. 2.185.000"',
                'price'=>2185000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 33.000 - SLO - NIDI',
                'description'=>'Daya 33.000 - SLO Rp. 660.000 - NIDI Rp. 2.310.000 - Total Biaya Rp. 2.970.000"',
                'price'=>2970000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 41.500 - SLO - NIDI',
                'description'=>'Daya 41.500 - SLO Rp. 830.000 - NIDI Rp. 2.490.000 - Total Biaya Rp. 3.320.000"',
                'price'=>3320000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 53.000 - SLO - NIDI',
                'description'=>'Daya 53.000 - SLO Rp. 1.060.000 - NIDI Rp. 3.180.000 - Total Biaya Rp. 4.240.000',
                'price'=>4240000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 66.000 - SLO - NIDI',
                'description'=>'Daya 66.000 - SLO Rp. 1.320.000 - NIDI Rp. 3.960.000 - Total Biaya Rp. 5.280.000',
                'price'=>5280000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 82.500 - SLO - NIDI',
                'description'=>'Daya 82.500 - SLO Rp. 1.237.500 - NIDI Rp. 4.950.000 - Total Biaya Rp. 6.187.500',
                'price'=>6187500,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 105.000 - SLO - NIDI',
                'description'=>'Daya 105.000 - SLO Rp. 1.575.000 - NIDI Rp. 4.200.000 - Total Biaya Rp. 5.775.000',
                'price'=>5775000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 131.000 - SLO - NIDI',
                'description'=>'Daya 131.000 - SLO Rp. 1.965.000 - NIDI Rp. 5.240.000 - Total Biaya Rp. 7.205.000',
                'price'=>7205000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 147.000 - SLO - NIDI',
                'description'=>'Daya 147.000 - SLO Rp. 2.205.000 - NIDI Rp. 5.880.000 - Total Biaya Rp. 8.085.000',
                'price'=>8085000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 164.000 - SLO - NIDI',
                'description'=>'Daya 164.000 - SLO Rp. 2.460.000 - NIDI Rp. 6.560.000 - Total Biaya Rp. 9.020.000',
                'price'=>9020000,
                'business_id'=>$business_id
            ],
            [
                'name'=>'Daya 197.000 - SLO - NIDI',
                'description'=>'Daya 197.000 - SLO Rp. 2.955.000 - NIDI Rp. 7.880.000 - Total Biaya Rp. 10.835.000',
                'price'=>10835000,
                'business_id'=>$business_id
            ],
        ];

        BusinessProduct::insert($product);

    }
}
