<?php

namespace App\Http\Controllers\API\Frontend\DeliveryCharge;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\Delivery\DeliveryZone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function get_delivery_charge($id): JsonResponse
    {
       $address = CustomerAddress::findOrFail($id);
       $pivot_data = DB::table('area_delivery_zone')->where('area_id', $address->area_id)->first();
       $delivery_charge = DeliveryZone::findOrFail($pivot_data->delivery_zone_id);
       return response()->json(['data'=>$delivery_charge]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
