@extends('layouts.app')
@section('content')

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
					 <form action="{{route('team.update',$team->id)}}" method="POST" enctype="multipart/form-data">
				    	@csrf
			            @method('PUT')
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Title</label>
				                <input class="form-control" id="validationDefault01" name="title" type="text" data-original-title="" title="Tag Name" value="{{$team->title}}" />
				            </div>
				           <div class="col-md-6 mb-3">
				                <label for="designation">Designation <span style="color:red">*</span> </label>
				                <input class="form-control" id="designation" name="designation" type="text" placeholder="Enter Designation" value="{{ $team->designation }}"/>
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="Image">Image <span style="color:red">*</span> </label>
				                <input class="form-control" id="img" name="image" type="file" value="{{ $team->image }}"/>
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
