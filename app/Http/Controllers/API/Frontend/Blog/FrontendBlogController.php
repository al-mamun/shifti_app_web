<?php

namespace App\Http\Controllers\API\Frontend\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Blog\BlogDetailsResource;
use App\Http\Resources\Frontend\Blog\BlogListResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FrontendBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
       $blogs = Blog::where('status', 1)->with('user')->latest()->take($request->input('take'))->get();
        return BlogListResource::collection($blogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return BlogDetailsResource
     */
    public function show($id)
    {
       $blog = Blog::where('slug_id', $id)->first();
       return new BlogDetailsResource($blog);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
