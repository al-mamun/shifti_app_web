
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
@foreach($emailhistory as $emails)
    <div class="modal fade viewEmailHistory" id="viewEmailHistory{{ $emails->id }}" tabindex="-1" role="dialog" aria-labelledby="viewEmailHistory" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="createJob">View Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div class="modal-body">
                    
                    <form id="emailReplay" method="post" action="javascript:void(0)" enctype="multipart/form-data">
        		    	@csrf
        		        <div class="row">
        		            <div class="col-md-6 mb-3">
        		               <label for="name" class="form-label">Name:</label>
        		               {{ $emails->name }}
        		               <input type="hidden" name="fullName" value="{{ $emails->name }}">
        		               <input type="hidden" name="job_id" value="{{ $emails->type_id }}">
        		            </div>
        		            <div class="col-md-6 mb-3">
        		                <label for="product_title" class="form-label">  Date of Email:</label>
        		                {{ $emails->date }}
        		                <input type="hidden" name="date" value="{{ $emails->date }}">
        		                
        		            </div>
        		        </div>
        		        <div class="row">
        		            <div class="col-md-12 mb-3">
        		               <label for="product_title" class="form-label">Company Name:</label>
        		                <input type="hidden" name="company_name" value="{{ $emails->company_name }}">
        		               {{ $emails->company_name }}
        		            </div>
        		        </div>
        		        <div class="row">
        		            <div class="col-md-12 mb-3">
        		               <label for="product_title" class="form-label">Email Body:</label>
        		               {{ $emails->body }}
        		            </div>
        		        </div>
        		        
        		        <div class="row">
        		            <h5 style="text-align: center;display: block;float: none;width: 75%;">Replay</h5>
        		        </div>
        		        
        		        <div class="alert alert-danger print-error-msg-replay" style="display:none">
                            <ul></ul>
                        </div>
                        <div class="row">
        		            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label"> Title</label>
                                <input name="title" name="title" class="form-control" />
        			      	</div>
        		        </div>
        		        <div class="row">
        		            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Email Body</label>
                                <textarea  class="form-control" rows="4" cols="60" type="text" name="body" id="body"> </textarea>
        			      	</div>
        		        </div>
        
        		        <div class="row">
        		            <div class="col-md-6 mb-3">
        		                 <button class="btn btn-primary" type="submit" >Replay </button>
        					</div>
        		        </div>
    		        </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
<div class="modal fade" id="newEmail" tabindex="-1" role="dialog" aria-labelledby="newEmail" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createSupport">Create New Email</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
            
                <form id="new_email_submit" method="POST" enctype="multipart/form-data">
			     @csrf
			        <div class="row">
			            <div class="col-md-12 mb-3">
			                <label for="title">Enter title<span style="color:red">*</span></label>
			                <input class="form-control" name="title" id="title" type="text" placeholder="Title"  title="title" value="{{old('title')}}" />
			            </div>
			        </div>
			        <div class="row">
			      		<div class="col-md-12 mb-3 mt-3">
		      				 <label for="subject">Enter Subject<span style="color:red">*</span></label>
			                <input class="form-control" name="subject" id="subject" type="text" placeholder="subject"  title="subject" value="{{old('subject')}}" />
		                </div>
			      	</div>
			      	<div class="row">
			      		<div class="col-md-12 mb-3 mt-3">
		      				 <label for="email">Email<span style="color:red">*</span></label>
			                <input class="form-control" name="email" id="email" type="text" placeholder="Enter email here"  title="email" value="{{old('email')}}" />
		                </div>
			      	</div>
			      	<div class="row">
    		            <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Message<span style="color:red">*</span></label>
                            <textarea  class="form-control" rows="4" cols="60" type="text" name="body" id="body"> </textarea>
    			      	</div>
    		        </div>
			        <button class="btn btn-primary" type="submit">Submit </button>
			    </form>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-fluid">
	        <!-- Ajax data source array start-->
	    <div class="row">
            <div class="col-md-6">
              	<h3 class="page-title-admin">Email Inquiries </h3>
            </div>
       
            <div class="col-md-6">
                <h3 class="pull-right">
	              	 <a href="javascript:void(0)" class="btn btn-primary text-white"  data-toggle="modal" data-target="#newEmail" title="Add new">
                         New  Email
                     </a>
                 </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="">
                  	<div class="dt-ext">
                  	 <table class="display global" id="global">
                        <thead>
                          	<tr>
	                            <th>Name</th>
	                            <th>Company</th>
	                            <th>Topic</th>
	                            <th>Date Of Email</th>
	                            <th>status</th>
	                            <th></th>
                          	</tr>
                        </thead>
                        <tbody>
                        	@php $sl = 1; @endphp

                        	@foreach($emailhistory as $emails)
	                        
		                         <tr>
		                            <td>{{ $emails->name }}</td>
		                            <td>{{ $emails->company_name }}</td>
	                                <td>{{ $emails->subject }}</td>
	                                <td>{{ $emails->date }}  </td>
	                                <td>
	                                    @if($emails->type == 1)
	                                        Order Confrimation
	                                    @elseif($emails->type == 2)
	                                        Contact 
	                                    @elseif($emails->type == 3)
	                                        Job
	                                    @elseif($emails->type == 4)
	                                        Admin Job Replay
	                                    @elseif($emails->type == 6)
	                                        Admin Custom SMS
	                                    @else
	                                        Purchase
	                                    @endif
	                                </td>
	                                <td>
	                               
		                                <div class="dropdown">
                                          <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            . . .
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="action_button">
                                              <a class="dropdown-item" href="javascript:void(0)"  data-toggle="modal" data-target="#viewEmailHistory{{ $emails->id }}"  style="float: left;font-size: 19px;">View</a> 
                                          </div>
                                        </div>
    		                        </td>
		                        </tr>
		                   
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
            
    <script type="text/javascript">
    
        $('#new_email_submit').on('submit', function(event) {
        	event.preventDefault();                          // for demo
            $.ajax({
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                type: "POST",
                url: window.baseUrl + '/send/new/email',
                success:function(data) {
                	if($.isEmptyObject(data.error)){
                        Swal.fire(
                          'success!',
                          'Your E-mail sent successfully.',
                          'success'
                        );
                        
                        $('#newEmail').modal('hide');
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
        
        
         $('#emailReplay').on('submit', function(event) {
             
        	event.preventDefault();                          // for demo
            $.ajax({
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                type: "POST",
                url: window.baseUrl + '/send/replay/email',
                success:function(data) {
                	if($.isEmptyObject(data.error)){
                        Swal.fire(
                          'success!',
                          'Your E-mail sent successfully.',
                          'success'
                        );
                        
                        $('.viewEmailHistory').modal('hide');
                    }else{
                        printErrorMsgReplay(data.error);
                    }
                   
                }
            }); 
        });
        
        function printErrorMsgReplay (msg) {
            $(".print-error-msg-replay").find("ul").html('');
            $(".print-error-msg-replay").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg-replay").find("ul").append('<li>'+value+'</li>');
            });
        }
        
        
</script>

@endsection

