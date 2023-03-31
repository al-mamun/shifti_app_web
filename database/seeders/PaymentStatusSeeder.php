<?php

namespace Database\Seeders;

use App\Models\PaymentStatus;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data = [
           ['name'=>'Paid', 'status'=>1 , 'order_by'=>1],
           ['name'=>'Unpaid', 'status'=>1 , 'order_by'=>1],
           ['name'=>'Partially Paid', 'status'=>1 , 'order_by'=>1],
       ];
//       PaymentStatus::truncate();
       foreach ($data as $status){
           PaymentStatus::create($status);
       }
    }
}
