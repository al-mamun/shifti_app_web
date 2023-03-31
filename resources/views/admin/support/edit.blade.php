@extends('layouts.app')

@section('content')

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
                    <h5>User Update</h5>
                  </div>
                  <div class="card-body">
                     <form action="{{ route('support.update',$supportInfoUpdate->id) }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
				              <div class="col-md-12 mb-3">
				                <label for="validationDefault01">Title</label>
                                <input type="text" name="title" class="form-control" value="{{$supportInfoUpdate->title}}">
                              </div>
                            </div>
                            <div class="row">
				              <div class="col-md-12 mb-3">
			      				<label for="validationDefault02">Content</label>
                                <textarea  class="summernote" type="text" name="content" id="content"> {{$supportInfoUpdate->content}} </textarea>
                              </div>
                             </div>
                            <div class="row">
				              <div class="col-md-12 mb-3">
			      				<label for="validationDefault02">Image </label>
							    <input type="file" name="image" class="form-control mt-2" placeholder="Upload Image" value="{{$supportInfoUpdate->image}}">
                              </div>
                            </div>
                          <button type="submit" class="btn btn-primary">Update</button>
                      </form>
                 </div>
            </div>
		</div>
	</div>
  </div>
</div>

@endsection
