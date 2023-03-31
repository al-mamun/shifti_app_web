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
			 @if(Session::has('success'))
	          <div class="alert alert-success alert-dismissible fade show" role="alert">
	            <strong>{{ Session::get('success')}}</strong>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            	 <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	        @endif
			<!-- Ajax data source array start-->
            <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Category List</h5>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      	<div class="dt-ext table-responsive">
                      	 <table class="display" id="basic-1">
	                        <thead>
	                          	<tr>
		                            <th>Sl</th>
		                            <th>Category Name</th>
		                            <th>Action</th>
	                          	</tr>
	                        </thead>
	                        <tbody>
	                        	@php $sl = 1; @endphp

	                        	@foreach($categoryTagList as $categoryTag)
		                         <tr>
		                            <td>{{ $sl++ }}</td>
		                            <td>{{ $categoryTag->tag_name }}</td>
		                            <td>
		                            	 <form class="text-center" action="{{route('categorytag.destroy',$categoryTag->id)}}" method="POST">
					                      <a href="{{route('categorytag.edit',$categoryTag->id)}}" class="btn btn-primary btn-xs text-white" data-original-title="" title=""><i data-feather="edit-3"></i></a>

					                       @csrf
					                       @method('DELETE')
					                      <button type="submit" class="btn btn-danger btn-xs text-white" title="Delete">
					                         <i data-feather="trash-2"></i>
					                      </button>
					                    </form>
		                            </td>
		                        </tr>
	                          	@endforeach
	                        </tbody>
                      </table>
                      {{ $categoryTagList->links() }}
                    </div>
                    </div>
                  </div>
                </div>
            </div>


		</div>
	</div>
</div>
@endsection
