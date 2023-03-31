<?php

namespace App\Http\Controllers\API\Backend\Country;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\Country\CountyListResource;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CountryControler extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ini_set('max_execution_time', 1800);
//       $countries = Http::get('https://countriesnow.space/api/v0.1/countries');
//        $countries= json_decode($countries);
//       foreach ( $countries->data as $country){
//           echo $country->country;
//       }

        $countries = Http::get('https://restcountries.com/v3.1/all');
        $countries = json_decode($countries);

        foreach ($countries as $country){

            $data['name'] = $country->name->common ?? null;
            $data['short_name'] = $country->flag ?? null;
            $data['continents'] = $country->continents[0] ?? null;

            $path = 'images/uploads/flags/';
            $filename = Str::slug($country->name->common, '-').'.png';
            Image::make($country->flags->png)->save(public_path($path . $filename));
            $data['flags'] = $filename;
            $data['status'] = 1;

            Country::create($data);
        }
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
     * @param  \Illuminate\Http\Request  $request
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


    public function get_country_list()
    {
        $country = Country::orderBy('name', 'asc')->get();
        return CountyListResource::collection($country);
    }
}
