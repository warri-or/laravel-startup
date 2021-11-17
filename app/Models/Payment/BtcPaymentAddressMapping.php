<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BtcPaymentAddressMapping extends Model
{
    public $timestamps = TRUE;
    protected $fillable = ['user_id','auction_id','type','btc_address','btc_rates','expired_at','status'];
}
