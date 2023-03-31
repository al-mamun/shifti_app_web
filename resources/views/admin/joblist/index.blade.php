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
<style>
table#joblist, table#customerlist, table#joblist_2, table#global {
    background: #fff;
    width: 100%;
}
</style>
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
	        <div id="message"> </div>
			<!-- Ajax data source array start-->
            <div class="col-sm-12">
                <div class="card-jobs">
                     <div class="row">
                          <div class="col-md-6">
        	              	<h3>Open Jobs <span class="open-job"><a href="{{ url('/admin/all/joblist') }}" class="btn btn-primary btn-xs text-white view_all" title="open"> VIEW All </a></span></h3>
        	            </div>
        	       
        	            <div class="col-md-6">
        	                <h3 class="pull-right">
        	                     <!--<a href="#" class="btn btn-primary text-white"  data-toggle="modal" data-target="#createJob" title="create new job">-->
            	              	 <a href="{{ url('/admin/joblist/create') }}" class="btn btn-primary text-white"  title="create new job">
    		                        CREATE NEW JOB
    		                     </a>
		                     </h3>
        	            </div>
        	          </div>
                    <div>
                      	<div class="dt-ext">
                      	    <table class="borderless display global table" id="joblist">
    	                        <thead>
    	                          	<tr>
    		                            <th>Role</th>
    		                            <th>Location</th>
    		                            <th>Type</th>
    		                            <th>Applicants</th>
    		                            <th>Status</th>
    		                            <th></th>
    	                          	</tr>
    	                        </thead>
    	                       <tbody>
	                        	@foreach($openJob as $joblist)
	                        	    @php 
	                        	        $totalApplication = DB::table('job_apply_list')
	                        	        ->where('job_id', $joblist->id)
	                        	        ->count();
	                        	    @endphp
		                            <tr id="joblist_id_{{ $joblist->id }}">
		                            <td>{{ $joblist->job_title }}</td>
		                            <td>{{ $joblist->job_location }}</td>
		                            <td>{{ $joblist->type }}</td>
		                            <td>
		                                {{ $totalApplication }}
		                             </td>
		                            <td>
		                                <button type="submit" class="btn btn-primary text-white status-button" title="open">
            		                         <span class="status-button-text open">Open</span>
            		                    </button>
            		                </td>
		                            <td>
		                            	<div class="dropdown">
                                            <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                . . .
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="action_button">
                                                <a class="dropdown-item" onClick="EditJobApplication('{{$joblist->id}}')" style="float: left;font-size: 19px;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editJOb">Edit</a> 
                                                <a class="dropdown-item" onClick="deleteData('{{$joblist->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;">Delete</a>
                                                <a class="dropdown-item" onClick="viewJobApplication('{{$joblist->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;" data-toggle="modal" data-target="#viewJob">View</a>
                                            </div>
                                        </div>
		                            </td>
		                        </tr>
	                          	@endforeach
	                         </tbody>
                        </table>
                    </div>
                  </div>
                </div>
            </div>
            <!--Pending -->
            <div class="col-sm-12" style="margin-top:20px;">
                <div class="card-jobs">
                     <div class="row">
        	            <div class="col-lg-6">
        	              	<h3>Pending Hire <span class="pending-job"><a href="#" class="btn btn-primary btn-xs text-white view_all" title="open"> VIEW All </a></span></h3>
        	            </div>
        	          </div>
                    <div>
                      	<div class="dt-ext">
                      	 <table class="display global" id="global">
    	                        <thead>
    	                          	<tr>
    		                            <th>Role</th>
    		                            <th>Location</th>
    		                            <th>Type</th>
    		                            <th>Applicants</th>
    		                            <th>Status</th>
    		                            <th></th>
    	                          	</tr>
    	                        </thead>
    	                       <tbody>
	                        	@foreach($pendingJob as $joblist)
		                            <tr id="joblist_id_{{$joblist->id}}">
		                            <td>{{ $joblist->job_title }}</td>
		                            <td>{{ $joblist->job_location }}</td>
		                            <td>{{ $joblist->type }}</td>
		                            <td>200</td>
		                            <td>
		                                <button type="submit" class="btn btn-primary text-white status-button pending" title="open">
            		                         <span class="status-button-text open">Pending</span>
            		                    </button>
            		                </td>
		                            <td>
		                            	<div class="dropdown">
                                            <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                . . .
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="action_button">
                                                <a class="dropdown-item" onClick="EditJobApplication('{{$joblist->id}}')" style="float: left;font-size: 19px;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editJOb">Edit</a> 
                                                <a class="dropdown-item" onClick="deleteData('{{$joblist->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;">Delete</a>
                                                <a class="dropdown-item" onClick="viewJobApplication('{{$joblist->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;" data-toggle="modal" data-target="#viewJob">View</a>
                                            </div>
                                        </div>
		                            </td>
		                            
		                        </tr>
	                          	@endforeach
	                         </tbody>
                      </table>
                     
                    </div>
                  </div>
                </div>
            </div>
            
            <div class="col-sm-12" style="margin-top:20px;">
                <div class="card-jobs">
                     <div class="row">
        	            <div class="col-lg-6">
        	              	<h3>Approved Hires <span class="pending-job"><a href="#" class="btn btn-primary btn-xs text-white view_all" title="open"> VIEW All </a></span></h3>
        	            </div>
        	          </div>
                    <div>
                      	<div class="dt-ext">
                      	 <table class="display global" id="joblist_2">
    	                        <thead>
    	                          	<tr>
    		                            <th>Role</th>
    		                            <th>Location</th>
    		                            <th>Type</th>
    		                            <th>Applicants</th>
    		                            <th>Status</th>
    		                            <th></th>
    	                          	</tr>
    	                        </thead>
    	                       <tbody>
	                        	@foreach($approvedJob as $joblist)
		                            <tr id="joblist_id_{{$joblist->id}}">
		                            <td>{{ $joblist->job_title }}</td>
		                            <td>{{ $joblist->job_location }}</td>
		                            <td>{{ $joblist->type }}</td>
		                            <td>200</td>
		                            <td>
		                                <button type="submit" class="btn btn-primary text-white status-button approved" title="Aprroved">
            		                         <span class="status-button-text ">Aprroved</span>
            		                    </button>
            		                </td>
		                            <td>
		                            	<div class="dropdown">
                                            <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                . . .
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="action_button">
                                                <a class="dropdown-item" onClick="EditJobApplication('{{$joblist->id}}')" style="float: left;font-size: 19px;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editJOb">Edit</a> 
                                                <a class="dropdown-item" onClick="deleteData('{{$joblist->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;">Delete</a>
                                                <a class="dropdown-item" onClick="viewJobApplication('{{$joblist->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;" data-toggle="modal" data-target="#viewJob">View</a>
                                            </div>
                                        </div>
		                            </td>
		                        </tr>
	                          	@endforeach
	                         </tbody>
                      </table>
                     
                    </div>
                  </div>
                </div>
            </div>
            @include('admin.joblist.modal')
            
		</div>
	</div>
</div>
<script type="text/javascript">

    function deleteData(id) {
             Swal.fire({
              title: 'Joblist Delete',
              text: "Be careful please !  All related details will be deleted with this.",
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                
              if (result.isConfirmed) {
                // window.location.href = link;
                $.ajax({
                    type: "POST",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': id,
                      
                    },
                    url: baseUrl +'/admin/joblist/delete/'+ id , 
                    success: function(HTML) {
                       $('#joblist_id_'+id).hide();
                        Swal.fire(
                          'Deleted!',
                          'Your record has been deleted',
                          'success'
                        );
                    }
                
                });
              }
            
        
        });
  
    }
    
$('#jobSubmit').on('submit', function(event) {
	event.preventDefault();                          // for demo
 
    $.ajax({
        data:new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        type: "POST",
        url: window.baseUrl + '/admin/joblist',
        success:function(data) {
        	if($.isEmptyObject(data.error)){
                Swal.fire(
                  'success!',
                  'Your record has been updated',
                  'success'
                );
                
                $('#createJob').modal('hide');
            }else{
                printErrorMsg(data.error);
            }
           
        }
    }); 
});

function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
}

 function EditJobApplication(id) {
   
    $.ajax({
        type: "POST",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
          
        },
        url: window.baseUrl + '/edit/admin/joblist',
        success:function(data) {
        	$('.update_result').html(data);
        }
    }); 
}
 function viewJobApplication(id) {
   
    $.ajax({
        type: "POST",
        data: {
            '_token': $('input[name=_token]').val(),
            'job_id': id,
          
        },
        url: window.baseUrl + '/view/apply/admin/joblist',
        success:function(data) {
        	$('.apply_list').html(data);
        }
    }); 
}
</script>
@endsection
