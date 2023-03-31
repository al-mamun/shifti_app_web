<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            ['name'=> 'Customer', 'email' =>'customer@iithost.com', 'phone'=>'1234567891', 'type'=>'1', 'photo'=>'demo.png', 'password'=>Hash::make('12345678')],
            ['name'=> 'User', 'email' =>'user@iithost.com', 'phone'=>'1234567891', 'type'=>'1', 'photo'=>'demo.png', 'password'=>Hash::make('12345678')]
        ];

        Customer::truncate();
        foreach($customers as $customer){
            Customer::create($customer);
        }
    }
}

