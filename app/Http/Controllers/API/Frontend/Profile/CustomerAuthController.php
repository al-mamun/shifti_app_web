<?php

namespace App\Http\Controllers\Api\Frontend\Profile;

use App\Helpers\Helper;
use App\Http\Controllers\API\Backend\SMS\SMSController;
use App\Http\Resources\Frontend\Customer\CustomerDetailsResource;
use App\Mail\ForgetPasswordMail;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerBilling;
use App\Models\Cart;
use App\Models\ProductSubscription;

use App\Models\CustomerPasswordResetOtp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\CustAuthResource;
use Illuminate\Http\JsonResponse;
use Session;
use App\Models\Product;
class CustomerAuthController extends Controller
{
    protected $documentDirectory  = "/upload/customer/";
    
    public function CustRegister(Request $request)
    {
        
       
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|unique:customers,email',
            'password' => 'required|string|min:8',
        ]);
        
       
        $user = Customer::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
        ]);
    
        if($user){
            
            $saveData = new CustomerAddress();
            $saveData->email     = $request->get('email');
            $saveData->address   = $request->get('address');
            $saveData->phone     = $request->get('phone');
            $saveData->country   = $request->get('country');
            $saveData->city      = $request->get('city');
            $saveData->post_code = $request->get('zip_code');
            $saveData->customer_id = $user->id;
            $saveData->city_id = 52;
            $saveData->zone_id = 472;
            $saveData->area_id = 1062;
            $saveData->save();
        }
        $token = $user->createToken('token')->plainTextToken;
        $response = [
            'success' => true,
            'user' => $user,
            'msg' => "Registration Successfully!",
            'token' => $token
        ];
        return response()->json($response, 200);

    }

    public function CustValidation(Request $request)
    {
        $condition = array();
        $data = "";
        if ($request->phone) {
            $data = $request->phone;
            $phonenumber = str_replace('+88', '', $request->phone);
            $result = substr($request->phone, 0, 2);
            if ($result == 88) {
                $phonenumber = ltrim($request->phone, 88);
            }
            $condition = ['phone' => $phonenumber];

        }
        if ($request->email) {
            $data = $request->email;
            $condition = ['email' => $request->email];
        }

        $customer = Customer::where($condition)->count();

        return response()->json([
            'response' => $customer,
            'datamsg' => $data
        ]);

    }

    public function CustLogin(Request $request)
    {
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
       
        $email_status = Customer::where('email', $request->email)
            ->whereIn('status', [1, 3])
            ->first();
       
        if (!is_null($email_status)) {

            if (Hash::check($request->password, $email_status->password)) {
                
                $customer = Customer::where("email", $request->email)->orWhere('phone', $request->email)->first();
                $token = $customer->createToken('token')->plainTextToken;
                
                session::put('token', $token);
                session::put('customer_id', $customer->id);
                // $customer->token =  $customer->createToken($customer->email)->plainTextToken;
                // return new CustAuthResource($customer) ;
                
                                
              
                return response()->json(
                    [
                        "status" => 200, 
                        "success" => true,
                        "message" => "You have logged in successfully",
                        "user" => $customer,
                        'token' => $token,
                        'customer_id' =>  $customer->id,
                    ]);

            } else {
                return response()->json(["status" => "failed", "success" => false, "message" => "Unable to login. Incorrect password."]);
            }
        } else {
            
            $email_status = Customer::where('email', $request->email)
                ->first();
            
            if($email_status->status == 2) {
                return response()->json(["status" => "failed", "success" => false, "message" => "Your account suspened."]);
            }
            return response()->json(["status" => "failed", "success" => false, "message" => "Unable to login. Credential doesn't Match."]);
        }


    }

    /**
     * @param $id
     * @return CustomerDetailsResource
     */
    public function CustomerProfileData($id)
    {
        $authUser = Customer::where('id', $id)->first();
        
        
        return  response()->json($authUser);
    }
    
    /**
     * @param $id
     * @return CustomerDetailsResource
     */
    public function CustomerProfileDataAfterLogin()
    {
        $authUser = Customer::where('id', auth()->user()->id)->first();
        
        
        return  response()->json($authUser);
    }
    /**
     * @param $id
     * @return CustomerDetailsResource
     */
    public function CustomerAddressData()
    {
        $authUser = CustomerAddress::where('customer_id', auth()->user()->id)->first();
         
        return  response()->json($authUser);
    }
    
    public function CustomerBillingInformation() {
        $authUser = CustomerBilling::where('customer_id', auth()->user()->id)->first();
         
        return  response()->json($authUser);
    }
    public function customerLogout(Request $request)
    {
        $request->session()->flush();
     
        // //  return auth()->user();
        // $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout Successfully']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function check_auth(Request $request): JsonResponse
    {
        
        $user = auth()->user()->id;
    
        $expire = Carbon::create($request->input('expire'))->setTimezone('Asia/Dhaka');
         $auth = [
             'auth' => true,
             'customer_id' => $user,
         ];
        return response()->json($auth);
    }
    
      /**
     * @throws ValidationException
     */
    public function customerBillingDataUpdate(Request $request)
    {
        
       
        $customer = CustomerBilling::where('customer_id', auth()->user()->id)->first();
        if(!empty($customer)){
            
            if(!empty($request->cardNumber)){
               $customer->card_number      = $request->cardNumber; 
            }
            if(!empty($request->name)){
               $customer->name      = $request->name; 
            }
            if(!empty($request->zip)){
               $customer->zip_code      = $request->zip; 
            }
            if(!empty($request->date)){
               $customer->expiration_date      = $request->date; 
            }
            if(!empty($request->cvv)){
               $customer->cvv      = $request->cvv; 
            }
          
        } else {
            
            $customerInfo = new CustomerBilling();
            $customerInfo->customer_id      = auth()->user()->id;
            $customerInfo->card_number      = $request->cardNumber;
            $customerInfo->name             = $request->name;
            $customerInfo->expiration_date  = $request->date;
            $customerInfo->zip_code         = $request->zip;
            $customerInfo->cvv              = $request->cvv;
            $customerInfo->save(); 
            
        }
        return response()->json(['msg' => 'Updated Successfully']);  
         
    }
    
    
    /**
     * @throws ValidationException
     */
    public function customerPasswordUpdate(Request $request)
    {
        
        $customer = Customer::findOrFail(auth()->user()->id);
        
        if($request->input('newPassword') != $request->input('repeatPassword')){
            return response()->json(['msg' => "Password and confirm password don't miss",
                'status' => 401
             ]);
        }
         if (Hash::check($request->currentPassword, $customer->password)) {

            
        }else {
          return response()->json(['msg' => "Current password don't miss",
            'status' => 401
         ]);
        }
      
     
        
        if(!empty($customer)) {
            $customer->password = Hash::make($request->input('newPassword'));
            $customer->save(); 
        }
        
        return response()->json(['msg' => 'Successfully changed password.',
            'status' => 201
        ]);
    }
    /**
     * @throws ValidationException
     */
    public function updateCustomerInformation(Request $request)
    {
        
       
        $customer = Customer::findOrFail(auth()->user()->id);
        
        if(!empty($request->get('email'))) {
            
            $customer1 = Customer::where('email', $request->get('email'))
                ->whereNotIn('id', [auth()->user()->id])
                ->first();
                
            if(!empty($customer1)) {
                 return response()->json(['msg' => 'Current email used another account',
                    'status' => 401
                 ]);
            }
          
        }

        
        if ($request->exists('password')) {
            
            // $this->validate($request, [
            //     'first_name' => ['required', 'string', 'max:255'],
            //     'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            //     'password' => ['string', 'min:8'],
            // ]);
        } else {
           
        }

   
        // $data['first_name'] = $request->input('first_name');
        // $data['last_name'] = $request->input('last_name');
        // $data['email'] = $request->input('email');
        // $data['phone'] = $request->input('phone');
      
        
        // $data['password'] = $request->exists('password') && strlen($request->input('password')) > 7 ? Hash::make($request->input('password')) : $customer->password;

        // if ($request->photo) {
        //     $path = 'images/uploads/customers/';
        //     $height = 800;
        //     $width = 800;
        //     $file = $request->photo;
        //     $name = Str::slug($customer->name, '-') . '-' . Str::slug(Carbon::now(), '-');
        //     $data['photo'] = Helper::uploadImage($name, $height, $width, $path, $file);
        // } else {
        //     $data['photo'] = null;
        // }
        if(!empty($request->get('first_name'))) {
            $customer->first_name = $request->get('first_name');
        }
        if(!empty($request->get('last_name'))) {
            $customer->last_name = $request->get('last_name');
        }
        
        if(!empty($request->get('email'))) {
            $customer->email = $request->get('email');
        }

        
        if(!empty($request->get('phone'))) {
            $customer->phone = $request->get('phone');
        }

        $cvd ='';
    
            if ($request->hasfile('file')) {
                
                $cvInfo =$request->file;
                $cvd   =  date('ymdh') . rand(0,99999) . $cvInfo->getClientOriginalName();
                $cvInfo->move(public_path() . $this->documentDirectory, $cvd);
                $customer->photo = $cvd;
            }
        
        $customer->save();
        $checkExit = CustomerAddress::where('customer_id', auth()->user()->id)->first();
        
        if(!empty($checkExit)) {
            if(!empty($request->get('email'))) {
                $checkExit->email = $request->get('email');
            }
            if(!empty($request->get('address'))) {
                $checkExit->address = $request->get('address');
            }
            if(!empty($request->get('phone'))) {
                $checkExit->phone = $request->get('phone');
            }
            if(!empty($request->get('country'))) {
                $checkExit->country = $request->get('country');
            }
            if(!empty($request->get('city'))) {
                $checkExit->city = $request->get('city');
            }
            
            if(!empty($request->get('zip_code'))) {
                $checkExit->post_code = $request->get('zip_code');
            }
            
            
     
            $checkExit->save();
            
        } else {
            $saveData = new CustomerAddress();
            $saveData->email     = $request->get('email');
            $saveData->address   = $request->get('address');
            $saveData->phone     = $request->get('phone');
            $saveData->country   = $request->get('country');
            $saveData->city      = $request->get('city');
            $saveData->post_code = $request->get('zip_code');
            $saveData->customer_id = auth()->user()->id;
            $saveData->city_id = 52;
            $saveData->zone_id = 472;
            $saveData->area_id = 1062;
            $saveData->save();
        }
        return response()->json(['msg' => 'Updated Successfully',
                    'status' => 201]);

    }

    /**
     * @throws ValidationException
     */
    public function forgetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $otp = rand(100000, 999999);


        if (is_numeric($request->input('email'))) { //number
        
            $customer = Customer::where('phone', $request->email)->first();
            
            if ($customer){
                $forget_password_data = [
                    'otp'              => $otp,
                    'customer_id'      => $customer->id,
                    'contact'          => $request->email,
                    'number_or_email'   => 'number',
                    'expire_at'       => Carbon::now()->addMinutes(5),
                ];
                
                CustomerPasswordResetOtp::create($forget_password_data);
                $text = 'Your password Reset OTP is '.$otp.'. Valid till 5min. -Orpon BD';
                // SMSController::sendSMS($request->email, $text );
                return response()->json(['msg'=>'OTP sent to your number please check it']);
            }else{
                throw ValidationException::withMessages(['email' => 'Sorry! No User found']);
            }
        } else {//email

            $customer = Customer::where('email', $request->email)->first();
            if ($customer){
                $forget_password_data = [
                    'otp' => $otp,
                    'customer_id' => $customer->id,
                    'contact' => $request->email,
                    'number_or_email' => 'email',
                    'expire_at' => Carbon::now()->addMinutes(5),
                ];
                CustomerPasswordResetOtp::create($forget_password_data);
                
                Mail::to($request->email)->send(new ForgetPasswordMail($otp));
                return response()->json(['msg'=>'OTP sent to your mail please check it']);
            }else{
                throw ValidationException::withMessages(['email' => 'Sorry! No User found']);
            }

        }
        return $request->all();
    }
    
     /**
     * @throws ValidationException
     */
    public function forgetPasswordsendEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $otp = rand(100000, 999999);


        if (is_numeric($request->input('email'))) { //number
        
            $customer = Customer::where('phone', $request->email)->first();
            
            if ($customer){
                $forget_password_data = [
                    'otp'              => $otp,
                    'customer_id'      => $customer->id,
                    'contact'          => $request->email,
                    'number_or_email'   => 'number',
                    'expire_at'       => Carbon::now()->addMinutes(5),
                ];
                
                CustomerPasswordResetOtp::create($forget_password_data);
                $text = 'Your password Reset OTP is '.$otp.'. Valid till 5min. -Orpon BD';
                // SMSController::sendSMS($request->email, $text );
                return response()->json(['msg'=>'OTP sent to your number please check it']);
                
            }else{
                throw ValidationException::withMessages(['email' => 'Sorry! No User found']);
            }
        } else {//email

            $customer = Customer::where('email', $request->email)->first();
            if ($customer){
                $forget_password_data = [
                    'otp' => $otp,
                    'customer_id' => $customer->id,
                    'contact' => $request->email,
                    'number_or_email' => 'email',
                    'expire_at' => Carbon::now()->addMinutes(5),
                ];
                CustomerPasswordResetOtp::create($forget_password_data);
                
                $data = [
                    'name'      =>"Shifti",
                    'fullName'  => "Raton Kumar",
                    'email'     => 'ratonkumarcse@gmail.com',
                    'message'   => "good",
                    'otp'       => $otp,
                ];
                
              
                
                Mail::send(['html' => 'emails.password_reset'], compact('data'), function($message) use ($data) {
                     $message->to($data['email'], 'Shifti')->subject
                        ('Password Recovery');
                     $message->from('shifti@mamundevstudios.com','Shifti');
                });
                    
                    return response()->json([
                        'msg'=>'Sent reset link to your mail please check it',
                        'status' => 200
                    ]);
                
            }else{
                return response()->json([
                    'msg'=>'Sorry! no customer found',
                    'status' => 400
                ]);

             
            }

        }
        return $request->all();
    }

    /**
     * @throws ValidationException
     */
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'email'=> 'required',
            'otp'=>'required|digits:6',
            'password'=>'required|confirmed',
        ]);

        $otp_details = CustomerPasswordResetOtp::where('contact', $request->input('email'))->latest()->first();
        if ($otp_details){
            if (Carbon::create($otp_details->expire_at)->greaterThan(Carbon::now()) ){
                if ($request->input('otp') == $otp_details->otp){
                    $customer = Customer::findOrFail($otp_details->customer_id);
                    if ($customer){
                        $password_data['password'] = Hash::make($request->input('password'));
                        $customer->update($password_data);
                        $otp_details->delete();

                        $token = $customer->createToken('token')->plainTextToken;
                        // $customer->token =  $customer->createToken($customer->email)->plainTextToken;
                        // return new CustAuthResource($customer) ;
                        return response()->json(
                            [
                                "status" => 200, "success" => true,
                                "message" => "You have logged in successfully",
                                "user" => $customer,
                                'token' => $token,
                                'msg' => 'Password Reset Successful'
                            ]);

                       // return response()->json(['msg'=>'Password Reset Successful']);
                    }
                }else{
                    throw ValidationException::withMessages(['otp' => 'Sorry! OTP not match']);
                }
            }else{
                throw ValidationException::withMessages(['otp' => 'Sorry! OTP expired']);
            }
        }else{
            throw ValidationException::withMessages(['email' => 'Sorry! no user found']);
        }
        return $request->all();
    }
    
      /**
     * @throws ValidationException
     */
    public function passwordChange(Request $request)
    {
         $this->validate($request, [
            'otp_check'=>'required|digits:6',
        ]);
        
        $passValue = $request->form_Value;
        
        $passwordInfo = CustomerPasswordResetOtp::where('otp', $request->otp_check)->first();
       
 
       
        $otp_details = CustomerPasswordResetOtp::where('contact', $passwordInfo->contact)->latest()->first();
        
        if ($otp_details){
            if (Carbon::create($otp_details->expire_at)->greaterThan(Carbon::now()) ){
                if ($request->otp_check == $otp_details->otp){
                    
                    $customer = Customer::findOrFail($otp_details->customer_id);
                    if ($customer){
                        $password_data['password'] = Hash::make($passValue['password']);
                        $customer->update($password_data);
                        $otp_details->delete();

                        $token = $customer->createToken('token')->plainTextToken;
                   
                        return response()->json(
                            [
                                "status" => 200,
                                "success" => true,
                                "message" => "You have logged in successfully",
                                "user" => $customer,
                                'token' => $token,
                                'msg' => 'Password Reset Successful'
                            ]);

                    }
                }else{
                    return response()->json([
                        'msg'=>'Sorry! OTP not match',
                        'status' => 400
                    ]);
                    // throw ValidationException::withMessages(['otp' => 'Sorry! OTP not match']);
                }
            }else{
                    return response()->json([
                        'msg'=>'Sorry! OTP expired',
                        'status' => 400
                    ]);
                    
                throw ValidationException::withMessages(['otp' => 'Sorry! OTP expired']);
            }
        }else{
            return response()->json([
                'msg'=>'Sorry! no user found',
                'status' => 400
            ]);
           
        }
        return $request->all();
    }

 /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function addTOCart(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
        ]);
        
        $cart_exits = Cart::where('customer_id', auth()->user()->id)->where('product_id', $request->input('product_id'))->first();
        
        if ($cart_exits) {
//                if ($request->input('product_type_id') == 2) {
                $total_quantity =  $cart_exits->quantity +1;
                $product = Product::select('stock', 'id')->findOrFail($request->input('product_id'));
                if ($product['stock'] >= $total_quantity ) {
                    $cart['quantity'] =$total_quantity;
                }else{
                    throw ValidationException::withMessages(['msg'=>'Sorry Product Stock out!']);
                }

//                }else{
//                    $cart['quantity'] = $cart_exits->quantity + 1;
//                }
            $cart_exits->update($cart);
            return response()->json(['msg' => 'Cart Updated Successfully']);
        }else{
            $product = Product::select('stock', 'id')->findOrFail($request->input('product_id'));
            
           
                $cart['customer_id']      = auth()->user()->id;
                $cart['product_id']       = $request->input('product_id');
                $cart['subscriber_id']    = 0;
                $cart['quantity']         = 1;
                $cart['product_type_id']  = 1;
                $cart['type']             = $request->type;
                $saved_cart = Cart::create($cart);
                return response()->json(['msg' => 'Product Added to Cart Successfully']);
            
        }
        
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function subcraptionReqeust(Request $request)
    {
        $this->validate($request, [
            'product_id'    => 'required',
            'subscriber_id' => 'required',
        ]);
        $array = explode('_',$request->subscriber_id);
                
            $subscriber_id= $array[0];
            $type     = $array[1];
                
        $cart_exits = Cart::where('customer_id', auth()->user()->id)
            ->where('product_id', $request->input('product_id'))
            ->where('subscriber_id',$subscriber_id)
            ->where('type', $request->type)
            ->first();
            
        $serviceFee = 25.50;
        $numberOfUser = 0;
        
        if ($cart_exits) {
                
            $cartExist =Cart::find($cart_exits->id)->delete();
            
            $product = Product::select('stock', 'id')->findOrFail($request->input('product_id'));
            
            $productSubcription = ProductSubscription::where('id', $subscriber_id)->first();
            
            
            if(!empty($productSubcription)) {
                $price = $productSubcription->price;
                
                $numberOfUser = $request->number_of_user;
                if($type == 1) {
                    
                 
                    $price = round( (((($productSubcription->price * 12)/100)*90))* $request->number_of_user,2);
                    $serviceFee =  round((((25.50 * 12)/100)*90),2);
                }  else {
                    $price = round(( $productSubcription->price * $request->number_of_user ), 2);
                }
                
            }
             
            $cart['customer_id']      = auth()->user()->id;
            $cart['product_id']       = 1101;
            $cart['subscriber_id']    = $subscriber_id;
            $cart['quantity']         = 1;
            $cart['product_type_id']  = 1;
            $cart['type']             = $request->type;
            $cart['price']            = $price;
            $cart['service_charge']   = $serviceFee;
            $cart['user_number']      = $numberOfUser;
            $saved_cart = Cart::create($cart);
           
            return response()->json(['msg' => 'Product Added to Cart Successfully']);
        }else{
           
                $product = Product::select('stock', 'id')->findOrFail($request->input('product_id'));
                
                $productSubcription = ProductSubscription::where('id', $subscriber_id)->first();
                
                if(!empty($productSubcription)) {
                    $price = $productSubcription->price;
                    $numberOfUser = $request->number_of_user;
                    if($type == 1) {
                        
                        $price = round( (((($productSubcription->price * 12)/100)*90))* $request->number_of_user,2);
                        $serviceFee =  round((((25.50 * 12)/100)*90),2);
                    } else {
                        $price = round(( $productSubcription->price * $request->number_of_user ), 2);
                    }
                }
                 
                $cart['customer_id']      = auth()->user()->id;
                $cart['product_id']       = 1101;
                $cart['subscriber_id']    = $subscriber_id;
                $cart['quantity']         = 1;
                $cart['product_type_id']  = 1;
                $cart['type']             = $request->type;
                $cart['price']            = $price;
                $cart['service_charge']   = $serviceFee;
                $cart['user_number']      = $numberOfUser;
                $saved_cart = Cart::create($cart);
               
                return response()->json(['msg' => 'Product Added to Cart Successfully']);
            
        }
        
    }
}
