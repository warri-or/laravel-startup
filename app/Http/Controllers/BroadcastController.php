<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class BroadcastController extends Controller
{

    public function broadcastAuth(Request $request){
        $request->server->set('REQUEST_URI', 'broadcast/auth');
        $request->request->set('channel_name', 'private-cd80d050631fe9cbce59cdf8678415ebe2cd39dfe6fd926099649f81d655df7.' . custom_encrypt($request->user()->id));
        return  Broadcast::auth($request);
    }

    public function getEncryptedUser(Request $request){
        return response()->json([
            'status' => true,
            'message' => 'user_id',
            'data' => custom_encrypt($request->user()->id)
        ]);
    }
}
