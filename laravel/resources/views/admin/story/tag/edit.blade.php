@extends('layouts.app')

@section('content')
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
	              	<h3>Update Tag</h3>
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">Tag</li>
		                <li class="breadcrumb-item active">Tag Details</li>
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
					 <form action="{{route('sotrytag.update',$storyTag->id)}}" method="POST" enctype="multipart/form-data">
				    	@csrf
			            @method('PUT')
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Tag Name</label>
				                <input class="form-control" id="validationDefault01" name="tag_name" type="text" placeholder="Tag name" data-original-title="" title="Tag Name" value="{{$storyTag->tag_name}}" />
				            </div>
				            
				        </div>
				        <button class="btn btn-primary" type="submit" data-original-title="" title="">Update </button>
				    </form>
				   </div>
				</div>

			</div>

		</div>
	</div>
@endsection
