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
<style>
    .global tbody tr td {
        font-family: 'Nunito Sans', sans-serif;
        font-style: normal;
        font-weight: 400;
        font-size: 13.0922px;
        line-height: 27px;
        color: #253334;
        padding-bottom: 2px;
        padding-top: 0px;
    }
     button.btn.btn-primary.text-white.status-button {
       
        padding-top: 5px;
    }
   .holder {
        height: 150px;
        width: 150px;
        border: 1px solid #eee;
        margin-bottom: 10px;
    }
    #imgPreview,.imgPreview {
        max-width: 150px;
        max-height: 150px;
        min-width: 150px;
        min-height: 150px;
        display: none;
    }
    .input_container {
      border: 1px solid #e5e5e5;
    }
        
    input[type=file]::file-selector-button {
        background-color: #fff;
        color: #000;
        border: 0px;
        border-right: 1px solid #e5e5e5;
        padding: 10px 15px;
        margin-right: 20px;
        transition: .5s;
    }
        
    input[type=file]::file-selector-button:hover {
        background-color: #eee;
        border: 0px;
        border-right: 1px solid #e5e5e5;
    }
    .heading {
        font-family: Montserrat;
        font-size: 45px;
        color: green;
    }
    </style>
    <script>
        $(document).ready(() => {
            $("#photo").change(function () {
                const file = this.files[0];
                if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $("#imgPreview").attr("src", event.target.result);
                    $("#imgPreview").show();
                 
                };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
<div class="modal fade" id="customerList" tabindex="-1" role="dialog" aria-labelledby="customerList" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createSupport">View Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body view_result">  </div>
    </div>
  </div>
</div>
<!-- Invite Company Modal -->

<div class="modal fade" id="inviteCompany" tabindex="-1" role="dialog" aria-labelledby="inviteCompany" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="invite">Invite Company</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg-invite" style="display:none">
                    <ul></ul>
                </div>
            
                    <form id="inviteSubmit" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    		    	    @csrf
                            <!--Newsletter Form-->
                            <div class="newsletter-form">
                                
                                    <div class="row">
				                       <div class="col-md-8 mb-3">
                                            <div class="form-group">
                                                <span><input class="form-control" type="email" name="email" value="" placeholder="Enter Your Email">
                                            </div>
                                           
                                        </div>
				                       <div class="col-md-3 mb-3">
                                            <button type="submit" class="form-control btn btn-primary">Send Invite</button>
                                        </div>
                                    </div>
                               
                            </div>
				    </form>
            </div>
        </div>
    </div>
</div>
<!--Onboard modal-->
<div class="modal fade" id="onBoardCompany" tabindex="-1" role="dialog" aria-labelledby="onBoardCompany" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="onBoard">On Board Company</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
            
                <form id="customerSubmit" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    		    	    @csrf
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="company"> Company Name <span style="color:red">*</span></label>
				                <input class="form-control" name="company" id="company" type="text" placeholder="Company Name"  />
				            </div>
				         
				            <div class="col-md-6 mb-3">
				                 <label for="Email">Email <span style="color:red">*</span></label>
                                 <input type="email" name="email" class="form-control" placeholder="Enter your email">
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-12 mb-3">
				                <label for="phone"> Phone <span style="color:red">*</span></label>
				                <input class="form-control" name="phone" id="phone" type="text" placeholder="Enter your phone"  />
				            </div>
				         </div>
				         <div class="row">
				             <div class="col-md-6 mb-3">
				                 <label for="address">Country <span style="color:red">*</span></label>
				                 <select name="country" class="form-control">
				                       <option value=""> Select Country </option>
				                     @foreach($country as $list)
				                        <option value="{{ $list->name }}"> {{ $list->name }} </option>
				                     @endforeach
				                 </select>
                                 
				            </div>
				            <div class="col-md-6 mb-3">
				                 <label for="address">Address <span style="color:red">*</span></label>
                                 <input type="text" name="address" class="form-control" placeholder="Enter your address">
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-12 mb-3">
				                <label for="phone"> Zip Code <span style="color:red">*</span></label>
				                <input class="form-control" name="zip_code" id="zip_code" type="text" placeholder="Enter your zip code"  />
				            </div>
				         </div>
				        <div class="row" style="margin-bottom:10px">
                            <div class="col-md-12 mb-3 form-group">
                                <label for="thumbnail_uplaod">Thumbnail upload <span style="color:red">*</span></label>
                                <div class="holder">
                                    <img id="imgPreview" src="" alt="pic" />
                                </div>
				                
				                <div class="input_container">
                                    <input type="file" name="photo" id="photo"  value= />
                                </div>
                            </div>
                        </div>
				        <div class="row">
    			           <div class="col-md-6 mb-3">
    			                <label for="password">Password  <span style="color:red">*</span></label>
    			                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
    			            </div>
    			          
				            <div class="col-md-6 mb-3">
				                 <label for="confirm_password">Confrim Password <span style="color:red">*</span></label>
                                 <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="{{old('email')}}">
				            </div>
				        </div>
	
					     <div class="row" style="margin-bottom:10px">
                          
                        </div>
				        <button class="btn btn-primary" type="submit" >Submit </button>
				    </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editList" tabindex="-1" role="dialog" aria-labelledby="onBoardCompany" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="onBoard">Update Company Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body edit_result">
                
            </div>
        </div>
    </div>
</div>

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
                    <div class="row customers_row">
        	            <div class="col-md-6 pull-left">
        	              	<h3>Customers</h3>
        	            </div>
        	            <div class="col-md-3 pull-left">
        	              	<h3 class="pull-right">
                                 <a href="javascript:void(0)" class="btn btn-primary text-white"  data-toggle="modal" data-target="#inviteCompany" title="On Board ">
        	                          INVITE COMPANY
        	                     </a>
                             </h3>
        	            </div>
        	            <div class="col-md-3 pull-left">
        	              	<h3 class="pull-right">
                                 <a href="javascript:void(0)" class="btn btn-primary text-white"  data-toggle="modal" data-target="#onBoardCompany" title="On Board ">
        	                           ONBOARD COMPANY
        	                     </a>
                             </h3>
        	            </div>
        	        </div>
                    <div class="">
                      	<div class="dt-ext ">
                      	 <table class="display global" id="global">
	                        <thead>
	                          	<tr>
		                            <th></th>
		                            <th>Company Name</th>
		                            <th>Status</th>
		                            <th>Date Of Sign Up</th>
		                            <th>Email Address</th>
		                            <th>Monthly Subscription</th>
		                            <th></th>
	                          	</tr>
	                          
	                        </thead>
	                        <tbody>
	                        	@foreach($customers as $list)
		                         <tr id="customer_id_{{$list->id}}">
		                            <td>
		                                @if(!empty($list->photo))
		                                    <img src="{{  URL::asset('upload/customer/'.$list->photo)}}" class="author_image">
		                                @else
		                                    <img src="{{  URL::asset('upload/customer/author_4.png')}}" class="author_image">
		                                @endif
		                            </td>
		                            <td>{{ $list->first_name.''.$list->last_name }}</td>
		                            <td>
		                                    @if($list->status == 1)
    		                                    <button type="submit" class="btn btn-primary text-white status-button approved" title="open">
                    		                         <span class="status-button-text open">Active</span>
                    		                    </button>
					                        @elseif($list->status == 3)
					                            <button type="submit" class="btn btn-primary text-white status-button pending" title="open">
                    		                         <span class="status-button-text open">On Notice</span>
                    		                    </button>
					                        @elseif($list->status == 2)
					                            <button type="submit" class="btn btn-primary text-white status-button reject" title="open">
                    		                         <span class="status-button-text open">Suspended</span>
                    		                    </button>
					                        @endif
					                </td>
		                            <td>
		                                @php
                                            $date = date("F d, Y", strtotime( $list->created_at));
                                        @endphp
                                        {{ $date }}
		                            </td>
		                            <td>{{ $list->email }} </td>
		                    
		                            <td> @if(!empty($list->price)) $ {{ $list->price }} @endif </td>
	                                <td>
                                        <div class="dropdown">
                                            <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                . . .
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="action_button">
                                                <a class="dropdown-item" onClick="viewCustomer('{{$list->id}}')" href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" data-toggle="modal" data-target="#customerList">View</a>
                                                <a class="dropdown-item" onClick="editCustomer('{{$list->id}}')" href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" data-toggle="modal" data-target="#editList">Edit</a>
                                                @if($list->status != 2)
                                                    <a class="dropdown-item" onClick="SuspendCustomer('{{$list->id}}','2')" href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" >Suspend Customers</a>
                                                @elseif($list->status == 2)
                                                    <a class="dropdown-item" onClick="SuspendCustomer('{{$list->id}}','1')" href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" >Un-Suspend Customers</a>
                                                @endif
                                                @if($list->status != 3)
                                                    <!--<a class="dropdown-item" onClick="SuspendCustomer('{{$list->id}}')" href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" >Suspend Customers</a>-->
                                                    <!--<a class="dropdown-item" onClick="SuspendCustomer('{{$list->id}}')" href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" >On Notice</a>-->
                                                @endif
                                            </div>
                                        </div>
                                    </td>
		                             <!-- <td>
		                           	 <form class="text-center" action="{{route('joblist.destroy',$list->id)}}" method="POST">
					                      <a class="btn btn-primary btn-xs text-white" href="{{route('joblist.edit',$list->id)}}" title=""><i data-feather="edit-3"></i></a>

					                       @csrf
					                       @method('DELETE')
					                      <button type="submit" class="btn btn-danger btn-xs text-white" title="Delete">
					                         <i data-feather="trash-2"></i>
					                      </button>
					                    </form>
					                   
		                            </td>-->
		                        </tr>
	                          	@endforeach
	                        </tbody>
                      </table>
                   
                  </div>
                </div>
            </div>


		</div>
	</div>
</div>

<script type="text/javascript">

function SuspendCustomer(id,status) {
    if(status == 2) {
        var message = "Are you sure want to this customers suspend?";
        var title = "Suspend customers?";
    } else {
        var title = "Un-suspend customers?";
        var message = "Are you sure want to this customers un-suspend?";
    }
    Swal.fire({
      title: title,
      text: message,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, confirm it!'
    }).then((result) => {
         $.ajax({
                type: "POST",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id,
                    'status':status
                  
                },
                url: baseUrl +'/admin/customer/list/suspended/'+ id , 
                success: function(HTML) {
                    
                //   $('#joblist_id_'+id).hide();
                   
                    Swal.fire(
                      'Suspended!',
                      'Your record has been suspended',
                      'success'
                    );
                    location.reload();
                }
            
            });
    });    
}

$('#customerSubmit').on('submit', function(event) {
   
	event.preventDefault();                          // for demo
 
    $.ajax({
        data:new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        type: "POST",
        url: window.baseUrl + '/onboard/customer',
        success:function(data) {
        	if($.isEmptyObject(data.error)){
                Swal.fire(
                  'success!',
                  'Your record has been added',
                  'success'
                );
                
                $('#onBoardCompany').modal('hide');
            }else{
                printErrorMsg(data.error);
            }
           
        }
    }); 
});

$('#inviteSubmit').on('submit', function(event) {
   
	event.preventDefault();                          // for demo
 
    $.ajax({
        data:new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        type: "POST",
        url: window.baseUrl + '/invite/company',
        success:function(data) {
            
        	if($.isEmptyObject(data.error)){
        	    
                Swal.fire(
                  'success!',
                  'Your invite is send',
                  'success'
                );
                
                $('#inviteCompany').modal('hide');
            }else{
                printErrorMsgInvite(data.error);
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
function printErrorMsgInvite (msg) {
    $(".print-error-msg-invite").find("ul").html('');
    $(".print-error-msg-invite").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg-invite").find("ul").append('<li>'+value+'</li>');
    });
}

function editCustomer(id) {
     $.ajax({
        type: "POST",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
          
        },
        url: window.baseUrl + '/edit/customer/list',
        success:function(data) {
        	$('.edit_result').html(data);
        }
    }); 
}

function viewCustomer(id) {

    $.ajax({
        type: "POST",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
          
        },
        url: window.baseUrl + '/view/customer/list',
        success:function(data) {
        	$('.view_result').html(data);
        }
    }); 
}
</script>
@endsection
