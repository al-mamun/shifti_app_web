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
<script type="text/javascript">
    $( document ).ready(function() {
        
        $(".payment_stripe").addClass("active");
        // $(".page_submenu").show();
        // $(".page_submenu").css('display','block !important');
    });
</script>
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            @if(Session::has('success'))
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('success')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                	 <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
        </div>
            <div class="row">
    		    <div class="col-md-6">
                  	<h3 class="page_title">Stripe Setup </h3>
                </div>
            </div>
		    <form action="{{ route('payment.store') }}" method="POST">
	            @csrf
                    <div class='row'>
                        <div class="col-md-6 mb-3">
                            <label class='control-label form-label'>Stripe Key</label> 
                            <input class='form-control' type='text' name="STRIPE_KEY" placeholder="Stripe Key" value="{{ $paymentMethod->STRIPE_KEY }}">
                        </div>
                    </div>

                    <div class='row'>
                        <div class="col-md-6 mb-3">
                            <label class='control-label form-label'>Stripe Secret</label> 
                            <input class='form-control' type='text' name="STRIPE_SECRET" placeholder="Stripe Secret" value="{{ $paymentMethod->STRIPE_SECRET }}">
                        </div>
                    </div>
                    <div class='row'>
                        <div class="col-md-6 mb-3">
                            <label class='control-label form-label'>Stripe Webhook Secret</label> 
                            <input class='form-control' type='text' name="STRIPE_WEBHOOK_SECRET" placeholder="Stripe Webhook Secret" value="{{ $paymentMethod->STRIPE_WEBHOOK_SECRET }}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
                        </div>
                    </div>
                    
                </div>
            </form>
          
    </div>
</div>


@endsection
