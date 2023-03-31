@extends('layouts.app')

@section('content')

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
		                            <th>Partner Name</th>
		                            <th>Partner Icon</th>
		                            <th width="100">Action</th>
	                          	</tr>

	                        	@foreach($partnerLists as $key=>$partnerList)
		                         <tr>
		                            <td>{{ $key+1 }}</td>
		                            <td>{{ $partnerList->partner_name }}</td>
		                            <td>{{ $partnerList->partner_icon }}</td>
		                            
		                            <td>
		                            	 <form class="text-center" action="{{route('partner.destroy',$partnerList->id)}}" method="POST">
					                      <a class="btn-primary btn-sm text-white" href="{{route('partner.edit',$partnerList->id)}}" title="">
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
                      {{ $partnerLists->links() }}
                    </div>
                    </div>
                  </div>
                </div>
            </div>


		</div>
	</div>
</div>
@endsection
