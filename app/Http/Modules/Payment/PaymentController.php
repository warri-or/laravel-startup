<?php

namespace App\Http\Modules\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    public function paymentComplete($status){
        $data['status'] = $status;
        return view('modules.payment.payment_completed',$data);
    }

}
