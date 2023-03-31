<?php

namespace Database\Seeders;

use App\Models\Shipping\City;
use App\Models\Shipping\Zone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1 ; $i <= 64; $i++){
            $response = Http::get('https://merchant.pathao.com/api/hermes/api/v1/cities/'.$i.'/zone-list');
            $response = json_decode($response, true);
            foreach ( $response['data']['data'] as $city){
                $zone_data['zone_name'] = $city['zone_name'];
                $zone_data['order_by'] = $city['zone_id'];
                $zone_data['status'] = 1;
                $city_info = City::where('order_by', $i)->first();
                $zone_data['city_id'] = $city_info->id;
                Zone::create($zone_data);
            }
        }
    }
}
