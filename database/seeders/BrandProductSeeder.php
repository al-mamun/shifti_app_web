<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 8; $i<= 60; $i++){
            for ($j = 1 ; $j <= 50; $j++){
                $product_id =random_int(81, 598);
                $data = ['product_id'=> $product_id, 'brand_id'=> $i];
                DB::table('brand_product')->insert($data);
            }
        }
    }
}
