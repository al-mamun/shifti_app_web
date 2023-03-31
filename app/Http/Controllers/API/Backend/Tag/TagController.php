<?php

namespace App\Http\Controllers\API\Backend\Tag;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TagRequest;
use App\Http\Resources\Backend\TagResource;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
      /*  if (isset($request->paginate) && $request->paginate != 'null'){
            $pagination  = $request->paginate;
        }else{
            $pagination = 10;
        }
        if (isset($request->search) && $request->search != 'null'){
            $tags = Tag::orderBy('order_by', 'asc')->where('tag_name', 'like',  '%'.$request->search.'%')->paginate($pagination);
        }else{
            $tags = Tag::orderBy('order_by', 'asc')->paginate($pagination);
        }*/
        //return TagResource::collection($tags);
        
    }
      public function create() {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(TagRequest $request)
    {
        $this->validate($request, [
            'tag_name' => 'required|unique:tags',
            'slug' => date('YmdHis'),
            'slug_id' => date('YmdHis'),
        ]);
        $data = $request->all();
        $data['slug']   = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->tag_name)));
        $tag_exist_or_not = Tag::all()->count();
        if($tag_exist_or_not > 0){
            $tag = Tag::orderBy('created_at', 'desc')->first();
            $data['slug_id']=$tag->slug_id+1;
        }else{
            $data['slug_id']= 100001;
        }
        Tag::create($data);
        //log generation start
        $old_data       = 'Tag Created';
        $new_data       =  $request->tag_name;
        $subject        = 'Tag Creation';
        $column_name    = 'Tag Created';
        $table_name     = (new Tag())->getTable();
        $action         = 'Creation';
        Helper::addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action);
        //log generation Ends
        //return response()->json(['msg'=>$request->tag_name.' Tag created Successfully']);
         return redirect('/admin/product/tag/show')->with('success',"Product tag Created Successfully");
    }
   public function edit(Request $request, $id)
    {
        $tag = Tag::find($id);
        return view('admin.tags.edit',compact('tag'));
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return TagResource|JsonResponse
     */
    public function show()
    {
          $taglist = Tag::latest()->paginate(2);
          return view('admin.tags.index',compact('taglist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TagRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TagRequest $request, int $id)
    {
         $this->validate($request, [
           'tag_name'    =>'required',
        ]);
        $data = $request->except(['created_at', 'updated_at']);
        $data['slug']   = Str::of($request->slug)->slug() ;
        $tag = Tag::findOrFail($id);
        $tag['tag_name'] = $request->tag_name;
        $original_origin= $tag->getOriginal();    //for log
        $tag->update($data);
        //log generation start
        $changes        = $tag->getChanges(); //for log
        $old_data = []; //for log
        $new_data = []; //for log
        $subject        = 'Category Update';
        $table_name     = (new Tag())->getTable();

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
         return redirect('/admin/product/tag/show')->with('success',"Product tag Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
       
            $tag = Tag::findOrFail($id);
            $tag->delete();
            return redirect('/admin/product/tag/show')->with('success',"Deleted Successfully");
        
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */

    public function status_update(Request $request, $id): JsonResponse
    {
        $tag = Tag::findOrFail($id);
        $updated_data = $tag->update($request->all());
        if ($request->status == 1){
            $status= 'Active';
            $cls = 'success';
        }else{
            $status = 'Inactive';
            $cls = 'warn';
        }
        return response()->json(['msg'=>$tag->tag_name.' set as ' . $status, 'cls'=>$cls]);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function get_tag_list(): AnonymousResourceCollection
    {
        $tags = Tag::orderBy('order_by', 'asc')->where('status', 1)->get();
        return TagResource::collection($tags);
    }
}
