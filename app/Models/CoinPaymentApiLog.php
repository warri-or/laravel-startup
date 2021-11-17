<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinPaymentApiLog extends Model
{
    protected $fillable = ['request_body','curl_object','response','user_id'];
}
