@extends('layouts.app')
@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<h3>Add new JOb</h3>
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
				    <form action="{{route('partner.store')}}" method="POST" enctype="multipart/form-data">
				    	@csrf
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="partner_name">Partner Name</label>
				                <input class="form-control" id="partner_name" type="text" placeholder="Partner Name" value="{{old('partner_name')}}" name="partner_name" title="Partner Name" />
				            </div>
                            <div class="row" style="margin-bottom:10px">
                            <div class="col-md-12 mb-3 form-group">
                                <label for="validationDefault01">Partner Icon Upload <span style="color:red">*</span></label>
                                <div class="holder">
                                    <img id="imgPreview" src="{{ asset('images/homepage/' . $homePage->thumbnail) }}" alt="pic" />
                                </div>
				                
				                <div class="input_container">
                                    <input type="file" name="partner_icon" id="photo"  value= />
                                </div>
                            </div>
                        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                 <button class="btn btn-primary" type="submit" data-original-title="" title="">Submit </button>
							</div>
				        </div>
				       </form>
				   </div>
				</div>

			</div>

		</div>
	</div>
@endsection
