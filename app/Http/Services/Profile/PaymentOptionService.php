<?php

namespace App\Http\Services\Profile;

use App\Http\Repositories\Profile\PaymentOptionRepository;
use App\Http\Services\BaseService;
use App\Models\UserPaymentOption;
use Illuminate\Support\Facades\Auth;

class PaymentOptionService extends BaseService {
    public function __construct(PaymentOptionRepository $repository) {
        $this->repo = $repository;
    }

    public function create(array $requestArray) {
        try {
            $requestArray['active'] = ACTIVE;
            $requestArray['user_id'] = Auth::user()->id;
            $response = $this->repo->create($requestArray);
            if ($response) {
                UserPaymentOption::where('user_id',Auth::user()->id)->where('id','<>',$response->id)->update(['active'=>INACTIVE]);
                return jsonResponse(TRUE)->message(__("Payment Option has been created successfully."));
            }
            return jsonResponse(FALSE)->message(__("Payment Option create failed."));
        } catch (\Exception $e) {
            return jsonResponse(FALSE)->message($e);
        }
    }

    public function update(int $id, array $requestArray) {
        try {
            $response = $this->repo->updateModel($id, $requestArray);
            return !$response ? jsonResponse(FALSE)->default() :
                jsonResponse(TRUE)->message(__("Payment Option has been updated successfully"));
        } catch (\Exception $e) {
            return jsonResponse(FALSE)->default();
        }
    }

    public function userPaymentStatusChange(array $requestArray){
        try {
            $response = $this->repo->userPaymentStatusChange($requestArray);
            if ($response){
                return jsonResponse(TRUE)->message(__('Status changed successfully.'));
            }else{
                return jsonResponse(FALSE)->message(__('Status changed failed.'));
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }
    }

    public function getUserPaymentOption($user_id){
        try {
            $payment_options = $this->repo->getData(['user_id'=>$user_id],[],['id'=>'desc']);
            if ($payment_options){
                $data['payment_options'] = $payment_options;
                return jsonResponse(TRUE)->message(__('Payment options get successfully.'))->data($data);
            }else{
                return jsonResponse(FALSE)->message(__('Payment options get failed.'));
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->message($exception->getMessage());
        }
    }

    public function delete($id) {
        try {
            $supplier = $this->repo->destroy($id);
            if ($supplier) {
                return jsonResponse(TRUE)->message('Payment Option deleted successfully.');
            } else {
                return jsonResponse(FALSE)->message('Payment Option delete failed.');
            }
        } catch (\Exception $exception) {
            return jsonResponse(FALSE)->default();
        }

    }


}
