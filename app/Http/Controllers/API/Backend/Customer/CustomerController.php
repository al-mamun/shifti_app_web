<?php

namespace App\Http\Controllers\API\Backend\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Customer\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomerAddress;
use App\Models\Country;
use Mail ;
class CustomerController extends Controller
{
    protected $documentDirectory          = "/upload/cv/";
    protected $documentDirectoryCustomer  = "/upload/customer/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        if (isset($request->paginate) && $request->paginate != 'null') {
            $pagination = $request->paginate;
        } else {
            $pagination = 10;
        }
        if (isset($request->search) && $request->search != 'null') {
            $customers = Customer::orderBy('created_at', 'desc')->where('name', 'like', '%' . $request->search . '%')->orWhere('phone', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->paginate($pagination);
        } else {
            $customers = Customer::orderBy('created_at', 'asc')->paginate($pagination);
        }


//        $customers  = Customer::latest()->get();

        return CustomerResource::collection($customers);

    }
    
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customerList(Request $request)
    {
        if (isset($request->paginate) && $request->paginate != 'null') {
            $pagination = $request->paginate;
        } else {
            $pagination = 10;
        }
        if (isset($request->search) && $request->search != 'null') {
            $customers = Customer::orderBy('customers.id','desc')
            ->leftjoin('customer_package','customers.id','customer_package.customer_id')
            ->leftjoin('subscription_product','customer_package.package_id','subscription_product.id')
            ->select('customers.*','subscription_product.price')
            ->where('name', 'like', '%' . $request->search . '%')->orWhere('phone', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->paginate($pagination);
        } else {
            $customers = Customer::orderBy('customers.id','desc')
            ->leftjoin('customer_package','customers.id','customer_package.customer_id')
            ->leftjoin('subscription_product','customer_package.package_id','subscription_product.id')
            ->select('customers.*','subscription_product.price')
            ->paginate($pagination);
        }
        
        $list  = Customer::orderBy('customers.id','desc')
            ->leftjoin('customer_package','customers.id','customer_package.customer_id')
            ->leftjoin('subscription_product','customer_package.package_id','subscription_product.id')
            ->select('customers.*','subscription_product.price')
            ->get();
        
        return view('admin.customer.list',[
          'customers' => $customers,
          'country'   => Country::all(),
          'list'      => $list
        ]);
 
    }
    
     public function customerListSuspended (Request $request, $id) {
        
        $customerInfo = Customer::where('id', $id)->first();
        if(!empty($customerInfo)) {
            $customerInfo->status = $request->status;
            $customerInfo->save();
        }
        
        return 201;
    }
    
    public function onboardCustomer(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'company'             => 'required',
            'email'               => 'required|string|unique:customers,email',
            'photo'               => 'required',
            'address'             => 'required',
            'country'             => 'required',
            'zip_code'            => 'required',
            'confirm_password'    => 'required',
            'password'            => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password'    => 'min:6'
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $cvd ='';
        
        if ($request->hasfile('photo')) {
            $cvInfo = $request->photo;
            $cvd   =  date('ymdh') . rand(0,99999) . $cvInfo->getClientOriginalName();
            $cvInfo->move(public_path() . $this->documentDirectoryCustomer, $cvd);
      
        }
 
        $user = Customer::create([
            'first_name' => $request->company,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'status'     => 1,
            'photo'      => $cvd,
        ]);
        
        if($user->id) {
            $saveData = new CustomerAddress();
            $saveData->email     = $request->email;
            $saveData->address   = $request->address;
            $saveData->phone     = $request->phone;
            $saveData->country   = $request->country;
            $saveData->city      = $request->city;
            $saveData->post_code = $request->zip_code;
            $saveData->customer_id = $user->id;
            $saveData->city_id = 52;
            $saveData->zone_id = 472;
            $saveData->area_id = 1062;
            $saveData->save();   
        }
     
        return response()->json([
            'msg'    => 'Add new record succssfully.',
            'status' => 200,
        ]);
      
    }

    
    public function onboardCustomerUpdate(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'company'             => 'required',
            'email'               => 'required|string',
            'address'             => 'required',
            'country'             => 'required',
            'zip_code'            => 'required',
            // 'confirm_password'    => 'required',
            // 'password'            => 'min:6|required_with:confirm_password|same:confirm_password',
            // 'confirm_password'    => 'min:6'
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $cvd ='';
        
        $customerInfo = Customer::where('id', $request->id)->first();
        
        if ($request->hasfile('photo')) {
            $cvInfo = $request->photo;
            $cvd   =  date('ymdh') . rand(0,99999) . $cvInfo->getClientOriginalName();
            $cvInfo->move(public_path() . $this->documentDirectoryCustomer, $cvd);
            
            $customerInfo->photo  = $cvd;
      
        }
 
        $customerInfo->first_name = $request->company;
        $customerInfo->email      = $request->email;
        $customerInfo->phone      = $request->phone;
        
        if(!empty($customerInfo->password)) {
            $customerInfo->password   = Hash::make($request->password);
        }
        
       
        if($customerInfo->save) {
            $saveData =  CustomerAddress::where('customer_id',$request->id )->first();
            $saveData->email     = $request->email;
            $saveData->address   = $request->address;
            $saveData->phone     = $request->phone;
            $saveData->country   = $request->country;
            $saveData->city      = $request->city;
            $saveData->post_code = $request->zip_code;
            $saveData->save();   
        }
     
        return response()->json([
            'msg'    => 'Add  record is updated.',
            'status' => 200,
        ]);
      
    }
    
    public function inviteCompany(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'               => 'required|string',
        ]);
  
         if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $data = array(
            'name'  => "Shifti",
            'name'  => "Shifti",
            'email' => $request->email
        );
        
        Mail::send(['html' => 'emails.invite_mail'], compact('data'), function($message) use ($data) {
            $message->to($data['email'], 'Invite Signup shifti')->subject
            ('Apply for job');
            $message->from('shifti@mamundevstudios.com','Shifti');
        });  
        
        return response()->json([
            'msg'    => 'New company invite successfully.',
            'status' => 200,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        //  return $request->all();
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|digits:11|unique:customers',
            'password' => 'required',
        ]);
     

        $data = $request->except('photo');
        $data['updated_by'] = auth()->user()->id;
        $data ['password'] = Hash::make($request->password);
        // $image = $request->file('photo');

        if ($request->photo != "") {
            $name = $request->name . '-' . str_replace([' ', ':'], '-', Carbon::now());
            $path = 'images/uploads/customers/';
            $file = $request->photo;
            $height = 300;
            $width = 300;
            $data['photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        } else {
            $data['photo'] = null;
        }


        $customer = Customer::create($data);
        return response()->json(['msg' => 'Customer Created Successfully']);


        return response()->json([
            'status' => 200,
            'message' => 'Customer Added Successfully!',
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*try {
            $customer = Customer::with('admin')->findOrFail($id);
            return new CustomerResource($customer);
            // return  response()->json($banner);
        } catch (ModelNotFoundException) {
            return response()->json(['msg' => 'Data Not Found']);
        }*/
    }
    
     public function viewcustomerList(Request $request) 
     {
        $customer = Customer::leftjoin('customer_package','customers.id','customer_package.customer_id')
            ->leftjoin('subscription_product','customer_package.package_id','subscription_product.id')
            ->leftjoin('payment_history','customers.id','payment_history.customer_id')
            ->select('customers.*','subscription_product.price','payment_history.status as paymentStatus')
            ->where('customers.id', $request->id)
            ->first();
     
        return view('admin.customer.view-list',[
            'customer' =>$customer,
        ]);
            
    }
    
    public function editcustomerList(Request $request) 
     {
        $customer = Customer::findOrFail($request->id);
     
        $customerAddress = CustomerAddress::where('customer_id', $request->id)->first();
     
        return view('admin.customer.edit_customer',[
            'customer'          => $customer,
            'customerAddress'  => $customerAddress,
            'country'          => Country::all(),
        ]);
            
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $this->validate($request, [
            'name'         => 'required',
            'email'         => 'required',
            'phone'         => 'required',
            'password'       => 'required',
        ]);

        $height = 300;
        $width = 300;
        $customer = Customer::findOrFail($id);

        $data = $request->except('photo');
        $data['updated_by'] = auth()->user()->id;
        if ($request->photo) {
            $name = $request->name . '-' . str_replace([' ', ':'], '-', Carbon::now());
            $path = 'images/uploads/customers/';
            if ($customer->photo !=null){
                Helper::unlinkImage($path, $customer->photo);
            }
            $file = $request->photo;
            $data['photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        } else {
            $data['photo'] = $customer->photo;
        }
        $customer->update($data);
        return response()->json(['msg' => 'Customer Updated Successfully']);
    }

    
}
