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
use App\Models\Upazila;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function get_division(): AnonymousResourceCollection
    {
        $division = Division::all();
        return DivisionResource::collection($division);
    }

    /**
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function get_district(int $id): AnonymousResourceCollection
    {
        $district = District::where('division_id', $id)->get();
        return DistrictResource::collection($district);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function get_thana(int $id): AnonymousResourceCollection
    {
        $thana = Upazila::where('district_id', $id)->get();
        return ThanaResource::collection($thana);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return AnonymousResourceCollection
     */
    public function get_customer_address(): AnonymousResourceCollection
    {
        $addresses = Address::with(['customer', 'division', 'district', 'upazila'])->where('customer_id', auth()->user()->id)->orderBy('default_address', 'desc')->get();
        return AddressListResource::collection($addresses);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function make_default_address(int $id): JsonResponse
    {
        $addresses = CustomerAddress::where('customer_id', auth()->user()->id)->get();
        foreach ($addresses as $address){
            if ($address->default_address == 1) {
                $update_data['default_address'] = 0 ;
                $address->update($update_data);
            }
        }
        $my_address = CustomerAddress::findOrFail($id);
        $data['default_address'] = 1;
        $my_address->update($data);
        return response()->json(['msg'=>'Address set as Default']);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function get_address_for_edit(int $id): JsonResponse
    {
        $address = CustomerAddress::findOrFail($id);
        return response()->json($address);
    }
}
