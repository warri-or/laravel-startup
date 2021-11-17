<?php

namespace App\Http\Modules\Payment;


use App\Http\Services\HomeDeelerService;
use App\Models\PaymentTransactionHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentService
{
    public function addToTransactionHistory($event_id,$purpose,$payment_method,$amount,$ref,$status=PAYMENT_DONE){
        try {
            $insert = [
                'event_id'=>$event_id,
                'user_id'=>Auth::user()->id,
                'purpose'=>$purpose,
                'payment_method'=>$payment_method,
                'amount'=>$amount,
                'created_at'=>Carbon::now(),
                'created_by'=>Auth::user()->id,
                'transaction_reference'=>$ref,
                'payment_status'=>$status,
            ];
            PaymentTransactionHistory::create($insert);

        }catch (\Exception $exception){

        }
    }

    public function adminBalanceUpdate($amount){
        try {
            $admin = User::where(['module_id'=>USER_ADMIN,'status'=>ACTIVE])->first();
            $new_balance = $admin->balance + $amount;
            User::where('id',$admin->id)->update(['balance'=>$new_balance]);
        }catch (\Exception $exception){

        }
    }

    public function productPurchaseBalanceUpdate($auction,$amount){
        $settings = __options(['commission_settings'])->commission_rate ?? 0;
        $service_charge = getPercentageValue($auction->highest_bid,$auction->service_charge);
        $commission_price = getPercentageValue($auction->highest_bid,$settings);
        $total_price = $auction->highest_bid + $service_charge;
        $received_payment_by_winner = $amount;
        $seller_paying_amount = $total_price-$commission_price;
        $auction_payment = [
            'auction_winning_price' => $auction->highest_bid,
            'commission_price' => $commission_price,
            'processing_fee' => $service_charge,
            'total_price' => $total_price,
            'recieved_amount_by_winner' => $received_payment_by_winner,
            'recieved_amount_by_winner_time' => Carbon::now(),
            'seller_paying_amount' => $seller_paying_amount
        ];
        $auction_payment['is_winner_paid'] = TRUE;
        AuctionPayment::where('auction_id',$auction->id)->update($auction_payment);
        Auction::where('id','$auction->id')->update(['status'=>PAYMENT_COMPLETED]);
        $this->userBalanceUpdate($auction->product->seller_id, $seller_paying_amount);
        $this->auctionStatusUpdate($auction->id, PAYMENT_COMPLETED);
    }

    public function userBalanceUpdate($user_id,$balance){
       $user = User::where('id',$user_id)->first();
       $balance = $user->balance + $balance;
       User::where('id',$user_id)->update(['balance'=>$balance]);
    }

    public function auctionStatusUpdate($auction_id,$status){
       Auction::where('id',$auction_id)->update(['status'=>$status]);
    }
}
