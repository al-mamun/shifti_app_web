<div class="alert alert-danger print-error-msg-edit" style="display:none">
    <ul></ul>
</div>

<form id="customerUpdate" method="post" action="javascript:void(0)" enctype="multipart/form-data">
	    @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="company"> Company Name <span style="color:red">*</span></label>
                <input class="form-control" name="company" id="company" type="text" placeholder="Company Name" value="{{ $customer->first_name }}" />
                <input class="form-control" name="id" id="id" type="hidden" placeholder="Company Name" value="{{ $customer->id }}" />
            </div>
         
            <div class="col-md-6 mb-3">
                 <label for="Email">Email <span style="color:red">*</span></label>
                 <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ $customer->email }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="phone"> Phone <span style="color:red">*</span></label>
                <input class="form-control" name="phone" id="phone" type="text" placeholder="Enter your phone"  value="{{ $customer->phone }}" />
            </div>
         </div>
         <div class="row">
             <div class="col-md-6 mb-3">
                 <label for="address">Country <span style="color:red">*</span></label>
                 <select name="country" class="form-control">
                       <option value=""> Select Country </option>
                     @foreach($country as $list)
                        <option value="{{ $list->name }}" @if($list->name == $customerAddress->country)  selected @endif > {{ $list->name }} </option>
                     @endforeach
                 </select>
                 
            </div>
            <div class="col-md-6 mb-3">
                 <label for="address">Address <span style="color:red">*</span></label>
                 <input type="text" name="address" class="form-control" placeholder="Enter your address" value="{{ $customerAddress->address }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="phone"> Zip Code <span style="color:red">*</span></label>
                
                <input class="form-control" name="zip_code" id="zip_code" type="text" placeholder="Enter your zip code"   value="{{ $customerAddress->post_code }}"/>
            </div>
         </div>
        <div class="row" style="margin-bottom:10px">
            <div class="col-md-12 mb-3 form-group">
                <label for="thumbnail_uplaod">Thumbnail upload <span style="color:red">*</span></label>
                <div class="holder">
                    <img id="imgPreview" src="{{  URL::asset('upload/customer/'.$customerAddress->photo)}}" alt="pic" />
                </div>
                
                <div class="input_container">
                    <input type="file" name="photo" id="photo"  value= />
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-md-6 mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
            </div>
          
            <div class="col-md-6 mb-3">
                 <label for="confirm_password">Confrim Password</label>
                 <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="{{old('email')}}">
            </div>
        </div>

	     <div class="row" style="margin-bottom:10px">
          
        </div>
        <button class="btn btn-primary" type="submit" >Submit </button>
    </form>
    
<script type="text/javascript">
    
$('#customerUpdate').on('submit', function(event) {
   
	event.preventDefault();                          // for demo
 
    $.ajax({
        data:new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        type: "POST",
        url: window.baseUrl + '/onboard/customer/update',
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