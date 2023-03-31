<div class="modal fade" id="createJob" tabindex="-1" role="dialog" aria-labelledby="createJob" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createJob">Create New Job Listing</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
           <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <form id="jobSubmit" method="post" action="javascript:void(0)" enctype="multipart/form-data">
        	    @csrf
      
	            <div class="row">
    	            <div class="col-md-6 mb-3">
    	                <label for="job_title">Title<span style="color:red">*</span></label>
    	                <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" placeholder="Enter title">
    	                
    	                <!--<input class="form-control" id="job_title" type="text" placeholder="Title" value="{{old('job_title')}}" name="job_title" title="job title" />-->
    	               
    	            </div>
	            </div>
	             <div class="row">
    	            <div class="col-md-6 mb-3">
    	                <label for="job_title">Position<span style="color:red">*</span></label>
    	                <select name="job_category" class="form-control" aria-label="job category">
    					     <option value="" selected>Select Category</option>
    					     @foreach($jobcategories as $key=>$data)
    	                       <option value="{{ $data->name }}"> {{ $data->name }} </option>
    					     @endforeach
    					 </select>
    	                <!--<input type="text" class="form-control" id="type" name="type" value="{{old('type')}}" placeholder="Enter Job Type">-->
    	            </div>
	            </div>
	             <div class="row">
    	            <div class="col-md-6 mb-3">
    	                <label for="status"> Location<span style="color:red">*</span></label>
    		    		<select name="job_location" class="form-control" aria-label="Job location" >
    					     <option value="" selected>Select Location</option>
    					     @foreach($joblocations as $key=>$data)
    	                       <option value="{{ $data->location }}"> {{ $data->location }} </option>
    					     @endforeach
    					 </select>
    	            </div>
	            </div>
	             <div class="row">
    	            <div class="col-md-6 mb-3">
    	                <label for="status"> Type<span style="color:red">*</span></label>
    		    		 <input type="text" class="form-control" id="term" name="term" value="{{old('term')}}" placeholder="">
    	            </div>
	            </div>
	             <div class="row">
    	            <div class="col-md-12 mb-3">
    	                <label for="job_title">Page Info</label>
                        <textarea id="descraption" name="descraption" class="form-control" rows="4" cols="50">
                           
                        </textarea>
    	               
    	            </div>
	            </div>
	            
    	        <div class="row">
    	            <div class="col-md-6 mb-3">
    	                 <button class="btn btn-primary" type="submit">Post Job </button>
    				</div>
    	        </div>
	        </div>
	       </form>
      </div>
    </div>
    </div>
</div>

<div class="modal fade" id="editJOb" tabindex="-1" role="dialog" aria-labelledby="createJob" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createJob">Edit Job Listing</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
           <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="update_result">
                
	        </div>
      </div>
    </div>
    </div>
</div>


<div class="modal fade" id="viewJob" tabindex="-1" role="dialog" aria-labelledby="createJob" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createJob">View Applicants</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
           <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="apply_list"> </div>
            
      </div>
    </div>
    </div>
</div>