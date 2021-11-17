@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'logoSettings'])
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('adminSettingsSave')}}"  novalidate method="POST" id="logo_setting" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="col-form-label" for="app_logo">{{__('App logo large')}}</label>
                                <input type="file" name="app_logo_large" data-plugins="dropify" class="logo_settings"
                                       data-default-file="{{isset($settings->app_logo_large) && !empty($settings->app_logo_large) ? asset(get_image_path('settings').$settings->app_logo_large) : ''}}"
                                       data-allowed-file-extensions="png jpg jpeg jfif"
                                       data-max-file-size="2M" />
                                <p class="text-muted text-center mt-2 mb-0">{{__('Please upload jpg or png file and size should be under 2mb')}}</p>
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="col-form-label" for="app_logo">{{__('App logo small')}}</label>
                                <input type="file" name="app_logo_small" data-plugins="dropify" class="logo_settings"
                                       data-default-file="{{isset($settings->app_logo_small) && !empty($settings->app_logo_small) ? asset(get_image_path('settings').$settings->app_logo_small) : ''}}"
                                       data-allowed-file-extensions="png jpg jpeg jfif"
                                       data-max-file-size="2M" />
                                <p class="text-muted text-center mt-2 mb-0">{{__('Please upload jpg or png file and size should be under 2mb')}}</p>
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="col-form-label" for="blog_cover_image">{{__('Favicon')}}</label>
                                <input type="file" name="favicon_logo" data-plugins="dropify" class="logo_settings"
                                       data-default-file="{{isset($settings->favicon_logo) && !empty($settings->favicon_logo) ? asset(get_image_path('settings').$settings->favicon_logo) : ''}}"
                                       data-allowed-file-extensions="png jpg jpeg jfif"
                                       data-max-file-size="2M" />
                                <p class="text-muted text-center mt-2 mb-0">{{__('Please upload jpg or png file and size should be under 2mb')}}</p>
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div
@endsection
@section('script')
    <script>
        $('.logo_settings').change(function (e){
            var file = e.target.files[0];
            if (file.length !== 0){
                var input_name = $(this).attr('name');
                var this_field = $('[name="'+input_name+'"]');
                var submit_url = "{{route('adminSettingsSave')}}";
                var option_group = "logo_settings";
                var formData = new FormData();
                formData.append('option_type', 'file');
                formData.append('option_group', option_group);
                formData.append('option_key', input_name);
                formData.append('option_value', file);
                makeAjaxPostFile(formData,submit_url,null).done(function (response){
                    if (response.success == true){
                        swalSuccess('{{__('Logo saved successfully.')}}');
                    }else {
                        swalError('{{__('Logo saved failed.')}}');
                    }
                })
            }

        })

    </script>
@endsection
