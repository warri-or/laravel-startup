<link href="{{adminAsset('libs/nestable2/jquery.nestable.min.css')}}" rel="stylesheet" type="text/css" />
<div class="card-box">
    <h4 class="header-title">{{__('Product Category List')}}</h4>
    <p class="sub-header">
        Here goes the product category list
    </p>
    <div class="text-left" id="nestable_list_menu">
        <button type="button" class="btn btn-dark btn-sm waves-effect mb-3 waves-light" data-action="expand-all"> + Expand All</button>
        <button type="button" class="btn btn-dark btn-sm waves-effect mb-3 waves-light" data-action="collapse-all"> - Collapse All</button>
    </div>
    <div class="row">
        <div class="col-12">
            @if(isset($categories) && !empty($categories))
                <div class="dd">
                    <ol class="dd-list">
                        @foreach($categories as $category)
                            <li class="dd-item" data-id="{{$category->id}}">
                                <div class="dd-handle">
                                    {{$category->name}} &nbsp;&nbsp;&nbsp;<a href="#" class="text-info"><i class="fa fa-edit"></i></a> <a href="#" class="text-danger"><i class="fa fa-trash"></i></a>
                                </div>
                                @if(isset($category->children) && count($category->children) > 0)
                                    @foreach($category->children as $children)
                                        @include('admin.products.category.category-tree', ['children'=>$children])
                                    @endforeach
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endif
        </div>
    </div>
</div>
