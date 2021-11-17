@extends('admin.layouts.app',['menu'=>'product','sub_menu'=>'categories'])
@section('content')
    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 col-xs-12 add_edit">
        @include('admin.products.category.category_add')
    </div> <!-- end col-->
    <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12 col-xs-12">
        @include('admin.products.category.category_list')
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('.dropify').dropify();
            var edit_url = "{{route('editCategory')}}";
            var delete_url = "{{route('deleteCategory')}}"
            var show_url = "{{route('showCategory')}}"
            submitOperation(submitResponse, 'category_submit');
            deleteOperation(deleteResponse,'delete_item',delete_url);
            editOperation(editResponse,edit_url,true);

            function submitResponse(response, this_form){
                if (response.success == true) {
                    swalSuccess(response.message);
                    resetLanguage('#name');
                    $('form :input').val('');
                    clearDropify();
                    this_form.removeClass('was-validated')
                    generateCategoryTree(show_url,function (response){
                        $('.category_content').html(response);
                    })
                } else {
                    swalError(response.message);
                }
            }

            function editResponse(){
                $('.dropify').dropify();
                submitOperation(submitResponse, 'category_submit');
            }

            function deleteResponse(response){
                if(response.success == false) {
                    swalError(response.message);
                } else {
                    swalSuccess(response.message);
                    generateCategoryTree(show_url,function (response){
                        $('.category_content').html(response);
                    });
                }
            }
        });
    </script>
@endsection
