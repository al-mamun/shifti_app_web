<?php

namespace App\Http\Controllers\API\Backend\Joblist;

use App\Http\Controllers\Controller;
use App\Models\Joblist;
use App\Models\Jobcategory;
use App\Models\Joblocation;
use App\Models\JobApplyList;
use App\Models\Settings\Settings;
use App\Models\Settings\CareerListing;
use Illuminate\Http\Request;
use Auth;
use Session;
use Mail;
use App\Models\Emailhistory;
use Illuminate\Support\Facades\Validator;
use App\Models\Visitors;

class JoblistController extends Controller
{
    protected $documentDirectory          = "/upload/cv/";
    
     private function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    private function visitorCountPage() {
        
        $visitorSave = new Visitors();
        $visitorSave->page_slug     = 'career'; 
        $visitorSave->total_visitor = 1;
        $visitorSave->date          = date('Y-m-d');
        $visitorSave->user_agent    = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->ip            = $this->get_client_ip();
        $visitorSave->browser       = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->save();
    }
    
    
    public function aplyJobList() {
        
        $applyjoblists = JobApplyList::leftjoin ('joblists', 'job_apply_list.job_id', '=', 'joblists.id')
             ->select('job_apply_list.*', 'joblists.job_title','joblists.job_category')
             ->paginate();
         
        return view('admin.joblist.aplylist',[
            'applyjoblists' =>$applyjoblists,
        ]);
            
    }
     public function viewapplyJobList(Request $request) {
        
        $applyjoblists = JobApplyList::leftjoin ('joblists', 'job_apply_list.job_id', '=', 'joblists.id')
            ->select('job_apply_list.*', 'joblists.job_title','joblists.job_category')
            ->where('job_apply_list.job_id', $request->job_id)
            ->latest()
            ->paginate();
     
        return view('admin.joblist.aplylist_view',[
            'applyjoblists' =>$applyjoblists,
        ]);
            
    }
    
    /**
     * Applicant JobList
     * 
     * */
    public function applicantJoblist(Request $request) {
        
        $applyID =  $request->applyID;
        
        $applyjoblists = JobApplyList::leftjoin ('joblists', 'job_apply_list.job_id', '=', 'joblists.id')
         ->select('job_apply_list.*', 'joblists.job_title','joblists.job_category')
         ->where('job_apply_list.id', $applyID)
         ->first();
     
        return view('admin.joblist.aplication',[
            'applyjoblists' =>$applyjoblists,
        ]);
      
    }
    
    public function jobOpenCategoryList(Request $request) {
        
        
        $categoryID =  $request->status;
        
        
        $jobOpenArray = [];

        $jobList = Joblist::where('job_category', $categoryID)->latest()->get();

        foreach( $jobList as $jobInfo) {

            $craetedAt = date("d M ", strtotime($jobInfo->created_at)); 

            $jobOpenArray[] =[
                'ID'           => $jobInfo->id,
                'title'        => $jobInfo->job_title,
                'slug'         => $jobInfo->slug,
                'location'     => $jobInfo->job_location,
                'subtitle'     => $jobInfo->job_category,
                'type'         => '',
                'team'         =>'test',
            ];
        }

         return json_encode($jobOpenArray);
            
    }
    public function jobOpenLocationList(Request $request) {
        
        $status =  $request->status;
        
        $jobOpenArray = [];

        $jobList = Joblist::where('job_location', $status)->latest()->get();

        foreach( $jobList as $jobInfo) {

            $craetedAt = date("d M ", strtotime($jobInfo->created_at)); 
     
            $jobOpenArray[] =[
                'ID'          => $jobInfo->id,
                'title'       => $jobInfo->job_title,
                'location'    => $jobInfo->job_location,
                'subtitle'    => $jobInfo->job_category,
                'type'        => '',
                'team'        =>'test',
            ];
        }

         return json_encode($jobOpenArray);
            
    }
    
    public function jobOpenTeamList(Request $request) {
        
        
        $status =  $request->status;
        
        
        $jobOpenArray = [];

        $jobList = Joblist::where('type', $status)->latest()->get();

        foreach( $jobList as $jobInfo) {

            $craetedAt = date("d M ", strtotime($jobInfo->created_at)); 
     
            $jobOpenArray[] =[
                'ID'          => $jobInfo->id,
                'title'       => $jobInfo->job_title,
                'location'    => $jobInfo->job_location,
                'subtitle'    => $jobInfo->job_category,
                'type'        => '',
                'team'        =>'test',
                

            ];
        }

         return json_encode($jobOpenArray);
            
    }
    
    public function jobPageContent(Request $request) {
        
        $this->visitorCountPage();
        
        $status =  $request->status;
        
        
        $jobOpenArray = [];

        $jobInfo = CareerListing::first();

        $craetedAt = date("d M ", strtotime($jobInfo->created_at)); 
 
        $jobOpenArray =[
            'ID'                   => $jobInfo->id,
            'page_title'           => $jobInfo->page_title,
            'page_content'         => $jobInfo->page_content,
            'page_sub_content'     => $jobInfo->page_sub_content,
            'page_sub_title'       => $jobInfo->page_sub_title,
            'page_company_content' => $jobInfo->page_company_content,
            'page_company_title'   => $jobInfo->page_company_title,
            'about_page_title'     => $jobInfo->about_page_title,
            'about_page_content'   => $jobInfo->about_page_content,
            'team'                 =>'test',
            

        ];
      
         return json_encode($jobOpenArray);
            
    }
    
    public function applyJob(Request $request) {
            
            $cvd ='';
        
            if ($request->hasfile('file')) {
                $cvInfo =$request->file;
                $cvd   =  date('ymdh') . rand(0,99999) . $cvInfo->getClientOriginalName();
                $cvInfo->move(public_path() . $this->documentDirectory, $cvd);
          
            }
 
            $jobListInfo = new JobApplyList();
            $jobListInfo->name             = $request->fullName;
            // $jobListInfo->cover_letter     = $request->cover_letter;
            $jobListInfo->expected_salary  = $request->salary;
            $jobListInfo->job_id           = $request->job_id;
            $jobListInfo->email            = $request->email;
            $jobListInfo->phone            = $request->phone;
            $jobListInfo->location         = $request->location;
            $jobListInfo->message          = $request->message;
            $jobListInfo->attachment       = $cvd;
          
            if($files=$request->file('cv')) {  
                $name=$files->getClientOriginalName();  
                $files->move('images',$name);  
            }  
            
            if($jobListInfo->save()) {
                
                $settingInfo = Settings::first();
                
                $title = 'Apply For'. $joblistInfo->job_title;
                
                $joblistInfo = Joblist::find($request->job_id);
                
                $data = array(
                    'name'         => "Shifti", 
                    'type'         => "Job", 
                    'message'      => $jobListInfo->message, 
                    'email'        => $settingInfo->admin_email,
                    'job_title'    => $joblistInfo->job_title,
                    'email_title'  => $title,
                );
                
                
                Mail::send(['html' => 'emails.job_mail'], compact('data'), function($message) use ($data) {
                 $message->to($data['email'], $data['email_title'])->subject
                    ('Apply for job');
                 $message->from('shifti@mamundevstudios.com','Shifti');
                });  
                
                Emailhistory::emailSendList($request->fullName,  $title, $jobListInfo->message,  3, $jobListInfo->id,'');// 3 job type
                
            }
            // $request->fullName,$request->email,$request->email message
            
            
            $jobOpenArray = [
                'status' => 200,
                'message' => "Successfully send data",
            ];
            return json_encode($jobOpenArray);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $pendingJob     = Joblist::where('status', 0)->latest()->paginate(2);
        $openJob        = Joblist::where('status', 1)->latest()->paginate(2);
        $approvedJob    = Joblist::where('status', 2)->latest()->paginate(2);
        $joblocations   = Joblocation::get();
        $jobcategories  = Jobcategory::get();
        
         return view('admin.joblist.index',compact('pendingJob','openJob','approvedJob','joblocations','jobcategories'));
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobAll()
    {
        $allJob         = Joblist::latest()->get();
        $joblocations   = Joblocation::get();
        $jobcategories  = Jobcategory::get();
        
        return view('admin.joblist.all',compact('allJob','joblocations','jobcategories'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $joblocations  = Joblocation::get();
        $jobcategories = Jobcategory::get();
       
        return view('admin.joblist.create',[
           'jobcategories' => $jobcategories,
           'joblocations'  => $joblocations,
        ]);
    }
    
    public function editJoblist(Request $request) {
        
        $jobList = Joblist::find($request->id);
        
        $joblocations  = Joblocation::get();
        $jobcategories = Jobcategory::get();
       
        return view('admin.joblist.job-edit',[
           'jobcategories' => $jobcategories,
           'joblocations'  => $joblocations,
           'jobList'       => $jobList,
        ]);
        
        
    }
    
    public function adminJoblistUpdate(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'title'        => 'required',
            'job_category' => 'required',
            'term'         => 'required',
            'job_location' => 'required',
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
       
       
         
        $joblist =  Joblist::find($request->id);
        $joblist->job_title = $request->title;
        $joblist->slug              = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));
        $joblist->type              = $request->term;
        // $joblist->date      =     $request->date;
        // $joblist->expire_date   = $request->expire_date;
        $joblist->job_location       = $request->job_location;
        $joblist->job_category       = $request->job_category;
        // $joblist->why_to_apply    = $request->why_to_apply;
        $joblist->descraption        = $request->descraption;
        $joblist->save();
        
         return response()->json(['success' => 'Post created successfully.']);
        
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        
        $this->validate($request, [
            'job_title' => 'required',
            'job_location' => 'required',
            'job_category' => 'required'
        ]);
         #Profile picture upload
            // if ($request->hasfile('cv')) {

            //     $cv= $request->file('cv');
            //     $picture   =  date('ymdh') . rand(0,99999) . $profile->getClientOriginalName();
            //     $profile->move(public_path() . $this->documentDirectory, $picture);
                
                
            // }
            
         
        $joblist = new Joblist;
        $joblist->job_title = $request->job_title;
        $joblist->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->job_title)));
        $joblist->type = $request->type;
        $joblist->date = $request->date;
        $joblist->expire_date = $request->expire_date;
        $joblist->job_location = $request->job_location;
        $joblist->job_category = $request->job_category;
        $joblist->why_to_apply = $request->why_to_apply;
        $joblist->descraption = $request->descraption;
        $joblist->save();
        return redirect('/admin/joblist')->with('success',"Joblist Created Successfully");
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Joblist  $joblist
     * @return \Illuminate\Http\Response
     */
    public function jobOpen(Joblist $joblist)
    {
        $jobOpenArray = [];

        $jobList = Joblist::latest()->paginate();

        foreach( $jobList as $jobInfo) {

            $craetedAt = date("d M ", strtotime($jobInfo->created_at)); 
     
            $jobOpenArray[] =[
                'ID'          => $jobInfo->id,
                'title'       => $jobInfo->job_title,
                'location'    => $jobInfo->job_location,
                'subtitle'    => $jobInfo->job_category,
                 'slug'        => $jobInfo->slug,
                'type'        => '',
                'team'        =>'test',
                

            ];
        }

         return json_encode($jobOpenArray);
    }
    
      /**
     * Display the specified resource.
     *
     * @param  \App\Models\Joblist  $joblist
     * @return \Illuminate\Http\Response
     */
    public function singlejob($slug)
    {
        $jobOpenArray = [];

        $jobInfo = Joblist::where('slug', $slug)->first();

        $craetedAt = date("d M ", strtotime($jobInfo->created_at)); 
 
        $jobOpenArray=[
            'ID'          => $jobInfo->id,
            'title'       => $jobInfo->job_title,
            'location'    => $jobInfo->job_location,
            'subtitle'    => $jobInfo->job_category,
            'slug'        => $jobInfo->slug,
            'descraption'  => $jobInfo->descraption,
            'why_to_apply' => $jobInfo->why_to_apply,
            'expire_date' => $jobInfo->expire_date,
            'type'        => '',
            'team'        =>'test',
            

        ];
        

         return json_encode($jobOpenArray);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Joblist  $joblist
     * @return \Illuminate\Http\Response
     */
    public function jobCategories(Jobcategory $joblist)
    {
        $jobOpenArray = [];

        $jobList = Jobcategory::latest()->get();

        foreach( $jobList as $jobInfo) {

            $craetedAt = date("d M ", strtotime($jobInfo->created_at)); 
     
            $jobOpenArray[] =[
                'ID'          => $jobInfo->id,
                'name'       => $jobInfo->name,
             
            ];
        }

         return json_encode($jobOpenArray);
    }
    
    
    public function jobLocation(Jobcategory $joblist)
    {
        $jobOpenArray = [];

        $jobList = Joblocation::latest()->get();

        foreach( $jobList as $jobInfo) {

            $craetedAt = date("d M ", strtotime($jobInfo->created_at)); 
     
            $jobOpenArray[] =[
                'ID'          => $jobInfo->id,
                'location'       => $jobInfo->location,
             
            ];
        }

         return json_encode($jobOpenArray);
    }
    
    public function jobTeam(Joblist $joblist)
    {
        $jobOpenArray = [];

        $jobList = Joblist::latest()->groupBy('type')->get();

        foreach( $jobList as $jobInfo) {
    
            if(!empty($jobInfo->type)) {
                $craetedAt = date("d M ", strtotime($jobInfo->created_at)); 
         
                $jobOpenArray[] =[
    
                    'type'       => $jobInfo->type,
                 
                ];  
            }
            
        }

         return json_encode($jobOpenArray);
    }
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Joblist  $joblist
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
         $joblist = Joblist::find($id);
         $joblocations = Joblocation::latest()->get();
         $jobcategories  = Jobcategory::latest()->get();
         return view('admin.joblist.edit',[
             'joblist'=> $joblist,
             'jobcategories'=> $jobcategories,
             'joblocations'=> $joblocations,
             ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Joblist  $joblist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request, [
            'job_title' => 'required',
            'job_location' => 'required',
            'job_category' => 'required'
            
        ]);
        $joblist = Joblist::find($id);
        $joblist->job_title = $request->job_title;
        $joblist->type = $request->type;
        $joblist->date = $request->date;
        $joblist->expire_date = $request->expire_date;
        $joblist->job_location = $request->job_location;
        $joblist->job_category = $request->job_category;
        $joblist->why_to_apply = $request->why_to_apply;
        $joblist->descraption = $request->descraption;
        
        $joblist->update();
        return redirect('/admin/joblist')->with('success',"Joblist Updated Successfully");
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Joblist  $joblist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Joblist $joblist)
    {
       /*  $joblist->delete();
         return redirect('/admin/joblist')->with('success',"Joblist Deleted Successfully");*/
    } 
    public function jobdelete(int $id)
    {
        $joblist = Joblist::find($id);
        $joblist->delete();
        return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
    }
}
