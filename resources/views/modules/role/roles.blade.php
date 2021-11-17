@extends('admin.layouts.app',['menu'=>'user','sub_menu'=>'roles'])
@section('content')
    <div class="col-lg-7 col-xl-7 col-md-7 col-sm-12 col-xs-12 add_edit">
        @include('modules.role.create')
    </div>
    <div class="col-lg-5 col-xl-5 col-md-5 col-sm-12 col-xs-12 list">
        @include('modules.role.list')
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var data_url = "{{route('roles')}}";
            var data_column = [
                {"data": "title"},
                {"data": "module_id"},
                {"data": "action"},
            ];
            renderDataTable($('#roleTable'),data_url,data_column);

            submitOperation(submitResponse, 'submit_basic');
            editOperation(editResponse,"{{route('editRole')}}");

            function submitResponse(response, this_form){
                if (response.success === true) {
                   swalRedirect("{{Request::url()}}",response.message,'success');
                } else {
                    swalError(response.message);
                }
            }

            function editResponse(){
                submitOperation(submitResponse, 'submit_basic');
                const role_id = $('#role_id').val();
                getModuleListByRoleId(role_id);
            }

            $(document).on('click','.update_route',function (){
                Ladda.bind(this);
                var load = $(this).ladda();
                var id = $(this).data('id');
                swalConfirm("Do you really want to update route list ?").then(function (s) {
                    if(s.value){
                        const update_url = "{{route('updateRouteList')}}";
                        makeAjax(update_url, load).done(function (response) {
                            if (response.success == true){
                                swalRedirect("{{Request::url()}}",response.message,'success')
                            }else {
                                swalError(response.message);
                            }
                        });
                    }else{
                        load.ladda('stop');
                    }
                })
            });

            $(document).on('change','#userType',function (){
                var get_roles_by_type_url = "{{route('getRouteByType')}}";
                var role_id = $('#role_id').val();
                var get_roles_by_type_data = {
                    module_id : $(this).val(),
                    role_action: role_id !== null ? <?php print_r(json_encode($role_action ?? [])) ?> : []
                }
                makeAjaxPostText(get_roles_by_type_data,get_roles_by_type_url,null).done(function (response){
                    $('#my_multi_select1').html(response);
                    $('#my_multi_select1').multiSelect('refresh');
                });
            })
        });

    </script>
@endsection
