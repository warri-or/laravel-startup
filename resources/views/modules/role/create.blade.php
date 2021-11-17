<div class="card-box">
    <form class="role-form" novalidate method="post" action="{{route('saveRole')}}" id="role_form">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">{{__('Role Add/Edit')}}</h4>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-dark waves-effect waves-light submit_basic  mr-1" type="submit"><i class="fa fa-save"></i> {{__('Save')}}</button>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label>{{__('Title')}}</label>
                <input type="text" name="title" class="form-control" value="{{$role->title ?? ''}}" required>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>{{__('Module')}}</label>
                <select class="selectpicker" multiple name="module_id[]" id="module_id" data-style="btn-light">
                    @foreach(MODULES as $module_id => $module_name)
                        <option value="{{$module_id}}" {{in_array($module_id, $role_module ?? []) ? 'selected' : ''}}>{{__($module_name)}}</option>
                    @endforeach
                </select>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <input type="hidden" name="id" value="{{$role->id ?? ''}}" id="role_id">
        </div>
    </form>
</div>

<div id="show_modules_by_role">

</div>



<script src="{{adminAsset('libs/multiselect/js/jquery.multi-select.js')}}"></script>

<script>
    $(document).ready(function (){
        $('.selectpicker').selectpicker();
    });

    function getModuleListByRoleId(role_id){
        const data = {
            role_id : role_id
        }
        makeAjaxPostText(data,"{{route('getModuleByRole')}}").done(function (response){
            $('#show_modules_by_role').html(response);
        });
    }
</script>
