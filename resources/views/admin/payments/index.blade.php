@extends('layouts.app')

@section('content')
<style type="text/css">
	.slugs{
		display: none;
	}
	.hide{
	    display: none;
	}
</style>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<h3>Add new Payments</h3>
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">Payments</li>
		                <li class="breadcrumb-item active">Payments Details</li>
	              	</ol>
	            </div>
	        </div>
	        @if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
	        <div class="card">
	               @if(Session::has('success'))
    	           <div class="alert alert-success alert-dismissible fade show" role="alert">
    	            <strong>{{ Session::get('success')}}</strong>
    	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    	            	 <span aria-hidden="true">&times;</span>
    	            </button>
    	          </div>
    	        @endif
			    <div class="card-body">
			        <form action="{{ route('payment.store') }}" method="POST">
			        @csrf
                            <div class='row'>
                                <div class="col-md-6 mb-3">
                                    <label class='control-label'>STRIPE KEY</label> 
                                    <input class='form-control' type='text' name="STRIPE_KEY" placeholder="STRIPE KEY" value="{{ $paymentMethod->STRIPE_KEY }}">
                                </div>
                            </div>
      
                            <div class='row'>
                                <div class="col-md-6 mb-3 card">
                                    <label class='control-label'>STRIPE SECRET</label> 
                                    <input class='form-control' type='text' name="STRIPE_SECRET" placeholder="STRIPE SECRET" value="{{ $paymentMethod->STRIPE_SECRET }}">
                                </div>
                            </div>
                            <div class='row'>
                                <div class="col-md-6 mb-3 card">
                                    <label class='control-label'>STRIPE WEBHOOK SECRET</label> 
                                    <input class='form-control' type='text' name="STRIPE_WEBHOOK_SECRET" placeholder="STRIPE WEBHOOK SECRET" value="{{ $paymentMethod->STRIPE_WEBHOOK_SECRET }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3 card">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                 </div>
             </div>
        </div>
    </div>


@endsection
