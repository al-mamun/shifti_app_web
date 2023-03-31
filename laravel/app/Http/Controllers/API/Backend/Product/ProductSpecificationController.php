<?php

namespace App\Http\Controllers\API\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductSpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function get_product_specifications($id)
    {
        $specifications = ProductSpecification::where('product_id', $id)->get();
        return $specifications;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $specification
     */
    public function store($specification)
    {
        return ProductSpecification::create($specification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function get_product_specifications_for_edit($id)
    {
        $specifications = ProductSpecification::select('value', 'name')->where('product_id', $id)->get();
        $fixed_specifications_array = [];
        $dynamic_specifications_array = [];
        $filed_list = ['weight', 'color', 'height', 'size', 'width'];

        foreach ($specifications as $specification) {
            $data = [$specification->name, $specification->value];
            if (in_array($specification->name, $filed_list)) {
                array_push($fixed_specifications_array, $data);
            } else {
                array_push($dynamic_specifications_array, $data);
            }

        }
        return response()->json(['fixed_specifications' => $fixed_specifications_array, 'dynamic_specifications' => $dynamic_specifications_array]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $specification = ProductSpecification::findOrFail($id);
        $specification->delete();
    }

    public function delete_product_specifications(Request $request)
    {
        $specifications = ProductSpecification::where('product_id', $request->product_id)->where('name', $request->name)->first();
        $specifications->delete();
        return response()->json(['msg' => 'Specifications Deleted Successfully']);
    }

}
