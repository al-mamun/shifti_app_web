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
                    <h5>Job List</h5>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      	<div class="dt-ext table-responsive">
                      	 <table class="display" id="basic-1">
	                          	<tr>
		                            <th>Sl</th>
		                            <th>Job title</th>
		                            <th>Job Type</th>
		                            <th>Job Category</th>
		                            <th>Date</th>
		                            <th>Expire Date</th>
		                            <th>Job Location</th>
		                            <th width="100">Action</th>
	                          	</tr>

	                        	@foreach($joblists as $key=>$joblist)
		                         <tr>
		                            <td>{{ $key+1 }}</td>
		                            <td>{{ $joblist->job_title }}</td>
		                            <td>{{ $joblist->type }}</td>
		                            <td>{{ $joblist->job_category }} </td>
		                            <td>{{ $joblist->date }} </td>
		                            <td>{{ $joblist->expire_date }} </td>
		                            <td>{{ $joblist->job_location }} </td>
		                            
		                            <td>
		                            	 <form class="text-center" action="{{route('joblist.destroy',$joblist->id)}}" method="POST">
					                      <a class="btn-primary btn-sm text-white" href="{{route('joblist.edit',$joblist->id)}}" title="">
					                          <i class="fa fa-edit" aria-hidden="true"></i></a>

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
                      {{ $joblists->links() }}
                    </div>
                    </div>
                  </div>
                </div>
            </div>


		</div>
	</div>
</div>
@endsection
