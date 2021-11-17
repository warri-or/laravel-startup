<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessagingDetails extends Model
{
    protected $table = 'messaging_details';
    protected $timestamp = TRUE;
    protected $fillable = ['messaging_id','sender','message','files'];

}
