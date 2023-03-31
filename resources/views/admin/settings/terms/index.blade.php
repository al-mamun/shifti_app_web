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
                    <h5>Terms</h5>
                  </div>
                   <div class="card-body">
                       <div class="row">
                          <div class="col-10">
                                   <form action="{{ url('/admin/terms/save') }}" method="post" enctype="multipart/form-data">
        	                            @csrf
        	                            <div class="repeater-heading">
                                            <button class="btn btn-primary pull-right repeater-add-btn" type="button">
                                                Add&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <!-- Repeater Heading -->
                                        <div class="reapert_result">
                                            @foreach($terms as $termInfo)
                                            <div class="repater">
                                                <div class="items" data-group="test">
                                                  <!-- Repeater Content -->
                                                    <div class="item-content">
                                                        <div class="form-group">
                                                          <label for="Title" class="col-lg-2 control-label">Title</label>
                                                          <div class="col-lg-10">
                                                            <input type="text" class="form-control" id="Title" placeholder="Title" data-name="name" name="title[]" value="{{ $termInfo->title }}">
                                                            <input type="hidden" class="form-control"  name="term_id[]" value="{{ $termInfo->id }}">
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
                                                            <input type="text" class="form-control" id="inputName" placeholder="content" data-name="content" name="content[]"  value="{{ $termInfo->content }}">
                                                          </div>
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
	       	
	    $('.reapert_result').append('<div class="repater"><div class="items" data-group="test"><div class="item-content"><div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Title</label><div class="col-lg-10"><input type="text" class="form-control" id="inputName" placeholder="Title" data-name="name" name="title[]"> </div> </div></div> </div><div id="repeater"><div class="items" data-group="test"><div class="item-content"><div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">content</label> <div class="col-lg-10"><input type="text" class="form-control" id="inputName" placeholder="content" data-name="content" name="content[]"></div></div></div></div></div></div>');
	}); 
	

</script>
@endsection
