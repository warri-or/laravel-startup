@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'siteSettings'])
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('adminSettingsSave')}}" name="site_settings" novalidate class="site-setting-form" method="POST" id="site_setting" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('Application title')}}<span class="text-danger">*</span></label>
                                <input type="text" name="app_title" required value="{{ $settings->app_title ?? ''}}"
                                       placeholder="App title" class="form-control set-settings" id="app_title">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('Contact Email')}}</label>
                                <input type="email" name="contact_email"  value="{{ $settings->contact_email ?? ''}}"
                                       placeholder="Email" class="form-control set-settings" id="contact_email">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('Contact number')}}</label>
                                <input data-parsley-type="number" type="text" name="contact_number" value="{{ $settings->contact_number ?? ''}}"
                                       placeholder="Contact number" class="form-control set-settings" id="contact_number">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('Address')}}</label>
                                <input type="text" name="address"  value="{{ $settings->address ?? ''}}"
                                       placeholder="Address" class="form-control set-settings" id="address" rows="3">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="name">{{__('Description')}}</label>
                                <textarea name="description" placeholder="Description here" rows="4" class="form-control set-settings" id="description">{{$settings->description ?? ''}}</textarea>
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="name">{{__('Copyright text')}}</label>
                                <textarea name="copy_right_text" placeholder="Footer description here here" rows="4" class="form-control set-settings" id="copy_right_text">{{$settings->copy_right_text ?? ''}}</textarea>
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="name">{{__('About us')}}</label>
                                <textarea name="about_us" placeholder="About us" class="form-control set-settings" rows="4" id="about_us">{{$settings->about_us ?? ''}}</textarea>
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
        $(document).ready(function (){
            resetValidation('application_setting_class');
        });
        $('.set-settings').on('blur',function (){
            if ($(this).val().length !== 0){
                var input_name = $(this).attr('name');
                var this_field = $('[name="'+input_name+'"]');
                var submit_url = "{{route('adminSettingsSave')}}";
                var option_group = "site_settings";
                var formData = new FormData();
                formData.append('option_type', 'text');
                formData.append('option_group', option_group);
                formData.append('option_key', input_name);
                formData.append('option_value', $(this).val());
                makeAjaxPostFile(formData,submit_url,null,validationResponse).done(function (response){
                    if (response.success == true){
                        this_field.removeClass('is-valid is-invalid').addClass('is-valid');
                        this_field.next().removeClass('invalid-feedback').addClass('valid-feedback');
                        this_field.siblings('.valid-feedback').text('{{__('Looks good!')}}');
                    }else{
                        this_field.removeClass('is-valid is-invalid').addClass('is-invalid');
                        this_field.next().removeClass('valid-feedback').addClass('invalid-feedback');
                        this_field.siblings('.invalid-feedback').text('{{__('Looks bad!')}}');
                    }
                });
            }
        });

        function validationResponse(response){
            $.each(response, function(key,value) {
                $('[name="'+key+'"]').removeClass('is-valid').addClass('is-invalid');
                $('[name="'+key+'"]').next().removeClass('valid-feedback').addClass('invalid-feedback');
                $('[name="'+key+'"]').siblings('.invalid-feedback').text(value[0]);
            });
        }

    </script>
@endsection
