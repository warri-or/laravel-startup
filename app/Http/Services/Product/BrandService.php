<?php

namespace App\Http\Services\Product;

use App\Http\Repositories\Product\BrandRepository;
use Illuminate\Support\Facades\DB;

class BrandService
{
    /**
     * Instantiate repository
     *
     * @param Product/BrandRepository $repository
     */
    public function __construct(BrandRepository $repository)
    {
        $this->repo = $repository;
    }

    // Your methods for repository

    public function getBrandData($id){

        if ($id !== NULL){
            $data['brand'] = $this->repo->getBrandDetails($id);
        }else{
            $data['brand'] = [];
        }
        return $data;
    }

    public function create(array $requestArray) {
        try {
            if (isset($requestArray['icon']) && !empty($requestArray['icon'])){
                $requestArray['icon'] = $this->imageData($requestArray['icon']);
            }
            $delivery = $this->repo->create($requestArray);
            if ( $delivery) {
                return jsonResponse(true)->message(__("Brand has been created successfully."));
            }
            return jsonResponse(false)->message(__("Brand create failed."));
        } catch (\Exception $e) {
            return jsonResponse(false)->default();
        }
    }

    public function update(int $id, array $requestArray) {
        try {
            if (isset($requestArray['icon']) && !empty($requestArray['icon'])){
                $requestArray['icon'] = $this->imageData($requestArray['icon'],$id);
            }
            $response = $this->repo->update($id, $requestArray);
            return !$response ? jsonResponse(false)->default() :
                jsonResponse(true)->message(__("Brand has been updated successfully"));
        } catch (\Exception $e) {
            return jsonResponse(false)->default();
        }
    }

    private function imageData($image,$id=NULL){
        if ($id !== NULL){
            $details =  $this->repo->getBrandDetails($id);
            return uploadImage($image,get_image_path('brand'),$details->icon ?? '');
        }else{
            return uploadImage($image,get_image_path('brand'));
        }
    }

    public function delete($id){
        try {
            $supplier = $this->repo->destroy($id);
            if ($supplier){
                return jsonResponse(TRUE)->message(__('Brand deleted successfully.'));
            }else{
                return jsonResponse(TRUE)->message(__('Brand delete failed.'));
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }

    }
}
