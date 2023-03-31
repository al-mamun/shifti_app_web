<?php

namespace App\Http\Controllers\API\Frontend\NewsLetter;

use App\Http\Controllers\Controller;
use App\Mail\NewsLetterEmail;
use App\Models\NewsLetter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FrontendNewsLetterController extends Controller
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $news_letter_data['email'] = $request->input('email');
        $news_letter_data['status'] = 1;
        $news_letter = NewsLetter::where('email', $request->input('email'))->first();
        if (!$news_letter) {
            NewsLetter::create($news_letter_data);
            Mail::to([$request->input('email'), env('APP_EMAIL')])->send(new NewsLetterEmail());
        }
        return response()->json(['msg'=>'You have successfully subscribed']);
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
     * @param Request $request
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
}
