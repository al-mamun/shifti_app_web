<?php

namespace App\Http\Controllers\API\Frontend\Address;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Address\AddressListResource;
use App\Http\Resources\Frontend\Address\DistrictResource;
use App\Http\Resources\Frontend\Address\DivisionResource;
use App\Http\Resources\Frontend\Address\ThanaResource;
use App\Models\Address;
use App\Models\CustomerAddress;
use App\Models\District;
use App\Models\Division;
use App\Models\Shipping\Area;
use App\Models\Shipping\City;
use App\Models\Shipping\Zone;
use App\Models\Upazila;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FrontCustomerAddressController extends Controller
{

    public function get_customer_address(): AnonymousResourceCollection
    {
        $addresses = CustomerAddress::with(['customer', 'city', 'zone', 'area'])->where('customer_id', auth()->user()->id)->orderBy('default_address', 'desc')->get();
        return AddressListResource::collection($addresses);
    }

    public function get_cities(): AnonymousResourceCollection
    {
        $division = City::all();
        return DivisionResource::collection($division);
    }

    public function get_zones(int $id): AnonymousResourceCollection
    {
        $zones = Zone::where('city_id', $id)->get();
        return DistrictResource::collection($zones);
    }

    public function get_areas(int $id): AnonymousResourceCollection
    {
        $areas = Area::where('zone_id', $id)->get();
        return ThanaResource::collection($areas);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
