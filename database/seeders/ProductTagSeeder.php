<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 22; $i<= 44; $i++){
            for ($j = 1 ; $j <= 50; $j++){
                $product_id =random_int(81, 598);
                $data = ['product_id'=> $product_id, 'tag_id'=> $i];
                DB::table('product_tag')->insert($data);
            }
        }
    }
}
