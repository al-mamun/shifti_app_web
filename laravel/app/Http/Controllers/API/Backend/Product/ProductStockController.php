<?php

namespace App\Http\Controllers\API\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response|int
     */
    public function calculate_product_stock($id)
    {
        $stock = 0;
        $product = Product::findOrFail($id);
        if ($product->variation_product == 1) {
            $child_products = Product::where('parent', $id)->get();
            foreach ($child_products as $child_product){
                $stock+=$child_product->stock;
            }
        }else{
            $stock = $product->stock;
        }
        return $stock;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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
        //
    }
}
