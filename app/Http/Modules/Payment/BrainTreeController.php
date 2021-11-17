<?php

namespace App\Http\Modules\Payment;

use App\Http\Controllers\Controller;
use Braintree\Configuration;
use Braintree\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrainTreeController extends Controller
{
    private $payment_service;

    public function __construct(PaymentService $payment_service){
        $this->payment_service = $payment_service;
        $settings = __options(['payment_settings']);
        Configuration::environment($settings->brain_tree_env ?? '');
        Configuration::merchantId($settings->brain_tree_merchant_id ?? '');
        Configuration::publicKey($settings->brain_tree_public_key ?? '');
        Configuration::privateKey($settings->brain_tree_private_key ?? '');
    }

    public function brainTreePayment(Request $request){
        try {
            DB::beginTransaction();
            $requestArray = $request->except('payload');
            $amount = 100;
            if (!$amount){
                return jsonResponse(FALSE)->message(__('Payment settings error!'));
            }
            $status = $this->makePaymentByBrainTree($request, $amount);
            if ($status->success == TRUE) {
                $this->payment_service->addToTransactionHistory($requestArray['event_id'],PAYMENT_PURPOSE_1,CARD_BRAIN_TREE,$amount,json_encode($status));
                DB::commit();
                return jsonResponse(TRUE)->message(__('Payment successful.'));
            }
            return jsonResponse(FALSE)->message(__('Payment failed.'));
        }catch (\Exception $exception){
            DB::rollBack();
            return jsonResponse(FALSE)->default();
        }
    }

    private function makePaymentByBrainTree($request,$amount){
        $payload = $request->input('payload', false);
        $nonce = $payload['nonce'];
        $status = Transaction::sale([
            'amount' => (float)$amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);
        return $status;
    }

}
