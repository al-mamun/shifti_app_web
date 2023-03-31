@extends('layouts.app')
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
	        <div class="card">
	            	<div class="row">
                        <div class="col-md-6 px-5 py-4">
                            <h3>Transaction History</h3>
                        </div>
                        <div class="col-md-6 px-5 py-4">
                            <div class="float-right">
                                <a class="pt-2 d-inline-block" href="{{ url('/transaction/history') }}" data-abc="true"><i class="fa fa-list" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
			    <div class="card-body">
		              <div class="table-responsive-sm">
                        <table class="table table-striped">
                         
                            <tbody>
                                    <tr>  
                                       <td>PAYMENT ID </td>
                                       <td>{{ $paymentHistory->paymend_id}}</td>
                                    </tr>
                                    <tr>
        		                       <td>AMOUNT </td>
		                               <td>{{ $paymentHistory->amount}}</td>
                                    </tr>
                                    <tr>
        		                        <td>AMOUNT CAPTURED </td>
		                                <td>{{ $paymentHistory->amount_captured }}</td>
                                    </tr>
                                    <tr>
        		                        <td>AMOUNT REFUNDED </td>
		                                <td>{{ $paymentHistory->amount_refunded }}</td>
                                    </tr>
                                    <tr>
        		                        <td>PAID</th>
		                                <td>{{ $paymentHistory->paid }}</td>
                                    </tr>
                                    <tr>
        		                        <td>PAYMENT METHOD</td>
		                                <td>{{ $paymentHistory->payment_method}}</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</div>
@endsection
