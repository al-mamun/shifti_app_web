 <div class="row">
       <div class="col-md-1">
             <div class="thumbnail_image">
                <span class="icon_thumbnails">
                     @if(!empty($data->authorImage))
                        <img src="{{  URL::asset('upload/customer/'.$data->authorImage)}}" class="author_image">
                    @else
                        <img src="{{  URL::asset('upload/customer/author_4.png')}}" class="author_image">
                    @endif
                </span>
                
            </div>
       </div>
     <div class="col-md-9">
        <table class="borderless display global table" id="global2">
            <tr>
                <tr>
                    <th>Company Name</th>
                    <th>Date Of Story</th>
                    <th>Status</th>
                </tr>
              	<tr>
                    <td>
                       {{ $data->first_name }}
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
              	</tr>
            
             </tr>

        </table>
     </div>
 </div>