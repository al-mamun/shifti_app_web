@extends('layouts.app')

@section('content')
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        $(".blog_list a").addClass("active");
        $(".blog_list_data").show();
        $(".blog_list_data").css('display','block !important');
    });
    
</script>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<h3>Add new Tag</h3>
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
				    <form action="{{route('tag.store')}}" method="POST" enctype="multipart/form-data">
				    	@csrf
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="tag_name">Tag Name <span style="color:red">*</span> </label>
				                <input class="form-control" id="tag_name" name="tag_name" type="text" placeholder="Tag name" data-original-title="" title="Tag Name" value="{{old('tag_name')}}" />
				            </div>
				        </div>
                        <input class="form-control" id="validationDefault01" name="Status" type="hidden" placeholder="Status"  value="1" />
                        <input class="form-control" id="validationDefault01" name="order_by" type="hidden" placeholder="Tag name" value="0" />
				        <button class="btn btn-primary" type="submit" data-original-title="" title="">Submit </button>
				    </form>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection
