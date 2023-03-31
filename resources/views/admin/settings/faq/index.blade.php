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
                    <h5>FAQ</h5>
                  </div>
                   <div class="card-body">
                       <div class="row">
                          <div class="col-10">
                                   <form action="{{ url('/admin/faqs') }}" method="post" enctype="multipart/form-data">
        	                            @csrf
        	                            <div class="repeater-heading">
                                            <button class="btn btn-primary pull-right repeater-add-btn" type="button">
                                                Add&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <!-- Repeater Heading -->
                                        <div class="reapert_result">
                                            @foreach($faq as $faqInfo)
                                            <div class="repater">
                                                <div class="items" data-group="test">
                                                  <!-- Repeater Content -->
                                                    <div class="item-content">
                                                        <div class="form-group">
                                                          <label for="Title" class="col-lg-2 control-label">Title</label>
                                                          <div class="col-lg-10">
                                                            <input type="text" class="form-control" id="Title" placeholder="Title" data-name="name" name="title[]" value="{{ $faqInfo->title }}">
                                                            <input type="hidden" class="form-control"  name="faq_id[]" value="{{ $faqInfo->id }}">
                                                          </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="repeater">
                                                  <!-- Repeater Items -->
                                                  <div class="items" data-group="test">
                                                      <!-- Repeater Content -->
                                                      <div class="item-content">
                                                        <div class="form-group">
                                                          <label for="inputEmail" class="col-lg-2 control-label">content</label>
                                                          <div class="col-lg-10">
                                                            <input type="text" class="form-control" id="inputName" placeholder="content" data-name="content" name="content[]"  value="{{ $faqInfo->content }}">
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div id="repeater">
                                                    <!-- Repeater Items -->
                                                    <div class="items" data-group="test">
                                                        <div class="form-group">
                                                            <label for="type" class="col-lg-10 control-label">Type</label>
                                                             <div class="col-md-10">
                                    				    		<select name="type[]" style="width:100%"  class="form-control" aria-label="Default select example">
                                    							     <option value="">Select type</option>
                                    							     <option value="Basics" @if($faqInfo->type=='Basics') selected @endif> Basics</option>
                                    							     <option value="Account & settings" @if($faqInfo->type=='Account & settings') selected @endif> Account & settings </option>
                                    							     <option value="Security" @if($faqInfo->type=='Security') selected @endif> Security </option>
                                    							 </select>
                                				            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                 </div>
                          </div>
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
	$('.repeater-add-btn').on('click', function(event) {
	       	
	    $('.reapert_result').append('<div class="repater"><div class="items" data-group="test"> <div class="item-content"> <div class="form-group"> <label for="inputEmail" class="col-lg-2 control-label">Title</label> <div class="col-lg-10"> <input type="text" class="form-control" id="inputName" placeholder="Title" data-name="name" name="title[]">   </div>  </div></div> </div> <div id="repeater"><div class="items" data-group="test"><div class="item-content"><div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">content</label> <div class="col-lg-10"><input type="text" class="form-control" id="inputName" placeholder="content" data-name="content" name="content[]"></div></div></div></div></div><div id="repeater"><div class="items" data-group="test"> <div class="form-group"><label for="type" class="col-lg-10 control-label">Type</label><div class="col-md-10"><select name="type[]" style="width:100%"  class="form-control" aria-label="Default select example"> <option value="">Select type</option><option value="Basics"> Basics</option><option value="Account & settings"> Account & settings </option><option value="Security"> Security </option> </select></div></div></div></div></div>');
	}); 
	

</script>
@endsection
