<div class="card-box">
    <h4 class="header-title">{{__('Product Category List')}}</h4>
    <p class="sub-header">
        {{__('Here goes the product category list')}}
    </p>
    <div class="row">
        <div class="col-12">
           <div class="category_content">

           </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        generateCategoryTree("{{route('showCategory')}}",function (response){
            $('.category_content').html(response);
        });
    })

</script>
