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
                <div class="card-header">
                    <h5>User Setup</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.setup') }}" method="post" enctype="multipart/form-data">
                       @csrf
                       <div class="row">
			              <div class="col-md-6 mb-3">
			                <label for="name">Name <span style="color:red">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name"  value="{{old('name')}}">
                          </div>
                        </div>
                        <div class="row">
			              <div class="col-md-6 mb-3">
			                <label for="Email">Email <span style="color:red">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{old('email')}}">
                           
                          </div>
                         </div>
                        <div class="row">
			              <div class="col-md-6 mb-3">
			                <label for="Password">Password <span style="color:red">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                          </div>
                        </div>
                        <div class="row">
			              <div class="col-md-6 mb-3">
			                <label for="country">Contact <span style="color:red">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter Contact" value="{{old('phone')}}">
                          </div>
                        </div>
                        <div class="row">
			              <div class="col-md-6 mb-3">
			                <label for="country">Country <span style="color:red">*</span></label>
                            <input type="text" name="country" class="form-control" placeholder="Enter country" value="{{old('country')}}">
                          </div>
                        </div>
                        <div class="row">
			              <div class="col-md-6 mb-3">
			                <label for="city">City <span style="color:red">*</span></label>
                            <input type="text" name="city" class="form-control" placeholder="Enter city" value="{{old('city')}}">
                          </div>
                        </div>
                      <div class="row">
				        	<div class="col-md-6 mb-3">
							  <label for="validationDefault02">Photo <span style="color:red">*</span> </label>
							  <input type="file" name="photo" class="form-control mt-2" placeholder="Upload Photo">
							</div>
						</div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
            </div>
		</div>
	</div>
  </div>
</div>

@endsection
