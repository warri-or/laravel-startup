<?php

namespace App\Http\Modules\Payment;

use App\Http\Controllers\Controller;
use App\Http\Services\CoinPaymentsAPI;
use App\Models\Payment\BtcPaymentAddressMapping;
use App\Models\Payment\CoinPaymentHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CoinPaymentController extends Controller
{
    private $coin_payment_service,$payment_service;

    public function __construct(PaymentService $payment_service,
                                CoinPaymentsAPI $coin_payment_service){
        $this->coin_payment_service = $coin_payment_service;
        $this->payment_service = $payment_service;
    }

    public function generateCoinPaymentAddress(Request $request){
        $data['btc_data'] = $this->getBtcAddress($request->auction_id,$request->type,'LTCT');
        return view('web.payment.btc',$data);
    }

    public function getBtcAddress($event_id,$type=PAYMENT_PURPOSE_1,$currency='BTC'){
        $coin_payment_settings = __options(['coin_payment_settings']);
        $coin_payment_service = new CoinPaymentsAPI();
        $user_id = Auth::user()->id;
        $btc_data = [];
        $conditions = [
            'event_id'=>$event_id,
            'user_id'=>$user_id,
            'type'=>$type,
            'status'=>BTC_ADDRESS_ACTIVE
        ];
        $check_address = BtcPaymentAddressMapping::where($conditions)->first();
        if (isset($check_address)){
            if ($check_address->expired_at >= Carbon::now()){
                $btc_data['btc_address'] = $check_address->btc_address;
                $btc_data['expiry_date'] = $check_address->expired_at;
            }else{
                BtcPaymentAddressMapping::where('id',$check_address->id)->update(['status'=>BTC_ADDRESS_EXPIRED]);
                $address = $coin_payment_service->GetCallbackAddress($currency,route('userBtcBalanceUpdate'));
                $btc_address = isset($address) && $address['error'] == 'ok' ? $address['result']['address'] : '';
                $insert_data = [
                    'event_id'=>$event_id,
                    'user_id'=>$user_id,
                    'type'=>$type,
                    'btc_address'=>$btc_address,
                    'status'=>BTC_ADDRESS_ACTIVE,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                    'expired_at'=> Carbon::now()->addMinutes($coin_payment_settings->coin_payment_expiration_time)
                ];
                $bit_rates = $coin_payment_service->GetRates();
                if (isset($bit_rates) && $bit_rates['error'] == 'ok'){
                    $insert_data['btc_rates'] = $bit_rates['result']['USD']['rate_btc'];
                }
                $btc_map = BtcPaymentAddressMapping::create($insert_data);
                $btc_data['btc_address'] = $btc_map->btc_address;
                $btc_data['expiry_date'] = $btc_map->expired_at;
            }
        }else{
            $address = $coin_payment_service->GetCallbackAddress($currency,route('userBtcBalanceUpdate'));
            $btc_address = isset($address) && $address['error'] == 'ok' ? $address['result']['address'] : '';
            $insert_data = [
                'event_id'=>$event_id,
                'user_id'=>$user_id,
                'type'=>$type,
                'btc_address'=> $btc_address,
                'status'=> BTC_ADDRESS_ACTIVE,
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
                'expired_at'=> Carbon::now()->addMinutes($coin_payment_settings->coin_payment_expiration_time)
            ];
            $btc_map = BtcPaymentAddressMapping::create($insert_data);
            $btc_data['btc_address'] = $btc_map->btc_address;
            $btc_data['expiry_date'] = $btc_map->expired_at;
        }
        return $btc_data;

    }

    public function paymentWithBtcBalance(Request $request){
        try
        {
            DB::beginTransaction();
            $user_id = Auth::user()->id;
            $user = User::where('id',$user_id)->first();
            $user_btc_balance =  (double)$user->btc_balance;
            $pay_btc_balance = (double)$request->amount_in_btc;
            if ($user_btc_balance >= $pay_btc_balance){
                $new_balance = $user_btc_balance - $pay_btc_balance;
                $amount = $request->amount;
                $requestArray = $request->all();
                $status = [
                    'payment_type' => 'BTC Payment',
                    'btc_amount' => $pay_btc_balance,
                    'amount' => $amount
                ];
                User::where('id',$user_id)->update(['btc_balance'=>$new_balance]);
                $this->payment_service->addToTransactionHistory($requestArray['event_id'],PAYMENT_PURPOSE_1,BTC,$amount,json_encode($status));
                DB::commit();
                return jsonResponse(TRUE)->message(__('Live charge payment with btc successful.'));
            }else{
                DB::rollBack();
                return jsonResponse(FALSE)->message(__('Insufficient Balance!'));
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return jsonResponse(FALSE)->default();
        }
    }


    public function userBtcBalanceUpdate(Request $request){
        try {
            DB::beginTransaction();
            if ($request->status == 100){
                $btc_address_map = BtcPaymentAddressMapping::where('address',$request->address)->first();
                $insert_data = [
                    'user_id' => $btc_address_map->user_id,
                    'address' => $request->address,
                    'currency' => $request->currency,
                    'txn_id' => $request->txn_id,
                    'amount' => $request->amount,
                    'confirms' => $request->confirms,
                    'ipn_type' => $request->ipn_type,
                    'status' => STATUS_ACTIVE,
                    'transaction_details' => $request->all()
                ];
                $user = User::where('id',$btc_address_map->user_id)->first();
                $new_balance = $user->btc_balance + $request->amount;
                User::where('id',$user->id)->update(['btc_balance'=>$new_balance]);
                CoinPaymentHistory::create($insert_data);
                DB::commit();
                Session::flash('success', __('Payment with btc successful.'));
            }else{
                $insert_data['status'] = STATUS_FAILED;
                $insert_data['transaction_details'] = $request->all();
                CoinPaymentHistory::create($insert_data);
                DB::commit();
                Session::flash('dismiss', __('Payment with btc failed.'));
            }

        }catch (\Exception $exception){
            DB::rollBack();
            $insert_data['status'] = STATUS_FAILED;
            $insert_data['transaction_details'] = $request->all();
            CoinPaymentHistory::create($insert_data);
            Session::flash('dismiss',$exception->getMessage());
        }
    }

    public function convertPriceToBtcPrice(Request $request){
        try {
            $price = $request->price;
            $coin_payment_service = new CoinPaymentsAPI();
            $bit_rates = $coin_payment_service->GetRates();
            if (isset($bit_rates) && $bit_rates['error'] == 'ok'){
                $data['btc_rates'] = $bit_rates['result']['USD']['rate_btc'];
                $data['btc_price'] =  $data['btc_rates']*$price;
                return jsonResponse(TRUE)->message(__('Price converted successfully'))->data($data);
            }
            return jsonResponse(FALSE)->message(__('Price converted failed'));
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }

    }
}
