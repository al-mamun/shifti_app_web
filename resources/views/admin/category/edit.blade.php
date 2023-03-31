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
				    <form action="{{route('category.update',$category->id)}}" method="POST" enctype="multipart/form-data">
				    	@csrf
			            @method('PUT')
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Category Name</label>
				                <input class="form-control" id="validationDefault01" type="text" placeholder="Category Name" value="{{$category->category_name}}" name="category_name" data-original-title="" title="Category" />
				                <input class="form-control aria-hidden type-id" name="product_type_id" id="product_type_id" type="text"  title="" />
				            </div>
				        </div>
				      
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Icon</label>
				               <input type="file" name="icon" class="form-control mt-2" placeholder="Update Photo" value="{{$category->icon}}">
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Feature photo</label>
				                <input type="file" name="feature_photo" class="form-control mt-2" placeholder="Update Photo" value="{{$category->feature_photo}}">
							</div>
			            </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                 <button class="btn btn-primary" type="submit" data-original-title="" title="">Update </button>
							</div>
				        </div>
				       </form>
				   </div>
				</div>

			</div>

		</div>
	</div>
@endsection
