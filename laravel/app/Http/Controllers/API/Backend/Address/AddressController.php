<?php

namespace App\Http\Controllers\API\Backend\Address;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\CustomerAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'address'=>'required',
            'city_id'=>'required',
            'zone_id'=>'required',
            'area_id'=>'required',
        ]);
        $data = $request->all();
        $data['customer_id'] = auth()->user()->id;
        if ($request->input('default_address') == 1) {
            $addresses = CustomerAddress::where('customer_id', auth()->user()->id)->get();
            foreach ($addresses as $address){
                if ($address->default_address == 1) {
                    $update_data['default_address'] = 0 ;
                    $address->update($update_data);
                }
            }
        }
        CustomerAddress::create($data);
        return response()->json(['msg'=>'Address Saved Successfully']);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'address'=>'required',
            'city_id'=>'required',
            'zone_id'=>'required',
            'area_id'=>'required',
        ]);
        $data = $request->all();

        if ($request->input('default_address') == 1) {
            $addresses = CustomerAddress::where('customer_id', auth()->user()->id)->get();
            foreach ($addresses as $address){
                if ($address->default_address == 1) {
                    $update_data['default_address'] = 0 ;
                    $address->update($update_data);
                }
            }
        }
        $address_update = CustomerAddress::findOrFail($id);
        $address_update->update($data);
        return response()->json(['msg'=>'Address Updated Successfully']);
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

    public function get_customer_address_for_edit($address_id)
    {
        $address = Address::findOrFail($address_id);
        return response()->json($address);
    }

    /**
     * @throws ValidationException
     */
    public function update_customer_address(Request $request, $address_id)
    {
        $this->validate($request, [
            'address'=>'required',
            'division_id'=>'required',
            'phone'=>'required',
            'district_id'=>'required',
            'upazila_id'=>'required',
        ]);
        $address = Address::findOrFail($address_id);
        $address->update($request->all());
        return response()->json(['msg'=>'Address Updated Successfully']);
    }
}
