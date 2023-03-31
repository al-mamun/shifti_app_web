
@extends('layouts.app')

@section('content')
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".email_menu_title").addClass("active");
        $(".email_submenu").show();
        $(".email_submenu").css('display','block !important');
    });
    
</script>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
			<!-- Ajax data source array start-->
            <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Email History</h5>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      	<div class="dt-ext table-responsive">
                      	 <table class="display" id="basic-1">
	                        <thead>
	                          	<tr>
		                            <th>Sl</th>
		                            <th>title</th>
		                            <th>Subject</th>
		                            <th>Body</th>
		                            <th>Type</th>
		                            <th>Date</th>
	                          	</tr>
	                        </thead>
	                        <tbody>
	                        	@php $sl = 1; @endphp

	                        	@foreach($emailhistory as $emails)
    	                        	@if(!empty($emails->title))
    		                         <tr>
    		                            <td>{{ $sl++ }}</td>
    		                            <td>{{ $emails->title }}</td>
		                                <td>{{ $emails->subject }}</td>
		                                <td>{{ $emails->body }}</td>
		                                <td>
		                                    @if($emails->type == 1)
		                                        Job List
		                                    @elseif($emails->type == 2)
		                                        Contact 
		                                    @else
		                                        Purchase
		                                    @endif
		                                </td>
		                                <td>{{ $emails->date }} </td>
    		                        </tr>
    		                        @endif
	                          	@endforeach
	                        </tbody>
                      </table>
                      {{ $emailhistory->links() }}
                    </div>
                    </div>
                  </div>
                </div>
            </div>


		</div>
	</div>
</div>
@endsection

