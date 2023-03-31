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
<div class="modal fade" id="addNewProduct" tabindex="-1" role="dialog" aria-labelledby="addNewProduct" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createJob">Create New Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
            
                <form id="productSubmit" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    		    	@csrf
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                <label for="product_title" class="form-label">Product Name <span style="color:red">*</span> </label>
    		                <input class="form-control" id="product_title" type="text" placeholder="Product Name" value="{{old('product_title')}}" name="product_title" title="Product Name" />
    		            </div>
    		            <div class="col-md-6 mb-3">
    		                <label for="validationDefault02"> Upload Image<span style="color:red">*</span></label>
    		                 <input type="file" name="product_image" class="form-control" placeholder="image" value="{{old('product_image')}}">
    		            </div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                <label for="type" class="form-label">
    		                    Type
    		                    <span style="color:red">*</span>
    		                </label>
    		                <select name="type" id="type" class="form-control" aria-label="type" value="{{ old('type') }}">
                                <option value="0" selected>Subscription</option>
                                <option value="Month">Month</option>
                                <option value="Year">Year</option>
                            </select>
    		            </div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                <label for="price" class="form-label">Price</label>
    		                <input type="text" class="form-control" id="price" name="price" value="{{old('price')}}" placeholder="Enter Price">
    		            </div>
                    </div>	
                    <div class="row">
    		            <div class="col-md-6 mb-3">
    		                <label for="term" class="form-label">
    		                    Term
    		                    <span style="color:red">*</span>
    		                </label>
    		                <select name="term" id="term" class="form-control" aria-label="term" value="{{ old('term') }}">
                                <option value="Per User/Month" selected>Per User/Month</option>
                                <option value="Per User/year">Per User/year</option>
                            </select>
    		            </div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descraption</label>
                            <textarea  class="summernote" type="text" name="description" id="description" value="{{old('description')}}"></textarea>
    			      	</div>
    		        </div>
    
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                 <button class="btn btn-primary" type="submit" >Create Product </button>
    					</div>
    		        </div>
		        </form>
            </div>
        </div>
    </div>
</div>
@foreach($productList as $productInfo)
<div class="modal fade" id="editProduct{{ $productInfo->id }}" tabindex="-1" role="dialog" aria-labelledby="editProduct" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createJob">Edit Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
            
                <form id="productEditSubmit{{ $productInfo->id }}" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    		    	@csrf
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                <label for="product_title" class="form-label">Product Name<span style="color:red">*</span></label>
    		                <input class="form-control" id="product_title" type="text" placeholder="Product Name" value="{{ $productInfo->title}}"  name="product_title" title="Product Name" />
    		                <input id="product_id" type="hidden" value="{{ $productInfo->id}}"  name="product_id"/>
    		            </div>
    		            <div class="col-md-6 mb-3">
    		                <label for="validationDefault02"> Upload Image </label>
    		                 <input type="file" name="product_image" class="form-control" placeholder="image" value="{{old('product_image')}}">
    		            </div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                <label for="type" class="form-label">
    		                    Type
    		                    <span style="color:red">*</span>
    		                </label>
    		                <select name="type" id="type" class="form-control" aria-label="type" value="{{ old('type') }}">
                                <option value="0" selected>Subscription</option>
                                <option value="Month" @if($productInfo->type =='Month') selected @endif>Month</option>
                                <option value="Year" @if($productInfo->type =='Year') selected @endif>Year</option>
                            </select>
    		            </div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                <label for="price" class="form-label">Price<span style="color:red">*</span></label>
    		                <input type="text" class="form-control" id="price" name="price" value="{{ $productInfo->price }}" placeholder="Enter Price">
    		            </div>
                    </div>	
                    <div class="row">
    		            <div class="col-md-6 mb-3">
    		                <label for="term" class="form-label">
    		                    Term
    		                    <span style="color:red">*</span>
    		                </label>
    		                <select name="term" id="term" class="form-control" aria-label="term" value="{{ old('term') }}">
                                <option value="Per User/Month" selected>Per User/Month</option>
                                <option value="Per User/year">Per User/year</option>
                            </select>
    		            </div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descraption</label>
                            <textarea type="text" name="description" class="form-control"  id="description" value="{{ $productInfo->description }}"></textarea>
    			      	</div>
    		        </div>
    
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                 <button class="btn btn-primary" type="submit" >Save Changes </button>
    					</div>
    		        </div>
		        </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#productEditSubmit{{ $productInfo->id }}').on('submit', function(event) {
    	event.preventDefault();                          // for demo
     
        $.ajax({
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            type: "POST",
            url: window.baseUrl + '/product_update',
            success:function(data) {
            	if($.isEmptyObject(data.error)){
                    Swal.fire(
                      'success!',
                      'Your record has been saved',
                      'success'
                    );
                    
                    $('#productSubmit').modal('hide');
                }else{
                    printErrorMsg(data.error);
                }
               
               
            }
        }); 
    });
</script>
@endforeach
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
                <div class="row">
                    <div class="col-md-6">
    	              	<h3 class="product_title">Product </h3>
    	            </div>
    	       
    	            <div class="col-md-6">
    	                <h3 class="pull-right">
        	              	 <a href="javascript:void(0)" class="btn btn-primary text-white"  data-toggle="modal" data-target="#addNewProduct" title="Add new Product">
    	                        Add new Product
    	                     </a>
                         </h3>
    	            </div>
	            </div>
        
                <div class="dt-ext">
                  	 <table class="display dataTable global" id="global">
                        <thead>
                          	<tr>
	                            <th style="display:none">Sl</th>
	                            <th>Product Name</th>
	                            <th>Type</th>
	                            <th>Status</th>
	                            <th>Cost</th>
	                            <th></th>
                          	</tr>
                        </thead>
                        <tbody>
                        	@php $sl = 1; @endphp

                        	@foreach($productList as $productInfo)
		                         <tr id="product_delete_{{$productInfo->id }}">
		                            <td style="display:none">{{ $sl++ }}</td>
		                            <td>
		                                <div class="thumbnail_image">
    		                                <span class="icon_thumbnails">
    		                                    @if(!empty($productInfo->thumbnail))
    		                                    <img src="{{ asset('images/uploads/products_thumb/'. $productInfo->thumbnail )}}" >
    		                                    @endif
    		                                </span>
    		                                <span class="productName">
    		                                    {{ $productInfo->title }}
    		                                </span>
		                                </div>
		                            </td>
		                            
		                            <td>{{ $productInfo->type }} </td>
		                     
    		                        <td>
		                                <button type="button" class="btn btn-primary text-white status-button" title="Live" style="background: #19A46A !important;border:1px solid #19A46A !important;">
            		                         <span class="status-button-text">Live</span>
            		                    </button>
            		                </td>
        		                    <td>{{ $productInfo->price }} </td>
		                            <td>
		                                <div class="dropdown">
                                            <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                . . .
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="action_button">
                                                <a class="dropdown-item" href="javascript:void(0)" class="btn btn-primary text-white"  data-toggle="modal" data-target="#editProduct{{ $productInfo->id }}" title="Edit Product" style="float: left;font-size: 19px;">Edit</a> 
                                                <a class="dropdown-item" onclick="deleteData('{{ $productInfo->id }}')" href="javascript:void(0)" style="float: left;font-size: 19px;">Delete</a> 
                                            </div>
                                        </div>
		                                
		                            </td>
		                        </tr>
		                  
                          	@endforeach
                        </tbody>
                  </table>
               
                </div>
            
		</div>
	</div>
</div>
<script type="text/javascript">
    function deleteData(id) {
        Swal.fire({
            title: 'Delete Product',
            text: "Are You Sure You want to delete Type 'DELETE' to delete",
            input: 'text',
            inputAttributes: {
                id: 'delete_text'
            },
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete Product'
        }).then((result) => {
            
            var deleteVar = $('#delete_text').val();
            
         
            if (result.isConfirmed && deleteVar == 'DELETE') {
              
                // window.location.href = link;
                $.ajax({
                type: "POST",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id,
                  
                },
                url: baseUrl +'/admin/products/delete' , 
                success: function(HTML) {
                   $('#product_delete_'+id).hide();
                    Swal.fire(
                      'Deleted!',
                      'Your record has been deleted',
                      'success'
                    );
                }
            
            });
            } else{
                Swal.fire({
                  icon: 'error',
                  title: 'Sorry',
                  text: 'Confirmation text wrong!',
                
                })
            }
        
    
    });
    }
    
    $('#productSubmit').on('submit', function(event) {
    	event.preventDefault();                          // for demo
     
        $.ajax({
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            type: "POST",
            url: window.baseUrl + '/product_submit',
            success:function(data) {
            	if($.isEmptyObject(data.error)){
                    Swal.fire(
                      'success!',
                      'Your record has been add',
                      'success'
                    );
                    
                    $('#addNewProduct').modal('hide');
                }else{
                    printErrorMsg(data.error);
                }
               
               
            }
        }); 
    });
    
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
</script>
@endsection
