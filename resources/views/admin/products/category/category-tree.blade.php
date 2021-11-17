<div id="jstree1">
    {!! App\Http\Controllers\Web\Admin\Product\CategoryController::makeCategoryTree($categoryTrees)!!}
</div>
<link href="{{adminAsset('vendors/jsTree/style.min.css')}}" rel="stylesheet">
<script src="{{adminAsset('vendors/jsTree/jstree.min.js')}}"></script>
<script>
    $('#jstree1')
        .on('changed.jstree', function (e, data) {
            var post_data = {
                id : data.node.id
            }
        })
        .on('move_node.jstree', function (e, data) {
            var postdata = {
                id: data.node.id,
                parent_id: data.parent == '#' ? 0 : data.parent,
                position: data.position,
            };
            var url = "{{route('categoryOrderSave')}}";
            makeAjaxPost(postdata, url).then(response => {
                console.log(response.success);
            });

        })
        .jstree({
            'core': {
                'check_callback': true,
                // 'data' : data.map(function (item){
                //     return item.name +' <i class="fa fa-edit"></i>';
                // })
            },
            'plugins': ["themes","html_data","dnd","ui","types"]
        });


</script>
