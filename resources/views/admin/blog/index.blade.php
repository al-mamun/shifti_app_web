@extends('layouts.app')

@section('content')
<style type="text/css">
	.slugs{
		display: none;
	}
   .holder {
        height: 300px;
        width: 300px;
        border: 2px solid #eee;
        margin-bottom: 10px;
    }
    #imgPreview,.imgPreview {
        max-width: 296px;
        max-height: 300px;
        min-width: 296px;
        min-height: 300px;
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
        $(".blog_list a").addClass("active");
        $(".blog_list_data").show();
        $(".blog_list_data").css('display','block !important');
    });
    
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
<div class="modal fade" id="addNewBlog" tabindex="-1" role="dialog" aria-labelledby="addNewBlog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createSupport">Create New Blog</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
            
                    <form id="blogSubmt" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    		    	    @csrf
				        <div class="row">
				            <div class="col-md-12 mb-3">
				                <label for="validationDefault01">Enter title <span style="color:red">*</span></label>
				                <input class="form-control" name="title" id="validationDefault01" type="text" placeholder="Title" data-original-title="" title="title" value="{{old('title')}}" />
				                <input class="form-control aria-hidden slugs" name="slug" id="slug" type="text" value="Title" required="" data-original-title="" title="" />
				            </div>
				        </div>
				        <div class="row">
				             <div class="col-md-6 mb-3">
				                <label for="status">Tag<span style="color:red">*</span></label>
    				    		<select name="tags[]"  class="form-control" aria-label="Default select example" >
    							     <option value="">Select Tag</option>
    							     @foreach($taglist as $key=>$data)
    			                       <option value="{{ $data->tag_name }}"> {{ $data->tag_name }} </option>
    							     @endforeach
    							 </select>
				            </div>
				            <div class="col-md-6 mb-3">
				                <label for="status">Category<span style="color:red">*</span></label>
    				    		<select name="category_name" class="form-control" aria-label="Default select example" required>
    							     <option value="" selected>Select Category</option>
    							     @foreach($categoryTagList as $key=>$data)
    			                       <option value="{{ $data->tag_name }}"> {{ $data->tag_name }} </option>
    							     @endforeach
    							 </select>
				            </div>
				        </div>
				 
				      	<div class="row">
				      		<div class="col-md-12 mb-3 mt-3">
			      				<label for="description">Descraption</label>
			                    <textarea  class="summernote" type="text" name="description" id="description"></textarea>
			                </div>
				      	</div>
                     
				     <!--  	<div class="row">
				            <div class="col-md-6 mb-3">
				                <label for="validationDefault02">Tags</label>
				                <input class="form-control" id="validationDefault02" type="text" placeholder="Tags" required="" data-original-title="" name="selling_price" />
				            </div>
				        </div> -->
	
					     <div class="row" style="margin-bottom:10px">
                            <div class="col-md-12 mb-3 form-group">
                                <label for="photo_uplaod">Photo upload <span style="color:red">*</span></label>
                                <div class="holder">
                                    <img id="imgPreview" src="{{ asset('images/uploads/blog/' . $data->photo) }}" alt="pic" />
                                </div>
				                
				                <div class="input_container">
                                    <input type="file" name="photo" id="photo"  value= />
                                </div>
                            </div>
                        </div>
				        <button class="btn btn-primary" type="submit" data-original-title="" title="">Submit </button>
				    </form>
            </div>
        </div>
    </div>
</div>
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
	              	<h3 class="page-title-admin">BLog List </h3>
	            </div>
	       
	            <div class="col-md-6">
	                <h3 class="pull-right">
                        <a href="javascript:void(0)" class="btn btn-primary text-white"  data-toggle="modal" data-target="#addNewBlog" title="Add new">
	                        New  Blog
	                     </a>
                     </h3>
	            </div>
            </div>
            <div class="row">
				<div class="global">
    		            <table class="display global dataTable no-footer" id="global" role="grid" aria-describedby="global_info">
    		                <thead>
    		                       <tr style="color:#000">
            		                  <th>SL.</th>
            		                  <th>Title</th>
            		                  <th>Tag</th>
            		                  <th>Category</th>
            		                  <th>Slug</th>
            		                  <th>Description</th>
            		                  <th>Photo</th>
            		                  <th width="150">Action</th>
            		              </tr>
    		                </thead>
    		           
    		             @foreach($blogs as $key=>$data)
    		               <tr id="blog_id_{{$data->id}}">
    		                  <td>{{ $key+1 }}</td>
    		                  <td>{{ $data->title }}</td>
    		                  <td>{{ $data->tags }}</td>
    		                  <td>{{ $data->category_name }}</td>
    		                  <td>{{ $data->slug }}</td>
    		                  <td>{!! substr(strip_tags($data->description), 0, 50)  !!}</td>
    		                  <td><img src="{{  URL::asset('images/uploads/blog/' . $data->photo)}}" width="200px"></td>
    		                  <td>
                                <div class="dropdown">
                                    <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        . . .
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="action_button">
            		                   <a href="{{ route('blog.show',$data->id) }}"  class="dropdown-item" style="float: left;font-size: 19px;">View</a> 
            		                   <!--<a href="{{ route('blog.edit',$data->id) }}"  class="dropdown-item" style="float: left;font-size: 19px;">Edit</a>--> 
            		                    <a class="dropdown-item" onClick="editBlog('{{$data->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;" data-toggle="modal" data-target="#editBlog">Edit</a> 
            		                     <!-- <a href="{{ route('blog.delete',$data->id) }}" class="btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a> --> 
            		                   <a class="dropdown-item" onClick="deleteData('{{$data->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;">Delete</a>
                                    </div>
                                </div>
                              </td>
    		                </tr>
    		              @endforeach
    		          </table>
    		           
    	          
			        </div>
			</dic>

		</div>
		 <style type="text/css">
	.slugs{
		display: none;
	}
</style>
    <div class="modal fade" id="editBlog" tabindex="-1" role="dialog" aria-labelledby="editBlog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBlog">Edit Blog</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body edit_result">
                </div>
            </div>
        </div>
    </div>
	</div>
</div>
<script type="text/javascript">

    function deleteData(id) {
             Swal.fire({
              title: 'Blog Delete',
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
                    url: baseUrl +'/admin/blog/delete/'+ id , 
                    success: function(HTML) {
                       $('#blog_id_'+id).hide();
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
    
  


    function editBlog(id) {
   
        $.ajax({
            type: "POST",
            data: {
                '_token': $('input[name=_token]').val(),
                'id': id,
              
            },
            url: window.baseUrl + '/admin/blog/edits/' + id,
            success:function(data) {
            	$('.edit_result').html(data);
            }
        }); 
    }
    
    $('#blogSubmt').on('submit', function(event) {
        
    	event.preventDefault();                          // for demo
        $.ajax({
            data:new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            type: "POST",
            url: window.baseUrl + '/admin/blog',
            success:function(data) {
            	if($.isEmptyObject(data.error)){
                    Swal.fire(
                      'success!',
                      'Your record has been add',
                      'success'
                    );
                    
                    $('#addNewBlog').modal('hide');
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
    
    
 
</script>
@endsection
