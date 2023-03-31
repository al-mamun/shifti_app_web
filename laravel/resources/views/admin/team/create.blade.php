@extends('layouts.app')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<h3>Add new Team</h3>
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">Team</li>
		                <li class="breadcrumb-item active">Team Details</li>
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
				    <form action="{{route('team.store')}}" method="POST" enctype="multipart/form-data">
				    	@csrf
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="Title">Title <span style="color:red">*</span> </label>
				                <input class="form-control" id="title" name="title" type="text" placeholder="Enter Title" data-original-title="" title="Team Title" value="{{old('title')}}" />
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="designation">Designation <span style="color:red">*</span> </label>
				                <input class="form-control" id="designation" name="designation" type="text" placeholder="Enter Designation" value="{{old('designation')}}" />
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="Image">Image <span style="color:red">*</span> </label>
				                <input class="form-control" id="img" name="image" type="file"/>
				            </div>
				        </div>
				           
				        <button class="btn btn-primary" type="submit">Submit </button>
				    </form>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection
