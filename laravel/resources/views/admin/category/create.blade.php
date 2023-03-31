@extends('layouts.app')
@section('content')
<style type="text/css">
	.type-id{
		display: none;
	}
</style>
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
	              	<h3>Add new Category</h3>
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
				    <form action="{{url('admin/category/submit')}}" method="POST" enctype="multipart/form-data">
				    	@csrf
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Category Name <span style="color:red">*</span></label>
				                <input class="form-control" type="text" placeholder="Category Name" value="{{old('category_name')}}" name="category_name" title="Category" />
				                <input class="form-control aria-hidden type-id" name="product_type_id" id="product_type_id" type="text"  title="" />
				            </div>
				        </div>
				     
				        <input class="form-control type-id" type="hidden" placeholder="" value="1" name="product_type_id" />
				      
				        <input class="form-control" type="hidden" placeholder="slug" value="1001" name="slug" title="slug" />
				           
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Icon <span style="color:red">*</span></label>
				               <input type="file" name="icon" class="form-control mt-2" placeholder="Upload Photo">
				            </div>
				        </div>
				   <!--     <div class="row">-->
				   <!--         <div class="col-md-6 mb-3">-->
				   <!--             <label for="validationDefault01">Feature photo</label>-->
				   <!--             <input type="file" name="feature_photo" class="form-control mt-2" placeholder="Upload Photo">-->
							<!--</div>-->
			    <!--        </div>-->
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                 <button class="btn btn-primary" type="submit" >Submit </button>
							</div>
				        </div>
				       </form>
				   </div>
				</div>

			</div>

		</div>
	</div>
@endsection
