@extends('layouts.app')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">Page</li>
		                <li class="breadcrumb-item active">Page Details</li>
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
				    <div class="card-content">
		            <table class="table table-bordered" border="1">
		              <tr style="color:#000">
		                  <th>SL.</th>
		                  <th>Title</th>
		                  <th>Page Name</th>
		                  <th>Description</th>
		                  <th>Action</th>
		              </tr>
		             @foreach($pages as $key=>$data)
		               <tr>
		                  <td>{{ $key+1 }}</td>
		                  <td>{{ $data->title }}</td>
		                  <td>{{ $data->page_name }}</td>
		                  <td>{!! $data->description !!}</td>
		                  <td>
		                  	<form class="icon-color" action="{{ route('page.destroy',$data->id ) }}" method="POST">

		                      <a href="{{ route('page.show',$data->id) }}" class="btn btn-primary"><i data-feather="edit-3"></i></a> 
		                        @csrf
		        				@method('DELETE')
		        				<button type="submit" class="btn btn-danger" onclick= "return confirm('Are you sure to delete?')">
		                          <i data-feather="trash-2"></i>
		                      </button> 
		                  </form>
		                  </td>
		                </tr>
		              @endforeach
		          </table>
		          {{ $pages->links() }}
	           </div>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection
