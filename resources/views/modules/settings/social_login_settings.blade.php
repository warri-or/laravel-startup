@extends('admin.layouts.app')
@section('style')
    <link href="{{adminAsset('libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="col-md-12">
        <div class="card-box">
            <label for="social_login"> {{__('Social Login')}} </label>
            <input type="checkbox" id="social_login" {{isset($settings->social_login) && $settings->social_login == ACTIVE ? 'checked' : ''}} class="check_social"  name="social_login" data-plugin="switchery" data-color="#039cfd"/>
        </div>
    </div>
    <div class="col-md-12">
        <div class="social_login_card">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <label for="fb_login"> {{__('Facebook Login')}} </label>
                            <input type="checkbox" id="fb_login" {{isset($settings->facebook_login) && $settings->facebook_login == ACTIVE ? 'checked' : ''}} class="check_social"  name="facebook_login" data-plugin="switchery" data-color="#039cfd"/>
                            <div class="valid-feedback">
                                {{__('Looks good!')}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="facebook_app_id">{{__('Facebook App ID')}}</label>
                                <input type="text" name="facebook_app_id" class="form-control set-settings" id="facebook_app_id" value="{{$settings->facebook_app_id ?? ''}}">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="facebook_app_secret">{{__('Facebook App Secret')}}</label>
                                <input type="text" name="facebook_app_secret" class="form-control set-settings" id="facebook_app_secret" value="{{$settings->facebook_app_secret ?? ''}}">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="facebook_redirect_url">{{__('Facebook Redirect Url')}}</label>
                                <input type="text" name="facebook_redirect_url" class="form-control set-settings" id="facebook_redirect_url" value="{{$settings->facebook_redirect_url ?? ''}}">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <label for="google_login"> {{__('Google Login')}} </label>
                            <input type="checkbox" id="google_login" {{isset($settings->google_login) && $settings->google_login == ACTIVE ? 'checked' : ''}} name="google_login" class="check_social" data-plugin="switchery" data-color="#039cfd"/>
                            <div class="valid-feedback">
                                {{__('Looks good!')}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="google_client_id">{{__('Google Client ID')}}</label>
                                <input type="text" name="google_client_id" class="form-control set-settings" value="{{$settings->google_client_id ?? ''}}" id="google_client_id">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="google_client_secret">{{__('Google Client Secret')}}</label>
                                <input type="text" name="google_client_secret" class="form-control set-settings" value="{{$settings->google_client_secret ?? ''}}" id="google_client_secret">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="google_redirect_url">{{__('Google Redirect Url')}}</label>
                                <input type="text" name="google_redirect_url" class="form-control set-settings" value="{{$settings->google_redirect_url ?? ''}}" id="google_redirect_url">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <label for="linkedin_login"> {{__('LinkedIn Login')}} </label>
                            <input type="checkbox" id="linkedin_login" name="linkedin_login" {{isset($settings->linkedin_login) && $settings->linkedin_login == ACTIVE ? 'checked' : ''}} class="check_social" data-plugin="switchery" data-color="#039cfd"/>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="linkedin_client_id">{{__('LinkedIn Client ID')}}</label>
                                <input type="text" name="linkedin_client_id" class="form-control set-settings" value="{{$settings->linkedin_client_id ?? ''}}" id="linkedin_client_id">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="linkedin_client_secret">{{__('LinkedIn Client Secret')}}</label>
                                <input type="text" name="linkedin_client_secret" class="form-control set-settings" value="{{$settings->linkedin_client_secret ?? ''}}" id="linkedin_client_secret">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="linkedin_redirect_url">{{__('LinkedIn Redirect Url')}}</label>
                                <input type="text" name="linkedin_redirect_url" class="form-control set-settings" value="{{$settings->linkedin_redirect_url ?? ''}}" id="linkedin_redirect_url">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <label for="twitter_login"> {{__('Twitter Login')}} </label>
                            <input type="checkbox" id="twitter_login" name="twitter_login" {{isset($settings->twitter_login) && $settings->twitter_login == ACTIVE ? 'checked' : ''}} class="check_social" data-plugin="switchery" data-color="#039cfd"/>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="twitter_client_id">{{__('Twitter Client ID')}}</label>
                                <input type="text" name="twitter_client_id" class="form-control set-settings" value="{{$settings->twitter_client_id ?? ''}}" id="twitter_client_id">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="twitter_client_secret">{{__('Twitter Client Secret')}}</label>
                                <input type="text" name="twitter_client_secret" class="form-control set-settings" value="{{$settings->twitter_client_secret ?? ''}}" id="twitter_client_secret">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="twitter_redirect_url">{{__('Twitter Redirect Url')}}</label>
                                <input type="text" name="twitter_redirect_url" class="form-control set-settings" value="{{$settings->twitter_redirect_url ?? ''}}" id="twitter_redirect_url">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <label for="github_login"> {{__('Github Login')}} </label>
                            <input type="checkbox" id="github_login" name="github_login" {{isset($settings->github_login) && $settings->github_login == ACTIVE ? 'checked' : ''}} class="check_social" data-plugin="switchery" data-color="#039cfd"/>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="github_client_id">{{__('Github Client ID')}}</label>
                                <input type="text" name="github_client_id" class="form-control set-settings" value="{{$settings->github_client_id ?? ''}}" id="github_client_id">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="github_client_secret">{{__('Github Client Secret')}}</label>
                                <input type="text" name="github_client_secret" class="form-control set-settings" value="{{$settings->github_client_secret ?? ''}}" id="github_client_secret">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="github_redirect_url">{{__('Github Redirect Url')}}</label>
                                <input type="text" name="github_redirect_url" class="form-control set-settings" value="{{$settings->github_redirect_url ?? ''}}" id="github_redirect_url">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{adminAsset('libs/mohithg-switchery/switchery.min.js')}}"></script>
<script>
    $(document).ready(function (){
        checkSocialLogin();
    });

    $('.check_social').on('change',function (){
        const input_name = $(this).attr('name');
        const submit_url = "{{route('adminSettingsSave')}}";
        const option_group = "social_login_settings";
        const formData = new FormData();
        formData.append('option_type', 'text');
        formData.append('option_group', option_group);
        formData.append('option_key', input_name);
        if ($(this).prop('checked') == true){
            formData.append('option_value', "{{ACTIVE}}");
        }else {
            formData.append('option_value', "{{INACTIVE}}");
        }
        makeAjaxPostFile(formData,submit_url).done(function (response){
            if (response.success == true){
                if (input_name == 'social_login'){
                    checkSocialLogin();
                }else {
                    swalSuccess(response.message);
                }
            }else{
                swalError(response.message);
            }

        });
    });

    $('.set-settings').on('blur',function (){
        if ($(this).val().length !== 0){
            const input_name = $(this).attr('name');
            const this_field = $('[name="'+input_name+'"]');
            const submit_url = "{{route('adminSettingsSave')}}";
            const option_group = "social_login_settings";
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

    function checkSocialLogin(){
        if ($('#social_login').prop('checked') == true){
            $('.social_login_card').removeClass('d-none');
        }else {
            $('.social_login_card').addClass('d-none');
        }
    }

</script>
@endsection
