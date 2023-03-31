@extends('layouts.app')
@section('content')
<script src= "https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"> </script>
<script type="text/javascript">
 // $(".view-customer-info a").attr("href").val('1');
    
    $( document ).ready(function() {
        
        $(".page_menu_title").addClass("active");
        $(".page_submenu").show();
        $(".page_submenu").css('display','block !important');
    });
    
</script>
                                       
    <style>
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
			   @if(isset($status))
	           
	          <div class="alert alert-success alert-dismissible fade show" role="alert">
    	            <strong> Home page save successfully</strong>
    	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    	            	 <span aria-hidden="true">&times;</span>
    	            </button>
    	          </div>
    	        @endif
                <div class="card">
                  <div class="card-header">
                    <h5>Home</h5>
                  </div>
                    <div class="card-body">
                    
                            <ul class="nav nav-tabs nav-right" id="right-tab" role="tablist">
                              <li class="nav-item"><a class="nav-link active" id="right-home-tab" data-toggle="tab" href="#right-home" role="tab" aria-controls="right-home" aria-selected="true"><i class="icofont icofont-ui-home"></i>Home Basic</a></li>
                              <li class="nav-item"><a class="nav-link" id="customaztion-right-tab" data-toggle="tab" href="#right-customaztion" role="tab" aria-controls="profile-icon" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Review</a></li>
                              <li class="nav-item"><a class="nav-link" id="hub-right-tab" data-toggle="tab" href="#right-hub" role="tab" aria-controls="contact-icon" aria-selected="false"><i class="icofont icofont-contacts"></i>Hub </a></li>
                              <li class="nav-item"><a class="nav-link" id="product-right-tab" data-toggle="tab" href="#right-product" role="tab" aria-controls="contact-icon" aria-selected="false"><i class="icofont icofont-contacts"></i>Product cuztomazation </a></li>
                            </ul>
                            <div class="tab-content" id="right-tabContent">
                                <div class="tab-pane fade show active" id="right-home" role="tabpanel" aria-labelledby="right-home-tab">
                                   <form action="{{ url('home-save') }}" id="homeFormSave" method="POST" action="javascript:void(0)" enctype="multipart/form-data">
                                        <div class="row">
            				              <div class="col-md-12 mb-3 form-group">
            				                <label for="validationDefault01">Title <span style="color:red">*</span></label>
                                            <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{ $homePage->title }}">
                                          </div>
            				              <div class="col-md-12 mb-3 mt-3">
            				                <label for="validationDefault01">Content<span style="color:red">*</span></label>
                                            <textarea type="text" name="content" class="summernote" placeholder="Enter Details">{{ $homePage->content }}</textarea>
                                          </div>
                                        </div>
                                       <div class="row" style="margin-bottom:10px">
                                            <div class="col-md-12 mb-3 form-group">
                                                <label for="validationDefault01">Thumbnail upload <span style="color:red">*</span></label>
                                                <div class="holder">
                                                    <img id="imgPreview" src="{{ asset('images/homepage/' . $homePage->thumbnail) }}" alt="pic" />
                                                </div>
                				                
                				                <div class="input_container">
                                                    <input type="file" name="thumbnail" id="photo"  value= />
                                                </div>
                                            </div>
                                        </div>
                
                                       <div class="row">
                				              <div class="col-md-12 mb-3 form-group">
                				                <label for="validationDefault01">Team Title <span style="color:red">*</span></label>
                                                <input type="text" name="team_title" class="form-control" placeholder="Enter Team Title" value="{{ $homePage->team_title }}">
                                              </div>
                				              <div class="col-md-12 mb-3 mt-3">
                				                <label for="validationDefault01">Team Content<span style="color:red">*</span></label>
                                                <textarea type="text" name="team_content" class="summernote" placeholder="Enter Details">{{ $homePage->team_content }}</textarea>
                                              </div>
                                           </div>
                                       <div class="row">
            				           
            				              <div class="col-md-12 mb-3 mt-3">
            				                <label for="validationDefault01">Team feature<span style="color:red">*</span></label>
            				                <input type="text" name="feature" class="form-control" placeholder="Enter feature" value="{{ $homePage->feature }}">
                                            <!--<textarea type="text" name="feature" class="summernote" placeholder="Enter Details">{{ $homePage->feature }}</textarea>-->
                                          </div>
                                       </div>
                                      
                                      
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                              </div>
                                
                                <div class="tab-pane fade" id="right-customaztion" role="tabpanel" aria-labelledby="customaztion-right-tab">
                                    <form action="{{ url('home-save-review') }}" id="homeFormSave" method="POST" action="javascript:void(0)" enctype="multipart/form-data">
                                        <div class="row other_box" >
                				            <table style="width:100%">
                                                <tr>
                                                    <td>
                                                        <div class="">
                            				                <label for="Discount">Title</label>
                            				                <input class="form-control"  type="text" placeholder="title" title="title" name="sub_title[]" />
                            				            </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                            				                <label for="Price">Price</label>
                            				                <input class="form-control"  type="text" title="price" name="sub_price[]"/>
                            				            </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                            				                <label for="type">Type</label>
                            				                <input class="form-control"  type="text" placeholder="Day/Month/Year" title="type" name="sub_type[]" />
                            				            </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                            				                <label for="type">Feuatre</label>
                            				                <input class="form-control"  type="text" placeholder="Fetuare" title="feuture" name="feature[]" />
                            				            </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success" type="button" style="margin-top: 24px; margin-left: 11px; font-size: 21px;padding: 2px 14px;" id="button_success">
                                                            +
                                                        </button>
                                                    </td>
                                                </tr>
                                                
                                            </table>
                				                
                				        </div>
                				        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                
                                </div>
                                
                                <div class="tab-pane fade" id="right-hub" role="tabpanel" aria-labelledby="hub-right-tab">
                                    <form action="{{ url('home-save-hub') }}" id="cuztomazationSave" method="POST" action="javascript:void(0)" enctype="multipart/form-data">
                                        <div class="row">
            				              <div class="col-md-12 mb-3 form-group">
            				                <label for="validationDefault01">Title <span style="color:red">*</span></label>
                                            <input type="text" name="hub_title" class="form-control" placeholder="Enter Title" value="{{ $homePage->hub_title }}">
                                          </div>
            				              <div class="col-md-12 mb-3 mt-3">
            				                <label for="validationDefault01">Content<span style="color:red">*</span></label>
                                            <textarea type="text" name="hub_content" class="summernote" placeholder="Enter Details">{{ $homePage->hub_content }}</textarea>
                                          </div>
                                        </div>
                                       <div class="row" style="margin-bottom:10px">
                                            <div class="col-md-12 mb-3 form-group">
                                                <label for="validationDefault01">Thumbnail upload <span style="color:red">*</span></label>
                                                <div class="holder">
                                                    <img id="imgPreview" src="{{ asset('images/homepage/' . $homePage->hub_thumbnail) }}" alt="pic" />
                                                </div>
                				                
                				                <div class="input_container">
                                                    <input type="file" name="hub_thumbnail" id="photo"  value= />
                                                </div>
                                            </div>
                                              <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="right-product" role="tabpanel" aria-labelledby="product-right-tab">
                                        <form action="{{ url('home-save-product') }}" id="productSave" method="POST" action="javascript:void(0)" enctype="multipart/form-data">
                                            <div class="row">
                				              <div class="col-md-12 mb-3 form-group">
                				                <label for="validationDefault01">Product Title <span style="color:red">*</span></label>
                                                <input type="text" name="product_title" class="form-control" placeholder="Enter Title" value="{{ $homePage->product_title }}">
                                              </div>
                				              <div class="col-md-12 mb-3 mt-3">
                				                <label for="validationDefault01">Product Content<span style="color:red">*</span></label>
                                                <textarea type="text" name="product_content" class="summernote" placeholder="Enter Details">{{ $homePage->product_content }}</textarea>
                                              </div>
                                           </div>
                                           <div class="row" style="margin-bottom:10px">
                                                <div class="col-md-12 mb-3 form-group">
                                                    <label for="product_content_banner">Thumbnail upload  <span style="color:red">*</span></label>
                                                    <div class="holder">
                                                        <img id="product_content_bannerimgPreview" class="imgPreview"  src="{{ asset('images/homepage/' . $homePage->product_content_banner) }}" alt="pic" />
                                                    </div>
                    				                
                    				                <div class="input_container">
                                                        <input type="file" name="product_content_banner" id="product_content_banner"  value= />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-bottom:10px">
                                                <div class="col-md-12 mb-3 form-group">
                                                    <label for="product_thumbnail">Thumbnail upload <span style="color:red">*</span></label>
                                                    <div class="holder">
                                                        <img id="product_thumbnailimgPreview" class="imgPreview" src="{{ asset('images/homepage/' . $homePage->product_thumbnail) }}" alt="pic" />
                                                    </div>
                    				                
                    				                <div class="input_container">
                                                        <input type="file" name="product_thumbnail" id="product_thumbnail"/>
                                                    </div>
                                                </div>
                                            </div>
                                           <div class="row">
                				             
                				              <div class="col-md-12 mb-3 mt-3">
                				                <label for="validationDefault01">Footer<span style="color:red">*</span></label>
                                                 <textarea type="text" name="footer" class="summernote" placeholder="Enter Details">{{ $homePage->footer }}</textarea>
                                              </div>
                                           </div>
                                            <div class="row">
            				              <div class="col-md-12 mb-3 form-group">
            				                <label for="validationDefault01">Intigration<span style="color:red">*</span></label>
            				                <textarea type="text" name="intiger" class="summernote" placeholder="Enter Details">{{ $homePage->intigration }}</textarea>
 
                                          </div>
                                       </div>
                                       
                                           <button type="submit" class="btn btn-primary">Save</button>
                                       </form>
                                        <script>
                                            $(document).ready(() => {
                                                $("#product_thumbnail").change(function () {
                                                    const file = this.files[0];
                                                    if (file) {
                                                    let reader = new FileReader();
                                                    reader.onload = function (event) {
                                                    $("#product_thumbnailimgPreview")
                                                        .attr("src", event.target.result);
                                                    };
                                                        reader.readAsDataURL(file);
                                                    }
                                                });
                                                
                                                 $("#product_content_banner").change(function () {
                                                    const file = this.files[0];
                                                    if (file) {
                                                    let reader = new FileReader();
                                                    reader.onload = function (event) {
                                                    $("#product_content_bannerimgPreview")
                                                        .attr("src", event.target.result);
                                                    };
                                                        reader.readAsDataURL(file);
                                                    }
                                                });
                                            });
                                        </script>
                                   </div>
                                </div>
                                
                            </div>
                            @csrf
                          
                         
                   </div>
		       </div>
        </div>
   </div>
</div>
<script>
<script type="text/javascript">
$('.other_box').hide();
     $('.regular_product').click(function(){
        var currentStatus = $(this).val();
         
        if(currentStatus == 1) {
             $('.other_box').hide();
        }  else {
             $('.other_box').show();
        }
    
     });
    
    $(document).on("click",".button_minus",function() {
       $(this).parents("table").remove(); 
    });
    
    $('#button_success').click(function(){
        $('.other_box').append(' <table style="width:100%"> <tr> <td> <div class=""> <label for="Discount">Title</label> <input class="form-control" type="text" placeholder="title" title="title" name="sub_title[]"/> </div></td><td> <div class=""> <label for="Price">Price</label> <input class="form-control" type="text" title="price" name="sub_price[]"/> </div></td><td> <div class=""> <label for="type">Type</label> <input class="form-control" type="text" placeholder="Day/Month/Year" title="type" name="sub_type[]"/> </div></td><td> <div class=""> <label for="type">Feuatre</label> <input class="form-control" type="text" placeholder="Fetuare" title="feuture" name="feature[]"/> </div></td><td> <button class="btn btn-danger button_minus" type="button" style="margin-top: 24px; margin-left: 11px; font-size: 21px;padding: 2px 14px;"> -</button> </td></tr></table>');
    });
</script>
</script>

@endsection
