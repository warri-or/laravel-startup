<form action="{{route('updateProfile')}}" class="user_address_form_class" method="POST" id="user_address_form_id" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="language">{{__('Language')}}</label>
            <select class="form-control" name="language">
                <option value="">{{__('Select')}}</option>
                @foreach(countries() as $key=>$value)
                    <option value="{{$value}}" {{is_selected($value,$profile->country)}}>{{$value}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="city">{{__('City')}}</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{$profile->city ?? ''}}" required >
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="state">{{__('State')}}</label>
            <input type="text" class="form-control" id="state" name="state" placeholder="State" value="{{$profile->state ?? ''}}">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="post_code">{{__('Post code')}}</label>
            <input type="text" class="form-control" id="post_code" name="post_code" placeholder="Post code" value="{{$profile->post_code ?? ''}}">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="address">{{__('Address')}}</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{$profile->address ?? ''}}">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="address_secondary">{{__('Secondary Address')}}</label>
            <input type="text" id="address_secondary" class="form-control" name="address_secondary" value="{{$profile->address_secondary ?? ''}}" placeholder="Secondary Address">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
    <input type="hidden" name="id" value="{{$profile->id ?? ''}}">
    <button type="submit" class="btn btn-dark waves-effect waves-light mt-2 submit_address" data-style="zoom-in"><i class="fa fa-save"></i> {{__('Save')}}</button>
</form>
