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
        
        $(".global_setting").addClass("active");
        // $(".page_submenu").show();
        // $(".page_submenu").css('display','block !important');
    });

        $(document).ready(() => {
            $("#logo").change(function () {
                const file = this.files[0];
                if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                $("#imgPreview")
                    .attr("src", event.target.result);
                };
                    reader.readAsDataURL(file);
                }
            });
            
            $("#footer_logo").change(function () {
                const file = this.files[0];
                if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                $("#imgPreviewFotter")
                    .attr("src", event.target.result);
                };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    <style>
   .holder {
        /*height: 300px;*/
        width: 300px;
        border: 2px solid #eee;
        margin-bottom: 10px;
    }
    #imgPreview,.imgPreview {
        max-width: 296px;
        /*max-height: 300px;*/
        min-width: 296px;
       /* min-height: 300px;*/
    }
    .input_container {
      border: 1px solid #e5e5e5;
    }
        
    input[type=file]::file-selector-button {
      background-color: #fff;
      color: #000;
      border: 0px;
      border-right: 1px solid #e5e5e5;
      padding: 10px 15px;
      margin-right: 20px;
      transition: .5s;
    }
    
    input[type=file]::file-selector-button:hover {
      background-color: #eee;
      border: 0px;
      border-right: 1px solid #e5e5e5;
    }
    .heading {
        font-family: Montserrat;
        font-size: 45px;
        color: green;
    }
    </style>    
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
                  <div class="card-body">
                     <div class="row">
        	            <div class="col-lg-6">
        	              	<h3>Settings</h3>
        	            </div>
        	         </div>
                     <form action="{{ url('admin/setting/save') }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row" style="margin-bottom:10px">
                                <div class="col-md-12 mb-3 form-group">
                                    <label for="thumbnail_uplaod">Upload Logo <span style="color:red">*</span></label>
                                    <div class="holder">
                                        <img id="imgPreview" class="imgPreview" src="{{ asset('images/global/' . $setup->logo) }}" alt="pic" />
                                    </div>
    				                
    				                <div class="input_container">
                                        <input type="file" name="logo" id="logo"  />
                                    </div>
                                    @error('logo')
    								   <div class="text-danger">{{ $message }}</div>
    								@enderror
                                </div>
                            </div>
                            
                                 <div class="row" style="margin-bottom:10px">
                                <div class="col-md-12 mb-3 form-group">
                                    <label for="thumbnail_uplaod">Upload Logo <span style="color:red">*</span></label>
                                    <div class="holder">
                                        <img id="imgPreviewFotter"  class="imgPreview" src="{{ asset('images/global/' . $setup->footer_logo) }}" alt="pic" />
                                    </div>
    				                
    				                <div class="input_container">
                                        <input type="file" name="footer_logo" id="footer_logo"  />
                                    </div>
                                    @error('logo')
    								   <div class="text-danger">{{ $message }}</div>
    								@enderror
                                </div>
                            </div>
                          
                            <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Footer Bottom Text<span style="color:red">*</span></label>
                                <textarea type="text" name="fotter_bottom_text" class="form-control" placeholder="Enter Footer Bottom Tex">{{ $setup->fotter_bottom_text }}</textarea>
                              </div>
                            </div>
                            <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Copyright Text<span style="color:red">*</span></label>
                                <textarea type="text" name="copyright" class="form-control" placeholder="Enter Copyright Text">{{ $setup->copyright }}</textarea>
                              </div>
                            </div>
                            <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Admin Email<span style="color:red">*</span></label>
                                <textarea type="text" name="admin_email" class="form-control" placeholder="Enter Admin Email">{{ $setup->admin_email }}</textarea>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
                                </div>
                            </div>
                          
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
