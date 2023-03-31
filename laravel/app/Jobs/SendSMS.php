<?php

namespace App\Jobs;

use App\Http\Controllers\API\Backend\SMS\SMSController;
use App\Models\SMS;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $message, $phone;

    public function __construct($phone, $message)
    {
       $this->phone = $phone;
       $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $api_key = 'J8HZyp82oe7DHoIA';
//        $secret_key = '41acb6a8';
//        $caller_id = 'arpanbd';
//        $sent_sms = Http::get('https://smpp.ajuratech.com:7790/sendtext?apikey='.$api_key.'&secretkey='.$secret_key.'&callerID='.$caller_id.'&toUser='.$this->details['number'].'&messageContent='.$this->details['text']);
//        $sent_sms = json_decode($sent_sms, true);
//
//        $sms_data['status'] = $sent_sms['Status'];
//        $sms_data['status_text'] = $sent_sms['Text'];
//        $sms_data['message_id'] = $sent_sms['Message_ID'];
//        $sms_data['message_text'] = $this->details['text'];
//        $sms_data['number'] = $this->details['number'];
//        $sms_data['customer_id'] = $this->details['customer_id'];
//        SMS::create($sms_data);

        SMSController::sendSMS($this->phone, $this->message);
    }
}
