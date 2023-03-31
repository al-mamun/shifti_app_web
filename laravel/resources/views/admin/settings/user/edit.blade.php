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
                     <form action="{{ route('user.update',$userInfoUpdate->id) }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Name<span style="color:red">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{$userInfoUpdate->name}}">
                              </div>
                            </div>
                            <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Email <span style="color:red">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ $userInfoUpdate->email }}">
                               
                              </div>
                             </div>
                            <div class="row">
				              <div class="col-md-6 mb-3">
				                <label for="validationDefault01">Password<span style="color:red">*</span></label>
                                <input type="password" name="password" class="form-control" value="{{ $userInfoUpdate->password }}">
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
