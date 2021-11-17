<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinPaymentHistory extends Model
{
    public $timestamps = TRUE;
    protected $fillable = ['user_id','address','currency','txn_id','amount','confirms','ipn_type','status','transaction_details'];
}
