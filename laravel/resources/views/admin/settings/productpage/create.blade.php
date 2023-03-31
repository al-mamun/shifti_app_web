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
                    <h5>Product Page Setup</h5>
                  </div>
                  <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    @endif
                     <form action="{{ route('product-page.store') }}" id="productPage" method="POST" action="javascript:void(0)" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Title <span style="color:red">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{ $productPage->title }}">
                                @error('title')
								   <div class="text-danger">{{ $message }}</div>
								@enderror
                              </div>
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Banner<span style="color:red">*</span></label>
                                <input type="file" name="banner" class="form-control" value="{{ $productPage->banner }}">
                              </div>

				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Url<span style="color:red">*</span></label>
                                <input type="text" name="url" class="form-control" placeholder="url" value="{{ $productPage->url }}">
                              </div>
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Button Text<span style="color:red">*</span></label>
                                <input type="text" name="button_text" class="form-control" placeholder="button_text" value="{{ $productPage->button_text }}">
                              </div>
                              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Content<span style="color:red">*</span></label>
                                <textarea type="text" name="content" class="form-control" placeholder="Enter Copyright Text">{{ $productPage->content }}</textarea>
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
<script>
$('#productPage').on('submit', function(event) {
    
});
</script>
@endsection
