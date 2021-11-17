<?php

namespace App\Http\Controllers\Web\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\Product\CategoryRequest;
use App\Http\Services\Product\CategoryService;
use App\Models\Product\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $service){
        $this->categoryService = $service;
    }

    public function index(Request $request,$id = NULL){
        return view('admin.products.category.categories');
    }

    public function edit(Request $request){
        return view('admin.products.category.category_add',$this->categoryService->getCategoryData($request->id));
    }


    public function store(CategoryRequest $request){
        if(!empty($request->id)){
            return $this->categoryService->update($request->id,$request->except('id'));
        }else{
            return $this->categoryService->create($request->except('id'));
        }

    }

    public function delete(Request $request){
        return $this->categoryService->delete($request->id);
    }

    public function categorySlugCheck(Request $request){
        return $this->categoryService->checkSlug($request);
    }

    public function categoryOrderUpdate(Request $request){
        return $this->categoryService->categoryOrderUpdate($request->list);
    }

    public function show(){
        return $this->categoryService->show();
    }

    public static function makeCategoryTree($trees = []) {
        $html = '<ul>';
        foreach ($trees as $val) {
            if (isset($val->children)) {
                $category_name = $val->name;
                if (!empty($val->children)) {
                    $html .= '<li id="' . $val->id . '" class="jstree-open mr-1" aria-selected="true" data-jstree=\'{"icon": "fa fa-box"}\'>'.$category_name;
                    $html .= '<span class="mx-2"><a href="javascript:void(0)" class="text-info edit_item" data-id="'.$val->id.'"><i class="fa fa-edit"></i></a></span>
                               <span><a href="javascript:void(0)" class="text-danger delete_item" data-id="'.$val->id.'" ><i class="fa fa-trash"></i></a></span>';
                    $html .= static::makeCategoryTree($val->children);
                    $html .= '</li>';
                }
            } else {
                $html .= '<li id="' . $val->id . '" aria-selected="true" class="mr-1" data-jstree=\'{"icon": "fa fa-box"}\'>'. $category_name;
                $html .='<span class="mx-2"><a href="javascript:void(0)" class="text-info edit_item" data-id="'.$val->id.'"><i class="fa fa-edit"></i></a></span>
                     <span><a href="javascript:void(0)" class="text-danger delete_item" data-id="'.$val->id.'" ><i class="fa fa-trash"></i></a></span></li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

    public static function makeCategoryTreeDropdown($trees = []) {
        $html = '<ul class="submenu">';
        foreach ($trees as $val) {
            if (isset($val->children)) {
                if (!empty($val->children)) {
                    $html .= '<li>
                                <a href="'.route('auctionList',['category_id'=>$val->id]).'">'.$val->name.'</a>';
                    $html .= static::makeCategoryTreeDropdown($val->children);
                    $html .= '</li>';
                }
            } else {
                $html .= '<li>
                            <a href="'.route('auctionList',['category_id'=>$val->id]).'">'.$val->name.'</a>
                        </li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

    public function categoryOrderSave(Request $request){
        return $this->categoryService->categoryOrderUpdate($request);
    }


}
