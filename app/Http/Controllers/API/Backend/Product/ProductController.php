<?php

namespace App\Http\Controllers\API\Backend\Product;

use App\Helpers\Helper;
use App\Http\Controllers\API\Backend\ProductVariation\GenerateVariationController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Http\Resources\Backend\ProductResource;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Product;
use App\Models\ProductSubscription;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductDeliveryInformation;
use App\Models\ProductPhoto;
use App\Models\ProductSpecification;
use App\Models\SEO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Models\Visitors;

class ProductController extends Controller
{
    
    private function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    private function visitorCountPage() {
        
        $visitorSave = new Visitors();
        $visitorSave->page_slug     = 'price'; 
        $visitorSave->total_visitor = 1;
        $visitorSave->date          = date('Y-m-d');
        $visitorSave->user_agent    = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->ip            = $this->get_client_ip();
        $visitorSave->browser       = $_SERVER["HTTP_USER_AGENT"];
        $visitorSave->save();
    }
    
    public function create() {
        
        $categoryList = Category::get();
        $taglist      = Tag::get();
        
        return view('admin.product.create',[
            'categoryList' => $categoryList,
            'taglist' => $taglist
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginCustom(Request $request)
    {
 
        $username  = $request->get('username');
        $password  = $request->get('password');
        
        $remember_me = $request->has('remember_me') ? true : false;
        $userData    = [ 'email' =>  $username,'password' => $request->input('password') ];
      
        if( Auth::attempt( $userData, $remember_me ) ) {
            
            $user   = Auth::User();
           
            return Redirect('/admin/dashboard');

        } else {
            Auth::logout();
            return redirect('/admin_login')->with([
                'status' => 1,
                'error' => "Your user role isn't assigned. You can't login. Please contact to PCB.",
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $categoryList = Product::get();
        
        $productList = ProductSubscription::latest()
            ->get();

        return view('admin.product.index', compact('productList'),[
            'categoryList' => $categoryList,
            'status'       => $status,
            'type'         => 3,
        ]);

        
    }
    
    /**
     * Product submit
     * */
    public function productSubmit(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'product_title'    => 'required',
            'price'            => 'required',
            'product_image'    => 'required',
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
       
        if ($image = $request->file('product_image')) {
            
            $destinationPath = 'images/uploads/products_thumb/';
            $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            
            $image->move($destinationPath, $productImage);
            
            $input['product_image'] = $productImage;
        }
        
        $productSubcraption = new ProductSubscription();
        $productSubcraption->product_id   = 1101;
        $productSubcraption->title       = $request->product_title;
        $productSubcraption->sub_title   = $request->description;
        $productSubcraption->type        = $request->type;
        $productSubcraption->price       = $request->price;
        $productSubcraption->thumbnail   = $input['product_image'];
        
        if($productSubcraption->save()) {
            
            return response()->json([
                'msg'    => 'Add new record succssfully.',
                'status' => 200,
            ]);
   
        }
        return response()->json([
            'msg'    => 'Something want wrong.',
            'status' => 400,
        ]);
      
    }
    
    public function productUpdate(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'product_title'    => 'required',
            'price'            => 'required',
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
       
        if ($request->hasFile('product_image')) {
            $image= $request->file('product_image');
            
            $destinationPath = 'images/uploads/products_thumb/';
            $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            
            $image->move($destinationPath, $productImage);
            
            $input['product_image'] = $productImage;
        }
        
        $productSubcraption =  ProductSubscription::where('id', $request->product_id)->first();
        if(!empty($productSubcraption)) {
            
            $productSubcraption->title       = $request->product_title;
            $productSubcraption->sub_title   = $request->description;
            $productSubcraption->type        = $request->type;
            $productSubcraption->price       = $request->price;
            
            if ($request->hasFile('product_image')) {
                $productSubcraption->thumbnail   = $input['product_image'];
            }
            
            if($productSubcraption->save()) {
                
                return response()->json([
                    'msg'    => 'Add new record succssfully.',
                    'status' => 200,
                ]);
       
            }
        }
        
        return response()->json([
            'msg'    => 'Something want wrong.',
            'status' => 400,
        ]);
    }
    
    
    public function productList() {

        $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
             ->select('products.*', 'categories.slug', 'categories.category_name')
             ->where('products.type', 1 )
             ->orderBy('id','desc')
              ->latest()
             ->paginate(10);


         $productInfoArray = [];

        foreach( $productList as $productInfo) {
            
            
            $productListInfo = ProductPhoto::where('product_id', $productInfo->id)->first();
            
            if(!empty($productListInfo->product_photo)) {
                $productInfoArray[] =[
                    'productID' => $productInfo->id,
                    'title'     => $productInfo->product_name,
                    'slug'      => $productInfo->slug,
                    'media'     => 'https://mamundevstudios.com/shifti_api/public/images/uploads/products_thumb/'. $productListInfo->product_photo,
                    'price'     => $productInfo->price,
                    'type'      => $productInfo->type,
                ];  
            }
           
        }

         return json_encode($productInfoArray);
    }
    
    public function frontendCategoryProduct($categorySlug) {
        
        if($categorySlug == 'all' || $categorySlug == 'latest') {
            
            $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.slug', 'categories.category_name')
                ->where('products.type', 1 )
                ->orderBy('id','desc')
                ->latest()
                ->paginate(15); 
                
        } else if($categorySlug == 'featured') {
            
            $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.slug', 'categories.category_name')
                ->where('products.type', 1 )
                ->where('products.is_featured_products', 1 )
                ->orderBy('id','desc')
                ->latest()
                ->paginate(15); 
                
        } else {
            
            $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.slug', 'categories.category_name')
                ->where('categories.slug',$categorySlug )
                ->where('products.type', 1 )
                ->orderBy('id','desc')
                ->latest()
                ->paginate(15);  
            }
            
  
        $productInfoArray = [];
       
        foreach( $productList as $productInfo) {
            
            $productListInfo = ProductPhoto::where('product_id', $productInfo->id)->first();
            
            if(!empty($productListInfo->product_photo)) {
                $productInfoArray[] =[
                    'productID' => $productInfo->id,
                    'title'     => $productInfo->product_name,
                    'slug'      => $productInfo->slug,
                    'media'     => 'https://mamundevstudios.com/shifti_api/public/images/uploads/products_thumb/'. $productListInfo->product_photo,
                    'price'     => $productInfo->price,
                    'type'      => $productInfo->type,
                ];  
            }
           
        }

        return json_encode($productInfoArray);
    }
    
    public function frontendCategoryTotalProducts($categorySlug, $page) {
        
        if($categorySlug == 'all' || $categorySlug == 'latest' ) {
            
            $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.slug', 'categories.category_name')
                ->where('products.type', 1 )
                ->orderBy('id','desc')
                ->latest()
                ->paginate(15, ['*'], 'page', $page);
                
        }else if($categorySlug == 'featured') {
            
            $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.slug', 'categories.category_name')
                ->where('products.type', 1 )
                ->where('products.is_featured_products', 1 )
                ->orderBy('id','desc')
                ->latest()
                ->paginate(15, ['*'], 'page', $page);
                
        }  else {
            
            $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.slug', 'categories.category_name')
                ->where('categories.slug',$categorySlug )
                ->where('products.type', 1 )
                ->orderBy('id','desc')
                ->latest()
                ->paginate(15, ['*'], 'page', $page);
            }
            
  
        $productInfoArray = [];
       
        foreach( $productList as $productInfo) {
            
            $productListInfo = ProductPhoto::where('product_id', $productInfo->id)->first();
            
            if(!empty($productListInfo->product_photo)) {
                $productInfoArray[] =[
                    'productID' => $productInfo->id,
                    'title'     => $productInfo->product_name,
                    'slug'      => $productInfo->slug,
                    'media'     => 'https://mamundevstudios.com/shifti_api/public/images/uploads/products_thumb/'. $productListInfo->product_photo,
                    'price'     => $productInfo->price,
                    'type'      => $productInfo->type,
                ];  
            }
           
        }

        return json_encode($productInfoArray);
    }
    
    public function frontendCategoryTotalProduct($categorySlug) {
        
        
        
        if($categorySlug == 'all' || $categorySlug == 'latest') {
            
            $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.slug', 'categories.category_name')
                ->where('products.type', 1 )
                ->orderBy('id','desc')
                ->latest()
                ->paginate(15); 
                
        } elseif($categorySlug == 'featured') {
            
            $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.slug', 'categories.category_name')
                ->where('products.type', 1 )
                ->where('products.is_featured_products', 1 )
                ->orderBy('id','desc')
                ->latest()
                ->paginate(15); 
                
        } else {
            
            $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.slug', 'categories.category_name')
                ->where('categories.slug',$categorySlug )
                ->where('products.type', 1 )
                ->orderBy('id','desc')
                ->latest()
                ->paginate(15);  
            }
            
  
        $productInfoArray = [];
        
        $productInfoArray= [
            'total'=> $productList->lastPage()
        ];
        
       

        return json_encode($productInfoArray);
    }
    
    public function featuredproductList() {

        $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
             ->select('products.*', 'categories.slug', 'categories.category_name')
             ->where('is_featured_products', 1)
             ->where('products.type', 1 )
             ->orderBy('id','desc')
             ->paginate(10);


        $productInfoArray = [];

        foreach( $productList as $productInfo) {
            
            $productListInfo = ProductPhoto::where('product_id', $productInfo->id)->first();
            if(!empty($productListInfo->product_photo)) {
                $productInfoArray[] =[
                    'productID' => $productInfo->id,
                    'title'  => $productInfo->product_name,
                    'slug'  => $productInfo->slug,
                    'media' => 'https://mamundevstudios.com/shifti_api/public/images/uploads/products_thumb/'. $productListInfo->product_photo,
                    'price' => $productInfo->price,
                    'type'  => $productInfo->type,
                ];  
            }
           
        }

         return json_encode($productInfoArray);
    }
    
    
    public function subscriptionProductList() {

        $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
             ->select('products.*',  'categories.category_name')
             ->where('type', 2)
             ->orderBy('id','desc')
             ->paginate(10);
        
        $this->visitorCountPage();

        $productInfoArray = [];

        foreach( $productList as $productInfo) {
            
            $productListInfo = ProductPhoto::where('product_id', $productInfo->id)->first();
            
            if(!empty($productListInfo->product_photo)) {
                $productInfoArray[] =[
                    'productID' => $productInfo->id,
                    'title'  => $productInfo->product_name,
                    'sub_title'  => $productInfo->product_name,
                    'slug'  => $productInfo->slug,
                    'media' => 'https://mamundevstudios.com/shifti_api/public/images/uploads/products_thumb/'. $productListInfo->product_photo,
                    'price' => [
                        'month' => $productInfo->price,
                        'annual' => $productInfo->price,
                        'bio-annual' => $productInfo->price,
                    ],
                    'features' => [
                        [
                            'title' => 'Google apps',
                            'isIncluded' => true,
                        ],
                        [
                            'title' => 'facbook apps',
                            'isIncluded' => false,
                        ],
                        [
                            'title' => 'youtube apps',
                            'isIncluded' => false,
                        ],
                        [
                            'title' => 'facbook apps',
                            'isIncluded' => false,
                        ],
                        [
                            'title' => 'facbook apps',
                            'isIncluded' => false,
                        ],
                      
                    ],
                    'btnText' => 'Get basic',
                    'type'    => $productInfo->type,
                ];  
            }
           
        }

         return json_encode($productInfoArray);
    }
    
    public function subscriptionProduct(Request $request,$slug) {
        
           $this->visitorCountPage();
        $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
             ->select('products.*', 'categories.slug', 'categories.category_name')
             ->where('products.slug', $slug)
             ->orderBy('products.id','desc')
             ->get();
      
        $productInfoArray = [];
        $productChild    = [];
            
        foreach( $productList as $productInfo) {
            
            $productListInfo = ProductPhoto::where('product_id', $productInfo->id)->first();
            
               if(!empty($request->is_homepage)) {
                    $productSubcraption = ProductSubscription::where('product_id', $productInfo->id)
                        ->where('is_homepage', 1)
                        ->orderBy('id','desc')
                        ->get();
                }  else if(!empty($request->is_product_page)) {
                    $productSubcraption = ProductSubscription::where('product_id', $productInfo->id)
                        ->where('is_product_display', 1)
                        ->orderBy('id','desc')
                        ->get();
                }  else if(!empty($request->is_ultimate_product)) {
                    
                    $productSubcraption = ProductSubscription::where('product_id', $productInfo->id)
                        ->where('id', 3)
                        ->orderBy('id','desc')
                        ->get();
                }  else{
                    
                    $productSubcraption = ProductSubscription::where('product_id', $productInfo->id)
                        ->orderBy('id','desc')
                        ->get();
                }
            foreach($productSubcraption as $key=>$productSubcationList) {
                 
                $explodeInfo = explode(',', $productSubcationList->fetuare);
                $array = [];
                foreach($explodeInfo as $explode) {
                    $array[] = [ 'module_title'=> $explode];
                }
                
                $productSubcraption1 = json_encode($array);
                
                $productChild[]=[
                    'product_id' => $productInfo->id,
                    'id' => $productSubcationList->id,
                    'price'      => $productSubcationList->price,
                    'annual'      => round(((($productSubcationList->price*12)/100)*90),2),
                    'monthly'    => $productSubcationList->price,
                    'title'      => $productSubcationList->title,
                    'sub_title'  => $productSubcationList->sub_title,
                    'type'       => $productSubcationList->type,
                    'is_active'  => $productSubcationList->is_active,
                    'module'     =>  $array,
                ];
                
               
            }
            
            if(!empty($productListInfo->product_photo)) {
                $productInfoArray =[
                    'productID'  => $productInfo->id,
                    'title'      => $productInfo->product_name,
                    'content'    => $productInfo->description,
                    'sub_title'  => $productInfo->product_name,
                    'slug'       => $productInfo->slug,
                    'media'      => 'https://mamundevstudios.com/shifti_api/public/images/uploads/products_thumb/'. $productListInfo->product_photo,
                    'product'    => $productChild,
                    'btnText'    => 'Get basic',
                    'type'       => $productInfo->type,
                ];  
            }
           
        }

         return json_encode($productInfoArray);
    }
     public function displayProductList() {

        $productList = Product::leftjoin('categories','products.category_id', '=', 'categories.id')
             ->select('products.*', 'categories.slug', 'categories.category_name')
             ->where('type', 5)
             ->orderBy('id','desc')
             ->limit(1)
             ->get();


         $productInfoArray = [];

        foreach( $productList as $productInfo) {
            
            $productListInfo = ProductPhoto::where('product_id', $productInfo->id)->first();
            
            if(!empty($productListInfo->product_photo)) {
                
                $productInfoArray[] =[
                    'productID' => $productInfo->id,
                    'title' => $productInfo->product_name,
                    'media' => 'https://mamundevstudios.com/shifti_api/public/images/uploads/products_thumb/'. $productListInfo->product_photo,
                    'price' => $productInfo->price,
                    'content' => $productInfo->description,
                    
                ];  
            }
           
        }

         return json_encode($productInfoArray);
    }
    
    
    
    public function show(int $id)
    {
            $product = Product::with('product_photo', 'seo', 'category', 'tag', 'brand', 'review', 'review.user', 'review.review_replay', 'review.review_replay.user', 'faq')->findOrFail($id);
            return new ProductResource($product);
      
    }

    public function delete_product($id)
    {
        $product = Product::where('slug_id', $id)->first();
        if ($product){
            $child_products = Product::where('parent', $product->id)->get();
            foreach ($child_products as $child_product){
                $this->destroy($child_product->id);
            }
            $this->destroy($product->id);
            return response()->json(['msg' => $product->product_name.' Deleted Successfully']);
        }
    }

     /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request)
    {
          $dataValidation = $this->validate($request, [
            //   'description'    =>'required',
               'price'          =>'required',
               'product_name'   =>'required',
               'category_id'    =>'required',
            ]);
            
         
        $product['description'] = $request->description;
        $product['price'] = $request->price;
        $product['slug'] = preg_replace('/\s+/', '-', $request->product_name);
        $product['product_name'] = $request->product_name;
        $product['category_id'] = $request->category_id;
        $product['tag']   = implode(',',$request->tag);
        $product['sku'] = $request->sku;
        $product['status'] = $request->status;
        $product['stock'] = $request->stock;
        $product['product_cost'] = $request->product_cost;
        $product['variation_product'] = "";
        $product['product_origin'] = "";
        $product['discount_time'] = "";
        $product['discount_type'] = 1;
        $product['discount_amount'] = $request->discount;
        $product['is_featured_products'] = !empty($request->is_featured_products)? $request->is_featured_products: 0;
        $product['type'] = $request->type;
        //$product['updated_by'] = auth()->user()->id;
        $product['store_id'] = $request->input('store_id');


        if ($image = $request->file('product_image')) {
            
            $destinationPath = 'images/uploads/products_thumb/';
            $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            
            $image->move($destinationPath, $productImage);
            $input['product_image'] = "$productImage";
        }


        $category['category_id'] = $request->input('category_id');


        if ($request->input('product_type_id') && $request->input('product_type_id') == 1) {
            
           // category_with_all_parent

            if ($request->input('category_id') ==2) {
                
                $product['product_type_id'] = 3;
                
            }else{
                $categories_database = Category::with('category_with_all_parent')->findOrFail($request->input('category_id'));
                $search_string = $categories_database->category_with_all_parent;
                $category_ids = [];
                while($search_string){
                    array_push($category_ids, $search_string->id);
                    $search_string = $search_string->category_with_all_parent;
                }
                if (in_array(2 , $category_ids)) {
                    $product['product_type_id'] =3;
                }else{
                    $product['product_type_id'] =1;
                }
            }


        }else{
            $product['product_type_id'] = 2;
        }


        //first request stats
        if ($request->missing('product_id')) {
            
            
           // $product['slug'] = Str::of($request->slug)->slug(); //make slug format
            $product['slug'] = preg_replace('/\s+/', '-', $request->product_name);;
            //slug id formation stats
            $product_exist_or_not = Product::all()->count();
            if ($product_exist_or_not > 0) {
                $tag = Product::orderBy('slug_id', 'desc')->first();
                $product['slug_id'] = $tag->slug_id + 1;
            } else {
                $product['slug_id'] = 100001;
            }


            if ($request->exists('save') && $request->save == 'save'){
                
                $this->validate($request, [
                    'product_name' =>'required',
                    'slug' =>'required',
                    'sku' =>'required',
                    'status' =>'required',
                    'category_id' =>'required',
                ]);

                //check all child product created or not

                $child_product_exist = ProductAttributeValue::where('product_id', $request->input('product_id'))->where('child_product_id', null)->get();
                if (count($child_product_exist) > 0){
                    $sku_variation_ids= [];
                    foreach ($child_product_exist as $child_product){
                        if (!in_array($child_product->sku_variation_id, $sku_variation_ids)){
                            array_push($sku_variation_ids, $child_product->sku_variation_id);
                        }
                    }
                    //sku_variation_id
                    return response()->json(['err_msg'=>'error', 'sku'=>$sku_variation_ids]);
                }
                $product['status'] = $request->input('status') == 2?1 : $request->input('status');
            }

            $product_save = Product::create($product);
            
        
            $productPhoto = new ProductPhoto();
            $productPhoto->product_photo = $productImage;
            $productPhoto->product_id = $product_save->id;
            $productPhoto->primary = 1;
            $productPhoto->save();
            
            if($request->type== 2) {
                
                $subPrice = $request->sub_price;
                $subTitle = $request->sub_title;
                $subType  = $request->sub_type;
                $feature  = $request->feature;
                
               
                if(!empty($subPrice)){
                    foreach($subPrice as $key => $value) {
                        $subscraption = new ProductSubscription();
                        $subscraption->title      = $subTitle[$key];
                        $subscraption->sub_title  = $subTitle[$key];
                        $subscraption->product_id = $product_save->id;
                        $subscraption->price      = $subPrice[$key];
                        $subscraption->type       = $subType[$key];
                        $subscraption->fetuare    = $feature[$key];
                        $subscraption->save();
                    }
                    
                }
            }
            
            if ($request->category_id) {
                $product_save->category()->attach($request->category_id);
            }
            return redirect('/admin/product?status=success')->with('success',"Created Successfully");
            //return response()->json(['product_id' => $product_save->id]);
            
        } else {
            try {
                $product_database = Product::findOrFail($request->product_id);
            } catch (ModelNotFoundException $e) {
                return response()->json($e);
            }
        }
        //first request ends


        //feature photo upload ends

        $product = $product_database->update($product);

        $original_product = Product::findOrFail($request->product_id);

        $product_specification = new ProductSpecificationController();

        $old_specifications = ProductSpecification::where('product_id', $original_product->id)->get();
        if ($old_specifications != null && count($old_specifications) > 0) {
            foreach ($old_specifications as $old_specification) {
                $product_specification->destroy($old_specification->id);
            }
        }
        if ($request->color && $request->color != null) {
            $color = ['name' => 'color', 'value' => $request->color, 'product_id' => $original_product->id];
            $product_specification->store($color);
        }

        if ($request->height && $request->height != null) {
            $height = ['name' => 'height', 'value' => $request->height, 'product_id' => $original_product->id];
            $product_specification->store($height);
        }

        if ($request->size && $request->size != null) {
            $size = ['name' => 'size', 'value' => $request->size, 'product_id' => $original_product->id];
            $product_specification->store($size);
        }

        if ($request->weight && $request->weight != null) {
            $weight = ['name' => 'weight', 'value' => $request->weight, 'product_id' => $original_product->id];
            $product_specification->store($weight);
        }

        if ($request->width && $request->width != null) {
            $width = ['name' => 'width', 'value' => $request->width, 'product_id' => $original_product->id];
            $product_specification->store($width);
        }


        if ($request->specificationName_0) {
            $i = 0;
           // specificationValue_3
            $product_specification_input = [];
            while ($request->input('specificationName_'.$i)) {
                array_push($product_specification_input, ['name' => $request->input('specificationName_'.$i), 'value' => $request->input('specificationValue_'.$i), 'product_id' => $original_product->id]);
                $i++;
            }
           // return $product_specification_input;
            $new_ids = [];
            foreach ($product_specification_input as $new_specification) {
                $old_data = ProductSpecification::where('product_id', $original_product->id)->where('name', $request->input('specificationName_'.$i))->first();
                if ($old_data){
                   $specifications_save = $old_data->update($new_specification);
                }else{
                    $specifications_save= $product_specification->store($new_specification);
                }
               array_push($new_ids, $specifications_save->id);
            }
            $all_specifications_data_fromDatabase = ProductSpecification::where('product_id', $original_product->id)->get();
            $filed_list = ['weight', 'color', 'height', 'size', 'width'];
            foreach ($all_specifications_data_fromDatabase as $all_specifications_data_from){
                if (!in_array($all_specifications_data_from->id ,$new_ids) && !in_array($all_specifications_data_from->name,$filed_list)){
                    $all_specifications_data_from->delete();
                }
            }
        }


        //category stats
        // $category_check =
        $original_product->category()->sync($request->category_id);
        //category ends

        //brand stats
        if ($request->brand_id && $request->brand_id != null) {
            $original_product->brand()->sync($request->brand_id);
        }

        //delivery Information stats
        $delivery['order_type'] = $request->order_type;
        $delivery['ship_from'] = $request->ship_from;
        $delivery['free_shipping'] = $request->free_shipping;
        $delivery['delivery_time'] = $request->delivery_time;
        $delivery['product_weight'] = $request->delivery_weight;
        $delivery['height'] = $request->delivery_height;
        $delivery['width'] = $request->delivery_width;
        $delivery['length'] = $request->delivery_length;
        $delivery['product_id'] = $original_product->id;

        $delivery_check = ProductDeliveryInformation::where('product_id', $original_product->id)->first();
        if ($delivery_check) {
            $delivery_check->update($delivery);
        } else {
            ProductDeliveryInformation::create($delivery);
        }


        //delivery Information ends
        //product attribute starts


        if ($request->attribute_name_0) {

            $old_attribute_value = ProductAttributeValue::where('product_id', $original_product->id)->get();
            foreach ($old_attribute_value as $old_attribute_data) {
                $old_attribute_data->delete();
            }

            $i = 0;
            $product_attributes = [];
            $attribute_name = [];
            $attribute_value = [];

            while ($request->input('attribute_name_' . $i)) {
                // array_push($product_attributes, ['attribute_name'=>ucwords($request->input('attribute_name_'.$i)) ]);
                $temp_name = ['attribute_name' => ucwords($request->input('attribute_name_' . $i))];
                array_push($attribute_name, ucwords($request->input('attribute_name_' . $i)));
                $product_attribute['attribute_name'] = ucwords($request->input('attribute_name_' . $i));


                $old_attribute = ProductAttribute::where('attribute_name', ucwords($request->input('attribute_name_' . $i)))->first();
                if (!$old_attribute) {
                    $created_attribute = ProductAttribute::create($product_attribute);
                    $attribute_id = $created_attribute->id;
                } else {
                    $attribute_id = $old_attribute->id;
                }

                $attribute = $request->input('attribute_value_' . $i);

                $temp_value = explode(',', $attribute);
                array_push($attribute_value, $temp_value);
                $i++;
            }

            $attributes = array_combine($attribute_name, $attribute_value);
            $combination_controller = new GenerateVariationController();
            $combinations = $combination_controller->possible_combos($attributes);
            $formatted_combo = [];
            foreach ($combinations as $value) {
                $tem_data = explode('|', $value);
                $tem_array = [];
                foreach ($tem_data as $key => $data) {
                    $temp_arr = [$attribute_name[$key] => $data];
                    array_push($tem_array, $temp_arr);
                }
                array_push($formatted_combo, $tem_array);
                $tem_array = [];
                $tem_data = '';
            }
            $combination_id = 1;
            foreach ($formatted_combo as $combo) {

                foreach ($combo as $data) {

                    foreach ($data as $key => $combo_value) {
                        $variation_name = ProductAttribute::where('attribute_name', $key)->first();
                        $product_attribute_data['product_id'] = $original_product->id;
                        $product_attribute_data['attribute_value'] = $combo_value;
                        $product_attribute_data['product_attribute_id'] = $variation_name->id;
                        $product_attribute_data['sku_variation_id'] = $combination_id;
                        ProductAttributeValue::create($product_attribute_data);
                    }

                }
                $combination_id++;
            }
        }


        //

        //product attribute ends

        //log generation start
        $old_data = 'Product Created';
        $new_data = $request->tag_name;
        $subject = 'Product Creation';
        $column_name = 'Product Created';
        $table_name = (new Product())->getTable();
        $action = 'Creation';
        Helper::addToLog($subject, $column_name, $old_data, $new_data, $table_name, $action);
        //log generation Ends
          return redirect('/admin/product/show?status=product_success')->with('success',"Created Successfully");
    }
     public function edit(Request $request, $id)
        {
            $categoryList = Category::get();
            $product = Product::find($id);
            $taglist      = Tag::get();
            
            return view('admin.product.edit',[
                'categoryList' => $categoryList,
                'product'      => $product,
                'taglist'      => $taglist,
            ]);
        }
     public function update(Request $request, $id)
        {
           $this->validate($request, [
                   'description'    =>'required',
                   'price'          =>'required',
                   'product_name'   =>'required',
                   'category_id'    =>'required',
                   'sku'            =>'required',
                   'status'         =>'required',
                   'stock'          =>'required',
                   'product_cost'   =>'required'
                ]);
    
            $product = Product::findOrFail($id);
            
            $tags ='';
            if(!empty($request->tag)) {
                $tags = implode(',', $request->tag);
            }
            $product['description'] = $request->description;
            $product['price'] = $request->price;
            $product['tag']   = $tags;
            $product['product_name'] = $request->product_name;
            $product['category_id'] = $request->category_id;
            $product['sku'] = $request->sku;
            $product['status'] = $request->status;
            $product['stock'] = $request->stock;
            $product['product_cost'] = $request->product_cost;
            $product['variation_product'] = "";
            $product['product_origin'] = "";
            $product['discount_time'] = "";
            $product['discount_type'] = $request->discount_type;
            $product['discount_amount'] = $request->discount_amount;
            $product['store_id'] = $request->input('store_id');
            $category['category_id'] = $request->input('category_id');
    
            $product->update();
            return redirect('/admin/product?status=updated')->with('success',"Updated Successfully");
        }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
            $path_thumb = 'images/uploads/products_thumbs/';
            $path = 'images/uploads/products/';
            $product = Product::with('product_photo')->findOrFail($id);
            if ($product->product_photo) {
                foreach ($product->product_photo as $product_photo) {
                    Helper::unlinkImage($path, $product_photo->product_photo);
                    Helper::unlinkImage($path_thumb, $product_photo->product_photo);
                }
            }
            $product->delete();
           return redirect()->back()->with(['success' => 'Data Deleted Successfully.']);
        
    }
    
    public function productDelete(Request $request) {
        
        ProductSubscription::find($request->id)->delete();
    }


}
