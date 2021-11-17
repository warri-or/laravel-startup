@extends('admin.layouts.app',['menu'=>'product','sub_menu'=>'brands'])
@section('content')
    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 col-xs-12 add_edit">
        @include('admin.products.brands.brands_add')
    </div>
    <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12 col-xs-12 list">
        @include('admin.products.brands.brands_list')
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
            var data_url = "{{route('brands')}}";
            var delete_url = "{{route('deleteBrand')}}";
            var data_column =  [
                {"data": "id", visible: false},
                {"data": "icon",orderable: false, searchable: false},
                {"data": "name"},
                {"data": "status"},
                {"data": "action",orderable: false, searchable: false}
            ];
            renderDataTable($('#brand_table'),data_url,data_column);
            submitOperation(submitResponse, 'submit_basic');
            deleteOperation(deleteResponse,'delete_item',delete_url);
            editOperation(editResponse,"{{route('editBrand')}}",true);

            function submitResponse(response, this_form){
                if (response.success == true) {
                    swalSuccess(response.message);
                    $('form :input').val('');
                    $('input:checkbox').removeAttr('checked');
                    clearDropify();
                    this_form.removeClass('was-validated')
                    renderDataTable($('#brand_table'),data_url,data_column);
                } else {
                    swalError(response.message);
                }
            }

            function editResponse(){
                $('.dropify').dropify();
                submitOperation(submitResponse, 'submit_basic');
            }

            function deleteResponse(response){
                if(response.success == false) {
                    swalError(response.message);
                } else {
                    swalSuccess(response.message);
                    renderDataTable($('#brand_table'),data_url,data_column);
                }
            }
        });
    </script>
@endsection

