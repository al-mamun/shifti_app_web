<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\API\Backend\Order\OrderPriceCalculator;
use App\Http\Controllers\API\Backend\Transaction\TransactionController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class BkashController extends Controller
{

    private string $app_key = 'i72w8vq9b5w8kKXAnnePBssaWZ';
    private string $app_secret = '6FSoknZ5XRfboFKW7cEnJBKRoKitES39seqUCt1WUu7E6V3fPqJG';
    private string $username = '01406666198';
    private string $password = 'M6RM&iNiI;3';
    private string $base_url = 'https://checkout.pay.bka.sh/v1.2.0-beta';



    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        return view('payments.bkash.index');
    }

    /**
     * @return JsonResponse
     */
    public function generate_token(): JsonResponse
    {

        session()->forget('bkash_token');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'password' => $this->password,
            'username' => $this->username,
        ])->post($this->base_url . '/checkout/token/grant', [
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret,
        ]);
        session()->put('bkash_token', $response['id_token']);
        return response()->json(['success', true]);
    }


    /**
     * @param Request $request
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create_payment(Request $request)
    {
        $amount = $request->input('amount') ?? 0;
        $invoice = $request->input('invoice') ?? mt_rand();
        $intent = "sale";
        echo $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'authorization' => session()->get('bkash_token'),
            'x-app-key' => $this->app_key,
        ])->post($this->base_url . '/checkout/payment/create', [
            'amount' => $amount,
            'currency' => 'BDT',
            'merchantInvoiceNumber' => $invoice,
            'intent' => $intent,
        ]);
    }

    /**
     * @param Request $request
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */

    public function execute_payment(Request $request)
    {
        echo $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'authorization' => session()->get('bkash_token'),
            'x-app-key' => $this->app_key,
        ])->post($this->base_url . '/checkout/payment/execute/' . $request->input('paymentID'));

    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ValidationException
     */
    public function call_back(Request $request)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'authorization' => session()->get('bkash_token'),
            'x-app-key' => $this->app_key,
        ])->post($this->base_url . '/checkout/payment/query/' . $request->input('paymentID'));
        $order = Order::with('order_product')->where('order_number', $request->input('invoice'))->first();
        $calculate_total_price = OrderPriceCalculator::calcualte_due_amount($request->input('invoice'));
        if ($request->input('transactionStatus') == "Completed" && $calculate_total_price['due_amount'] == $request->input('amount')) {
//Success
            $post = new Request();
            $post->setMethod('post');
            $post->request->add(
                [
                    'amount'=>$calculate_total_price['due_amount'],
                    'payment_method_id'=>3,
                    'transaction_id' => $request->input('trxID'),
                    'payment_id' => $request->input('paymentID'),
                ]
            );
            $transaction_object = new TransactionController();
            $transaction_object->store($post, $order->order_number);
            return redirect('https://orponbd.com/congratulation?payment_status=1&order_number='.$order->order_number);
        }else{
            return redirect('https://orponbd.com/customer/order-details-page/'.$order->order_number.'?payment_status=0&msg='.$request->input('errorMessage').'&payment_method_id=3');
        }
    }

    public function refund(Request $request)
    {
        $this->generate_token();
        $amount = $request->input('amount');
        $trxID = $request->input('trxID');
        $paymentId = $request->input('paymentId');
         $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'authorization' => session()->get('bkash_token'),
            'x-app-key' => $this->app_key,
        ])->post($this->base_url . '/checkout/payment/refund', [
            'amount' => $amount,
            'trxID' => $trxID,
            'paymentID' => $paymentId,
            'sku' => 'ORP-'.rand(1000000000, 9999999999),
            'reason' => 'Customer Requirement',
        ]);
         $data = json_decode($response, true);
         if ($data['transactionStatus'] == 'Completed') {
             return redirect('https://orponbd.com/bkash-refund?msg=Successfully Refunded');
         }

    }

}
