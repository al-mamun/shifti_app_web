<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        for ($i = 1; $i<= 104; $i++){
            for ($j = 1 ; $j <= 50; $j++){
                $product_id =random_int(81, 598);
                $data = ['product_id'=> $product_id, 'category_id'=> $i];
                DB::table('category_product')->insert($data);
            }
        }

    }
}
