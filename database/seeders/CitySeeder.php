<?php

namespace Database\Seeders;

use App\Models\Shipping\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('https://merchant.pathao.com/api/hermes/api/v1/countries/1/city-list');
        $response = json_decode($response, true);
        foreach ( $response['data']['data'] as $district){
            $city_data['city_name'] = $district['city_name'];
            $city_data['order_by'] = $district['city_id'];
            $city_data['status'] = 1;
            City::create($city_data);
        }
    }
}
