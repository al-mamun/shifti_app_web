@extends('layouts.app')

@section('content')
<div class="modal fade" id="addNewSupport" tabindex="-1" role="dialog" aria-labelledby="addNewSupport" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createSupport">Create New Support</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>
            
                <form action="{{ url('/admin/support/add/save') }}" method="POST" enctype="multipart/form-data">
			     @csrf
			        <div class="row">
			            <div class="col-md-12 mb-3">
			                <label for="validationDefault01">Enter title<span style="color:red">*</span></label>
			                <input class="form-control" name="title" id="validationDefault01" type="text" placeholder="Title" data-original-title="" title="title" value="{{old('title')}}" />
			            </div>
			        </div>
			 
			      	<div class="row">
			      		<div class="col-md-12 mb-3 mt-3">
		      				<label for="validationDefault02">Content<span style="color:red">*</span></label>
		                     <textarea  class="summernote" type="text" name="content" id="content"></textarea>
		                </div>
			      	</div>
			      	<div class="row">
			      		<div class="col-md-12 mb-3 mt-3">
		      				<label for="validationDefault02">Image <span style="color:red">*</span> </label>
						    <input type="file" name="image" class="form-control mt-2" placeholder="Upload Image">
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
	              	<h3 class="page-title-admin">Support</h3>
	            </div>
	            <div class="col-md-6">
	                <h3 class="pull-right">
	                    <a href="javascript:void(0)" class="btn btn-primary text-white"  data-toggle="modal" data-target="#addNewSupport" title="Add new">
    	                        Add new
    	                     </a>
    	                     
    	              	 <!--<a href="{{ route('page.create') }}" class="btn btn-primary text-white" >
	                            New  Page
	                     </a>-->
                     </h3>
	            </div>
            </div>
	        <div class="card">
			    <div class="card-body">
				    <div class="card-content">
		            <table class="table table-bordered" border="1">
		              <tr style="color:#000">
		                  <th>SL.</th>
		                  <th>Title</th>
		                  <th>Content</th>
		                  <th>Image</th>
		                  <th>Action</th>
		              </tr>
		             @foreach($supports as $key=>$data)
		                <tr id="support_id_{{$data->id}}">
		                  <td>{{ $key+1 }}</td>
		                  <td>{{ $data->title }}</td>
		                  <td>{!! $data->content !!}</td>
		                  <td><img src="{{  URL::asset('images/support/' . $data->image)}}" width="200px"></td>
	                         <td>
                                <div class="dropdown">
                                    <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        . . .
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="action_button">
                                        <a class="dropdown-item" href="javascript:void(0)" class="btn btn-primary text-white" title="Edit Support" style="float: left;font-size: 19px;">Edit</a> 
                                        <a class="dropdown-item" onClick="deleteData('{{$data->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;">Delete</a>
                                         <!--<a href="{{route('support.delete',$data->id)}}" class="btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                                    </div>
                                </div>
                                
                            </td>
		                </tr>
		              @endforeach
		          </table>
		          {{ $supports->links() }}
	           </div>
			 </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

    function deleteData(id) {
             Swal.fire({
              title: 'Support Delete',
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
                    url: baseUrl +'/admin/support/delete/'+ id , 
                    success: function(HTML) {
                       $('#support_id_'+id).hide();
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
                  'Your record has been add',
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
</script>
@endsection
