<?php

namespace App\Http\Modules\Payment;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaypalController extends Controller
{
    private $payment_service;

    public function __construct(PaymentService $payment_service){
        $this->payment_service = $payment_service;
        $settings = __options(['payment_settings']);
        Config::set('paypal.client_id',$settings->paypal_client_id ?? '');
        Config::set('paypal.secret',$settings->paypal_secret ?? '');
        Config::set('paypal.settings.mode',$settings->paypal_env ?? '');
        Config::set('paypal.settings.mode',$settings->paypal_env ?? '');
    }
    public function paymentByPaypal(Request $request)
    {
        $requestArray = $request->all();
        $product = $this->prepareDataForPayapl($requestArray);
        $paypalModule = new ExpressCheckout;
        $res = $paypalModule->setExpressCheckout($product, true);
        return redirect($res['paypal_link']);
    }


    public function cancelPaypalPayment()
    {
        return redirect()->route('paymentComplete',['status'=>'failed'])->with(['dismiss'=>__('Your payment has been declined!')]);
    }

    public function successPaypalPayment(Request $request)
    {
        try {
            DB::beginTransaction();
            $paypalModule = new ExpressCheckout;
            $response = $paypalModule->getExpressCheckoutDetails($request->token);
            if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
                $this->payment_service->addToTransactionHistory($response['PAYMENTREQUEST_0_INVNUM'],PAYMENT_PURPOSE_1,CARD_PAYPAL,$response['PAYMENTREQUEST_0_AMT'],json_encode($response));
                DB::commit();
                return redirect()->route('paymentComplete',['status'=>'completed'])->with(['success'=>__('Payment was successful.')]);
            }
            return redirect()->route('paymentComplete',['status'=>'failed'])->with(['dismiss'=>__('Error occured!')]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->route('paymentComplete',['status'=>'failed'])->with(['dismiss'=>__('Error occured!')]);
        }

    }

    private function prepareDataForPayapl($requestArray){
        $amount = 100;
        $product = [];
        $product['items'] = [
            [
                'name' => 'Test',
                'price' => $amount,
                'des' => __('Test product description'),
                'qty' => 1
            ]
        ];

        $product['invoice_id'] = 1;
        $product['invoice_description'] = __("Test product payment");
        $product['return_url'] = route('successPaypalPayment');
        $product['cancel_url'] = route('cancelPaypalPayment');
        $product['total'] = $amount;
        return $product;
    }

}
