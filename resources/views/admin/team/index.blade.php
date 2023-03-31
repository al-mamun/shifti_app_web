@extends('layouts.app')

@section('content')
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".product_menu_title").addClass("active");
        $(".product_submenu").show();
        $(".product_submenu").css('display','block !important');
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
                    <h5>Team List</h5>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      	<div class="dt-ext table-responsive">
                      	 <table class="display" id="basic-1">
	                        <thead>
	                          	<tr>
		                            <th>Sl</th>
		                            <th>Title</th>
		                            <th>Designation</th>
		                            <th>Profile</th>
		                            <th>Action</th>
	                          	</tr>
	                        </thead>
	                        <tbody>
	                        	@php $sl = 1; @endphp

	                        	@foreach($teamlists as $team)
		                         <tr>
		                            <td>{{ $sl++ }}</td>
		                            <td>{{ $team->title }}</td>
		                            <td>{{ $team->designation }}</td>
		                            <td>
		                                 <img src="{{  URL::asset('images/' . $team->image)}}" width="100px">
		                            </td>
		                            <td>
		                            	 <form class="text-center" action="{{route('team.destroy',$team->id)}}" method="POST">
					                      <a href="{{route('team.edit',$team->id)}}" class="btn btn-primary btn-xs text-white" data-original-title="" title=""><i data-feather="edit-3"></i></a>

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
                      {{ $teamlists->links() }}
                    </div>
                    </div>
                  </div>
                </div>
            </div>


		</div>
	</div>
</div>
@endsection
