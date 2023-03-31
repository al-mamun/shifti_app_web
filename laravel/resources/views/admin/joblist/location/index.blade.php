@extends('layouts.app')

@section('content')
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".job_menu_title").addClass("active");
        $(".job_submenu").show();
        $(".job_submenu").css('display','block !important');
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
                    <h5>All Location List</h5>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      	<div class="dt-ext table-responsive">
                      	 <table class="display" id="basic-1">
	                          	<tr>
		                            <th>Sl</th>
		                            <th>Job Location</th>
		                            <th>Action</th>
	                          	</tr>
	                        	@foreach($joblocations as $key=>$jobloc)
		                         <tr>
		                            <td>{{ $key+1 }}</td>
		                            <td>{{ $jobloc->location }}</td>
		                            
		                            <td>
		                            	 <form class="text-center" action="{{route('locations.destroy',$jobloc->id)}}" method="POST">
					                      <a class="btn btn-primary btn-xs text-white" href="{{route('locations.edit',$jobloc->id)}}" title=""><i data-feather="edit-3"></i></a>

					                       @csrf
					                       @method('DELETE')
					                      <button type="submit" class="btn btn-danger btn-xs text-white" title="Delete">
					                         <i data-feather="trash-2"></i>
					                      </button>
					                    </form>
		                            </td>
		                        </tr>
	                          	@endforeach
                          </table>
                          {{ $joblocations->links() }}
                    </div>
                    </div>
                  </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection
