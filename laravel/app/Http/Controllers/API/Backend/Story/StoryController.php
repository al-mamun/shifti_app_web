<?php

namespace App\Http\Controllers\API\Backend\Story;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\StoryTag;
use App\Models\Brand;
use App\Models\Settings\Stories;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use URL;


class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $stories = Story::latest()->paginate();
       return view('admin.story.index',compact('stories'));
    }
    
       public function storyApi()
    {
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
        $this->validate($request, [
            'title'       =>'required',
            'description' =>'required',
            'slug'        =>'required',
            'photo'       => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $data = $request->all();
        $data['user_id'] =1;
        $data['slug']   = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));
        $data['tags']   = implode(',',$request->tags);

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

        return redirect('/admin/stories')->with('success',"Created Successfully");
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
    public function edit(Story $story)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $story = Story::findOrFail($id);
        Helper::unlinkImage('images/uploads/blog/', $story->photo);
       $story->delete();
        return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
    }
}
