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
		                <li class="breadcrumb-item">Story</li>
		                <li class="breadcrumb-item active">Story Details</li>
	              	</ol>
	            </div>
	        </div>
	        <div class="card">
			 
			    <div class="card-body">
				    <div class="card-content">
		            <table class="table table-bordered" border="1">
		              <tbody>
				  	<tr>
				  		<th>Title</th>
				  		<td>{{ $story->title }}</td>
				  	</tr>
				  	<tr>
				  		<th>Description</th>
				  		<td>{!! $story->description !!}</td>
				  	</tr>
				  	<tr>
				  		<th>Photo</th>
				  		<td><img src="{{  URL::asset('images/uploads/blog/' . $story->photo)}}" width="200px"></td>
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
