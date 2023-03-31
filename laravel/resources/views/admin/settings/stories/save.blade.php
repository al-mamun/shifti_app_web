@extends('layouts.app')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
			 @if(Session::has('success'))
	          <div class="alert alert-success alert-dismissible fade show" role="alert">
	            <strong>{{ Session::get('success')}}</strong>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            	 <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	        @endif
			<!-- Ajax data source array start-->
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Stories</h5>
                  </div>
                  <div class="card-body">
                     <form action="{{ url('/admin/stories/save') }}"id="storiesFormSave" method="POST" action="javascript:void(0)" enctype="multipart/form-data">
                           @csrf
                             <div class="row">
				              <div class="col-md-6 mb-3 form-group">
				                <label for="validationDefault01">Title <span style="color:red">*</span></label>
                                <input type="text" name="page_title" class="form-control" placeholder="Enter Title" value="{{ $storiesViews->page_title }}">
                              </div>
				              <div class="col-md-6 mb-3 form-group">
				                <label for="validationDefault01">Sub Title <span style="color:red">*</span></label>
                                <input type="text" name="page_sub_title" class="form-control" placeholder="Enter Title" value="{{ $storiesViews->page_sub_title }}">
                              </div>
                           </div>
                             <div class="row">
				              <div class="col-md-12 mb-3 mt-3">
				                <label for="validationDefault01">Pge Content<span style="color:red">*</span></label>
                                <textarea type="text" name="page_content" class="summernote" placeholder="Enter Details">{{ $storiesViews->page_content }}</textarea>
                              </div>
                           </div>
                             <div class="row">
				              <div class="col-md-12 mb-3 mt-3">
				                <label for="validationDefault01">Pge Sub Content<span style="color:red">*</span></label>
                                <textarea type="text" name="page_sub_content" class="summernote" placeholder="Enter Details">{{ $storiesViews->page_sub_content }}</textarea>
                              </div>
                           </div>
                           <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Upload Logo <span style="color:red">*</span></label>
                                <input type="file" name="image" class="form-control" placeholder="Enter Logo" value="{{ $storiesViews->image }}">
                              </div>
                            </div>
                          <button type="submit" class="btn btn-primary">Save</button>
                      </form>
                 </div>
            </div>
		</div>
	</div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" 
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" 
        crossorigin="anonymous">
</script>
<script>
$('#storiesFormSave').on('submit', function(event) {
    
});
</script>
@endsection
