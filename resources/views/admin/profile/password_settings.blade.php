<div class="card-box">
    <h4 class="mb-4">{{__('Change Password')}}</h4>
    <form action="{{route('updatePassword')}}" novalidate class="profile_password" method="POST" id="profile_password_id">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="pass1">{{__('Old Password')}}<span class="text-danger">*</span></label>
                <input type="password" name="old_password" placeholder="Old Password" required class="form-control">
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>

            <div class="form-group">
                <label for="pass1">{{__('New Password')}}<span class="text-danger">*</span></label>
                <input id="pass1" type="password"  name="password" placeholder="New Password" required class="form-control">
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="form-group">
                <label for="passWord2">{{__('Confirm Password')}} <span class="text-danger">*</span></label>
                <input data-parsley-equalto="#pass1" type="password"  name="password_confirmation" required placeholder="Confirm Password" class="form-control" id="passWord2">
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>

            <input type="hidden" name="id" value="{{$profile->id ?? ''}}">
            <button type="submit" class="btn btn-dark submit_password" data-style="zoom-in"><i class="fa fa-key"></i> {{__('Change Password')}}</button>
        </div>
    </div>
</form>
</div>
