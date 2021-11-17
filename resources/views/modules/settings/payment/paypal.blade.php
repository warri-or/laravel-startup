<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">{{__('Paypal Environment')}}</label>
            <input type="text" name="paypal_env" value="{{ $settings->paypal_env ?? ''}}"
                   placeholder="Paypal Environment" class="form-control set-settings" id="paypal_env">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">{{__('Client ID')}}</label>
            <input type="text" name="paypal_client_id" value="{{ $settings->paypal_client_id ?? ''}}"
                   placeholder="Client ID" class="form-control set-settings" id="paypal_client_id">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">{{__('Secret')}}</label>
            <input type="text" name="paypal_secret"  value="{{ $settings->paypal_secret ?? ''}}"
                   placeholder="Secret" class="form-control set-settings" id="paypal_secret">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
</div>
