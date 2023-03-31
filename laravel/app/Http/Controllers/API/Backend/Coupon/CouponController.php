<?php

namespace App\Http\Controllers\API\Backend\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Coupon\CouponListResource;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $coupons = Coupon::with('user')->latest()->get();
        return CouponListResource::collection($coupons);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'code' => 'required|unique:coupons',
            'applied_to' => 'required',
            'status' => 'required',
            'discount_amount' => 'required',
            'discount_type' => 'required',
            'foreign_key' => 'required_if:applied_to,==,2|required_if:applied_to,==,3|required_if:applied_to,==,4'
        ],
            [
                'foreign_key.required_if'=>'Please Select Category/Sub Category/ Product'
            ]
        );

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        Coupon::create($data);
        return response()->json(['msg' => 'Coupon Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_items_for_coupon_create(Request $request): JsonResponse
    {
        $items = [];
        if ($request->input('id') == 2) {
            $items = Category::select('category_name as name', 'id')->where('parent', null)->get();
        } elseif ($request->input('id') == 3) {
            $category = Category::select('id')->where('parent', null)->get();
            $items = Category::select('category_name as name', 'id')->whereIn('parent', $category)->get();
        } elseif ($request->input('id') == 4) {
            $items = Product::select('product_name as name', 'id')->where('parent', null)->where('status', 1)->get();
        }
        return response()->json($items);
    }
}
