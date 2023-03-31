 <div class="row">
     <div class="col-md-1">
        @if(!empty($customer->photo))
            <img src="{{  URL::asset('upload/customer/'.$customer->photo)}}" class="author_image">
        @else
            <img src="{{  URL::asset('upload/customer/author_4.png')}}" class="author_image">
        @endif
     </div>
     <div class="col-md-9">
        <table class="borderless display global table" id="global2">
            <tr>
                <tr>
                    <th>Company Name</th>
                    <th>Date Joined</th>
                    <th>Contact Email</th>
                    <th>Monthly Subscription</th>
                </tr>
                  
              	<tr>
              	    <td>{{ $customer->first_name.''.$customer->last_name }}</td>
              	    <td>
                        @php
                            $date = date("F d, Y", strtotime( $customer->created_at));
                        @endphp
                        {{ $date }}
                    </td>
              	    <td>{{ $customer->email }} </td>
              	    <td>  @if(!empty($customer->price)) $ {{ $customer->price }} @endif </td>
              	</tr>
            
             </tr>
             <tr>
               <th><b> Contact Phone </b></th>
               <th><b> Custom Domain </b></th>
               <th><b> Company Plan </b></th>
               <th><b> Paid Users </b></th>
            </tr>
            <tr>
                <td> @if(!empty($customer->phone)){{ $customer->phone }} @endif </td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
          	<tr>
               <th><b>Paid Status</b></th>
               <th><b>Account Status</b></th>
          	</tr>
            <tr>
                <td>
                        @if(!empty($customer->paymentStatus) && $customer->paymentStatus == 'succeeded')
                            <button type="submit" class="btn btn-primary text-white status-button approved" title="open">
                                <span class="status-button-text open">Paid</span>
                            </button>
                        @else
                            <button type="submit" class="btn btn-primary text-white status-button reject" title="open">
                                <span class="status-button-text open">Unpaid</span>
                            </button>
                        @endif
                     
            	</td>
                <td>
                    @if($customer->status == 1)
                        <button type="submit" class="btn btn-primary text-white status-button approved" title="open">
                            <span class="status-button-text open">Active</span>
                        </button>
                    @elseif($customer->status == 3)
                        <button type="submit" class="btn btn-primary text-white status-button pending" title="open">
                            <span class="status-button-text open">On Notice</span>
                        </button>
                    @elseif($customer->status == 2)
                        <button type="submit" class="btn btn-primary text-white status-button reject" title="open">
                            <span class="status-button-text open">Suspended</span>
                        </button>
                    @endif
                    
            	</td>
              
            </tr>
           <!-- <tr>-->
           <!--     <th>Subscription & Add-Ons</th>-->
           <!-- </tr>-->
          	<!--<tr>-->
           <!--     <th>Subscription/Add-On</th>-->
           <!--     <th>Start Date</th>-->
           <!--     <th>Amount</th>-->
           <!--     <th>Monthly Subscription</th>-->
          	<!--</tr>-->
           <!-- <tr>-->
           <!--      <td>1</td>-->
           <!--      <td>2</td>-->
           <!--      <td>3</td>-->
           <!--      <td>4</td>-->
            </tr>
        </table>
     </div>
 </div>