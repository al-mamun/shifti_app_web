<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\Category\FrontendCategoryListResource;
use App\Http\Resources\Frontend\Category\GlobalCategoryListResource;
use App\Http\Resources\Frontend\Menu\MenuResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function get_menu_categories()
    {
        $categories = Category::where('status', 1)->where('parent', null)->where('primary_category', 1)->with('subCategory', 'subCategory.subSubCategory')->get();
        return MenuResource::collection($categories);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function get_all_categories(): AnonymousResourceCollection
    {
        $categories = Category::where('status', 1)->where('parent', null)->with('subCategory', 'subCategory.subSubCategory')->get();
        return FrontendCategoryListResource::collection($categories);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function get_sub_categories($slug_id): AnonymousResourceCollection
    {
        $category = Category::where('slug_id', $slug_id)->first();
        if ($category) {
            $sub_categories = Category::where('status', 1)->where('parent', $category->id)->with('subCategory', 'subCategory.subSubCategory')->get();
            return FrontendCategoryListResource::collection($sub_categories);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return MenuResource
     */
    public function get_related_category($slug_id)
    {
        $category = Category::with('category_with_all_parent')->where('slug_id', $slug_id)->first();
        $parent_id = [];
        if ($category) {
            $index = $category->category_with_all_parent;
            while ($index) {
                array_push($parent_id, $index->id);
                $index = $index->category_with_all_parent;
            }
        }
        if (count($parent_id) > 0) {
            $parent = array_pop($parent_id);
            $categories = Category::with(['subCategory'])->where('status', 1)->findOrFail($parent);
        }else{
            $categories = Category::with(['subCategory'])->where('status', 1)->where('slug_id', $slug_id)->first();
        }
        return new MenuResource($categories);
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
     * @param \Illuminate\Http\Request $request
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

    /**
     * @return JsonResponse
     */
    public function get_hot_categories(): JsonResponse
    {
        $categories = Category::orderBy('order_by', 'asc')->take(6)->get();
        return response()->json([
            'data' => $categories,
            'status' => 200,
        ]);
    }

    public function get_global_category(Request $request): JsonResponse
    {
        try {
            $category = Category::where('status', 1)->where('slug', $request->slug)->with('category_tag')->with('product', function ($q) {
                $q->take(3);
            })->whereHas('category_tag', function ($q) use ($request) {
                $q->where('slug', 'like', '%' . $request->tag_slug . '%');
            })->first();
            return response()->json([
                'data' => $category,
                'status' => 200,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'data' => 'Not Found',
                'status' => 404,
            ]);
        }
    }

    public function get_grocery_category(Request $request)
    {
        try {
            $category = Category::where('status', 1)->with('category_tag')->whereHas('category_tag', function ($q) use ($request) {
                $q->where('slug', $request->tag_slug);
            })->take(6)->latest()->get();
            return response()->json([
                'data' => $category,
                'status' => 200,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'data' => 'Not Found',
                'status' => 404,
            ]);
        }
    }

    public function test()
    {
        // $category = Category::with('subCategory', 'subSubCategory')->where('parent', null)->get();
//        $categories = (new Category)->tree();
//        return response()->json([
//            'data' => $categories,
//            'status'=>200,
//        ]);

        $color = ['name' => 'color', 'value' => 'Red'];
        print_r($color);
    }

    public function category_bread_crumb(Request $request): JsonResponse
    {
        $slug_id = $request->input('slug_id');
        $category_bread_crumb = [];
        if ($request->exists('slug_id')) {
            $category = Category::with('category_with_all_parent')->where('slug_id', $request->input('slug_id'))->first();
            if ($category) {
                $category_level_one = ['category_name' => $category->category_name, 'slug' => $category->slug, 'slug_id' => $category->slug_id];
                array_push($category_bread_crumb, $category_level_one);

                if ($category->category_with_all_parent) {
                    $category_level_two = ['category_name' => $category->category_with_all_parent->category_name, 'slug' => $category->category_with_all_parent->slug, 'slug_id' => $category->category_with_all_parent->slug_id];
                    array_push($category_bread_crumb, $category_level_two);

                    if ($category->category_with_all_parent->category_with_all_parent) {
                        $category_level_three = ['category_name' => $category->category_with_all_parent->category_with_all_parent->category_name, 'slug' => $category->category_with_all_parent->category_with_all_parent->slug, 'slug_id' => $category->category_with_all_parent->category_with_all_parent->slug_id];
                        array_push($category_bread_crumb, $category_level_three);

                        if ($category->category_with_all_parent->category_with_all_parent->category_with_all_parent) {
                            $category_level_four = ['category_name' => $category->category_with_all_parent->category_with_all_parent->category_with_all_parent->category_name, 'slug' => $category->category_with_all_parent->category_with_all_parent->category_with_all_parent->slug, 'slug_id' => $category->category_with_all_parent->category_with_all_parent->category_with_all_parent->slug_id];
                            array_push($category_bread_crumb, $category_level_four);

                            if ($category->category_with_all_parent->category_with_all_parent->category_with_all_parent->category_with_all_parent) {
                                $category_level_five = ['category_name' => $category->category_with_all_parent->category_with_all_parent->category_with_all_parent->category_with_all_parent->category_name, 'slug' => $category->category_with_all_parent->category_with_all_parent->category_with_all_parent->category_with_all_parent->slug, 'slug_id' => $category->category_with_all_parent->category_with_all_parent->category_with_all_parent->category_with_all_parent->slug_id];
                                array_push($category_bread_crumb, $category_level_five);
                            }
                        }
                    }
                }
            }
        }
        $category_bread_crumb = array_reverse($category_bread_crumb);
        return response()->json($category_bread_crumb);
    }

    /*
     *
     */
    public function get_global_categories(): AnonymousResourceCollection
    {
        $category = Category::where('parent', 2)->orderBy('order_by', 'asc')->get();
        return GlobalCategoryListResource::collection($category);
    }


}
