@extends('layouts.app')

@section('content')
<style>
    tr {
        height:70px;
    }

        .holder {
            height: 50px;
            width: 50px;
            border: 2px solid #eee;
            margin-bottom: 10px;
                margin-top: 12px;
        }
        #imgPreview,.imgPreview {
            max-width: 50px;
            max-height: 50px;
            min-width: 50px;
            min-height: 50px;
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
    <script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".page_settings_menu").addClass("active");
      
    });
    
</script>
    <script>
        $(document).ready(() => {
            $("#photo").change(function () {
                const file = this.files[0];
                if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                $("#imgPreview")
                    .attr("src", event.target.result);
                };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>


<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
          
	        @if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
			
	       @if(Session::has('success'))
	          <div class="alert alert-success alert-dismissible fade show" role="alert">
	            <strong>{{ Session::get('success')}}</strong>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	            	 <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	        @endif
	        <div class="row">
                <div class="col-md-6">
	              	<h3 class="page-title-admin">Pages List </h3>
	            </div>
	       
	            <div class="col-md-6">
	                <h3 class="pull-right">
	                    <a href="javascript:void(0)" class="btn btn-primary text-white"  data-toggle="modal" data-target="#addNewPage" title="Add new Page">
    	                        Add new Page
    	                     </a>
    	                     
    	              	 <!--<a href="{{ route('page.create') }}" class="btn btn-primary text-white" >
	                            New  Page
	                     </a>-->
                     </h3>
	            </div>
            </div>
            <table class="display dataTable global" id="global">
                <thead>
                    <tr style="color:#000">
                      <th>Page Name</th>
                      <th>Date Of Payment</th>
                      <th>Status</th>
                      <th colspan="2">Page Visits (24 HR)</th>
                    </tr>
                </thead>
                <tbody>
                   
                    @foreach($pages as $key=>$data)
                    
                        <tr id="pages_id_{{$data->id}}" @if($key % 2 == 0)  style="background: #FCFCFC;" @endif>
                        <td>{{ $data->page_name }}</td>
                        <td>
                            @php
                                $date = date("F d, Y", strtotime( $data->created_at));
                            @endphp
                            {{ $date }} 
                        </td>
                       
                      <td>
                        @if($data->status == 1)  
                            <button type="submit" class="btn btn-primary text-white status-button" title="Active">
                                 <span class="status-button-text open">Active</span>
                            </button> 
                        
                        @else
                           <button type="submit" class="btn btn-primary text-white status-button draft" title="Draft">
                                 <span class="status-button-text open">Draft</span>
                            </button> 
                        @endif
                        
                        </td>
                       <td> 
                       
                            @php
                                $totalVisitior= DB::TABLE('visitor_logs')
                                    ->where('page_slug', $data->slug)
                                    ->where('date', date('Y-m-d'))
                                    ->count();
                            @endphp
                            @if(!empty($totalVisitior))
                                {{ $totalVisitior }}
                            @else
                                0
                            @endif
                       </td>
                       <td>
                            <div class="dropdown">
                                <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    . . .
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action_button">
                                    <a class="dropdown-item" href="javascript:void(0)"  data-toggle="modal" data-target="#editPage{{ $data->id }}" title="Edit Page" style="float: left;font-size: 19px;" class="btn btn-primary btn-sm">Edit</a> 
                                    <a class="dropdown-item" onClick="deleteData('{{$data->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;">Delete</a>
                                  <!--<a class="dropdown-item" href="{{ route('page.edit',$data->id) }}" style="float: left;font-size: 19px;">Delete</a> -->
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

<div class="modal fade" id="addNewPage" tabindex="-1" role="dialog" aria-labelledby="addNewPage" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createPage">Create New Page</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form id="pageSubmit" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    		    	@csrf
              
    		    	    <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="title">Enter title</label>
				                <input class="form-control" name="title" id="title" type="text" placeholder="Title" data-original-title="" title="title" value="{{old('title')}}" />
				            </div>
				            <div class="col-md-6 mb-3">
				                <div class="row">
				                     <div class="col-md-8 mb-3">
				                    <label for="thumbnail_uplaod">Thumbnail upload </label>
                              
    				                
    				                <div class="input_container">
                                        <input type="file" name="page_image" id="photo"  value= />
                                    </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="holder">
                                            <img id="imgPreview" src="#" alt="pic" />
                                        </div>
                                    </div>
                                </div>
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="page_name">Enter Page Name</label>
				                <input class="form-control" name="page_name" id="page_name" type="text" placeholder="Enter Page Name" data-original-title="" title="name" value="{{old('page_name')}}" />
				            </div>
				        </div>
				 
				      	<div class="row">
				      		<div class="col-md-12 mb-3 mt-3">
			      				<label for="Descraption">Descraption</label>
			                    <textarea   class="form-control" type="text" name="description" id="description"></textarea>
			                </div>
				      	</div>
    
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                 <button class="btn btn-primary" type="submit" >Create Page </button>
    					</div>
    		        </div>
		        </form>
            </div>
        </div>
    </div>
</div>
@foreach($pages as $key=>$data)
    <div class="modal fade" id="editPage{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="editPage" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createPage">Edit Page</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
                <form id="editPages" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    		    	@csrf
              
    		    	    <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="title">Enter title</label>
				                <input name="id" type="hidden" value="{{ $data->id }}" />
				                <input class="form-control" name="title" id="title" type="text" placeholder="Title" data-original-title="" title="title" value="{{ $data->title }}" />
				            </div>
				            <div class="col-md-6 mb-3">
				                <div class="row">
				                     <div class="col-md-8 mb-3">
				                        <label for="thumbnail_uplaod">Thumbnail upload</label>
        				                <div class="input_container">
                                            <input type="file" name="page_image" id="photo"  value= />
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="holder">
                                            @if(!empty($data->thumbnail))
                                                 <img id="imgPreview" src="{{ asset('images/uploads/page/'. $data->thumbnail )}}" alt="pic" />
                                                
                                            @endif
                                        </div>
                                    </div>
                                </div>
				            </div>
				        </div>
				        <div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="page_name">Enter Page Name</label>
				                <input class="form-control" name="page_name" id="page_name" type="text" placeholder="Enter Page Name" data-original-title="" title="name" value="{{ $data->page_name }}" />
				            </div>
				        </div>
				 
				      	<div class="row">
				      		<div class="col-md-12 mb-3 mt-3">
			      				<label for="Descraption">Descraption</label>
			                    <textarea   class="form-control" type="text" name="description" id="description">{{$data->description}}</textarea>
			                </div>
				      	</div>
    
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                 <button class="btn btn-primary" type="submit" > Save Change </button>
    					</div>
    		        </div>
		        </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<script type="text/javascript">

    function deleteData(id) {
          Swal.fire({
          title: 'Delete Page',
          text: "Are You Sure You want to delete Type 'DELETE' to delete",
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
                url: baseUrl +'/admin/pages/delete/'+ id , 
                success: function(HTML) {
                   $('#pages_id_'+id).hide();
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

    $('#pageSubmit').on('submit', function(event) {
    	event.preventDefault();                          // for demo
     
        $.ajax({
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            type: "POST",
            url: window.baseUrl + '/admin/pages',
            success:function(data) {
            	if($.isEmptyObject(data.error)){
                    Swal.fire(
                      'success!',
                      'Your record has been add',
                      'success'
                    );
                    
                    $('#addNewPage').modal('hide');
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
    
    	    
   $('#editPages').on('submit', function(event) {
    	event.preventDefault();                          // for demo
        $.ajax({
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            type: "POST",
            url: window.baseUrl + '/admin_page_update',
            success:function(data) {
            	if($.isEmptyObject(data.error)){
                    Swal.fire(
                      'success!',
                      'Your record has been Updated',
                      'successfully'
                    );
                    
                    $('#editPage').modal('hide');
                }else{
                    printErrorMsg(data.error);
                }
               
               
            }
        }); 
    });

</script>

@endsection
