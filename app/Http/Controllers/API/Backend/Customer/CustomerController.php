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


class CustomerController extends Controller
{
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
            $customers = Customer::orderBy('created_at', 'desc')->where('name', 'like', '%' . $request->search . '%')->orWhere('phone', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->paginate($pagination);
        } else {
            $customers = Customer::orderBy('created_at', 'asc')->paginate($pagination);
        }

        return view('admin.customer.list',[
          'customers'=>$customers,
        ]);
 
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        try {
            $customer = Customer::with('admin')->findOrFail($id);
            return new CustomerResource($customer);
            // return  response()->json($banner);
        } catch (ModelNotFoundException) {
            return response()->json(['msg' => 'Data Not Found']);
        }
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
