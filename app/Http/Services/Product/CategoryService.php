<?php

namespace App\Http\Services\Product;

use App\Http\Repositories\Product\CategoryRepository;
use App\Http\Services\BaseService;
use App\Models\Product\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    /**
     * Instantiate repository
     *
     * @param Product/CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repo = $repository;
    }

    // Your methods for repository


    public function getCategoryData($id){

        if ($id !== NULL){
            $data['category'] = $this->repo->getCategoryDetails($id);
        }else{
            $data['category'] = [];
        }
        return $data;
    }

    public function create(array $requestArray) {

        try {
            if (isset($requestArray['icon']) && !empty($requestArray['icon'])){
                $requestArray['icon'] = $this->imageData($requestArray['icon']);
            }
            $category = $this->repo->create($requestArray);
            if ( $category) {
                return jsonResponse(true)->message(__("Category has been created successfully."));
            }
            return jsonResponse(false)->message(__("Category create failed."));
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
                jsonResponse(true)->message(__("Category has been updated successfully"));
        } catch (\Exception $e) {
            return jsonResponse(false)->default();
        }
    }

    private function imageData($image,$id=NULL){
        if ($id !== NULL){
            $details =  $this->repo->getCategoryDetails($id);
            return uploadImage($image,get_image_path('category'),$details->icon ?? '');
        }else{
            return uploadImage($image,get_image_path('category'));
        }
    }

    public function delete($id){
        try {
            $category = $this->repo->destroy($id);
            if ($category){
                return jsonResponse(TRUE)->message('Category deleted successfully.');
            }else{
                return jsonResponse(TRUE)->message('Category delete failed.');
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }

    }

    public function checkSlug(Request $request){
        $slug = DB::table('categories')->where('slug',$request->slug)->where('id','<>',$request->id)->first();
        try {
            if ($slug){
                return jsonResponse(FALSE)->message(__('Unique and valid Slug required'));
            }else{
                return jsonResponse(TRUE)->message(__('Valid Slug'));
            }

        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }
    }

    public function categoryOrderUpdate(Request $request){
        try {
            $category_order_update = $this->repo->categoryOrderUpdate($request);
            if ($category_order_update){
                return jsonResponse(TRUE)->message('Category order updated successfully.');
            }else{
                return jsonResponse(TRUE)->message('Category order update failed.');
            }
        }catch (\Exception $exception){
            return jsonResponse(FALSE)->default();
        }
    }

    public function show(){
        $categories = Category::orderBy('sort_number','asc')->get();
        $branch = [];
        $data['categoryTrees'] = buildTree($categories,NULL,$branch);
        return view('admin.products.category.category-tree',$data);
    }

    public function getBrandCategories($brand_id,$parent_id = NULL){
        return $this->prepareBrandCategoryData($this->repo->getBrandCategories($brand_id,$parent_id));
    }

    public function prepareBrandCategoryData($category_brand){
       $category_data = [];
       if (isset($category_brand)) {
           foreach ($category_brand as $key=>$category){
               $category_data[$key]['id'] = $category->id;
               $category_data[$key]['name'] = $category->name;
               $category_data[$key]['slug'] = $category->slug;
               $category_data[$key]['icon'] = $category->icon;
               $category_data[$key]['parent_id'] = $category->parent_id;
               $category_images = explode('***',$category->category_image);
               $category_image_data = [];
               if (isset($category_images) && !empty($category_images[0])) {
                   foreach ($category_images as $image_key=>$category_image){
                       $image = explode('==',$category_image);
                       $category_image_data[$image_key]['id'] = $image[0];
                       $category_image_data[$image_key]['brand_id'] = $image[1];
                       $category_image_data[$image_key]['image'] = $image[2];
                       $category_image_data[$image_key]['url'] = $image[3];
                   }
               }
               $category_data[$key]['category_image'] = $category_image_data;
           }
       }
        return $category_data;
    }
}
