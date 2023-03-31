<?php

namespace App\Http\Controllers\API\Backend\Transaction;

use App\Http\Controllers\API\Backend\Order\OrderPriceCalculator;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $order_number)
    {
        $this->validate($request, [
            'amount'=>'required',
            'payment_method_id'=>'required',
        ]);
        $order = Order::with('order_product')->where('order_number', $order_number)->first();
        if ($order) {
            $data = $request->except('order_id');
            $amount = OrderPriceCalculator::calculate_total_price($order->order_product);
            if ($request->input('amount') >= $amount['amount_after_discount']) {
               $order_data['payment_status_id'] = 1;
            }else{
                $order_data['payment_status_id'] = 3;
            }
            $order->update($order_data);

//            $data['order_id'] = $order->id;
           $transaction =  Transaction::create($data);

            $transaction->orders()->attach([$order->id]);

        }
        return response(['msg'=>'Transaction Added Successfully']);
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

    public function get_my_transaction()
    {
        $transaction = Customer::with('transactions')->findOrFail(auth()->user()->id);
        return response()->json($transaction);


    }
}
