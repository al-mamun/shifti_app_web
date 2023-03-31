<?php

namespace App\Http\Controllers\API\Frontend\ContactUs;

use App\Http\Controllers\Controller;
use App\Mail\ContactUsEmail;
use App\Mail\NewsLetterEmail;
use App\Models\ContactUsMail;
use App\Models\NewsLetter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactUsController extends Controller
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
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);

        $data = $request->except('news_letter');
        $data['type'] = 1;
        ContactUsMail::create($data);

        if ($request->input('news_letter')) {
            $news_letter_data['email'] = $request->input('email');
            $news_letter_data['status'] = 1;
            $news_letter = NewsLetter::where('email', $request->input('email'))->first();
            if (!$news_letter) {
                NewsLetter::create($news_letter_data);
                Mail::to([$request->input('email'), env('APP_EMAIL')])->send(new NewsLetterEmail());
            }
        }
        $emailData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
        ];
        Mail::to([$request->input('email'), env('APP_EMAIL')])->send(new ContactUsEmail($emailData));
        return response()->json(['msg' => 'Your Message Sent Successfully']);

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
     * @param Request $request
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
}
