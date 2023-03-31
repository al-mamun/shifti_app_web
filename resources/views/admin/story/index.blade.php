@extends('layouts.app')

@section('content')
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".stories_menu_title").addClass("active");
        $(".stories_submenu").show();
        $(".stories_submenu").css('display','block !important');
    });
    
</script>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          	<div class="row">
	            <div class="col-lg-6">
	              	<ol class="breadcrumb">
		                <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
		                <li class="breadcrumb-item">Stories</li>
		                <li class="breadcrumb-item active">Stories Details</li>
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
		                  <th>Slug</th>
		                  <th>Description</th>
		                  <th>Photo</th>
		                  <th>Action</th>
		              </tr>
		             @foreach($stories as $key=>$data)
		               <tr>
		                  <td>{{ $key+1 }}</td>
		                  <td>{{ $data->title }}</td>
		                  <td>{{ $data->tags }}</td>
		                  <td>{{ $data->slug }}</td>
		                  <td>{!! $data->description !!}</td>
		                  <td><img src="{{  URL::asset('images/uploads/blog/' . $data->photo)}}" height="240"></td>
		                  <td>
		                    <form class="icon-color text-center" action="{{route('stories.destroy',$data->id)}}" method="POST">
		                      <a href="{{ route('stories.show',$data->id) }}" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-edit"></i>show</a> 

		                       @csrf
		                       @method('DELETE')
		                      <button type="submit" id="delete" class="btn btn-danger">
		                          <i class="fas fa-trash"></i>Delete
		                      </button>
		                    </form>
		                  </td>
		                </tr>
		              @endforeach
		          </table>
		          {{ $stories->links() }}
	           </div>
				</div>

			</div>

		</div>
	</div>
</div>
@endsection
