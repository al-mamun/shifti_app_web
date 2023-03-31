<?php

namespace Database\Seeders;

use App\Models\ShippingStatus;
use Illuminate\Database\Seeder;

class ShippingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name'=>'Pending', 'status'=>1 , 'order_by'=>1],
            ['name'=>'Processing', 'status'=>1 , 'order_by'=>1],
            ['name'=>'On the Way', 'status'=>1 , 'order_by'=>1],
            ['name'=>'Completed', 'status'=>1 , 'order_by'=>1],
            ['name'=>'Canceled', 'status'=>1 , 'order_by'=>1],
        ];
        foreach ($data as $status){
            ShippingStatus::create($status);
        }
    }
}
