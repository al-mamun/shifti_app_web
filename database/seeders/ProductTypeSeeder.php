<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data= [
           ['type_name'=>'General', 'status'=>1, 'order_by'=>1],
           ['type_name'=>'Grocery', 'status'=>1, 'order_by'=>2],
           ['type_name'=>'Global', 'status'=>1, 'order_by'=>3],
       ];
       foreach ($data as $type){
           ProductType::create($type);
       }
    }
}
