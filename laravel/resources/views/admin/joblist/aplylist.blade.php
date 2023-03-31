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
                    <h5>Aply Job List</h5>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      	<div class="dt-ext table-responsive">
                      	 <table class="display" id="basic-1">
	                          	<tr>
		                            <th>Sl</th>
		                            <th>Name</th>
		                            <th>Job title</th>
		                            <th>Job title</th>
		                            <th>Cover Letter</th>
		                            <th>Date</th>
		                            <th>CV</th>
		                            
	                          	</tr>

	                        	@foreach($applyjoblists as $key=>$data)
		                         <tr>
		                            <td>{{ $key+1 }}</td>
		                            <td>{{ $data->name }}</td>
		                            <td>{{ $data->job_title }} </td>
		                            <td>{{ $data->job_category }}</td>
		                            <td>{{ $data->cover_letter }} </td>
		                            <td>{{ $data->date }} </td>
		                            <td> <a class="btn-primary btn-sm text-white" target="_blank" href="{{ asset('upload/cv/'. $data->attachment) }}" title="">
					                          <i class="fa fa-eye" aria-hidden="true"></i></a> </td>
		                           
		                        </tr>
	                          	@endforeach
                      </table>
                      {{ $applyjoblists->links() }}
                    </div>
                    </div>
                  </div>
                </div>
            </div>


		</div>
	</div>
</div>
@endsection
