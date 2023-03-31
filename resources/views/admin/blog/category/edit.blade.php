@extends('layouts.app')

@section('content')
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        $(".blog_list a").addClass("active");
        $(".blog_list_data").show();
        $(".blog_list_data").css('display','block !important');
    });
    
</script>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<h3>Update Category</h3>
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">Category Tag</li>
		                <li class="breadcrumb-item active">Category Tag Details</li>
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
					 <form action="{{route('categorytag.update',$categoryTag->id)}}" method="POST" enctype="multipart/form-data">
				    	@csrf
			            @method('PUT')
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Category Name</label>
				                <input class="form-control" id="validationDefault01" name="tag_name" type="text" placeholder="Category name" data-original-title="" title="Category Name" value="{{$categoryTag->tag_name}}" />
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
