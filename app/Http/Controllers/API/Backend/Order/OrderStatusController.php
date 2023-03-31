<?php

namespace App\Http\Controllers\API\Backend\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Order\OrderStatuesListResource;
use App\Models\Order;
use App\Models\OrderStatusDetails;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($order_number)
    {
        $statuses = OrderStatusDetails::with('user', 'shipping_status')->where('order_id', $order_number)->latest()->get();
        return OrderStatuesListResource::collection($statuses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function change_single_order_status(Request $request, $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        if ($order && $order->shipping_status_id != $request->input('shipping_status_id')) {
            $data['shipping_status_id'] = $request->input('shipping_status_id');
            $order->update($data);

            $status_data['order_id'] = $order->id;
            $status_data['user_id'] = auth()->user()->id;
            $status_data['shipping_status_id'] = $request->input('shipping_status_id');
            OrderStatusDetails::create($status_data);
        }

        return response()->json(['msg' => 'Status Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
