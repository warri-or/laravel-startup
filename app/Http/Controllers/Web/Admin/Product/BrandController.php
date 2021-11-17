<?php

namespace App\Http\Controllers\Web\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\Product\BrandRequest;
use App\Http\Services\Product\BrandService;
use App\Models\Product\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $brandService;

    public function __construct(BrandService $service){
        $this->brandService = $service;
    }

    public function index(Request $request,$id = NULL){
        $brand_lists = Brand::orderBy('created_at','desc');
        if ($request->ajax()){
            return datatables($brand_lists)
                ->editColumn('icon',function ($item){
                    return '<img src="'.asset(get_image_path('brand').'/'.$item->icon).'" class="img-circle" width="30">';
                })->editColumn('status',function ($item){
                    return $item->status == STATUS_ACTIVE ? '<span class="badge badge-success">'.__('Active').'</span>':'<span class="badge badge-warning">'.__('Inactive').'</span>';
                }) ->editColumn('action',function ($item){
                    $html = '<a href="javascript:void(0)" class="text-info p-1 edit_item" data-id="'.$item->id.'"><i class="fa fa-edit"></i></a>';
                    $html .='<a href="javascript:void(0)" class="text-danger p-1 delete_item" data-style="zoom-in" data-id="'.$item->id.'"><i class="fa fa-trash"></i></a>';
                    return $html;
                })->rawColumns(['icon','status','action'])
                ->make(TRUE);
        }

        return view('admin.products.brands.brands',$this->brandService->getBrandData($id));
    }
    public function edit(Request $request){
        return view('admin.products.brands.brands_add',$this->brandService->getBrandData($request->id));
    }

    public function store(BrandRequest $request){
        if(!empty($request->id)){
            return $this->brandService->update($request->id,$request->except('id'));
        }else{
            return $this->brandService->create($request->except('id'));
        }
    }

    public function delete(Request $request){
        return $this->brandService->delete($request->id);
    }
}
