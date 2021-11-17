<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">{{__('STRIPE KEY')}}</label>
            <input type="text" name="stripe_key" value="{{ $settings->stripe_key ?? ''}}"
                   placeholder="STRIPE_KEY" class="form-control set-settings" id="stripe_key">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">{{__('STRIPE SECRET')}}</label>
            <input type="text" name="stripe_secret" value="{{ $settings->stripe_secret ?? ''}}"
                   placeholder="STRIPE_SECRET" class="form-control set-settings" id="stripe_secret">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
</div>
