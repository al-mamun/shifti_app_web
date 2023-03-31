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
                    <h5>Settings</h5>
                  </div>
                  <div class="card-body">
                     <form action="{{ url('admin/setting/save') }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Upload Logo <span style="color:red">*</span></label>
                                <input type="file" name="logo" class="form-control" placeholder="Enter Logo" value="{{ $setup->logo }}">
                                @error('logo')
								   <div class="text-danger">{{ $message }}</div>
								@enderror
                              </div>
                            </div>
                            <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Upload Logo <span style="color:red">*</span></label>
                                <input type="file" name="retina_logo" class="form-control" placeholder="Enter Logo" value="{{ $setup->retina_logo }}">
                                @error('retina_logo')
								   <div class="text-danger">{{ $message }}</div>
								@enderror
                              </div>
                             </div>
                            <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Copyright Text<span style="color:red">*</span></label>
                                <textarea type="text" name="copyright" class="form-control" placeholder="Enter Copyright Text">{{ $setup->copyright }}</textarea>
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
$('#adminSetup').on('submit', function(event) {
    
});
</script>
@endsection
