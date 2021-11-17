<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPaymentOption extends Model
{
    protected $table = 'user_payment_options';
    protected $fillable = array('user_id','payment_type','bank_name','branch_name','account_name','routing_number','account_number',
                                'card_type','card_name','card_number','cvc','coin_address','active');

    public function user(){
        $this->belongsTo(User::class);
    }
}
