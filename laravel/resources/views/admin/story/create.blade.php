@extends('layouts.app')
@section('content')
<style type="text/css">
	.slugs{
		display: none;
	}
</style>
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".stories_menu_title").addClass("active");
        $(".stories_submenu").show();
        $(".stories_submenu").css('display','block !important');
    });
    
</script>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<h3>Add new Stories</h3>
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">Stories</li>
		                <li class="breadcrumb-item active">Stories Details</li>
	              	</ol>
	            </div>
	        </div>
	        @if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

	       @if(Session::has('success'))
	          <div class="alert alert-success alert-dismissible fade show" role="alert">
	            <strong>{{ Session::get('success')}}</strong>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            	 <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	        @endif
	        <div class="card">
			 
			    <div class="card-body">
				    <form action="{{ route( 'stories.store' ) }}" method="POST" enctype="multipart/form-data">
				     @csrf
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Enter title<span style="color:red">*</span></label>
				                <input class="form-control" name="title" id="validationDefault01" type="text" placeholder="Title" data-original-title="" title="title" value="{{old('title')}}" />
				                <input class="form-control aria-hidden slugs" name="slug" id="slug" type="text" value="Title" required="" data-original-title="" title="" />
				            </div>
				              <div class="col-md-6 mb-3">
				                <label for="status">Tag<span style="color:red">*</span></label>
    				    		<select name="tags[]"  class="form-control select2" aria-label="Default select example" multiple>
    							     <option value="">Select Tag</option>
    							     @foreach($storyTagList as $key=>$data)
    			                       <option value="{{ $data->tag_name }}"> {{ $data->tag_name }} </option>
    							     @endforeach
    							 </select>
				            </div>
				        </div>
				 
				      	<div class="row">
				      		<div class="col-md-12 mb-3 mt-3">
			      				<label for="validationDefault02">Descraption</label>
			                      <textarea  class="summernote" type="text" name="description" id="description"></textarea>
			                </div>
				      	</div>
				        <div class="row">
				        	<div class="col-md-6 mb-3">
							  <label for="validationDefault02">Photo<span style="color:red">*</span></label>
							  <input type="file" name="photo" class="form-control mt-2" placeholder="Upload Photo">
							</div>
						</div>
				        <button class="btn btn-primary" type="submit" data-original-title="" title="">Submit </button>
				    </form>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection
