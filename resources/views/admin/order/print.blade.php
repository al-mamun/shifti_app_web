@extends('layouts.app')

@section('content')
<style>
    h5{
        font-size:16px !important;
        font-weight:400 !important;
    }
    h3{
        font-size:16px !important;
        font-weight:400 !important;
    }
    p{
       font-size:16px !important;
        font-weight:400 !important; 
    }
</style>
<div class="page-body">
    <div class="container-fluid">
            <div class="card">
                <div class="card-header p-4">
                    <div class="row mb-4">
                        <div class="col-md-4">
                             <a class="pt-2 d-inline-block" href="#" data-abc="true"><img width="150" src="{{URL::asset('shifti_logo.png')}}"></a>
                            <div>
                                <h3 class="mb-0 mt-2"> Shop Name:</h3> 
                                <h3 class="mb-0"> Address:</h3> 
                                <h3 class="mb-0">Phone:</h3> 
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="float-right">Date: {{ $order->created_at }} <h2 class="mb-0 mt-2">
                                Invoice #01</h2> 
                               <h5 class="mb-1 mt-3"> {{ $order->customer->first_name }}</h5>
                               <h5 class="mb-1 mt-3"> {{ $order->customer->address  }}</h5>
                               <h5 class="mb-1 mt-3"> {{ $order->customer->phone  }}</h5>
                            </div>
                        </div>
                    </div>
                   
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="center">#</th>
                                    <th>ORDER NO</th>
                                    <th>CUST NAME</th>
                                    <th>MOBILE</th>
                                    <th>ADDRESS</th>
                                    <th class="right">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="left strong">1</td>
                                    <td class="left strong">{{ $order->order_number }}</td>
                                    <td class="left">{{ $order->customer->first_name  }}</td>
                                    <td class="right">{{ $order->customer->phone }}</td>
                                    <td class="center">{{ $order->customer->address }}</td>
                                    <td class="right">{{ $order->total + 25.50 }}</td>
                                </tr>
   
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-5">
                        </div>
                        <div class="col-lg-4 col-sm-5 ml-auto">
                            <table class="table table-clear">
                                <tbody>
                                <tr>
                                    <td class="left">
                                    <strong class="text-dark">Subtotal</strong>
                                    </td>
                                    <td class="right">100</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                    <strong class="text-dark">Discount (0%)</strong>
                                    </td>
                                    <td class="right">100</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                    <strong class="text-dark">Total</strong>
                                     </td>
                                    <td class="right">
                                    <strong class="text-dark">{{ $order->total + 25.50 }}</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
	                  <div class="col-md-6">
	                      <p class="mb-0">Thank you for your oder!</p>
                          <p class="mb-0">If you have any question, please fell free to contact us</p>
	                  </div>
	                  <div class="col-md-6 float-right">
	                      <p class="float-right mt-0 mb-0"><a href="https://mamundevstudios.com/">www.mamundevstudios.com</a></p>
	                  </div>
	                </div>
                </div>
            </div>
        
	</div>
</div>
@endsection
