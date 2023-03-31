<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data= [
           ['name'=>'Cash On Delivery', 'status'=>1, 'order_by'=>1],
           ['name'=>'Credit/Debit Cards', 'status'=>1, 'order_by'=>2],
           ['name'=>'Bkash', 'status'=>1, 'order_by'=>3],
           ['name'=>'Nagad', 'status'=>1, 'order_by'=>4],
       ];

       foreach ($data as $method){
           PaymentMethod::create($method);
       }
    }
}
