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
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">Blog</li>
		                <li class="breadcrumb-item active">Blog Details</li>
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
		                  <th>Tag</th>
		                  <th>Category</th>
		                  <th>Slug</th>
		                  <th>Description</th>
		                  <th>Photo</th>
		                  <th width="150">Action</th>
		              </tr>
		             @foreach($blogs as $key=>$data)
		               <tr>
		                  <td>{{ $key+1 }}</td>
		                  <td>{{ $data->title }}</td>
		                  <td>{{ $data->tags }}</td>
		                  <td>{{ $data->category_name }}</td>
		                  <td>{{ $data->slug }}</td>
		                  <td>{!! substr_replace($data->description, "...", 50);  !!}</td>
		                  <td><img src="{{  URL::asset('images/uploads/blog/' . $data->photo)}}" width="200px"></td>
		                  <td>
		                  <form class="text-center" action="{{route('blog.destroy',$data->id)}}" method="POST">
		                      <a href="{{ route('blog.show',$data->id) }}" class="btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a> 
		                      <a href="{{ route('blog.edit',$data->id) }}" class="btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a> 
		                     <!-- <a href="{{ route('blog.delete',$data->id) }}" class="btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a> --> 
		                       @csrf
		                       @method('DELETE')
		                       <button type="submit" class="btn btn-danger btn-xs text-white" title="Delete">
		                         <i class="fa fa-trash" aria-hidden="true"></i>
		                       </button>
		                   </form>
		                  </td>
		                </tr>
		              @endforeach
		          </table>
		          {{ $blogs->links() }}
	           </div>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection
