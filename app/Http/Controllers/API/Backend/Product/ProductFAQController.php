<?php

namespace App\Http\Controllers\API\Backend\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductFAQRequest;
use App\Http\Resources\Backend\ProductFAQResource;
use App\Models\Product;
use App\Models\ProductFAQ;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductFAQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
       $faqs = Product::all();
       return  ProductFAQResource::collection($faqs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductFAQRequest $request
     * @return JsonResponse
     */
    public function store(ProductFAQRequest $request): JsonResponse
    {
       ProductFAQ::create($request->all());
       return response()->json(['msg'=>'Product FAQ created successfully']);
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
