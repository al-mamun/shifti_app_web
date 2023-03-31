<?php

namespace App\Http\Controllers\API\Backend\Media;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Media\MediaListResource;
use App\Http\Resources\Backend\Media\VideoMediaListResource;
use App\Models\Media;
use App\Models\ProductPhoto;
use App\Models\ProductVideo;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit= $request->input('take') ?? 18;
        if ($request->input('search') != 'null') {
            $product_photos  = ProductPhoto::latest()->where('product_photo', 'like', '%'.$request->input('search').'%')->paginate($limit);
            $gallery_photo = Media::where('product_photo', 'like', '%'.$request->input('search').'%')->latest()->paginate($limit);
        }else{
            $product_photos  = ProductPhoto::latest()->paginate($limit);
            $gallery_photo = Media::latest()->paginate($limit);
        }


        $product_photos =  $this->merge($gallery_photo, $product_photos);
        return MediaListResource::collection($product_photos);
    }

    static public function merge(LengthAwarePaginator $collection1, LengthAwarePaginator $collection2)
    {
        $total = $collection1->total() + $collection2->total();

        $perPage = $collection1->perPage() + $collection2->perPage();

        $items = array_merge($collection1->items(), $collection2->items());

        $paginator = new LengthAwarePaginator($items, $total, $perPage);

        return $paginator;
    }



    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function videos(Request $request): AnonymousResourceCollection
    {
        $limit= $request->input('take') ?? 18;
        $product_videos  = ProductVideo::latest()->paginate($limit);
        return VideoMediaListResource::collection($product_videos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(Request $request): JsonResponse
    {
        $height = 800;
        $width = 800;
        $path = 'images/uploads/media/';
        $name = 'orpon-bd-media-'.Str::slug(Carbon::now()->toDayDateTimeString(), '-').'-'.random_int(10000,99999);
        if ($request->input('photo')) {
            $file =$request->input('photo');
            $data['product_photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        }else {
            $data['product_photo'] = null;
        }
        Media::create($data);
        return response()->json(['msg'=>'Photo Uploaded Successfully']);
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
     * @param Request $request
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
