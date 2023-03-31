<?php

namespace App\Http\Controllers\API\Backend\Order;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOrderCount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductOrderCountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $product_id
     * @param $quantity
     * @return bool
     */
    public static function store(int $product_id, $quantity, $product_type_id): bool
    {
        $product_order_count = ProductOrderCount::where('product_id', $product_id)->first();
        if ($product_order_count) {
            $data['sold']= $product_order_count->sold+$quantity;
            $product_order_count->update($data);
        }else{
            $product = Product::findOrFail($product_id);
            if ($product && $product->parent != null) {
                $data['product_id'] = $product->parent;
            }else{
                $data['product_id'] = $product->id;
            }
            $data['sold'] = $quantity;
            $data['product_type_id'] = $product_type_id;
            ProductOrderCount::create($data);
        }
        return true;
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
     * @param Request $request
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
