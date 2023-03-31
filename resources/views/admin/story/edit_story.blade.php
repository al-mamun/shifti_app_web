    <div class="alert alert-danger print-error-msg-edit" style="display:none">
        <ul></ul>
    </div>
    <form id="storyUpdate" method="post" action="javascript:void(0)" enctype="multipart/form-data">
    	@csrf
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="who" class="form-label">Who <span style="color:red">*</span> </label>
                <select name="customer_id" id="customer_id" class="form-control" aria-label="customer_id" >
                    <option value="">Select</option>
                    @foreach($customerList as $key=>$data)
                    <option value="{{ $data->id }}" @if($data->id == $story->customer_id) selected @endif> {{ $data->first_name }}</option>
                    @endforeach
                    
                </select>
              
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="date">When?<span style="color:red">*</span></label>
                <input class="form-control" id="date" type="date" placeholder="date" name="date" title="date" value="{{ $story->date }}"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="image">Title<span style="color:red">*</span></label>
                <input class="form-control" id="title" type="text" placeholder="Title" name="title" title="title"  value="{{ $story->title }}"/>
                <input type="hidden" name="id"  value="{{ $story->id }}"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="status">Tag<span style="color:red">*</span></label>
	    		<select name="tags"  class="form-control" aria-label="Story Tag" >
				     <option value="">Select Tag</option>
				     @foreach($storyTagList as $key=>$data)
                       <option value="{{ $data->tag_name }}" @if($data->tag_name ==  $story->tags) selected @endif> {{ $data->tag_name }} </option>
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
                <textarea  class="form-control" type="text" name="description" id="description" value="{{old('description')}}"> {!! $story->description !!} </textarea>
            </div>
        </div>
     

        <div class="row">
           
            <div class="col-md-6 mb-3">
                 <button class="btn btn-primary publish" type="submit" style="width:100%; float:left">Update</button>
			</div>
        </div>
    </form>
    
        
<script type="text/javascript">
    
$('#storyUpdate').on('submit', function(event) {
   
	event.preventDefault();                          // for demo
 
    $.ajax({
        data:new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        type: "POST",
        url: window.baseUrl + '/customer/story/update',
        success:function(data) {
        	if($.isEmptyObject(data.error)){
                Swal.fire(
                  'success!',
                  'Your customer information has been updated',
                  'success'
                );
                
                $('#customerUpdate').modal('hide');
            }else{
                printErrorMsgEdit(data.error);
            }
           
        }
    }); 
});
function printErrorMsgEdit (msg) {
    $(".print-error-msg-edit").find("ul").html('');
    $(".print-error-msg-edit").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg-edit").find("ul").append('<li>'+value+'</li>');
    });
}
    
</script>