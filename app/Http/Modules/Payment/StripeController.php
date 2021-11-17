<?php

namespace App\Http\Modules\Payment;

use App\Http\Controllers\Controller;
use App\Http\Services\HomeDeelerService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Stripe;

class StripeController extends Controller
{
    private $payment_service;

    public function __construct(PaymentService $payment_service){
        $this->payment_service = $payment_service;
    }

    public function paymentByStripe(Request $request){
        try {
            DB::beginTransaction();
            $requestArray = $request->all();
            $amount = 100;
            if (!$amount){
                return redirect()->back()->with(['dismiss'=>__('Payment settings error!')]);
            }
            $stripe_response = $this->makePaymentByStripe($request, $amount, __('Stripe Payment'));

            if ($stripe_response->status == 'succeeded') {
                $paid_amount = !empty($stripe_response->amount) ? $stripe_response->amount/100 : 0 ;
                $this->payment_service->addToTransactionHistory($requestArray['event_id'],PAYMENT_PURPOSE_1,CARD_STRIPE,$paid_amount,json_encode($stripe_response));
                DB::commit();
                return redirect()->route('paymentComplete',['status'=>'completed'])->with(['success'=>__('Payment successful.')]);
            }
            return redirect()->route('paymentComplete',['status'=>'failed'])->with(['dismiss'=>__('Payment failed!')]);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['dismiss'=>$exception->getMessage()]);
        }
    }


    public function makePaymentByStripe($request,$amount,$description){
        $settings = __options(['payment_settings']);
        Stripe::setApiKey($settings->stripe_secret);
        $stripe_response = Charge::create ([
            "amount" => 100 * floatval($amount),
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => $description
        ]);
        return $stripe_response;
    }


}
