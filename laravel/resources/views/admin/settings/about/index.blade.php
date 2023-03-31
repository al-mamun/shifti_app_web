@extends('layouts.app')

@section('content')
<style>

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
                <div class="card">
                  <div class="card-header">
                    <h5>About</h5>
                  </div>
                    <div class="card-body">
                    <form action="{{ url('about-save') }}" id="aboutFormSave" method="POST" action="javascript:void(0)" enctype="multipart/form-data">
                         {{ csrf_field() }}
                           <div class="row">
				              <div class="col-md-12 mb-3 form-group">
				                <label for="title">Title <span style="color:red">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{ $aboutPage->title }}">
                              </div>
                              <div class="col-md-12 mb-3 form-group">
				                <label for="sub_title">Sub Title <span style="color:red">*</span></label>
                                <input type="text" name="sub_title" class="form-control" placeholder="Enter Title" value="{{ $aboutPage->title }}">
                              </div>
				              <div class="col-md-12 mb-3 mt-3">
				                <label for="content">Content<span style="color:red">*</span></label>
                                <textarea type="text" name="content" class="summernote" placeholder="Enter Details">{{ $aboutPage->content }}</textarea>
                              </div>
                              <div class="col-md-12 mb-3 mt-3">
				                <label for="why_we_are">Who are we?<span style="color:red">*</span></label>
                                <textarea type="text" name="why_we_are" class="summernote" placeholder="Enter Details">{{ $aboutPage->why_we_are }}</textarea>
                              </div>
                              <div class="col-md-12 mb-3 mt-3">
				                <label for="our_prcess">Our process<span style="color:red">*</span></label>
                                <textarea type="text" name="our_prcess" class="summernote" placeholder="Enter Details">{{ $aboutPage->our_prcess }}</textarea>
                              </div>
                              <div class="col-md-12 mb-3 form-group">
				                <label for="title">Gallery Ttitle <span style="color:red">*</span></label>
                                <input type="text" name="gallery_title" class="form-control" placeholder="Enter Title" value="{{ $aboutPage->gallery_title }}">
                              </div>
                              <div class="col-md-12 mb-3 form-group">
				                <label for="title">Gallery Sub Ttitle <span style="color:red">*</span></label>
                                <input type="text" name="gallery_sub_title" class="form-control" placeholder="Enter Title" value="{{ $aboutPage->gallery_sub_title }}">
                              </div>
                              
                              <div class="col-md-12 mb-3 form-group">
				                <label for="title">Gallery Content <span style="color:red">*</span></label>
				                <textarea type="text" name="gallery_content" class="summernote" placeholder="Enter Details">{{ $aboutPage->gallery_content }}</textarea>
                              </div>
                           </div>
                          <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                   </div>
		       </div>
        </div>
   </div>
</div>
<script>
$('#aboutFormSave').on('submit', function(event) {
    
});

</script>
@endsection
