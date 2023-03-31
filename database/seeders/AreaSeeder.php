<?php

namespace Database\Seeders;

use App\Models\Shipping\Area;
use App\Models\Shipping\Zone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1004 ; $i<=1010; $i++){
            $response = Http::get('https://merchant.pathao.com/api/hermes/api/v1/zones/'.$i.'/area-list');
            $response = json_decode($response, true);
            foreach ( $response['data']['data'] as $area){
                $area_data['area_name'] = $area['area_name'];
                $area_data['order_by'] = $area['area_id'];
                $area_data['home_delivery_available'] = $area['home_delivery_available'];
                $area_data['pickup_available'] = $area['pickup_available'];
                $area_data['status'] = 1;
                $zone_info = Zone::where('order_by', $i)->first();
                if ($zone_info){
                    $area_data['zone_id'] = $zone_info?->id;
                    Area::create($area_data);
                }
            }
        }
    }
}
