<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\PaymentHistory;
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
        $transactions=PaymentHistory::latest()->paginate(10);
        return view('admin.transaction.index',compact('transactions'))
                    ->with('i',(request()->input('page',1)-1)*10);
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
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentHistory $paymentHistory)
    {
        $paymentHistory = PaymentHistory::first();
        return view('admin.transaction.show',compact('paymentHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentHistory $paymentHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentHistory $paymentHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentHistory  $paymentHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentHistory $paymentHistory)
    {
        //
    }
}
