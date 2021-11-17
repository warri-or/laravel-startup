@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'emailSettings'])
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('adminSettingsSave')}}" novalidate name="site_settings" method="POST" id="email_setting" class="email_setting_class" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mail_mailer">{{__('Mail Mailer')}}</label>
                                <input type="text" name="mail_mailer" value="{{ $settings->mail_mailer ?? ''}}"
                                       placeholder="MAIL_MAILER" class="form-control set_settings" id="mail_mailer">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mail_host">{{__('Mail Host')}}</label>
                                <input type="text" name="mail_host" value="{{ $settings->mail_host ?? ''}}"
                                       placeholder="MAIL_HOST" class="form-control set_settings" id="mail_host">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mail_port">{{__('Mail Port')}}</label>
                                <input type="text" name="mail_port" value="{{ $settings->mail_port ?? ''}}"
                                       placeholder="MAIL_PORT" class="form-control set_settings" id="mail_port">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mail_username">{{__('Mail Username')}}</label>
                                <input type="text" name="mail_username" value="{{ $settings->mail_username ?? ''}}"
                                       placeholder="MAIL_USERNAME" class="form-control set_settings" id="mail_username">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mail_password">{{__('Mail Password')}}</label>
                                <input type="text" name="mail_password" value="{{ $settings->mail_password ?? ''}}"
                                       placeholder="MAIL_PASSWORD" class="form-control set_settings" id="mail_password">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mail_encryption">{{__('Mail Encryption')}}</label>
                                <input type="text" name="mail_encryption" value="{{ $settings->mail_encryption ?? ''}}"
                                       placeholder="MAIL_ENCRYPTION" class="form-control set_settings" id="mail_encryption">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mail_from_address">{{__('Mail From Address')}}</label>
                                <input type="text" name="mail_from_address" value="{{ $settings->mail_from_address ?? ''}}"
                                       placeholder="MAIL_FROM_ADDRESS" class="form-control set_settings" id="mail_from_address">
                                <div class="valid-feedback">
                                    {{__('Looks good!')}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mail_from_name">{{__('Mail From Name')}}</label>
                                <input type="text" name="mail_from_name" value="{{ $settings->mail_from_name ?? ''}}"
                                       placeholder="MAIL_FROM_NAME" class="form-control set_settings" id="mail_from_name">
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
        $('.set_settings').on('blur',function (){
            if ($(this).val().length !== 0){
                const input_name = $(this).attr('name');
                const this_field = $(this);
                const submit_url = "{{route('adminSettingsSave')}}";
                const option_group = "email_settings";
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
