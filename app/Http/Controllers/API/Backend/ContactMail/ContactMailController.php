<?php

namespace App\Http\Controllers\API\Backend\ContactMail;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\ContactUsEmail\ContactUsEmailDetailsResource;
use App\Http\Resources\Backend\ContactUsEmail\ContactUsEmailListResource;
use App\Mail\AdminSendToUserMail;
use App\Mail\ContactUsEmail;
use App\Models\ContactUsMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;

class ContactMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
       $mails = ContactUsMail::withoutTrashed()->latest()->where('type', 1)->paginate(20);
       return ContactUsEmailListResource::collection($mails);
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index_sent(): AnonymousResourceCollection
    {
       $mails = ContactUsMail::withoutTrashed()->latest()->where('type', 2)->paginate(20);
       return ContactUsEmailListResource::collection($mails);
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index_trash(): AnonymousResourceCollection
    {
       $mails = ContactUsMail::onlyTrashed()->latest()->paginate(20);
       return ContactUsEmailListResource::collection($mails);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ContactUsEmailDetailsResource
     */
    public function show(int $id): ContactUsEmailDetailsResource
    {
        $emailDetails = ContactUsMail::findOrfail($id);
        return new ContactUsEmailDetailsResource($emailDetails);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send_email(Request $request)
    {
//       $extension = explode('/', mime_content_type($request->attachment))[1];


        $data = $request->except(['attachment', 'id']);
        $data['type'] = 2;
        $data['status'] = 1;
        if ($request->exists('id')) {
            $contact_mail = ContactUsMail::findOrFail($request->input('id'));
            if ($contact_mail){
                $data['name']= $contact_mail->name;
                $data['phone']= $contact_mail->phone;
                $data['email']= $contact_mail->email;
            }
        }
        $mail = ContactUsMail::create($data);
        $emailData = [
            'name' => $request->input('name') ?? $mail->name,
            'email' =>   $request->exists('email') && $request->input('email') != null ? $request->input('email') : $mail->email,
            'phone' => $request->input('phone') ?? $mail->phone,
            'message' => $request->input('message'),
            'subject' => $request->input('subject') ?? 'Orpon BD',
            'attachment' => $request->input('attachment') ?? null,
            'extension' => $request->exists('attachment')? explode('/', mime_content_type($request->attachment))[1]: null,
        ];

        Mail::to([$emailData['email'], env('APP_EMAIL')])->send(new AdminSendToUserMail($emailData));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $email = ContactUsMail::findOrfail($id);
        $email->delete();
        return response()->json(['msg'=>'Email Deleted Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function restore_email(int $id): JsonResponse
    {
        $email = ContactUsMail::withTrashed()->findOrfail($id);
        $email->restore();
        return response()->json(['msg'=>'Email restored Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function permanently_delete_email(int $id): JsonResponse
    {
        $email = ContactUsMail::withTrashed()->findOrfail($id);
        $email->forceDelete();
        return response()->json(['msg'=>'Email Deleted Permanently Successfully']);
    }

}
