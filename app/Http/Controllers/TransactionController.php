<?php

namespace App\Http\Controllers;

use App\Http\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private $transaction_service;
    public function __construct(TransactionService $transaction_service){
        $this->transaction_service = $transaction_service;
    }
    public function transactionHistories(Request $request){
        if ($request->ajax()){
            $condition = [];
            if (Auth::user()->default_module_id == MODULE_USER){
                $condition['products.seller_id'] = Auth::user()->id;
            }
            $list = $this->transaction_service->getTransactionHistoryList($condition);
            return $this->showTransactionTable($list);
        }
        return view('admin.auction.transaction_histories');
    }

    public function showTransactionTable($list) {
        return datatables($list)
            ->editColumn('created_at', function ($item) {
                return Carbon::parse($item->created_at)->format('d-m-Y h:i:s');
            })->editColumn('purpose', function ($item) {
                return PAYMENT_PURPOSES[$item->purpose];
            })->editColumn('payment_method', function ($item) {
                return PAYMENT_METHODS[$item->payment_method];
            })
            ->editColumn('payment_status', function ($item) {
                return $item->payment_status == ACTIVE ? '<span class="badge badge-success">'.__('Successful').'</span>' : '<span class="badge badge-danger">'.__('Failed').'</span>'  ;
            })
            ->rawColumns(['payment_status'])
            ->make(TRUE);
    }
}
