<?php

namespace App\Http\Controllers\API\Backend\Category;

use App\Helpers\Helper;
use App\Http\Controllers\API\Backend\SEO\CategorySeoController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryRequest;
use App\Http\Resources\Backend\Category\CategoryEditResource;
use App\Http\Resources\Backend\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use Exception;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{

    public function create() {

        return view('admin.category.create');
    }

     public function show() {
        
        $categoryList = Category::get();

        return view('admin.category.list',[
            'categoryList' =>  $categoryList
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        if (isset($request->paginate) && $request->paginate != 'null') {
            $pagination = $request->paginate;
        } else {
            $pagination = 10;
        }
        if (isset($request->search) && $request->search != 'null') {
            $categories = Category::where('parent', null)->orderBy('order_by', 'asc')->where('category_name', 'like', '%' . $request->search . '%')->paginate($pagination);
        } else {
            $categories = Category::where('parent', null)->orderBy('order_by', 'asc')->paginate($pagination);
        }

        return CategoryResource::collection($categories);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function subCategoryList(Request $request): AnonymousResourceCollection
    {
        if (isset($request->paginate) && $request->paginate != 'null') {
            $pagination = $request->paginate;
        } else {
            $pagination = 10;
        }
        if (isset($request->search) && $request->search != 'null') {
            $categories = Category::whereNotNull('parent')->orderBy('order_by', 'asc')->where('category_name', 'like', '%' . $request->search . '%')->paginate($pagination);
        } else {
            $categories = Category::whereNotNull('parent')->orderBy('order_by', 'asc')->with('parentCategory')->paginate($pagination);
        }
        return CategoryResource::collection($categories);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function allCategoryList(Request $request): AnonymousResourceCollection
    {
        if (isset($request->paginate) && $request->paginate != 'null') {
            $pagination = $request->paginate;
        } else {
            $pagination = 10;
        }
        if (isset($request->search) && $request->search != 'null') {
            $categories = Category::where('category_name', 'like', '%' . $request->search . '%')->orderBy('order_by', 'asc')->paginate($pagination);
        } else {
            $categories = Category::with('parentCategory')->orderBy('order_by', 'asc')->paginate($pagination);
        }
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
           
       $this->validate($request, [
            'category_name'       =>'required|unique:categories',
            'icon'                => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);
    
        $data = $request->all();
        $data['user_id'] =1;
        //$data['slug']   = Str::of($request->slug)->slug();
        $data['slug']   = date('YmdHis');
        
 
        $data = $request->except('description', 'keywords', 'parent', 'feature_photo');
        //$data['updated_by'] = auth()->user()->id;
        //$data['slug'] = Str::of($request->slug)->slug();
        
        $data['slug']   = date('YmdHis');
        
        $category_exist_or_not = Category::all()->count();
        
        if ($category_exist_or_not > 0) {
            $category = Category::orderBy('created_at', 'desc')->first();
            $data['slug_id'] = $category->slug_id + 1;
        } else {
            $data['slug_id'] = 100001;
        }
        if ($request->exists('parent')) {
            if ($request->parent != 'null') {
                $data['parent'] = $request->parent;
            }
        }
        
        $height = 800;
        $width = 800;
        $path = 'images/uploads/category_icon/';
        $name = $data['slug'] . '-' . $data['slug_id'];
        if ($request->icon) {
            $file = $request->icon;
            $data['icon'] = Helper::uploadImage($name, $height, $width, $path, $file);
        } else {
            $data['icon'] = null;
        }
        if ($request->feature_photo) {
            $file = $request->feature_photo;
            $data['feature_photo'] = Helper::uploadImage($name . '_feature_photo', $height, $width, $path, $file);
        } else {
            $data['feature_photo'] = null;
        }

        $category = Category::create($data);
        //category seo create
        $category_seo = new Request();
        $category_seo->setMethod('POST');
        $category_seo->request->add(['description' => $request->description, 'keywords' => $request->keywords, 'category_id' => $category->id]);
        $category_seo_create = new CategorySeoController();
        $category_seo_create->store($category_seo);
        //log generation start
        $old_data = 'Category Created';
        $new_data = $request->category_name;
        $subject = 'Category Creation';
        $column_name = 'Category Created';
        $table_name = (new Category())->getTable();
        $action = 'Creation';
        Helper::addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action);
        //log generation Ends
       /* return response()->json(['msg' => $category->category_name . ' Category created Successfully']);*/
         return redirect('/admin/category/show')->with('success',"Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return CategoryResource|JsonResponse
     */


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
     public function edit(Request $request, int $id)
    {
       $category = Category::find($id);
       return view('admin.category.edit',compact('category'));  
    }
    public function update(Request $request, int $id)
    {

        $this->validate($request, [
            'category_name'       =>'required',
            'icon'                => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $data = $request->only('category_name', 'order_by', 'product_type_id', 'slug', 'status', 'primary_category');
        $data['slug'] =strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->category_name)));
        $category = Category::with('seo')->findOrFail($id);
        $original_origin = $category->getOriginal();    //for log

        $height = 800;
        $width = 800;
        $path = 'images/uploads/category_icon/';
        $name = $data['slug'] . '-' . $category->slug_id;
        if ($request->icon) {
            $file = $request->icon;
            if ($category->icon != null) {
                Helper::unlinkImage($path, $category->icon);
            }
            $data['icon'] = Helper::uploadImage($name, $height, $width, $path, $file);
        } else {
            $data['icon'] = $category->icon;
        }

        if ($request->input('primary_category') == 1) {
            if ($request->feature_photo) {
                $file = $request->feature_photo;
                if ($category->feature_photo != null) {
                    Helper::unlinkImage($path, $category->feature_photo);
                }
                $data['feature_photo'] = Helper::uploadImage($name . '_feature_photo', $height, $width, $path, $file);
            } else {
                $data['feature_photo'] = $category->feature_photo;
            }
        }else{
            if ($category->feature_photo != null) {
                Helper::unlinkImage($path, $category->feature_photo);
            }
            $data['feature_photo'] =null;
        }




        $category->update($data);

        //category seo create/update

        $category_seo = new Request();
        $category_seo->setMethod('PUT');
        $category_seo->request->add(['description' => $request->description, 'keywords' => $request->keywords, 'category_id' => $category->id]);
        $category_seo_create = new CategorySeoController();
        if ($category->seo) {
            $category_seo_create->update($category_seo, $id);
        } else {
            $category_seo_create->store($category_seo);
        }


        //log generation start
        $changes = $category->getChanges(); //for log
        $old_data = []; //for log
        $new_data = []; //for log
        $subject = $category->category_name . ' updated to ' . $request->category_name;
        $table_name = (new Category())->getTable();

        foreach ($changes as $key => $value) { //for log
            $old_data[$key] = $original_origin[$key];
            $new_data[$key] = $changes[$key];
            $column_name = $key;
            $action = 'Update';
            if ($key !== 'updated_at') {
                Helper::addToLog($subject, $column_name, $old_data[$key], $new_data[$key], $table_name, $action);
            }
        }
        //log generation Ends
        return redirect('/admin/category/show')->with('success',"Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        //log generation start
        $old_data = $category->category_name;
        $new_data = 'Category Deleted';
        $subject = $category->category_name . 'Category Deleted';
        $column_name = 'Category Deletion';
        $table_name = (new Category())->getTable();
        $action = 'Deletion';
        Helper::addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action);
        //log generation Ends
        $path = 'images/uploads/category_icon/';
        if ($category->icon != null) {
            Helper::unlinkImage($path, $category->icon);
        }

        $category->delete();
        return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */

    public function status_update(Request $request, $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        if ($request->status == 1) {
            $status = 'Active';
            $cls = 'success';
        } else {
            $status = 'Inactive';
            $cls = 'warn';
        }
        return response()->json(['msg' => $category->category_name . ' set as ' . $status, 'cls' => $cls]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function get_categories(int $id): JsonResponse // for product create page
    {
        $categories = Category::where('status', 1)->where('parent', null)->where('product_type_id', $id)->orderBy('order_by', 'asc')->get();
        // $categories = Category::with('subCategory', 'subCategory.subSubCategory')->where('parent', null)->where('status' , 1)->get();
        return response()->json($categories);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function get_sub_categories(int $id): JsonResponse // for product create page
    {
        $sub_categories = Category::where('status', 1)->where('parent', $id)->orderBy('order_by', 'asc')->get();
        return response()->json($sub_categories);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function get_sub_sub_categories(int $id): JsonResponse // for product create page
    {
        $sub_categories = Category::where('status', 1)->where('parent', $id)->orderBy('order_by', 'asc')->get();
        return response()->json($sub_categories);
    }

    public function check_primary_category(Request $request)
    {
        $categories = Category::where('primary_category', 1)->count();
        if ($categories >= 9) {
            return response()->json(['msg' => 'Sorry! Maximum 9 primary category allowed']);
        } else {
            return response()->json(['msg' => 'ok']);
        }
    }

    public function get_category_for_edit_page(int $id)
    {
        //  $category = Category::wherePivot('product_id', $id)->first();

        $product = Product::with('category')->where('slug_id', $id)->first();
        if ($product->category) {
            return response()->json(['category_name' => $product->category[0]->category_name, 'category_id' => $product->category[0]->id]);
        }
    }

    /**
     * @param int $id
     * @return CategoryEditResource
     */
    public function get_category_for_edit(int $id): CategoryEditResource
    {
        $category = Category::select('id', 'category_name', 'feature_photo', 'icon','order_by', 'parent', 'primary_category', 'product_type_id', 'slug', 'status')->with('seo')->findOrFail($id);
        return new CategoryEditResource($category);
    }


}
