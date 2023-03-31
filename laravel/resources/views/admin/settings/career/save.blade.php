@extends('layouts.app')

@section('content')
<style>
.repater {
    border: 1px solid #eee;
    padding: 10px;
    margin-bottom: 13px;
}
</style>
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".page_menu_title").addClass("active");
        $(".page_submenu").show();
        $(".page_submenu").css('display','block !important');
    });
    
</script>
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
                    <h5>Career Listing</h5>
                  </div>
                  <div class="card-body">
                     <form action="{{ url('/admin/career-listing/save') }}"id="careerFormSave" method="POST" action="javascript:void(0)" enctype="multipart/form-data">
                           @csrf
                             <div class="row">
				              <div class="col-md-6 mb-3 form-group">
				                <label for="validationDefault01">Title <span style="color:red">*</span></label>
                                <input type="text" name="page_title" class="form-control" placeholder="Enter Title" value="{{ $careerViews->page_title }}">
                              </div>
				              <div class="col-md-6 mb-3 form-group">
				                <label for="validationDefault01">Sub Title <span style="color:red">*</span></label>
                                <input type="text" name="page_sub_title" class="form-control" placeholder="Enter Title" value="{{ $careerViews->page_sub_title }}">
                              </div>
                           </div>
                           <div class="row">
				              <div class="col-md-12 mb-3 mt-3">
				                <label for="validationDefault01">Page  Content<span style="color:red">*</span></label>
                                <textarea type="text" name="page_content" class="summernote" placeholder="Enter Details">{!! $careerViews->page_content !!}</textarea>
                              </div>
                           </div>
                            <div class="row">
				              <div class="col-md-12 mb-3 mt-3">
				                <label for="validationDefault01">Page Company Title<span style="color:red">*</span></label>
                                <input type="text" name="page_company_title" placeholder="Enter Details" value="{!! $careerViews->page_company_title !!}"></textarea>
                              </div>
                           </div>
                            <div class="row">
				              <div class="col-md-12 mb-3 mt-3">
				                <label for="validationDefault01">Page Company Content<span style="color:red">*</span></label>
                                <textarea type="text" name="page_company_content" class="summernote" placeholder="Enter Details">{!! $careerViews->page_company_content !!}</textarea>
                              </div>
                           </div>
                           
                            <div class="row">
                                <div class="col-md-6 mb-3 form-group">
    				                <label for="validationDefault01">About Title <span style="color:red">*</span></label>
                                    <input type="text" name="about_page_title" class="form-control" placeholder="Enter Title" value="{{ $careerViews->about_page_title }}">
                                </div>
				              <div class="col-md-12 mb-3 mt-3">
				                <label for="validationDefault01">About Section Page Content<span style="color:red">*</span></label>
                                <textarea type="text" name="about_page_content" class="summernote" placeholder="Enter Details">{!! $careerViews->about_page_content !!}</textarea>
                              </div>
                           </div>
                           <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Upload Logo <span style="color:red">*</span></label>
                                <input type="file" name="image" class="form-control" placeholder="Enter Logo" value="{{ $careerViews->image }}">
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
$('#careerFormSave').on('submit', function(event) {
    
});
</script>
@endsection
