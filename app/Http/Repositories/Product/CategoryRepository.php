<?php

namespace App\Http\Repositories\Product;

use App\Models\Product\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    // Your methods for repository

    public function create(array $input)
    {
        return Category::create($input);
    }

    public function update($id, array $input)
    {
        return Category::where(['id' => $id])->update($input);
    }

    public function destroy($id)
    {
        return Category::where('id',$id)->delete();
    }

    public function getBrandCategories($brand_id,$parent_id = NULL){
        $query =  $this->model::select('categories.*',
            DB::raw("	GROUP_CONCAT(
                               CONCAT( website_categories_menus.id ,'==',
                                    website_categories_menus.brand_id , '==',
                                    IFNULL(website_categories_menus.image,'NO_MEDIA'), '==',
                                    IFNULL(website_categories_menus.url,'NO_URL')
                                    ) SEPARATOR '***'
                            )  AS category_image")
        )->leftJoin('website_categories_menus',function ($join) use ($brand_id){
            $join->on('categories.id','=','website_categories_menus.category_id')
                 ->where('website_categories_menus.brand_id','=',$brand_id);
        })->where(['categories.status'=>STATUS_ACTIVE]);
       if ($parent_id !== NULL) {
           $query = $query->where('categories.parent_id','=',$parent_id);
       }
       $query = $query->groupBy('categories.id')->get();
       return $query ;
    }

    public function getCategoryDetails($id){
        return $this->model::where(['id'=>$id])->first();
    }

    public function categoryOrderUpdate(Request $request){
        $parent_id = (int)$request->parent_id;
        $position = (int)$request->position;
        $category_id = (int)$request->id;
        $categories = Category::where('parent_id', $parent_id)
                              ->orderBy('sort_number', 'asc')
                              ->pluck('id')->toArray();
        $dif_category = array_diff($categories, [$category_id]);
        $dif_sort_category = array_values($dif_category);
        $new_category_arr = [];
        $new_key = 0;
        $i = 0;
        if (!empty($dif_sort_category)) {
            foreach ($dif_sort_category as $i => $dif_sort_menu) {
                if ($i == $position) {
                    $new_category_arr[$position] = $category_id;
                    $new_key++;
                }
                $new_category_arr[$new_key] = $dif_sort_category[$i];
                $new_key++;
            }
            if ($position > $i) {
                $new_category_arr[$position] = $category_id;
            }
        }

        $sqltext = 'UPDATE categories SET sort_number = CASE';
        if (!empty($dif_sort_category)) {
            foreach ($new_category_arr as $key => $new_category_id) {
                $sqltext .= ' WHEN id = ' . $new_category_id . ' THEN ' . $key;
            }
        } else {
            $sqltext .= ' WHEN id = ' . $category_id . ' THEN ' . 1;
        }

        $sqltext .= ' ELSE sort_number END ,';
        $sqltext .= ' parent_id = CASE WHEN id = ' . $category_id . ' THEN ' . $parent_id . ' ELSE parent_id END';
        return DB::statement($sqltext);
    }



}
