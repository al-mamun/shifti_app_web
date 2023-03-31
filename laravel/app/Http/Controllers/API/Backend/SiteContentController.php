<?php

namespace App\Http\Controllers\API\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteContentController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type'      => 'required',
            'content'   => 'required',
            'status'    => 'required',
        ]);
        $data = $request->all();
        if ($request->hasFile('content')) {
            $name = $request->type.'-'.str_replace([' ', ':'], '-', Carbon::now() );
            $path = 'images/uploads/site_contents/';
            $file = $request->file('content');
            $dimensions = getimagesize($file);
            $height = $dimensions[1];
            $width = $dimensions[0];
            $data['content'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }
        $site_content = SiteContent::create($data);
        return  response()->json(['msg'=>'Site Content Updated Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
