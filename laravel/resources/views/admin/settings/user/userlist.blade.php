@extends('layouts.app')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">User</li>
		                <li class="breadcrumb-item active">User List</li>
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
		                  <th>Name</th>
		                  <th>Email</th>
		                  <th>Action</th>
		              </tr>
		             @foreach($userList as $key=>$data)
		               <tr>
		                  <td>{{ $key+1 }}</td>
		                  <td>{{ $data->name }}</td>
		                  <td>{{ $data->email }}</td>
		                  <td>
    		                  <a href="{{route('user.edit',$data->id)}}" class="btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a> 
    		                  <a href="{{route('user.delete',$data->id)}}" class="btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a> 
		                  </td>
		                </tr>
		              @endforeach
		          </table>
		          {{ $userList->links() }}
	           </div>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection
