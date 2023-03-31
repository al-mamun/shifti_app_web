<?php

namespace App\Http\Controllers\API\Backend\SMS;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backend\SMS\SMSListResource;
use App\Jobs\SendSMS;
use App\Models\Customer;
use App\Models\SMS;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SMSController extends Controller
{

    public static function sendSMS($number, $text, $customer_id = null , $comment = null)
    {
        $api_key = 'J8HZyp82oe7DHoIA';
        $secret_key = '41acb6a8';
        $caller_id = 'arpanbd';
       // $sent_sms = Http::get('https://smpp.ajuratech.com:7790/sendtext?apikey='.$api_key.'&secretkey='.$secret_key.'&callerID='.$caller_id.'&toUser='.$number.'&messageContent='.$text);
        $sent_sms = Http::get( 'http://smpp.ajuratech.com:7788/sendtext?apikey='.$api_key.'&secretkey='.$secret_key.'&callerID='.$caller_id.'&toUser='.$number.'&messageContent='.$text);
        $sent_sms = json_decode($sent_sms, true);

        $sms_data['status'] = $sent_sms['Status'];
        $sms_data['status_text'] = $sent_sms['Text'];
        $sms_data['message_id'] = $sent_sms['Message_ID'];
        $sms_data['message_text'] = $text;
        $sms_data['number'] = $number;
        $sms_data['customer_id'] = $customer_id;
        SMS::create($sms_data);

        return 'sms sent successfully';
    }


    public function check()
    {
        return self::sendSMS('01862555262', 'আপনার অর্ডার গ্রহণ করা হয়েছে।  ধন্যবাদ '.PHP_EOL.'- অর্পণ বিডি' );
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getSMSBalance(): Response
    {
        return Http::get('https://smpp.ajuratech.com/portal/sms/smsConfiguration/smsClientBalance.jsp?client=arpanbd');
    }

    /**
     * @return JsonResponse
     */
    public function getSMSContacts(): JsonResponse
    {
        $start_date = Carbon::now()->subDays(7)->format('Y-m-d');
        $endDate = Carbon::now()->format('Y-m-d');
        $customer = Customer::whereBetween('created_at',[ $start_date.' 00:00:00', $endDate.' 23:59:59'] )->count();
        $sms_sent_today = SMS::where('created_at',  $endDate.' 23:59:59')->count();
        return response()->json(['this_week_contact'=>$customer, 'sms_sent_today'=>$sms_sent_today]);
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $smses = SMS::orderBy('created_at', 'desc')->paginate(10);
        return SMSListResource::collection($smses);
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
}
