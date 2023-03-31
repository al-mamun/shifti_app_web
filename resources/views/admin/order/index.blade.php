@extends('layouts.app')
@section('content')
  <style>
    .custom-btn a{
        background: #FF6347 !important;
        color:#fff;
        padding:10px 15px 10px 15px;
        border-radius:5px;
    }
    .card .card-body {
        padding: 23px  17px;
        background-color: rgba(0,0,0,0);
    }
</style>
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".order_menu_title").addClass("active");
        $(".order_submenu").show();
        $(".order_submenu").css('display','block !important');
    });
    
</script>
<div class="page-body">
  
    <div class="container-fluid">
        <div class="page-header">
            <div class="card">
			   <div class="card-body">
			        <div class="row">
        	            <div class="col-lg-6">
        	              	<h3>Menage Orders</h3>
        	            </div>
        	        </div>
                    <div class="row">
        	          
        	        </div>
                  	<div class="row">
        	            <div class="col-md-12 mt-3 custom-btn">
        	              	<span><a href="#"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp;Print</a></span>
        	              	<!--<span><a href="#"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp;Shipping Label</a></span>-->
        	               <!-- <span><a href="#">Export&nbsp;&nbsp;<i class="fa fa-arrow-down" aria-hidden="true"></i></a> </span>-->
    	            
        	            </div>
        	        </div>
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
			
	       @if(Session::has('success'))
	          <div class="alert alert-success alert-dismissible fade show" role="alert">
	            <strong>{{ Session::get('success')}}</strong>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            	 <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	        @endif
	        <div class="card">
			    
    	            <div class="col-md-10 mt-3">
    	              	 <h5>All Orders</h5>
    	            </div>
                    <div class="row py-2 px-2">
        	            <div class="col-md-4 mt-3">
        	              	 <select class="custom-select">
                              <option selected>Set Status</option>
                              <option value="1">Approved</option>
                              <option value="1">Cancelled</option>
                              <option value="1">Pending</option>
                              <option value="1">Deliverd</option>
                              <option value="1">In Transit</option>
                              <option value="1">Ready to ship</option>
                            </select> 
        	            </div>
        	            <div class="col-md-5 mt-3 custom-btn">
        	              	 <a href="#">Apply</a> 
        	            </div>
        	            <div class="col-md-3 mt-3">
        	              	   <div class="input-group">
    	                          <input type="text" class="form-control" placeholder="Search">
    	                          <div class="input-group-append">
                                    <button type="button">
                                     <i class="fa fa-search"></i>
                                    </button>
                                  </div>
                              </div>
        	            </div>
    	            </div>
			    <div class="card-body">
				    <div class="card-content">
		           <table id="datatablesSimple" class="table">
		              <tr style="color:#000">
		                  <th><input class="form-check-input" type="checkbox" value="" id="defaultCheck1"></th>
		                  <th>ORDER NO</th>
		                  <th>DATE</th>
		                  <th>CUST NAME</th>
		                  <th>EMAIL</th>
		                  <th>ADDRESS</th>
		                  <th>PAYMENT</th>
		                  <th>TOTAL</th>
		                  <th>STATUS</th>
		                  <th width="100">ACTION</th>
		              </tr>
		             @foreach($orderList as $key=>$data)
		               <tr>
		                  <td><span style="display:none">{{ $key+1 }} </span> <input class="form-check-input" type="checkbox" value="" id="defaultCheck1"></td>
		                  <td>{{ $data->order_number }}</td>
		                  <td>{{ $data->created_at }}</td>
		                  <td>{{ $data->customer->first_name }}</td>
		                  <td>{{ $data->customer->email }}</td>
		                  <td>{{ $data->customer->address }}</td>
		                  <td>Paid</td>
		                  <td>{{ $data->total }}</td>
		                  <td>Pending</td>
		                  <td>
		                      <a href="{{route('order.show',$data->id)}}" class="btn-light btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a> 

		                      <a href="#" id="delete" class="btn-light btn-sm"><i class="fa fa-print" aria-hidden="true"></i></a> 
		                  </td>
		                </tr>
		              @endforeach
		          </table>
	           </div>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection
