<style>
.job_table_aplication {
    width: 100%;
}
.job_table_aplication  tr td {
    padding:10px;
}
</style>
<table class="job_table_aplication global" id="global2">
    <thead >
      	<tr>
           
            <th><b>Name</b></th>
            <th><b>Application Date</b></th>
            <th><b>Contact Email</b></th>
            <th><b>Contact Phone</b></th>

      	</tr>
    </thead>
    <tbody>	
        <tr>
            
            <td>{{ $applyjoblists->name }}</td>
        
            <td>{{ $applyjoblists->date }}</td>
            <td>{{ $applyjoblists->email }}</td>
            <td>{{ $applyjoblists->phone }}</td>
          
        </tr>

   
      	<tr>
          
           <td><b>Loction</b></td>
           <td><b>Cover Letter</b></td>
           <td><b>Resume</b></td>
           <td><b> </b></td>
      	</tr>

        <tr>
           
            <td>{{ $applyjoblists->location }}</td>
            <td> {{ $applyjoblists->message }} </td>
            <td> </td>
            <td> </td>
        </tr>
        <tr>
            
            <td></td>
            <td><button type="button" class="coverletterbtn btn btn-primary">Cover Letter</button></td>
            <td><button type="button" class="resumebtn btn btn-info">Resume</button></td>
            <td></td>
        </tr>
    </tbody>
</table>
<div class="row">
    <div class="col-md-12">
        <textarea type="text" class="cover-letter">{{ $applyjoblists->message }}</textarea>
    </div>
    <div class="col-md-4">
        <button type="button" class="btn-custom btn btn-primary">Email Reply</button>
    </div>
    
    <div class="col-md-4">
        <button type="button" class="btn-custom btn btn-primary">Call</button>
    </div>
    
    <div class="col-md-4">
        <button type="button" class="btn-custom btn btn-primary">Reject</button>
    </div>
    
</div>

