<?php

namespace App\Http\Controllers\Web\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Services\Profile\PaymentOptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentOptionController extends Controller {
    private $payment_option_service;
    private $data = [];
    public function __construct(PaymentOptionService $service) {
        $this->payment_option_service = $service;
    }

    public function index(Request $request) {
        $data_lists = $this->payment_option_service->getData(['user_id'=>Auth::id()], [], ['created_at' => 'desc']);
        //dd($data_lists);
        if ($request->ajax()) {
            return datatables($data_lists)
                ->editColumn('account_info', function ($item) {
                    $html = '';
                    if($item->payment_type == 'Bank'){
                        $html .= '<b>'.$item->bank_name.'</b><br/>';
                        $html .= __('Branch - ').$item->branch_name.'<br/>';
                        $html .= __('Account name - ').$item->account_name.'<br/>';
                        $html .= __('Account number - ').$item->account_number.'<br/>';
                        $html .= __('Routing Name -').$item->routing_number.'<br/>';
                    }elseif($item->payment_type == 'Card'){
                        $html .= '<b>'.$item->card_type.'</b><br/>';
                        $html .= __('Card Name - ').$item->card_name.'<br/>';
                        $html .= __('Card Number - ').$item->card_number.'<br/>';
                        $html .= __('CVC -').$item->cvc.'<br/>';
                        $html .= __('Expiry Date -').$item->expiry_date.'<br/>';
                    }elseif($item->payment_type == 'Coin'){
                        $html .= '<b>'.$item->coin_address.'</b><br/>';
                    }else{
                        $html = '--';
                    }
                    return $html;
                }) ->editColumn('active',function ($item){
                    $checked = $item->active == STATUS_ACTIVE ? 'checked' : '';
                    $html = '<input type="checkbox" '.$checked.' data-id="'.$item->id.'" data-plugin="switchery" data-size="small"
                     data-status="'.$item->active.'" data-user-id="'.$item->user_id.'"  data-color="#1bb99a" class="status_change"/>';
                    return $html;
                })->editColumn('action', function ($item) {
                    $html = '';
                    //$html = '<a href="javascript:void(0);" class="text-info p-1 edit_item" data-id="' . $item->id . '"><i class="fa fa-edit"></i></a>';
                    $html .= '<a href="javascript:void(0);" class="text-danger p-1 delete_item" data-id="' . $item->id . '"><i class="fa fa-trash"></i></a>';
                    return $html;
                })->rawColumns(['account_info', 'active', 'action'])
                ->make(TRUE);
        }
        return view('admin.profile.payment_option.payment_option');
    }

    public function edit(Request $request) {
        $this->data['payment_options'] = $this->payment_option_service->firstWhere(['id' => $request->id]);
        return view('admin.profile.payment_option.payment_option', $this->data);
    }

    public function store(Request $request) {
        $request->request->add(['user_id'=> Auth::id()]);
        if (!empty($request->id)) {
            return $this->payment_option_service->update($request->id, $request->except('id'));
        } else {
            return $this->payment_option_service->create($request->except('id'));
        }
    }

    public function userPaymentStatusChange(Request $request){
        return $this->payment_option_service->userPaymentStatusChange($request->all());
    }

    public function delete(Request $request) {
        return $this->payment_option_service->delete($request->id);
    }
}
