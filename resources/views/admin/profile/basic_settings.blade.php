<form action="{{route('updateProfile')}}" class="parsley-examples" method="POST" id="user_profile_update" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="name">{{__('Name')}}</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" value="{{$profile->name ?? ''}}" required >
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="email">{{__('Email')}}</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$profile->email ?? ''}}" required >
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="phone">{{__('Phone')}}</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{$profile->phone ?? ''}}">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="nid">{{__('Nid')}}</label>
            <input type="text" class="form-control" id="nid" name="nid" placeholder="Nid" value="{{$profile->nid ?? ''}}">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="phone">{{__('Tin')}}</label>
            <input type="text" class="form-control" id="tin" name="tin" placeholder="Tin" value="{{$profile->tin ?? ''}}">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="date_of_birth">{{__('Date of birth')}}</label>
            <input type="text" id="date_of_birth" class="form-control" name="date_of_birth" value="{{$profile->date_of_birth ?? ''}}" placeholder="Date of birth">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="time_zone">{{__('Time zone')}}</label>
            <select class="form-control" name="time_zone">
                <option value="">{{__('Select')}}</option>
                @foreach(timezones() as $key=>$value)
                    <option value="{{$key}}" {{is_selected($key,$profile->time_zone)}}>{{$value}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="language">{{__('Language')}}</label>
            <select class="form-control" name="language">
                <option value="">{{__('Select')}}</option>
                @foreach(languages() as $key=>$lang)
                    <option value="{{$key}}" {{is_selected($key,$profile->language)}}>{{$lang}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label>{{__('Avatar')}}</label>
            <input type="file" name="profile_photo_path" data-plugins="dropify"
                   data-default-file="{{getUserAvatar($profile)}}"
                   data-allowed-file-extensions="png jpg jpeg jfif"
                   data-max-file-size="2M" />
            <p class="text-muted text-center mt-2 mb-0">{{__('Please upload jpg or png file and size should be under 2mb')}}</p>
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label>{{__('Nid Picture')}}</label>
            <input type="file" name="nid_picture" data-plugins="dropify"
                   data-default-file="{{!empty($profile->nid_picture) ? asset(get_image_path('user').$profile->nid_picture) : ''}}"
                   data-allowed-file-extensions="png jpg jpeg jfif"
                   data-max-file-size="2M" />
            <p class="text-muted text-center mt-2 mb-0">{{__('Please upload jpg or png file and size should be under 2mb')}}</p>
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
    <input type="hidden" name="id" value="{{$profile->id ?? ''}}">
    <button type="submit" class="btn btn-dark waves-effect waves-light mt-2 submit_basic" data-style="zoom-in"><i class="fa fa-save"></i> {{__('Save')}}</button>
</form>
<script>
    $('#date_of_birth').flatpickr({

    });
</script>
