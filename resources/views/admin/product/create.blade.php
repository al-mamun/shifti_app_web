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
<style>
    .row.other_box {
        margin: 16px 1px;
        border: 1px solid #eee;
        padding: 10px;
    }
</style>
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
				    <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
				    	@csrf
				        <div class="row">
				             <div class="col-md-6 mb-3">
					        	<label for="validationDefault02">Category<span style="color:red">*</span></label>
				                <!-- Single Item Start -->
				                <div class="obd-preorder-add-product-bx-rt-inpt-fld">
				                   <select name="category_id" id="category_id" class="form-control form-select" value="{{old('category_id')}}">
								     <option >Select Category</option>
		        					 @foreach($categoryList as $key=>$data)
		                                <option value="{{ $data->id }}">{{ $data->category_name }}</option>
		                              @endforeach
							    </select>
				                </div>
				            </div>
				            <div class="col-md-6 mb-3">
					        	<label for="validationDefault02">Tag<span style="color:red">*</span></label>
				                <!-- Single Item Start -->
				                <div class="obd-preorder-add-product-bx-rt-inpt-fld">
				                   <select name="tag[]"  class="form-control select2" aria-label="Default select example" multiple>
								     <option >Select Tag</option>
		        					 @foreach($taglist as $key=>$data)
		                                <option value="{{ $data->tag_name }}">{{ $data->tag_name }}</option>
		                              @endforeach
							    </select>
				                </div>
				            </div>
				        </div>
				        <div class="row">
				            
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Product Name<span style="color:red">*</span></label>
				                <input class="form-control" id="validationDefault01" name="product_name" type="text" placeholder="Product name"  title="Product Name" value="{{old('product_name')}}" />
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault02">Selling Price<span style="color:red">*</span></label>
				                <input class="form-control"  type="text" placeholder="Selling Price" required=""  name="price" value="{{old('price')}}" />
				            </div>
				        </div>
				         <div class="row">
				            
				            <div class="col-md-6 mb-3">
				                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-primary-1" type="checkbox" name="is_featured_products" value="1">
                                    <label for="checkbox-primary-1"> Featured products?</label>
                                </div>
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="product_type">Product type<span style="color:red">*</span></label>
				                <div class="form-group m-t-15 m-checkbox-inline mb-0">
				                   
				                    <div class="radio radio-primary">
                                        <input id="regular_product" class="regular_product" type="radio" name="type" value="1" checked>
                                        <label class="mb-0" for="regular_product">Regular</label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <input id="subscription" class="regular_product" type="radio" name="type" value="2">
                                        <label class="mb-0" for="subscription">Subscription based</label>
                                    </div>
                                </div>
				            </div>
				        </div>
				        <div class="row other_box" >
				            <table style="width:100%">
                                <tr>
                                    <td>
                                        <div class="">
            				                <label for="Discount">Title</label>
            				                <input class="form-control"  type="text" placeholder="title" title="title" name="sub_title[]" />
            				            </div>
                                    </td>
                                    <td>
                                        <div class="">
            				                <label for="Price">Price</label>
            				                <input class="form-control"  type="text" title="price" name="sub_price[]"/>
            				            </div>
                                    </td>
                                    <td>
                                        <div class="">
            				                <label for="type">Type</label>
            				                <input class="form-control"  type="text" placeholder="Day/Month/Year" title="type" name="sub_type[]" />
            				            </div>
                                    </td>
                                    <td>
                                        <div class="">
            				                <label for="type">Feuatre</label>
            				                <input class="form-control"  type="text" placeholder="Fetuare" title="feuture" name="feature[]" />
            				            </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-success" type="button" style="margin-top: 24px; margin-left: 11px; font-size: 21px;padding: 2px 14px;" id="button_success">
                                            +
                                        </button>
                                    </td>
                                </tr>
                                
                            </table>
				                
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault02">Discount Price</label>
				                <input class="form-control"  type="text" placeholder="Discount Price" title="Discount" name="discount_amount" value="{{old('discount_amount')}}"/>
				            </div>
				            
						     <div class="col-md-6 mb-3">
				                <label for="validationDefault02">Sku<span style="color:red">*</span></label>
				                <input class="form-control" id="validationDefault02" type="text" placeholder="sku" required=""  name="sku" value="{{old('sku')}}"/>
				             </div>
				        </div>
				      	<div class="row">
				      		<div class="col-md-12 mb-3">
			      				<label for="validationDefault02">Descraption</label>
			                      <textarea  class="summernote" type="text" name="description" id="description" value="{{old('description')}}"></textarea>
			                </div>
				      	</div>
				      	<div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault02">Status<span style="color:red">*</span></label>
				               <select name="status" id="status" class="form-control form-select" aria-label="Default select example" value="{{old('status')}}">
                                    <option >Select Status</option>
                                    <option value="0">Draft</option>
                                    <option value="1">Publish</option>
                                </select>
				            </div>
				            
				        </div>

				      	<div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault02">Stock<span style="color:red">*</span></label>
				                <input class="form-control" id="validationDefault02" type="text" placeholder="stock" required="" name="stock" value="{{old('stock')}}" />
				            </div>

				            <div class="col-md-6 mb-3">
				                <label for="validationDefault02">Product cost<span style="color:red">*</span></label>
				                <input class="form-control" id="validationDefault02" type="text" placeholder="Product Cost" required="" title="Product Cost" name="product_cost" value="{{old('product_cost')}}"/>
				            </div>
				            <div class="col-md-12 mb-3">
				                <label for="validationDefault02">Product Image<span style="color:red">*</span></label>
				                 <input type="file" name="product_image" class="form-control" placeholder="image" value="{{old('product_image')}}">
				            </div>
				            <div class="col-md-6 mb-3">
				                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-primary-1" type="checkbox" name="is_display_prduct" value="1">
                                    <label for="checkbox-primary-1"> Display Product ?</label>
                                </div>
				            </div>
				        </div>
				        <button class="btn btn-primary" type="submit">Submit </button>
				    </form>
				</div>

			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
$('.other_box').hide();
     $('.regular_product').click(function(){
        var currentStatus = $(this).val();
         
        if(currentStatus == 1) {
             $('.other_box').hide();
        }  else {
             $('.other_box').show();
        }
    
     });
    
    $(document).on("click",".button_minus",function() {
       $(this).parents("table").remove(); 
    });
    
    $('#button_success').click(function(){
        $('.other_box').append(' <table style="width:100%"> <tr> <td> <div class=""> <label for="Discount">Title</label> <input class="form-control" type="text" placeholder="title" title="title" name="sub_title[]"/> </div></td><td> <div class=""> <label for="Price">Price</label> <input class="form-control" type="text" title="price" name="sub_price[]"/> </div></td><td> <div class=""> <label for="type">Type</label> <input class="form-control" type="text" placeholder="Day/Month/Year" title="type" name="sub_type[]"/> </div></td><td> <div class=""> <label for="type">Feuatre</label> <input class="form-control" type="text" placeholder="Fetuare" title="feuture" name="feature[]"/> </div></td><td> <button class="btn btn-danger button_minus" type="button" style="margin-top: 24px; margin-left: 11px; font-size: 21px;padding: 2px 14px;"> -</button> </td></tr></table>');
    });
</script>
@endsection
