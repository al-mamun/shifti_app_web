@extends('layouts.app')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">Transaction</li>
		                <li class="breadcrumb-item active">Transaction History</li>
	              	</ol>
	            </div>
	        </div>
	        <div class="card">
			    <div class="card-body">
				    <div class="card-content">
		            <table class="table table-bordered" border="1">
		              <tr style="color:#000;font-size:13px;">
		                  <th>SL.</th>
		                  <th>PAYMENT ID </th>
		                  <th>AMOUNT </th>
		                  <th>AMOUNT CAPTURED </th>
		                  <th>AMOUNT REFUNDED </th>
		                  <th>PAID</th>
		                  <th>PAYMENT METHOD</th>
		                  <th width="50">Action</th>
		              </tr>
		             @foreach($transactions  as $key=>$data)
		               <tr>
		                  <td>{{ ++$i }}</td>
		                  <td><span style="width:150px; display:block;">{{ $data->paymend_id }}</span></td>
		                  <td>{{ $data->amount}}</td>
		                  <td>{{ $data->amount_captured }}</td>
		                  <td>{{ $data->amount_refunded }}</td>
		                  <td>{{ $data->paid }}</td>
		                  <td><span style="width:150px; display:block;">{{ $data->payment_method }}</span></td>
		                  <td>
		                      <a href="{{ route('tarnsaction.show',$data->id) }}" class="btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a> 
		                  </td>
		             
		                </tr>
		              @endforeach
		          </table>
		          {{ $transactions->links() }}
	           </div>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection
