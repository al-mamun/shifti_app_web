<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Banner\BannerResource;
use App\Models\Banner;
use Exception;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return BannerResource
     * @throws Exception
     */
    public function get_banner(Request $request): BannerResource
    {
        $banner = Banner::where('location', $request->location)->where('status', 1)->first();
//       $banner = \cache()->rememberForever('banner', function () use ($request) {
//           return Banner::where('location', $request->location)->where('status', 1)->first();
//       });
       return new BannerResource($banner);
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
