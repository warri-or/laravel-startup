@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'applicationSettings'])
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('adminSettingsSave')}}" name="application_settings" novalidate method="POST" id="application_setting" class="application_setting_class" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">{{__('Product Image Max Size in MB')}}<span class="text-danger">*</span></label>
                                <input type="text" name="product_image_max_size_in_mb" required value="{{ $settings->product_image_max_size_in_mb ?? ''}}"
                                       placeholder="Ex: 2" class="form-control set-settings" id="product_image_max_size_in_mb">
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
                const input_name = $(this).attr('name');
                const this_field = $(this);
                const submit_url = "{{route('adminSettingsSave')}}";
                const option_group = "application_settings";
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
