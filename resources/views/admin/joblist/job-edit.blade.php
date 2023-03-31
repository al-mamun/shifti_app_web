<form id="jobUpdate" method="post" action="javascript:void(0)" enctype="multipart/form-data">
	    @csrf

    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="job_title">Title<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $jobList->job_title }}" placeholder="Enter title">
            <input type="hidden" class="form-control" id="id" name="id" value="{{ $jobList->id }}" placeholder="Enter title">
            <!--<input class="form-control" id="job_title" type="text" placeholder="Title" value="{{old('job_title')}}" name="job_title" title="job title" />-->
           
        </div>
        <div class="col-md-12 mb-3">
            <label for="job_title">Position<span style="color:red">*</span></label>
            <select name="job_category" class="form-control" aria-label="job category">
			     <option value="" selected>Select Category</option>
			     @foreach($jobcategories as $key=>$data)
                   <option value="{{ $data->name }}"  @if($data->name ==  $jobList->job_category) selected @endif> {{ $data->name }} </option>
			     @endforeach
			 </select>
            <!--<input type="text" class="form-control" id="type" name="type" value="{{old('type')}}" placeholder="Enter Job Type">-->
        </div>
        <div class="col-md-12 mb-3">
            <label for="status"> Location<span style="color:red">*</span></label>
    		<select name="job_location" class="form-control" aria-label="Job location" >
			     <option value="" selected>Select Location</option>
			     @foreach($joblocations as $key=>$data)
                   <option value="{{ $data->location }}" @if($data->location ==  $jobList->job_location) selected @endif> {{ $data->location }} </option>
			     @endforeach
			 </select>
        </div>
        <div class="col-md-12 mb-3">
            <label for="status"> Type<span style="color:red">*</span></label>
    		 <input type="text" class="form-control" id="term" name="term" value="{{ $jobList->type }}" placeholder="">
        </div>
        <div class="col-md-12 mb-3">
            <label for="job_title">Page Info</label>
            <textarea id="descraption" name="descraption" class="form-control" rows="4" cols="50">{{ $jobList->descraption }} </textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
             <button class="btn btn-primary" type="submit">Post Job </button>
		</div>
    </div>
</form>
<script type="text/javascript">
 
$('#jobUpdate').on('submit', function(event) {
	event.preventDefault();                          // for demo
 
    $.ajax({
        data:new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        type: "POST",
        url: window.baseUrl + '/admin/joblist/update',
        success:function(data) {
        	if($.isEmptyObject(data.error)){
                Swal.fire(
                  'success!',
                  'Your record has been add',
                  'success'
                );
                
                $('#editJOb').modal('hide');
            }else{
                printErrorMsg(data.error);
            }
           
        }
    }); 
});


</script>