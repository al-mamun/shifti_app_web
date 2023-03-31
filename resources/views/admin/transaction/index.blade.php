@extends('layouts.app')

@section('content')
<script type="text/javascript">
    $( document ).ready(function() {
        
        $(".transaction_history").addClass("active");
        // $(".page_submenu").show();
        // $(".page_submenu").css('display','block !important');
    });
</script>
<div class="modal fade" id="customerList" tabindex="-1" role="dialog" aria-labelledby="customerList" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createSupport">View Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
               <table class="borderless display global table" id="global2">
                  	<tr>
                      	<tr>
                            <th></th>
                            <th>Company Name</th>
                            <th>Date Joined</th>
                            <th>Contact Email</th>
                            <th>Monthly Subscription</th>
                      	</tr>
                      	<tr>
                      	    <td><img src="{{  URL::asset('images/partner/202301Fri003424.png')}}" width="60px"></td>
                      	    <td>1</td>
                      	    <td>2</td>
                      	    <td>3</td>
                      	    <td>4</td>
                      	</tr>
                  	</tr>
                  	<tr>
                       <th></th>
                       <th><b>Contact Phone</b></th>
                       <th><b>Custom Domain</b></th>
                       <th><b>Company Plan</b></th>
                       <th><b>Paid Users</b></th>
                  	</tr>
                    <tr>
                        <td></td>
                        <td>+865752</td>
                        <td>example.com</td>
                        <td>lorem ipsum</td>
                        <td>lorem</td>
                    </tr>
                  	<tr>
                       <th></th>
                       <th><b>Paid Status</b></th>
                       <th><b>Account Status</b></th>
                  	</tr>
                    <tr>
                        <td></td>
                        <td>
                             <button type="submit" class="btn btn-primary text-white status-button pending" title="open"><span class="status-button-text open">Pending</span></button>
                    	</td>
                        <td>
                            <button type="submit" class="btn btn-primary text-white status-button approved" title="open"><span class="status-button-text open">Active</span> </button>
                    	</td>
                      
                    </tr>
                    <tr>
                        <th>Subscription & Add-Ons</th>
                    </tr>
                  	<tr>
                        <th>Subscription/Add-On</th>
                        <th>Start Date</th>
                        <th>Amount</th>
                        <th>Monthly Subscription</th>
                  	</tr>
                    <tr>
                         <td>1</td>
                         <td>2</td>
                         <td>3</td>
                         <td>4</td>
                    </tr>
              </table>

        </div>
    </div>
  </div>
</div>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
			 @if(Session::has('success'))
	          <div class="alert alert-success alert-dismissible fade show" role="alert">
	            <strong>{{ Session::get('success')}}</strong>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            	 <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	        @endif
			<!-- Ajax data source array start-->
            <div class="col-sm-12">
              
                      <div class="row">
        	            <div class="col-md-9">
        	              	<h3>Transactions</h3>
        	            </div>
        	            <div class="col-md-3">
        	              	<h3 class="pull-right"><a href="#" class="btn btn-primary">Manual Transaction</a></h3>
        	            </div>
        	            <!--<div class="col-md-2.5">-->
        	            <!--  	<h3 class="pull-right"><a href="#" class="btn btn-primary">ONBOARD COMPANY</a></h3>-->
        	            <!--</div>-->
        	        </div>
                    <div class="">
                      	<div class="dt-ext ">
                      	 <table class="display global" id="global">
	                        <thead>
	                          	<tr>
		                            <th></th>
		                            <th>Company Name</th>
		                            
		                            <th>Date Of Payment</th>
		                            <th>Status</th>
		                            <th>Amount Paid</th>
		                            <th></th>
		                         
	                          	</tr>
	                          	</tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($customers as $list)
		                         <tr id="customer_id_{{$list->id}}">
		                            <td>
		                                @if(!empty($list->photo))
		                                    <img src="{{  URL::asset('upload/customer/'.$list->photo)}}" class="author_image">
		                                @else
		                                    <img src="{{  URL::asset('upload/customer/author_4.png')}}" class="author_image">
		                                @endif
		                            </td>
		                            <td>{{ $list->first_name.''.$list->last_name }}</td>
		                            <td>
		                                @php
                                            $date = date("F d, Y", strtotime( $list->created_at));
                                        @endphp
                                        {{ $date }}
		                            </td>
		                            <td>
		                                    @if($list->status == 1)
    		                                    <button type="submit" class="btn btn-primary text-white status-button approved" title="open">
                    		                         <span class="status-button-text open">Active</span>
                    		                    </button>
					                        @elseif($list->status == 2)
					                            <button type="submit" class="btn btn-primary text-white status-button pending" title="open">
                    		                         <span class="status-button-text open">On Notice</span>
                    		                    </button>
					                        @else
					                            <button type="submit" class="btn btn-primary text-white status-button reject" title="open">
                    		                         <span class="status-button-text open">Suspended</span>
                    		                    </button>
					                        @endif
					                </td>
		                            
		                             <td>$78751.00</td>
		                                <td>
                                            <div class="dropdown">
                                                <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    . . .
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="action_button">
                                                    <a class="dropdown-item" onClick="viewCustomer'{{$list->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;" data-toggle="modal" data-target="#customerList">View</a>
                                                </div>
                                            </div>
                                            
                                        </td>
		                             <!-- <td>
		                           	 <form class="text-center" action="{{route('joblist.destroy',$list->id)}}" method="POST">
					                      <a class="btn btn-primary btn-xs text-white" href="{{route('joblist.edit',$list->id)}}" title=""><i data-feather="edit-3"></i></a>

					                       @csrf
					                       @method('DELETE')
					                      <button type="submit" class="btn btn-danger btn-xs text-white" title="Delete">
					                         <i data-feather="trash-2"></i>
					                      </button>
					                    </form>
					                   
		                            </td>-->
		                        </tr>
	                          	@endforeach
	                        </tbody>
                      </table>
                   
                  </div>
                </div>
            </div>


		</div>
	</div>
</div>
<!--<div class="page-body">-->
<!--    <div class="container-fluid">-->
<!--        <div class="page-header">-->
     
<!--	        <div class="row">-->
<!--	            <div class="col-lg-6">-->
<!--	              	<h3>Transactions</h3>-->
<!--	            </div>-->
<!--	        </div>-->
<!--	           <div class="table-responsive">-->
<!--              	 <table id="datatablesSimple" class="table global" id="global">-->
<!--                    <thead>-->
<!--                      	<tr>-->
<!--                          <th>SL.</th>-->
<!--		                  <th>PAYMENT ID </th>-->
<!--		                  <th>AMOUNT </th>-->
<!--		                  <th>AMOUNT CAPTURED </th>-->
<!--		                  <th>AMOUNT REFUNDED </th>-->
<!--		                  <th>PAID</th>-->
<!--		                  <th>PAYMENT METHOD</th>-->
<!--		                  <th width="50">Action</th>-->
                         
<!--                      	</tr>-->
<!--                    </thead>-->
<!--                    <tbody>-->
<!--                        @php $sl = 1; @endphp-->
<!--                           @foreach($transactions  as $key=>$data)-->
<!--    		               <tr>-->
<!--    		                  <td>{{ $sl++ }}</td>-->
<!--    		                  <td><span style="width:150px; display:block;">{{ $data->paymend_id }}</span></td>-->
<!--    		                  <td>{{ $data->amount}}</td>-->
<!--    		                  <td>{{ $data->amount_captured }}</td>-->
<!--    		                  <td>{{ $data->amount_refunded }}</td>-->
<!--    		                  <td>{{ $data->paid }}</td>-->
<!--    		                  <td><span style="width:150px; display:block;">{{ $data->payment_method }}</span></td>-->
<!--    		                  <td>-->
<!--    		                      <a href="{{ route('tarnsaction.show',$data->id) }}" class="btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a> -->
<!--    		                  </td>-->
    		             
<!--    		                </tr>-->
<!--    		              @endforeach-->
         
<!--                    </tbody>-->
<!--                  </table>-->
<!--            </div>-->
			

<!--		</div>-->
<!--	</div>-->
<!--</div>-->
@endsection
