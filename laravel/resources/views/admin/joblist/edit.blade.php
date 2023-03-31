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
	              	<h3>Update job</h3>
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
				    <form action="{{route('joblist.update',$joblist->id)}}" method="POST" enctype="multipart/form-data">
				    	@csrf
			            @method('PUT')
		                <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Job Title</label>
				                <input class="form-control" id="validationDefault01" type="text" name="job_title" value="{{ $joblist->job_title }}" />
				               
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="job_title">Type</label>
				                 <input class="form-control" id="validationDefault01" type="text" name="type" value="{{ $joblist->type }}">
				            </div>
				        </div>
		                <div class="row">
				           <div class="col-md-6 mb-3">
				                <label for="descraption">Job descraption</label>
				                <textarea type="text" name="descraption" class="summernote">{{ $joblist->descraption }}</textarea>
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="why_to_apply">Why To Apply</label>
				                <textarea type="text" name="why_to_apply" class="summernote">{{ $joblist->why_to_apply }}</textarea>
				            </div>
				        </div>
		                <div class="row">
				           <div class="col-md-6 mb-3">
				                 <label for="status">Job Category<span style="color:red">*</span></label>
    				    		<select name="job_category" class="form-control" aria-label="Default select example" value="{{old('job_category')}}">
    							     <option value="" selected>Select Category</option>
    							      @foreach($jobcategories as $key=>$data)
    			                       <option value="{{ $data->name }}" @if($data->job_category==$joblist->name) selected @endif>{{ $data->name }}</option>
    							     @endforeach
    							 </select>
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Date</label>
				                <input type="date" class="form-control" id="validationDefault01" name="date" value="{{ $joblist->date }}" >
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Expire Date</label>
				                <input type="date" class="form-control" id="validationDefault01" name="expire_date" value="{{ $joblist->expire_date }}">
				            </div>
				            
				            <div class="col-md-6 mb-3">
				                <label for="status">Job Location<span style="color:red">*</span></label>
    				    		<select name="job_location" class="form-control" aria-label="Default select example" required>
    							     <option value="" selected>Select Location</option>
    							     @foreach($joblocations as $key=>$data)
    			                       <option value="{{ $data->location }}" @if($data->location==$joblist->job_location) selected @endif>{{ $data->location }}</option>
    							     @endforeach
    							 </select>
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
