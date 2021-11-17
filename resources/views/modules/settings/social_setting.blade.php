@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'socialSettings'])
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('adminSettingsSave')}}" novalidate name="site_settings" method="POST" id="social_setting" class="social_setting_class" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('Facebook')}}</label>
                                <input type="text" name="facebook_link" value="{{ $settings->facebook_link ?? ''}}"
                                       placeholder="Facebook" class="form-control social_settings" id="facebook_link">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('Twitter')}}</label>
                                <input type="text" name="twitter_link" value="{{ $settings->twitter_link ?? ''}}"
                                       placeholder="Twitter" class="form-control social_settings" id="twitter_link">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('Instagram')}}</label>
                                <input type="text" name="instagram_link" value="{{ $settings->instagram_link ?? ''}}"
                                       placeholder="Instagram" class="form-control social_settings" id="instagram_link">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('Google')}}</label>
                                <input type="text" name="google_link"  value="{{ $settings->google_link ?? ''}}"
                                       placeholder="Google" class="form-control social_settings" id="google_link">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('LinkedIn')}}</label>
                                <input type="text" name="linkedin_link" value="{{ $settings->linkedin_link ?? ''}}"
                                       placeholder="LinkedIn" class="form-control social_settings" id="linkedin_link">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('Whatsapp')}}</label>
                                <input type="text" name="whatsapp_link" value="{{ $settings->whatsapp_link ?? ''}}"
                                       placeholder="Whatsapp" class="form-control social_settings" id="whatsapp_link">
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
        $('.social_settings').on('blur',function (){
            if ($(this).val().length !== 0){
                const input_name = $(this).attr('name');
                const this_field = $(this);
                const submit_url = "{{route('adminSettingsSave')}}";
                const option_group = "social_settings";
                const formData = new FormData();
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
