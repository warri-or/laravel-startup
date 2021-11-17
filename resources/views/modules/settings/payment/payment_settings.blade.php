@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'paymentSettings'])
@section('style')
    <link href="{{adminAsset('libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="col-md-12">
        <div class="page-title-box">
            <h4 class="page-title"><i class="fa fa-cogs"></i> {{__('Payment settings')}}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header text-center">
                <label for="card_payment"> {{__('Card')}} </label>
                <input type="checkbox" id="card_payment" {{isset($settings->card_payment) && $settings->card_payment == ACTIVE ? 'checked' : ''}} class="check_payment"  name="card_payment" data-plugin="switchery" data-color="#039cfd"/>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="radio radio-info form-check-inline">
                        <input type="radio" id="brainTree" value="brain_tree" name="card_payment_method" @if(isset($settings->card_payment_method) && $settings->card_payment_method == 'brain_tree') checked @endif class="set-payment-setting">
                        <label for="brainTree"> {{__('Braintree')}} </label>
                    </div>
                    <div class="radio radio-info form-check-inline">
                        <input type="radio" id="stripe" value="stripe" name="card_payment_method" @if(isset($settings->card_payment_method) && $settings->card_payment_method == 'stripe') checked @endif class="set-payment-setting">
                        <label for="stripe"> {{__('Stripe')}} </label>
                    </div>
                </div>
                <div class="show_payment_settings brain_tree @if(isset($settings->card_payment_method) && $settings->card_payment_method == 'brain_tree') @else d-none @endif">
                    @include('modules.settings.payment.brain_tree')
                </div>
                <div class="show_payment_settings stripe @if(isset($settings->card_payment_method) && $settings->card_payment_method == 'stripe') @else d-none @endif">
                    @include('modules.settings.payment.stripe')
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header text-center">
                <label for="paypal_payment"> {{__('Paypal')}} </label>
                <input type="checkbox" id="paypal_payment" {{isset($settings->paypal_payment) && $settings->paypal_payment == ACTIVE ? 'checked' : ''}} class="check_payment"  name="paypal_payment" data-plugin="switchery" data-color="#039cfd"/>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="card-body">
                @include('modules.settings.payment.paypal')
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header text-center">
                <label for="btc_payment"> {{__('BTC')}} </label>
                <input type="checkbox" id="btc_payment" {{isset($settings->btc_payment) && $settings->btc_payment == ACTIVE ? 'checked' : ''}} class="check_payment"  name="btc_payment" data-plugin="switchery" data-color="#039cfd"/>
                <div class="valid-feedback">
                    {{__('Looks good!')}}
                </div>
            </div>
            <div class="card-body">
                @include('modules.settings.payment.coin_payment_settings')
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{adminAsset('libs/mohithg-switchery/switchery.min.js')}}"></script>
    <script>
        $('.check_payment').on('change',function (){
            if ($(this).val().length !== 0){
                const input_name = $(this).attr('name');
                const submit_url = "{{route('adminSettingsSave')}}";
                const option_group = "payment_settings";
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
                       swalSuccess(response.message);
                   }else {
                       swalError(response.message);
                   }
                });
            }

        });

        $('.set-settings').on('blur',function (){
            if ($(this).val().length !== 0){
                const input_name = $(this).attr('name');
                const this_field = $(this);
                const submit_url = "{{route('adminSettingsSave')}}";
                const option_group = "payment_settings";
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

        $('.set-payment-setting').on('change',function (){
            if ($(this).val().length !== 0){
                const input_name = $(this).attr('name');
                const active_class = $(this).val();
                const submit_url = "{{route('adminSettingsSave')}}";
                const option_group = "payment_settings";
                const formData = new FormData();
                formData.append('option_type', 'text');
                formData.append('option_group', option_group);
                formData.append('option_key', input_name);
                formData.append('option_value', $(this).val());
                makeAjaxPostFile(formData,submit_url,null).done(function (response){
                    if (response.success == true){
                        $('.show_payment_settings').addClass('d-none');
                        $('.'+active_class).removeClass('d-none');
                    }
                })
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
