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
	              	<h3>Add new JOb</h3>
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
				    <form action="{{route('joblist.store')}}" method="POST" enctype="multipart/form-data">
				    	@csrf
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="job_title">Job Title</label>
				                <input class="form-control" id="job_title" type="text" placeholder="Job Title" value="{{old('job_title')}}" name="job_title" title="job title" />
				               
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="job_title">Type</label>
				                <input type="text" class="form-control" id="type" name="type" value="{{old('type')}}" placeholder="Enter Job Type">
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="descraption">Job descraption</label>
				                <textarea type="text" name="descraption" class="summernote" placeholder="Enter Details"></textarea>
				                <!--<input class="form-control" id="descraption" type="text" placeholder="Job Title" value="{{old('job_title')}}" name="descraption" title="job title" />-->
				               
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="why_to_apply">Why To Apply</label>
				                <textarea type="text" name="why_to_apply" class="summernote" placeholder="Enter Details"></textarea>
				                <!--<input type="text" class="form-control" id="why_to_apply" name="type" value="{{old('type')}}" placeholder="Enter Job Type">-->
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="status">Job Category<span style="color:red">*</span></label>
    				    		<select name="job_category" class="form-control" aria-label="Default select example" required>
    							     <option value="" selected>Select Category</option>
    							     @foreach($jobcategories as $key=>$data)
    			                       <option value="{{ $data->name }}"> {{ $data->name }} </option>
    							     @endforeach
    							 </select>
				               
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Date</label>
				                <input type="date" class="form-control" id="validationDefault01" name="date" placeholder="Enter date">
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Expire Date</label>
				                <input type="date" class="form-control" id="validationDefault01" name="expire_date" placeholder="Enter expire_date">
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="status">Job Location<span style="color:red">*</span></label>
    				    		<select name="job_location" class="form-control" aria-label="Default select example" required>
    							     <option value="" selected>Select Location</option>
    							     @foreach($joblocations as $key=>$data)
    			                       <option value="{{ $data->location }}"> {{ $data->location }} </option>
    							     @endforeach
    							 </select>
				            </div>
				        </div>

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
