<style>
.holder {
        height: 190px;
        width: 190px;
        border: 2px solid #eee;
        margin-bottom: 10px;
    }
    #imgPreviewEdit,.imgPreview {
        max-width: 190px;
        max-height: 190px;
        min-width: 190px;
        min-height: 190px;
    }
</style>
<script type="text/javascipt">
$(document).ready(() => {
        $("#editPhoto").change(function () {
            const file = this.files[0];
            if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
            $("#imgPreviewEdit")
                .attr("src", event.target.result);
            };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
            <div class="alert alert-danger-blog print-error-msg-blog" style="display:none">
                <ul></ul>
            </div>
            
    	    <form id="blogUpdate" method="post" action="javascript:void(0)" enctype="multipart/form-data">
	         @csrf

    	        <div class="row">
    	            <div class="col-md-12 mb-3">
    	                <label for="enter_title">Enter title <span style="color:red">*</span></label>
    	                <input class="form-control" name="title" id="enter_title" type="text" placeholder="Title" title="title" value="{{$blog->title}}" />
    	                <input class="form-control aria-hidden slugs" name="id" type="text" value="{{ $blog->id }}" required="" data-original-title="" title="" />
    	            </div>
    	        </div>
    	        <div class="row">
    	          
    	            <div class="col-md-6 mb-3">
    	                <label for="status">Tag<span style="color:red">*</span></label>
    		    			<select name="tags[]" class="form-control" aria-label="Default select example" value="{{ $blog->tags }}">
    					     <option value="">Select Tag</option>
    					     @foreach($taglist as $key=>$data)
    					        @php $tagNames = explode(',', $blog->tags); @endphp 
    		                    <option value="{{ $data->tag_name }}"  @foreach($tagNames as $tagName) @if($data->tag_name == $tagName) selected @endif @endforeach> {{ $data->tag_name }} </option>
    		                  @endforeach
    					 </select>
    	            </div>
    	            <div class="col-md-6 mb-3">
    	                <label for="status">Category<span style="color:red">*</span></label>
    		    		<select name="category_name" class="form-control" aria-label="Default select example" value="{{ $blog->category_name }}">
    					     <option value="" selected>Select Category</option>
    					     @foreach($categoryTagList as $key=>$data)
    	                       <option value="{{ $data->tag_name }}" @if ($data->tag_name==$blog->category_name) selected @endif>
    	                    	{{ $data->tag_name }}
    	                     </option>
    					     @endforeach
    					 </select>
    	            </div>
    	        </div>
    	 
    	      	<div class="row">
    	      		<div class="col-md-12 mb-3 mt-3">
          				<label for="validationDefault02">Descraption</label>
                          <textarea class="summernote" type="text" name="description" id="description">{{$blog->description}}</textarea>
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
                            <img id="imgPreviewEdit" src="{{ asset('images/uploads/blog/' . $blog->photo) }}" alt="pic" />
                        </div>
    	                
    	                <div class="input_container">
                            <input type="file" name="photo" id="editPhoto"  value= />
                        </div>
                    </div>
                </div>
    	        <button class="btn btn-primary" type="submit" >Update </button>
    	    </form>
    	    
            <script src="{{ asset('assets/js/editor/summernote/summernote.js') }}"></script>
            <script src="{{ asset('assets/js/editor/summernote/summernote.custom.js') }}"></script>   	    
    	  <script>
    	           $('#blogUpdate').on('submit', function(event) {
                    	event.preventDefault();                          // for demo
                     
                        $.ajax({
                            data:new FormData(this),
                            dataType:'JSON',
                            contentType: false,
                            cache: false,
                            processData: false,
                            type: "POST",
                            url: window.baseUrl + '/admin/blog/update/{{$blog->id}} ',
                            success:function(data) {
                            	if($.isEmptyObject(data.error)){
                                    Swal.fire(
                                      'success!',
                                      'Your record has been Updated',
                                      'successfully'
                                    );
                                    
                                    $('#blogUpdate').modal('hide');
                                }else{
                                    printErrorMsg(data.error);
                                }
                               
                               
                            }
                        }); 
                    });
                    
                    function printErrorMsg (msg) {
                        $(".print-error-msg-blog").find("ul").html('');
                        $(".print-error-msg-blog").css('display','block');
                        $.each( msg, function( key, value ) {
                            $(".print-error-msg-blog").find("ul").append('<li>'+value+'</li>');
                        });
                    }
    	  </script>
   