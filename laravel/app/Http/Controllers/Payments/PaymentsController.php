<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Session;
class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethod = PaymentMethod::first();
        
        return view('admin.payments.index', compact('paymentMethod'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paymentMethod = PaymentMethod::first();
        $paymentMethod->STRIPE_KEY              = $request->STRIPE_KEY;
        $paymentMethod->STRIPE_WEBHOOK_SECRET   = $request->STRIPE_WEBHOOK_SECRET;
        $paymentMethod->STRIPE_SECRET            = $request->STRIPE_SECRET;
        $paymentMethod->save();
        
         return redirect('/payments')->with('success',"Updated Successfully");
    	
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $this->validate($request, [
            'STRIPE_KEY'=> 'required',
            'STRIPE_SECRET'=> 'required',
            'STRIPE_WEBHOOK_SECRET'=> 'required',
        ]);
        $paymentMethod = PaymentMethod::first();
        $paymentMethod->STRIPE_KEY = $request->STRIPE_KEY;
        $paymentMethod->STRIPE_SECRET = $request->STRIPE_SECRET;
        $paymentMethod->STRIPE_WEBHOOK_SECRET = $request->STRIPE_WEBHOOK_SECRET;
        $paymentMethod->save();
        return redirect('/payments')->with('success',"Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }
}
