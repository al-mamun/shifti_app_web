<?php

namespace App\Http\Controllers\API\Backend\Story;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\StoryTag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Session;
use URL;

class StoryTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.story.tag.create');
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
            'tag_name' => 'required|unique:story_tags',
            'slug' => date('YmdHis'),
            'slug_id' => date('YmdHis'),
        ]);
       
        $data = $request->all();
        $data['slug']   = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->tag_name)));
        $tag_exist_or_not = StoryTag::all()->count();
        if($tag_exist_or_not > 0){
            $storyTag = StoryTag::orderBy('created_at', 'desc')->first();
            $data['slug_id']=$storyTag->slug_id+1;
        }else{
            $data['slug_id']= 100001;
        }
       
        StoryTag::create($data);
        //log generation start
        $old_data       = 'Tag Created';
        $new_data       =  $request->tag_name;
        $subject        = 'Tag Creation';
        $column_name    = 'Tag Created';
        $table_name     = (new StoryTag())->getTable();
        $action         = 'Creation';
        Helper::addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action);
        //log generation Ends
        //return response()->json(['msg'=>$request->tag_name.' Tag created Successfully']);
     
         return redirect('/admin/stories/tag/show')->with('success',"Story tag Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StoryTag  $storyTag
     * @return \Illuminate\Http\Response
     */
    public function show(StoryTag $storyTag)
    {
        $storyTagList = StoryTag::latest()->paginate(2);
         return view('admin.story.tag.index',compact('storyTagList'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StoryTag  $storyTag
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
         $storyTag = StoryTag::find($id);
         return view('admin.story.tag.edit',compact('storyTag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StoryTag  $storyTag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request, [
           'tag_name'    =>'required',
        ]);
        $data = $request->except(['created_at', 'updated_at']);
        $data['slug']   = Str::of($request->slug)->slug() ;
        $storyTag = StoryTag::find($id);
        $storyTag['tag_name'] = $request->tag_name;
        $original_origin= $storyTag->getOriginal();    //for log
        
        $storyTag->update($data);
        //log generation start
        $changes        = $storyTag->getChanges(); //for log
        $old_data = []; //for log
        $new_data = []; //for log
        $subject        = 'StoryTag Update';
        
        $table_name     = (new StoryTag())->getTable();

        foreach ($changes as $key=>$value){ //for log
            $old_data[$key] = $original_origin[$key];
            $new_data[$key] = $changes[$key];
            $column_name =$key;
            $action ='Update';
            if ($key !== 'updated_at') {
                Helper::addToLog($subject, $column_name, $old_data[$key], $new_data[$key], $table_name, $action);
            }
        }
        
        //log generation Ends
         return redirect('/admin/stories/tag/show')->with('success',"Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StoryTag  $storyTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoryTag $storyTag, $id)
    {
        $storyTag = StoryTag::findOrFail($id);
        $storyTag->delete();
        return redirect('/admin/stories/tag/show')->with('success',"Deleted Successfully");
    }
}
