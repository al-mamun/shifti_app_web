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
			 @if(isset($status) && $status=='success')
	          <div class="alert alert-success alert-dismissible fade show" role="alert">
	            <strong> Your contact successfully save. </strong>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            	 <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	          <!--<div class="alert alert-success alert-dismissible fade show" role="alert">-->
	          <!--  <strong>{{ Session::get('success')}}</strong>-->
	          <!--  <button type="button" class="close" data-dismiss="alert" aria-label="Close">-->
	          <!--  	 <span aria-hidden="true">&times;</span>-->
	          <!--  </button>-->
	          <!--</div>-->
	        @endif
			<!-- Ajax data source array start-->
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Contact</h5>
                  </div>
                    <div class="card-body">
                      <div class="row">
                         <form action="{{ url('contact-save') }}" id="contctFormSave" method="POST" action="javascript:void(0)" enctype="multipart/form-data">
	                            @csrf
                                <div class="row">
                                  <div class="col-md-6 mb-3">
    				                <label for="page_title">Page title <span style="color:red">*</span></label>
                                    <input type="text" name="page_title" class="form-control" placeholder="Enter Title" value="{{ $contact->page_title }}">
                                  </div>
    				              <div class="col-md-6 mb-3 mt-3">
    				                <label for="page_content">Page Content<span style="color:red">*</span></label>
                                    <textarea type="text" name="page_content" class="form-control" placeholder="Enter Details">{{ $contact->page_content }}</textarea>
                                  </div>
    				              <div class="col-md-6 mb-3">
    				                <label for="Contect_title">Contact title <span style="color:red">*</span></label>
                                    <input type="text" name="contact_title" class="form-control" placeholder="Enter Title" value="{{ $contact->contact_title }}">
                                  </div>
    				              <div class="col-md-6 mb-3 mt-3">
    				                <label for="validationDefault01">Contact Content<span style="color:red">*</span></label>
                                    <textarea type="text" name="contact_content" class="form-control" placeholder="Enter Details">{{ $contact->contact_content }}</textarea>
                                  </div>
    				              <div class="col-md-6 mb-3">
    				                <label for="validationDefault01">Phone<span style="color:red">*</span></label>
                                    <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{ $contact->phone }}">
                                  </div>
    				              <div class="col-md-6 mb-3">
    				                <label for="validationDefault01">Email<span style="color:red">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ $contact->email }}">
                                  </div>
    				              <div class="col-md-6 mb-3">
    				                <label for="validationDefault01">Address<span style="color:red">*</span></label>
                                    <textarea type="text" name="address" class="form-control" placeholder="Enter Details">{{ $contact->address }}</textarea>
                                  </div>
    				              <div class="col-md-6 mb-3">
    				                <label for="validationDefault01">Google Map<span style="color:red">*</span></label>
                                    <input type="text" name="google_map" class="form-control" placeholder="Google Map" value="{{ $contact->google_map }}">
                                  </div>
                                  <div class="col-md-6 mb-3">
    				                <label for="from_header_title">From header title <span style="color:red">*</span></label>
                                    <input type="text" name="from_header_title" class="form-control" placeholder="Enter Title" value="{{ $contact->from_header_title }}">
                                  </div>
    				              <div class="col-md-6 mb-3 mt-3">
    				                <label for="from_header_content">From Header Content<span style="color:red">*</span></label>
                                    <textarea type="text" name="from_header_content" class="form-control" placeholder="Enter Details">{{ $contact->from_header_content }}</textarea>
                                  </div>
    				              <div class="col-md-6 mb-3">
    				                <label for="validationDefault01">Admin Email<span style="color:red">*</span></label>
                                    <input type="email" name="admin_email" class="form-control" placeholder="Enter Email" value="{{ $contact->admin_email }}">
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
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" 
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" 
        crossorigin="anonymous">
</script>
<script>
$('#contctFormSave').on('submit', function(event) {
    
});

	$('.repeater-add-btn').on('click', function(event) {
	       	
	    $('.reapert_result').append('<div class="repater"><div class="items" data-group="test"> <div class="item-content"> <div class="form-group"> <label for="inputEmail" class="col-lg-2 control-label">Title</label> <div class="col-lg-10"> <input type="text" class="form-control" id="inputName" placeholder="Title" data-name="name" name="title[]">   </div>  </div></div> </div> <div id="repeater"><div class="items" data-group="test"><div class="item-content"><div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">content</label> <div class="col-lg-10"><input type="text" class="form-control" id="inputName" placeholder="content" data-name="content" name="content[]"></div></div></div></div></div><div id="repeater"><div class="items" data-group="test"> <div class="form-group"><label for="type" class="col-lg-10 control-label">Type</label><div class="col-md-10"><select name="type[]" style="width:100%"  class="form-control" aria-label="Default select example"> <option value="">Select type</option><option value="Basics"> Basics</option><option value="Account & settings"> Account & settings </option><option value="Security"> Security </option> </select></div></div></div></div></div>');
	}); 
	

</script>
@endsection
