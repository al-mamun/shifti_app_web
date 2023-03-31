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
	        <div class="card">
			 
			    <div class="card-body">
				    <div class="card-content">
		            <table class="table table-bordered" border="1">
		              <tbody>
				  	<tr>
				  		<th>Page Title</th>
				  		<td>{{ $pages->title }}</td>
				  	</tr>
				  	<tr>
				  		<th>Page Name</th>
				  		<td>{{ $pages->page_name }}</td>
				  	</tr>
				  	<tr>
				  		<th>Description</th>
				  		<td>{!! $pages->description !!}</td>
				  	</tr>
				  </tbody>
		          </table>
	           </div>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
