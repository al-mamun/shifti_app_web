<div class="apply_list_sinlgle">
<div class="table-responsive">
  	<div class="dt-ext table-responsive">
  	     <table class="display global" id="global2">
            <thead>
              	<tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Application Date</th>
                    <th>Email  address</th>
                    <th>Phone</th>
                    <th></th>
              	</tr>
            </thead>
            <tbody>
        		@foreach($applyjoblists as $key=>$data)
            <tr id="joblist_id_{{$data->id}}">
                <td>{{ $data->name }}</td>
                <td>{{ $data->location }}</td>
                <td>{{ $data->date }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->phone }}</td>
                <td>
                	<div class="dropdown">
                        <button class="button-custom" type="button" id="action_button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            . . .
                        </button>
                        <div class="dropdown-menu" aria-labelledby="action_button">
                            <!--<a class="dropdown-item" onClick="EditJobApplication('{{$data->id}}')" style="float: left;font-size: 19px;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editJOb">Edit</a> -->
                            <!--<a class="dropdown-item" onClick="deleteData('{{$data->id}}')" href="javascript:void(0)" style="float: left;font-size: 19px;">Delete</a>-->
                            <a class="dropdown-item" onClick="viewJobApplicationList('{{ $data->id }}')" href="javascript:void(0)" style="float: left;font-size: 19px;">View</a>
                        </div>
                    </div>
                </td>
            </tr>
          	@endforeach
            </tbody>
        </table>
  	 
  {{ $applyjoblists->links() }}
</div>
</div>

    <!-- Plugins JS start-->
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/custom.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
</div>
<script type="text/javascript">

 function viewJobApplicationList(applyID) {
   
    $.ajax({
        type: "POST",
        data: {
            '_token': $('input[name=_token]').val(),
            'applyID': applyID,
          
        },
        url: window.baseUrl + '/view/apply/applicant/joblist',
        success:function(data) {
        	$('.apply_list_sinlgle').html(data);
        }
    }); 
}

</script>