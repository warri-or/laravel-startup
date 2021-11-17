<div class="form-group">
    <label for="coin_payment_public_key">{{__('Coin Payment Public Key')}}</label>
    <input type="text" name="coin_payment_public_key" value="{{ $settings->coin_payment_public_key ?? ''}}"
           placeholder="{{__('Coin Payment Public Key')}}" class="form-control coin_payment_settings" id="coin_payment_public_key">
    <div class="valid-feedback">
        {{__('Looks good!')}}
    </div>
</div>
<div class="form-group">
    <label for="coin_payment_private_key">{{__('Coin Payment Private Key')}}</label>
    <input type="text" name="coin_payment_private_key" value="{{ $settings->coin_payment_private_key ?? ''}}"
           placeholder="{{__('Coin Payment Private Key')}}" class="form-control coin_payment_settings" id="coin_payment_private_key">
    <div class="valid-feedback">
        {{__('Looks good!')}}
    </div>
</div>
<div class="form-group">
    <label for="coin_payment_minimum_confirms">{{__('Minimum Confirms')}}</label>
    <input type="number" name="coin_payment_minimum_confirms" value="{{ $settings->coin_payment_minimum_confirms ?? ''}}"
           placeholder="{{__('Minimum Confirms')}}" class="form-control coin_payment_settings" id="coin_payment_minimum_confirms">
    <div class="valid-feedback">
        {{__('Looks good!')}}
    </div>
</div>
<div class="form-group">
    <label for="coin_payment_expiration_time">{{__('Expiration Time (MIN)')}}</label>
    <input type="number" name="coin_payment_expiration_time" value="{{ $settings->coin_payment_expiration_time ?? ''}}"
           placeholder="{{__('Expiration Time')}}" class="form-control coin_payment_settings" id="coin_payment_expiration_time">
    <div class="valid-feedback">
        {{__('Looks good!')}}
    </div>
</div>
