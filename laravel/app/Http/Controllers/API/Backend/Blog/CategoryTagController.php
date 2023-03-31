<?php

namespace App\Http\Controllers\API\Backend\Blog;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\CategoryTag;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\TagRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Session;
use URL;
class CategoryTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $categoryTagList = CategoryTag::latest()->paginate(2);
         return view('admin.blog.category.index',compact('categoryTagList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.category.create');
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
            'tag_name' => 'required|unique:category_tags',
            'slug' => date('YmdHis'),
            'slug_id' => date('YmdHis'),
        ]);
       
        $data = $request->all();
        $data['slug']   = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->tag_name)));
        $tag_exist_or_not = CategoryTag::all()->count();
        if($tag_exist_or_not > 0){
            $categoryTag = CategoryTag::orderBy('created_at', 'desc')->first();
            $data['slug_id']=$categoryTag->slug_id+1;
        }else{
            $data['slug_id']= 100001;
        }
       
        CategoryTag::create($data);
        //log generation start
        $old_data       = 'Tag Created';
        $new_data       =  $request->tag_name;
        $subject        = 'Tag Creation';
        $column_name    = 'Tag Created';
        $table_name     = (new CategoryTag())->getTable();
        $action         = 'Creation';
        Helper::addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action);
        //log generation Ends
        //return response()->json(['msg'=>$request->tag_name.' Tag created Successfully']);
     
         return redirect('/admin/blog/category/tag')->with('success',"Category tag Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryTag  $categoryTag
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryTag  $categoryTag
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
        $categoryTag = CategoryTag::find($id);
        return view('admin.blog.category.edit',compact('categoryTag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryTag  $categoryTag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'tag_name'    =>'required',
        ]);
        $data = $request->except(['created_at', 'updated_at']);
        $data['slug']   = Str::of($request->slug)->slug() ;
        $categoryTag = CategoryTag::find($id);
        $categoryTag['tag_name'] = $request->tag_name;
        $original_origin= $categoryTag->getOriginal();    //for log
        
        $categoryTag->update($data);
        //log generation start
        $changes        = $categoryTag->getChanges(); //for log
        $old_data = []; //for log
        $new_data = []; //for log
        $subject        = 'Category Update';
        
        $table_name     = (new CategoryTag())->getTable();

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
         return redirect('/admin/blog/category/tag')->with('success',"Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryTag  $categoryTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryTag $categoryTag, $id)
    {
        $categoryTag = CategoryTag::findOrFail($id);
        $categoryTag->delete();
        return redirect('/admin/blog/category/tag')->with('success',"Deleted Successfully");
    }
}
