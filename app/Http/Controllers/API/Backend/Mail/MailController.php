<?php

namespace App\Http\Controllers\API\Backend\Mail;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = [
            'name'=>'Naimul Hasan',
            'amount'=>'250tk',
            'total_amount'=>'250tk',
            'order_number'=>'1000052',
            'order_url'=>env('APP_URL').'/dashboard-invoice-details/1000052',
            'pay_link'=>env('APP_URL').'/dashboard-invoice-details/1000052',
            'product' => [
                [
                    'product_name'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, nulla! consectetur adipisicing elit. Fugit, nulla!',
                    'quantity'=>5,
                    'image' =>env('API_URL').'/images/uploads/products_thumb/'.'1-more-dual-driver-in-ear-headphones-e1017-black-100270-78203.webp',
                    'attributes'=>[
                        'color'=>'red', 'size' =>'M'
                    ]
                ],
            ],
        ];
        //return view('emails.order.orderConfirmation', compact('details'));
        Mail::to('naim.iithost@gmail.com')->send(new OrderConfirmationMail($details));
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
