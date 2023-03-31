<?php

namespace App\Http\Controllers\API\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Productpage;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $productPage = ProductPage::first();
         return view('admin.settings.productpage.create',compact('productPage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = $request->validate([
            'title'      => 'required',
            'banner'      => 'required|mimes:jpeg,jpg,png|max:5000',
            'url'         => 'required',
            'button_text' => 'required',
            'content'    => 'required',
        ]);
         $productPage = ProductPage::first();
         
          if($banner = $request->file(['banner'])){
             $destinationPath = public_path('images/banner/');
             $bannerImage    = date('YmDHis').".".$banner->getClientOriginalExtension();
             $banner->move($destinationPath, $bannerImage);
             $productPage['banner']=$bannerImage;

         }
        
        $productPage->title       = $request->title;
        $productPage->url         = $request->url;
        $productPage->button_text = $request->button_text;
        $productPage->content     = $request->content;

        if($productPage->save()) {
            return redirect()->back()->with('success','save succesfully');   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings\Productpage  $productpage
     * @return \Illuminate\Http\Response
     */
    public function show(Productpage $productpage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings\Productpage  $productpage
     * @return \Illuminate\Http\Response
     */
    public function edit(Productpage $productpage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings\Productpage  $productpage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Productpage $productpage)
    {
       $this->validate($request, [
            'title' => 'required',
            'banner' => 'required|mimes:jpeg,jpg,png|max:5000',
            'url' => 'required',
            'email' => 'required',
            'button_text' => 'required',
            'content' => 'required',
        ]);
        $productPage = ProductPage::first();
         if($banner=$request->file(['banner'])){
            $destinationPath = public_path('images/banner/');
            $bannerImage    = date('YmDHis').".".$banner->getClientOriginalExtension();
            $banner->move($destinationPath, $bannerImage);
            $productPage['banner']=$bannerImage;

        }
        
        $productPage->title = $request->title;
        $productPage->url = $request->url;
        $productPage->button_text = $request->button_text;
        $productPage->content = $request->content;
        $productPage->save();
         return redirect()->back()->with('success','save succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings\Productpage  $productpage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Productpage $productpage)
    {
        //
    }
}
