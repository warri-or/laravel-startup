<?php

namespace App\Http\Repositories\Product;

use App\Models\Product\Brand;

class BrandRepository
{

    // Your methods for repository

   public function getBrandDetails($id){
        return Brand::where(['id'=>$id])->first();
   }

    public function create(array $input)
    {
        return Brand::create($input);
    }

    public function update($id, array $input)
    {
        return Brand::where(['id' => $id])->update($input);
    }

    public function destroy($id)
    {
        return Brand::where('id',$id)->delete();
    }
}
