<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messaging extends Model
{
    protected $table = 'messaging';
    protected $fillable = ['event_type','event_id','sender','receiver','seen','last_message_date','last_message','synced','is_connected','status'];

    public function messaging_details(){
        $this->hasMany(MessagingDetails::class);
    }

}
