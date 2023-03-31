<?php

namespace App\Http\Controllers\API\Backend\Blog;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Blog\BlogListResource;
use App\Models\Blog;
use App\Models\Story;
use App\Models\CategoryTag;
use App\Models\BlogTag;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Session;
use URL;
use App\Models\Visitors;

class BlogController extends Controller
{
    public function create() {
        
        $categoryTagList = CategoryTag::get();
        $taglist         = BlogTag::get();
        
        return view('admin.blog.create',[
              'categoryTagList'=>$categoryTagList,
              'taglist'=>$taglist
            ]);
    }
    
  

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        
        $categoryTagList = CategoryTag::get();
        $taglist         = BlogTag::get();
        $blogs = Blog::all();
        $type  = 2;
        
        return view('admin.blog.index',[
              'categoryTagList'=>$categoryTagList,
              'taglist'=>$taglist,
              'blogs'=>$blogs,
              'type'=>$type
            ]);

    }
    
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
        $visitorSave->page_slug     = 'blog'; 
        $visitorSave->total_visitor = 1;
        $visitorSave->date          = date('Y-m-d');
        $visitorSave->user_agent    = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->ip            = $this->get_client_ip();
        $visitorSave->browser       = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->save();
    }
    
    
    public function blogApi(Request $request)
    {
        $productInfoArray = [];
        $limit = $request->get('limit');
        
        if(isset($limit)) {
             $blogs = Blog::with('user')->latest()
             ->limit($limit)
             ->get();
        } else {
             $blogs = Blog::with('user')->latest()->paginate();
        }
        
        $this->visitorCountPage();

        foreach( $blogs as $blogsInfo) {

            $craetedAt = date("d M ", strtotime($blogsInfo->created_at)); 
     
            $productInfoArray[] =[
                'ID'          => $blogsInfo->id,
                'title'       => $blogsInfo->title,
                'slug'        => $blogsInfo->slug,
                'image'       =>  URL::asset('images/uploads/blog/'.$blogsInfo->photo),
                'description' => strip_tags($blogsInfo->description),
                'short_dsc'   => substr(strip_tags($blogsInfo->description), 0, 200),
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
    
    /**
     * Single page 
     * */
    public function singlePage($singleID) {
       
        $blogsInfo = Blog::with('user')
            ->where('slug', $singleID)
            ->latest()
            ->first();

        $craetedAt = date("d M ", strtotime($blogsInfo->created_at)); 
 
        $blogArray =[
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
       

         return json_encode($blogArray);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'title'       =>'required',
            'tags'         =>'required',
            'category_name'    =>'required',
            'description'    =>'required',
            'photo'       => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
     
        $data = $request->all();
        $data['user_id'] =1;
        $data['slug']     = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));
        $data['tags']   = implode(',',$request->tags) ;
        $blog_exist_or_not = Blog::all()->count();

        if($blog_exist_or_not > 0){
            $blog = Blog::orderBy('id', 'desc')->first();
            
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

        Blog::create($data);
        return response()->json([
            'msg'    => 'Add new record succssfully.',
            'status' => 200,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return BlogListResource
     */
    public function show(Blog $blog)
    {
         return view('admin.blog.show',compact('blog'));
    } 
  /*  public function edit($id)
    {
         $blog = Blog::find($id);
         $categoryTagList = CategoryTag::get();
         $taglist = BlogTag::get();
         
         return view('admin.blog.edit',[
              'categoryTagList'=>$categoryTagList,
              'taglist'=>$taglist,
              'blog'=>$blog
             ]);
    }*/
    public function editBlog(Request $request, $id)
    {
         $blog = Blog::find($id);
         $categoryTagList = CategoryTag::get();
         $taglist = BlogTag::get();
         
        return view('admin.blog.edit-blog',[
              'categoryTagList'=>$categoryTagList,
              'taglist'=>$taglist,
              'blog'=>$blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateBlog(Request $request,int $id)
    {
        
        
        $validator = Validator::make($request->all(), [
            'title'      => 'required',
            'tags'  => 'required',
            'category_name'  => 'required',
            'description'  => 'required',
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
       
    
        $data = $request->all();
        $data['user_id'] =1;
        $data['slug']   = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));
        $data['tags']   = implode(',',$request->tags) ;
        
        $blog_exist_or_not = Blog::all()->count();
        
        if($blog_exist_or_not > 0){
            $blog = Blog::orderBy('id', 'desc')->first();
        }else{
        }
        $blogInfo = Blog::where('id', $id)->orderBy('id', 'desc')->first();
        
        $height = 550;
        $width = 1100;
        $path = 'images/uploads/blog/';
        $name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));

        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $data['photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }


        $blogInfo->update($data);
        return response()->json([
            'msg'    => 'Blog information update succssfully.',
            'status' => 200,
        ]);
       
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {/*
        $blog = Blog::findOrFail($id);
        Helper::unlinkImage('images/uploads/blog/', $blog->photo);
        $blog->delete();
        Session::flash('success', 'Data Deleted Successfully.');
        return redirect('/admin/blog')->with('success',"Data Deleted Successfully.");*/
    }

  public function delete(int $id)
  {
        $blog = Blog::find($id);
        Helper::unlinkImage('images/uploads/blog/', $blog->photo);
        $blog->delete();
        Session::flash('success', 'Data Deleted Successfully.');
        return redirect('/admin/blog')->with('success',"Data Deleted Successfully.");
    }
}
