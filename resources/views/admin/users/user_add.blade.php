<div class="card">
    <div class="card-body ajax-load">
        <h4 class="card-title">{{__('Admin Add/Edit')}}</h4>
        <form class="user-form" novalidate action="{{route('saveUser')}}" method="post" id="user_save">
            <div class="form-group mb-3">
                <label for="name">{{__('Name')}}<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$user->name ?? ''}}" required>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="email">{{__('Email')}}<span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email ?? ''}}" required>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="form-group mb-3">
                <label>{{__('Module')}} <span class="text-danger">*</span></label>
                <select class="form-control" required name="default_module_id">
                    <option value="">{{__('Select')}}</option>
                    @foreach(MODULES as $key => $value)
                        <option value="{{$key}}" {{is_selected($key,$user->default_module_id ?? '')}}>{{$value}}</option>
                    @endforeach
                </select>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="form-group mb-3">
                <label>{{__('Role')}} <span class="text-danger">*</span></label>
                <select class="form-control" required name="role">
                    <option value="">{{__('Select')}}</option>
                    @if(isset($roles) )
                        @foreach($roles as $role)
                            <option value="{{$role->id}}" {{is_selected($role->id,$user->role ?? '')}}>{{$role->title}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="form-group mb-3">
                <label>{{__('Status')}} <span class="text-danger">*</span></label>
                <select class="form-control" required name="status">
                    <option value="">{{__('Select')}}</option>
                    <option value="{{INACTIVE}}" {{is_selected(INACTIVE,$user->status ?? '')}}>{{__('Inactive')}}</option>
                    <option value="{{ACTIVE}}" {{is_selected(ACTIVE,$user->status ?? '')}}>{{__('Active')}}</option>
                    <option value="{{STATUS_BLOCKED}}" {{is_selected(STATUS_BLOCKED,$user->status ?? '')}}>{{__('Block')}}</option>
                    <option value="{{STATUS_SUSPENDED}}" {{is_selected(STATUS_SUSPENDED,$user->status ?? '')}}>{{__('Suspend')}}</option>
                </select>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <input type="hidden" name="id" value="{{$user->id ?? ''}}">
            <button class="btn btn-dark waves-effect waves-light submit_basic" data-style="zoom-in" type="submit"><i class="fa fa-save"></i> {{__('Save')}}</button>
            <button class="btn btn-outline-secondary waves-effect waves-light reset_from float-right" type="button" onclick="reset_form()"><i class="fas fa-sync-alt"></i> {{__('Reset')}}</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function (){
        resetValidation('user-form');
        checkSlugVlaidity('user');
    })
</script>
