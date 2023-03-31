
@extends('layouts.app')

@section('content')
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".subscriber_list").addClass("active");
      
    });
    
</script>

<div class="modal fade" id="viewEmailHistory" tabindex="-1" role="dialog" aria-labelledby="viewEmailHistory" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createJob">View Email</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <form id="productSubmit" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    		    	@csrf
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		               <label for="product_title" class="form-label">Name:</label>
    		               John McGrill’d
    		            </div>
    		            <div class="col-md-6 mb-3">
    		               Date of Email:March 12, 2023
    		            </div>
    		        </div>
    		 
                    <div class="row">
    		            <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Email TItle</label>
                            <input name="title" name="title"  value="" class="form-control" />
    			      	</div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Email Body</label>
                            <textarea  class="summernote" type="text" name="description" id="description" value="{{old('description')}}"></textarea>
    			      	</div>
    		        </div>
    
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                 <button class="btn btn-primary" type="submit" >Replay </button>
    					</div>
    		        </div>
		        </form>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-fluid">
			<!-- Ajax data source array start-->
			    <div class="row">
                    <div class="col-md-6">
    	              	<h3 class="page-title-admin">Subscriber Email List </h3>
    	            </div>
    	       
    	            
	            </div>
	            <div class="row">
                    <div class="col-sm-12">
                        <div class="">
                          	<div class="dt-ext">
                          	 <table class="display global" id="global">
    	                        <thead>
    	                          	<tr>
    		                          
    		                            <th>Email</th>
    		                            <th>Date Of Email</th>
    		                        
    	                          	</tr>
    	                        </thead>
    	                        <tbody>
    	                        	@php $sl = 1; @endphp
    
    	                        	@foreach($emailSubscribe as $emails)
        	                        	@if(!empty($emails->email))
        		                         <tr>
        		                            <td>{{ $emails->email }}</td>
    		                                <td>{{ $emails->date }}  </td>
    		                                
    		                               
        		                        </tr>
        		                        @endif
    	                          	@endforeach
    	                        </tbody>
                          </table>
                          {{ $emailSubscribe->links() }}
                        </div>
                        </div>
                     </div>
                    </div>
                </div>
            </div>

@endsection

