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
        
        $(".job_menu_title").addClass("active");
        $(".job_submenu").show();
        $(".job_submenu").css('display','block !important');
    });
    
</script>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<h3>Add new Job Category</h3>
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
				    <form action="{{route('categories.store')}}" method="POST" enctype="multipart/form-data">
				    	@csrf
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Job Category</label>
				                <input class="form-control" id="validationDefault01" type="text" placeholder="Enter Category Name" value="{{old('name')}}" name="name" />
				               
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                 <button class="btn btn-primary" type="submit" data-original-title="" title="">Submit </button>
							</div>
				        </div>
				       </form>
				   </div>
				</div>

			</div>

		</div>
	</div>
@endsection
