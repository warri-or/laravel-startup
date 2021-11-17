@extends('admin.layouts.app',['menu'=>'users','sub_menu'=>'users'])
@section('content')
    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12 col-xs-12 add_edit">
        @include('admin.users.user_add')
    </div>
    <div class="col-lg-8 col-xl-8 col-md-8 col-sm-12 col-xs-12 list">
        @include('admin.users.user_list')
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var data_url = "{{route('users')}}";
            var delete_url = "{{route('deleteUser')}}";
            var data_column = [
                {"data": "id", visible: false},
                {"data": "image"},
                {"data": "name"},
                {"data": "contact_info"},
                {"data": "role_name"},
                {"data": "status"},
                {"data": "action",orderable: false, searchable: false}
            ];
            renderDataTable($('#user_table'),data_url,data_column);
            submitOperation(submitResponse, 'submit_basic');
            editOperation(editResponse,"{{route('editUser')}}");
            statusChangeOperation(function (response){
                if (response.success === true){
                    swalSuccess(response.message);
                }else {
                    swalError(response.message);
                }
                renderDataTable($('#user_table'), data_url, data_column);
            },'status_change',"{{route('userStatusChange')}}")

            function submitResponse(response, this_form){
                if (response.success == true) {
                    swalSuccess(response.message);
                    $('form :input').val('');
                    this_form.removeClass('was-validated')
                    renderDataTable($('#user_table'),data_url,data_column);
                } else {
                    swalError(response.message);
                }
            }

            function editResponse(){
                submitOperation(submitResponse, 'submit_basic');
            }

        });
    </script>
@endsection
