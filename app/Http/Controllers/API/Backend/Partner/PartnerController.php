<?php

namespace App\Http\Controllers\API\Backend\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partnerLists = Partner::latest()->paginate();
        return view('admin.partner.index',[
           'partnerLists'=>$partnerLists
           ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.partner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'partner_name'  => 'required',
                'partner_icon'  => 'required|mimes:jpeg,jpg,png|max:5000',
            ]);
            $data = $request->all();
            if($icon=$request->file('partner_icon')){
                $destinationPath = public_path('images/partner');
                $iconImage    = date('YmDHis').".".$icon->getClientOriginalExtension();
                $icon->move($destinationPath, $iconImage);
                $data['partner_icon']=$iconImage;
    
            }
     
             Partner::create($data);
             return redirect('/admin/partner')->with('success',"Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partnerList = Partner::find($id);
        return view('admin.partner.edit',[
           'partnerList'=>$partnerList
           ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $this->validate($request, [
                'partner_name'  => 'required',
                'partner_icon'  => 'required|mimes:jpeg,jpg,png|max:5000',
            ]);
            $data = $request->all();
            if($icon=$request->file('partner_icon')){
                $destinationPath = public_path('images/partner');
                $iconImage    = date('YmDHis').".".$icon->getClientOriginalExtension();
                $icon->move($destinationPath, $iconImage);
                $data['partner_icon']=$iconImage;
    
            }
             $partner->update($data);
             return redirect('/admin/partner')->with('success',"Created Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect('/admin/partner')->with('success',"Created Successfully");
    }
}
