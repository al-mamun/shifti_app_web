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
          	<div class="row">
	            <div class="col-lg-6">
	              	<h3>Add new product</h3>
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">product</li>
		                <li class="breadcrumb-item active">product Details</li>
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

	       @if(Session::has('success'))
	          <div class="alert alert-success alert-dismissible fade show" role="alert">
	            <strong>{{ Session::get('success')}}</strong>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            	 <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	        @endif
	        <div class="card">
			    <div class="card-body">
					 <form action="{{route('product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
				    	@csrf
			            @method('PUT')
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="product_name">Product Name</label>
				                <input class="form-control" id="product_name" name="product_name" type="text" placeholder="Product name" data-original-title="" title="Product Name" value="{{$product->product_name}}" />
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="selling_price">Selling Price</label>
				                <input class="form-control" id="selling_price" type="text" placeholder="Selling Price" required="" data-original-title="" name="price" value="{{$product->price}}" />
				            </div>

				        </div>
				        <div class="row">
				           
				            <div class="col-md-6 mb-3">
				                <label for="discount_price">Discount Price</label>
				                <input class="form-control" id="discount_price" type="text" placeholder="Discount Price" required="" data-original-title="" title="Discount" name="discount_amount" value="{{$product->discount_amount}}"/>
				            </div>
				      
				        	<div class="col-md-6 mb-3">
					        	<label for="validationDefault02">Category</label>
				                <!-- Single Item Start -->
				                <div class="obd-preorder-add-product-bx-rt-inpt-fld">
				                   <select name="category_id" id="category_id" class="form-control form-select" aria-label="Default select example" value="{{old('category_id')}}">
								     <option >Select Category</option>
		                               @foreach($categoryList as $key=>$data)
					                    <option value="{{ $data->id }}" @if($data->id==$product->category_id) selected @endif>{{ $data->category_name }}</option>
					                  @endforeach
							    </select>
				                </div>
				            </div>
				            
						    <!-- Single Item End -->
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
					        	<label for="validationDefault02">Tag<span style="color:red">*</span></label>
				                <!-- Single Item Start -->
				                <div class="obd-preorder-add-product-bx-rt-inpt-fld">
				                   <select name="tag[]"  class="form-control select2" aria-label="Default select example" multiple>
								     <option >Select Tag</option>
								     @php $tags=[]; @endphp
		        					 @foreach($taglist as $key=>$data)
		        					    @if(!empty($product->tag))
		        					        @php $tags = explode(',', $product->tag); @endphp
		        					    @endif
		        					    
		        					    
		                                <option value="{{ $data->tag_name }}" @foreach($tags as $tagInfo) @if($tagInfo ==$data->tag_name ) selected @endif @endforeach>{{ $data->tag_name }}</option>
		                              @endforeach
							    </select>
				                </div>
				            </div>
				        </div>
				      	<div class="row">
				      		<div class="col-md-12 mb-3">
			      				<label for="description">Descraption</label>
			                      <textarea  class="summernote" type="text" name="description" id="description">{{$product->description}}</textarea>
			                </div>
				      	</div>

				      	<div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="sku">Sku</label>
				                <input class="form-control" id="sku" type="text" placeholder="sku" required="" data-original-title="" name="sku" value="{{$product->sku}}"/>
				            </div>

				            <div class="col-md-6 mb-3">
				                <label for="status">Status</label>
                                    <label for="status">Status<span style="color:red">*</span></label>
                                    <select name="status" id="status" class="form-control form-select" aria-label="Default select example" value="{{old('status')}}">
                                        <option >Select Status</option>
                                        <option value="1" @if($product->status == 1) selected @endif> Publish </option>
                                        <option value="0" @if($product->status == 0) selected @endif> Draft </option>
                                    </select>
        				          
        				        </div>
				                
				            </div>
				       
				      	<div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault02">Stock</label>
				                <input class="form-control" id="validationDefault02" type="text" placeholder="stock" required="" data-original-title="" name="stock" value="{{$product->stock}}" />
				            </div>

				            <div class="col-md-6 mb-3">
				                <label for="validationDefault02">Product cost</label>
				                <input class="form-control" id="validationDefault02" type="text" placeholder="Product Cost" required="" data-original-title="" title="Product Cost" name="product_cost" value="{{$product->product_cost}}"/>
				            </div>
				        </div>
				        <button class="btn btn-primary" type="submit" data-original-title="" title="">Update </button>
				    </form>
				   </div>
				</div>

			</div>

		</div>
	</div>
@endsection
