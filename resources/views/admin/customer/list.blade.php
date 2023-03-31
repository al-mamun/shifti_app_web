@extends('layouts.app')

@section('content')
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".customer_menu_title").addClass("active");
        $(".customer_submenu").show();
        $(".customer_submenu").css('display','block !important');
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
                    <h5>Customer List</h5>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      	<div class="dt-ext table-responsive">
                      	 <table class="display" id="basic-1">
	                        <thead>
	                          	<tr>
		                            <th>Sl</th>
		                            <th>Name</th>
		                            <th>Email</th>
		                            <th>Address</th>
		                            <th>Action</th>
		                         
	                          	</tr>
	                          	</tr>
	                        </thead>
	                        <tbody>
	                        	@php $sl = 1; @endphp

	                        	@foreach($customers as $list)
		                         <tr>
		                            <td>{{ $sl++ }}</td>
		                            <td>{{ $list->first_name.''.$list->last_name }}</td>
		                            <td>{{ $list->email }} </td>
		                    
		                            <td> </td>
		                            <td>
		                            	 <form class="text-center" action="{{route('joblist.destroy',$list->id)}}" method="POST">
					                      <a class="btn btn-primary btn-xs text-white" href="{{route('joblist.edit',$list->id)}}" title=""><i data-feather="edit-3"></i></a>

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
                        	<tfoot>
	                          	<tr>
		                            <th>Sl</th>
		                            <th>Name</th>
		                            <th>Email</th>
		                            <th>Address</th>
		                            <th>Action</th>
	                          	</tr>
                        	</tfoot>
                      </table>
                    </div>
                    </div>
                  </div>
                </div>
            </div>


		</div>
	</div>
</div>
@endsection
