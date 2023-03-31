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
use Session;
use URL;

class BlogController extends Controller
{
    public function create() {
        $categoryTagList = CategoryTag::get();
        $taglist = BlogTag::get();
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
        $blogs = Blog::with('user')->latest()->paginate();
        $type  = 2;
        
        return view('admin.blog.index',compact('blogs','type'));

    }

    public function blogApi()
    {
        $productInfoArray = [];

        $blogs = Blog::with('user')->latest()->paginate();

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
        $this->validate($request, [
            'title'       =>'required',
            'tags'         =>'required',
            'category_name'    =>'required',
            'description'    =>'required',
            'slug'        =>'required',
            'photo'       => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

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
        return redirect('/admin/blog')->with('success',"Created Successfully");
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
    public function edit($id)
    {
         $blog = Blog::find($id);
         $categoryTagList = CategoryTag::get();
         $taglist = BlogTag::get();
         
         return view('admin.blog.edit',[
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
    public function update(Request $request,int $id)
    {
        $this->validate($request, [
            'title'       =>'required',
            'tags'         =>'required',
            'category_name'    =>'required',
            'description'    =>'required',
            'slug'        =>'required',
            'photo'       => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);
        $data = $request->all();
        $data['user_id'] =1;
        $data['slug']   = Str::of($request->slug)->slug() ;
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


        $blog->update($data);
        return redirect('/admin/blog')->with('success',"Updated Successfully");
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $blog = Blog::findOrFail($id);
        Helper::unlinkImage('images/uploads/blog/', $blog->photo);
        $blog->delete();
        Session::flash('success', 'Data Deleted Successfully.');
        return redirect('/admin/blog')->with('success',"Data Deleted Successfully.");
    }

  public function delete(int $id)
  {
    /* try {
        $blogDelete = Blog::findOrFail($id);
        $blogDelete->delete();
        return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
        } catch (Throwable $e) {
            report($e);

            return false;
        }*/
    }
}
