@extends('layouts.app')

@section('content')
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".stories_menu_title").addClass("active");
        $(".stories_submenu").show();
        $(".stories_submenu").css('display','block !important');
    });
    
</script>
<div class="modal fade" id="customerList" tabindex="-1" role="dialog" aria-labelledby="customerList" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createSupport">View Customer Story</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body view_result">  </div>
    </div>
  </div>
</div>
<div class="modal fade" id="customerStories" tabindex="-1" role="dialog" aria-labelledby="addNewProduct" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createJob">New User Story</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
            
                <form id="storySubmit" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    		    	@csrf
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
    		                <label for="who" class="form-label">Who <span style="color:red">*</span> </label>
    		                <select name="customer_id" id="customer_id" class="form-control" aria-label="customer_id" >
    		                    <option value="">Select</option>
    		                    @foreach($customerList as $key=>$data)
                                <option value="{{ $data->id }}" > {{ $data->first_name }}</option>
                                @endforeach
                                
                            </select>
    		              
    		            </div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
    		                <label for="date">When?<span style="color:red">*</span></label>
    		                <input class="form-control" id="date" type="date" placeholder="date" value="" name="date" title="date" />
    		            </div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
    		                <label for="image">Title<span style="color:red">*</span></label>
    		                <input class="form-control" id="title" type="text" placeholder="Title" value="{{old('title')}}" name="title" title="title" />
    		            </div>
    		        </div>
    		        <div class="row">
			            <div class="col-md-12 mb-3">
			                <label for="status">Tag<span style="color:red">*</span></label>
				    		<select name="tags[]"  class="form-control" aria-label="Story Tag" >
							     <option value="">Select Tag</option>
							     @foreach($storyTagList as $key=>$data)
			                       <option value="{{ $data->tag_name }}"> {{ $data->tag_name }} </option>
							     @endforeach
							 </select>
			            </div>
			        </div>
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
    		                <label for="photo"> Image?<span style="color:red">*</span></label>
    		                 <input type="file" name="photo" class="form-control" placeholder="photo" value="{{old('photo')}}">
    		            </div>
    		        </div>
    		        
                    <div class="row">
    		            <div class="col-md-12 mb-3">
    		                <label for="term" class="form-label">
    		                    Notes
    		                    <span style="color:red">*</span>
    		                </label>
    		                <textarea  class="summernote" type="text" name="description" id="description" value="{{old('description')}}"></textarea>
    		            </div>
    		        </div>
    		     
    
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                 <button class="btn btn-info save_draft" type="submit" style="width:100%; float:left">Save as Draft</button>
    					</div>
    		            <div class="col-md-6 mb-3">
    		                 <button class="btn btn-primary publish" type="submit" style="width:100%; float:left">Publish</button>
    					</div>
    		        </div>
		        </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editStories" tabindex="-1" role="dialog" aria-labelledby="addNewProduct" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createJob">Update customer story</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body edit_result">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
            
                <form id="storySubmit" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    		    	@csrf
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
    		                <label for="who" class="form-label">Who <span style="color:red">*</span> </label>
    		                <select name="customer_id" id="customer_id" class="form-control" aria-label="customer_id" >
    		                    <option value="">Select</option>
    		                    @foreach($customerList as $key=>$data)
                                <option value="{{ $data->id }}" > {{ $data->first_name }}</option>
                                @endforeach
                                
                            </select>
    		              
    		            </div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
    		                <label for="date">When?<span style="color:red">*</span></label>
    		                <input class="form-control" id="date" type="date" placeholder="date" value="" name="date" title="date" />
    		            </div>
    		        </div>
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
    		                <label for="image">Title<span style="color:red">*</span></label>
    		                <input class="form-control" id="title" type="text" placeholder="Title" value="{{old('title')}}" name="title" title="title" />
    		            </div>
    		        </div>
    		        <div class="row">
			            <div class="col-md-12 mb-3">
			                <label for="status">Tag<span style="color:red">*</span></label>
				    		<select name="tags[]"  class="form-control" aria-label="Story Tag" >
							     <option value="">Select Tag</option>
							     @foreach($storyTagList as $key=>$data)
			                       <option value="{{ $data->tag_name }}"> {{ $data->tag_name }} </option>
							     @endforeach
							 </select>
			            </div>
			        </div>
    		        <div class="row">
    		            <div class="col-md-12 mb-3">
    		                <label for="photo"> Image?<span style="color:red">*</span></label>
    		                 <input type="file" name="photo" class="form-control" placeholder="photo" value="{{old('photo')}}">
    		            </div>
    		        </div>
    		        
                    <div class="row">
    		            <div class="col-md-12 mb-3">
    		                <label for="term" class="form-label">
    		                    Notes
    		                    <span style="color:red">*</span>
    		                </label>
    		                <textarea  class="summernote" type="text" name="description" id="description" value="{{old('description')}}"></textarea>
    		            </div>
    		        </div>
    		     
    
    		        <div class="row">
    		            <div class="col-md-6 mb-3">
    		                 <button class="btn btn-info save_draft" type="submit" style="width:100%; float:left">Save as Draft</button>
    					</div>
    		            <div class="col-md-6 mb-3">
    		                 <button class="btn btn-primary publish" type="submit" style="width:100%; float:left">Publish</button>
    					</div>
    		        </div>
		        </form>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
              	<h3 class="product_title">Customer Stories </h3>
            </div>
       
            <div class="col-md-6">
                <h3 class="pull-right">
	              	 <a href="javascript:void(0)" class="btn btn-primary text-white"  data-toggle="modal" data-target="#customerStories" title="Add new Customer Stories">
                        New User Story
                     </a>
                 </h3>
            </div>
        </div>
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
	        
            <table class="display global" id="global">
                <thead>
                    <tr style="color:#000">
                        <th></th>
                        <th>Company Name</th>
                        <th>Date Of Story</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stories as $key=>$data)
                        <tr id="story_id_{{ $data->id }}">
                            
                            <td>
                                <div class="thumbnail_image">
                                    <span class="icon_thumbnails">
                                         @if(!empty($data->authorImage))
                                            <img src="{{  URL::asset('upload/customer/'.$data->authorImage)}}" class="author_image">
                                        @else
                                            <img src="{{  URL::asset('upload/customer/author_4.png')}}" class="author_image">
                                        @endif
                                    </span>
                                    
                                </div>
                            </td>
                            <td>
                                <span class="productName">
                                    {{ $data->first_name }}
                                </span>
                            </td>
                            
                            <td>
                                @php
                                    $date = date("F d, Y", strtotime( $data->date));
                                @endphp
                                {{ $date }}
                             </td>
                          
                            <td>
                                @if($data->status == 1)
                                 <button type="submit" class="btn btn-primary text-white status-button approved" title="Publish">
    		                         <span class="status-button-text open">Publish</span>
    		                    </button>
    		                    @else 
    		                        <button type="submit" class="btn btn-primary text-white status-button darft" title="Darft">
    		                         <span class="status-button-text open">Darft</span>
    		                    </button>
    		                    @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                  <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    . . .
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="action_button">
                                        <a class="dropdown-item" onClick="viewCustomerStory('{{$data->id }}')" href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" data-toggle="modal" data-target="#customerList">View</a>
                                        <a class="dropdown-item" onClick="editCustomer('{{$data->id }}')" href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" data-toggle="modal" data-target="#editStories">Edit</a>
                                        <a class="dropdown-item" onClick="deleteData('{{ $data->id }}')"  href="javascript:void(0)" style="float: left;font-size: 14px; font-family: 'Nunito Sans', sans-serif;" style="float: left;font-size: 19px; color:#666">Delete</button>
                   
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
<script type="text/javascript">

    function deleteData(id) {
             Swal.fire({
              title: 'Delete Story',
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
                    url: baseUrl +'/admin/story/delete/'+ id , 
                    success: function(HTML) {
                       $('#story_id_'+id).hide();
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
    
     $('#storySubmit').on('submit', function(event) {
    	event.preventDefault();                          // for demo
     
        $.ajax({
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            type: "POST",
            url: window.baseUrl + '/admin/stories/post',
            success:function(data) {
            	if($.isEmptyObject(data.error)){
                    Swal.fire(
                      'success!',
                      'Your record has been add',
                      'success'
                    );
                    
                    $('#customerStories').modal('hide');
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
    
    function editCustomer(id) {
     $.ajax({
        type: "POST",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
          
        },
        url: window.baseUrl + '/edit/customer/story/'+ id,
        success:function(data) {
        	$('.edit_result').html(data);
        }
    }); 
}

    function viewCustomerStory(id) {
    
        $.ajax({
            type: "POST",
            data: {
                '_token': $('input[name=_token]').val(),
                'id': id,
              
            },
            url: window.baseUrl + '/view/story',
            success:function(data) {
            	$('.view_result').html(data);
            }
        }); 
    }
</script>
@endsection
