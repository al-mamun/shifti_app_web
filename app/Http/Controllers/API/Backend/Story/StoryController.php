<?php

namespace App\Http\Controllers\API\Backend\Story;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\StoryTag;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Settings\Stories;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use URL;
use Illuminate\Support\Facades\Validator;
use App\Models\Visitors;

class StoryController extends Controller
{
    
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
        $visitorSave->page_slug     = 'story'; 
        $visitorSave->total_visitor = 1;
        $visitorSave->date          = date('Y-m-d');
        $visitorSave->user_agent    = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->ip            = $this->get_client_ip();
        $visitorSave->browser       = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->save();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stories = Story::leftjoin('customers','stories.customer_id','customers.id')
            ->select('stories.*','customers.first_name','customers.last_name','customers.photo as authorImage')
            ->get();
       
        $customerList = Customer::limit(100)->get();
        $storyTagList = StoryTag::get();
        
        return view('admin.story.index',compact('stories','customerList','storyTagList'));
       
    }
    
       public function storyApi()
    {
        $this->visitorCountPage();
        
        $productInfoArray = [];

        $blogs = Story::latest()->paginate();

        foreach( $blogs as $blogsInfo) {

            $craetedAt = date("d M ", strtotime($blogsInfo->created_at)); 
     
            $productInfoArray[] =[
                'ID'          => $blogsInfo->id,
                'title'       => $blogsInfo->title,
                'slug'        => $blogsInfo->slug,
                'image'       =>  URL::asset('images/uploads/blog/'.$blogsInfo->photo),
                'description' => strip_tags($blogsInfo->description),
                'tags'        => explode(',', $blogsInfo->tags),
                'date'        => $craetedAt,
                'author' => [
                    'name' => 'Author 1',
                    'avatar' => 'https://assets.maccarianagency.com/avatars/img3.jpg'
                ],

            ];
        }

         return json_encode($productInfoArray);
    }
    
      public function singleStroies($slug)
    {
        $productInfoArray = [];

        $storyInfo = Story::where('slug', $slug)->first();

       
            $craetedAt = date("d M ", strtotime($storyInfo->created_at)); 
     
            $slugArray=[
                'ID'          => $storyInfo->id,
                'title'       => $storyInfo->title,
                'slug'        => $storyInfo->slug,
                'image'       =>  URL::asset('images/uploads/blog/'.$storyInfo->photo),
                'description' => strip_tags($storyInfo->description),
                'tags'        => explode(',', $storyInfo->tags),
                'date'        => $craetedAt,
                'author' => [
                    'name' => 'Author 1',
                    'avatar' => 'https://assets.maccarianagency.com/avatars/img3.jpg'
                ],

            ];
       

         return json_encode($slugArray);
    }
    
     public function pageContent()
    {
        
        $storyInfo = Stories::first();

        $slugArray  =[
            'ID'                => $storyInfo->id,
            'page_title'        => $storyInfo->page_title,
            'page_sub_title'    => $storyInfo->page_sub_title,
            'page_sub_content'  => $storyInfo->page_sub_content,
            'page_content'      => $storyInfo->page_content,
            'image'             =>  URL::asset('images/uploads/blog/'.$storyInfo->image),
        ];
       

         return json_encode($slugArray);
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $storyTagList = StoryTag::get();
        
        return view('admin.story.create',[
             'storyTagList'=>$storyTagList
            ]);
    }
    
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'title'        => 'required',
            'description'  => 'required',
            'photo'        => 'required',
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
       
       
        
        $data = $request->all();
       
        $data['user_id'] = 1;
        $data['slug']    = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));
        $data['tags']    = implode(',',$request->tags);

        $blog_exist_or_not = Story::all()->count();

        if($blog_exist_or_not > 0){
            $blog = Story::orderBy('id', 'desc')->first();
            $data['slug_id']=$blog->slug_id+1;
        }else{
            $data['slug_id']= 100001;
        }

        $height = 550;
        $width = 1100;
        $path = 'images/uploads/blog/';
        $name = $data['slug'].'-'.$data['slug_id'];

        if ($request->photo) {
            $file = $request->photo;
            $data['photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $data['photo'] = null;
        }

        Story::create($data);

            
        return response()->json([
            'msg'    => 'New record add succssfully.',
            'status' => 200,
        ]);
   
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        return view('admin.story.show',compact('story'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function editCustomerStory(Story $story, $id)
    {
        $storyTagList = StoryTag::get();
        $story        = Story::find($id);
        $customerList = Customer::limit(100)->get();
        return view('admin.story.edit_story',compact('story','storyTagList','customerList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function updateCustomerStory(Request $request, Story $story)
    {
         $validator = Validator::make($request->all(), [
            'title'        => 'required',
            'description'  => 'required',
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
       
        
        $customerStoryInfo = Story::where('id', $request->id)->first();
        
        if ($request->hasfile('photo')) {
            $cvInfo = $request->photo;
            $cvd   =  date('ymdh') . rand(0,99999) . $cvInfo->getClientOriginalName();
            $cvInfo->move(public_path() . $this->documentDirectoryCustomer, $cvd);
            
            $customerStoryInfo->photo  = $cvd;
      
        }
 
        $customerStoryInfo->customer_id  = $request->customer_id;
        $customerStoryInfo->title        = $request->title;
        $customerStoryInfo->date         = $request->date;
        $customerStoryInfo->description  = $request->description;
         $customerStoryInfo->tags       = $request->tags;
        if($customerStoryInfo->save()) {

                
            return response()->json([
                'msg'    => 'Update customer story information.',
                'status' => 200,
            ]);
        }
        return response()->json([
                'msg'    => 'New record add succssfully.',
                'status' => 400,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
  public function viewcustomerStory(Request $request) 
     {
         $data = Story::findOrFail($request->id);
         $customerList = Customer::limit(100)->get();
            return view('admin.story.view-story',[
                'data' =>$data,
                'customerList' =>$customerList
            ]);
            
    }
    public function destroy(int $id)
    {
        /*$story = Story::findOrFail($id);
        Helper::unlinkImage('images/uploads/blog/', $story->photo);
       $story->delete();
        return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);*/
    }
    public function storydelete(int $id)
    {
        $story = Story::find($id);
        Helper::unlinkImage('images/uploads/blog/', $story->photo);
        $story->delete();
        return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
    }
}
