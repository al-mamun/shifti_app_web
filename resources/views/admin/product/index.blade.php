@extends('layouts.app')

@section('content')
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".product_menu_title").addClass("active");
        $(".product_submenu").show();
        $(".product_submenu").css('display','block !important');
    });
    
</script>
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
	        @if(isset($status) && $status =='updated')
	            <div class="alert alert-success alert-dismissible fade show" role="alert">
    	            <strong>Product updated successfully</strong>
    	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    	            	 <span aria-hidden="true">&times;</span>
    	            </button>
    	          </div>
    	    @elseif(isset($status) )
    	        <div class="alert alert-success alert-dismissible fade show" role="alert">
    	            <strong>Product create successfully</strong>
    	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    	            	 <span aria-hidden="true">&times;</span>
    	            </button>
    	          </div>
	        @endif
	        
	        
	        
			<!-- Ajax data source array start-->
            <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Product List</h5>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      	<div class="dt-ext table-responsive">
                      	 <table class="display" id="basic-1">
	                        <thead>
	                          	<tr>
		                            <th>Sl</th>
		                            <th>Product Name</th>
		                            <th>Price</th>
		                            <th>Category Name</th>
		                            <th>Tag</th>
		                            <th>Image</th>
		                            <th>sku</th>
		                            <th>stock</th>
		                            <th>Product Cost</th>
		                            <th>Action</th>
	                          	</tr>
	                        </thead>
	                        <tbody>
	                        	@php $sl = 1; @endphp

	                        	@foreach($productList as $productInfo)
    	                        	@if(!empty($productInfo->product_name))
    		                         <tr>
    		                            <td>{{ $sl++ }}</td>
    		                            <td>{{ $productInfo->product_name }}</td>
    		                            <td>{{ $productInfo->price }} </td>
    		                            <td>{{ $productInfo->category_name }} </td>
    		                            <td>{{ $productInfo->tag }} </td>
    		                            <td><img src="/image/{{ $productInfo->product_image }}" width="100px"></td>
    		                            <td>{{ $productInfo->sku }} </td>
    		                            <td>{{ $productInfo->stock }} </td>
    		                            <td>{{ $productInfo->product_cost }} </td>
    		                            <td>
    		                                  

		                                     <a href="{{route('product.edit',$productInfo->id)}}" style="float: left;font-size: 19px;"><i class="fa fa-edit" aria-hidden="true"></i></a> 
		          
    		                            	 <form class="text-center" action="{{route('product.destroy',$productInfo->id)}}" method="POST">
    					                         
    					                          @csrf
    					                           @method('DELETE')
        					                      <button type="submit" title="Delete" style="background: none;
                                                        border: 0px;
                                                        box-shadow: none !important;
                                                        padding: 0px !important;
                                                        color: #666 !important;">
                                                            					                         <i data-feather="trash-2"></i>
        					                      </button>
    					                    </form>
    		                            </td>
    		                        </tr>
    		                        @endif
	                          	@endforeach
	                        </tbody>
                      </table>
                      {{ $productList->links() }}
                    </div>
                    </div>
                  </div>
                </div>
            </div>


		</div>
	</div>
</div>
@endsection
