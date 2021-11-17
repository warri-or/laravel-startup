<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">{{__('BRAINTREE ENV')}}</label>
            <input type="text" name="brain_tree_env" value="{{ $settings->brain_tree_env ?? ''}}"
                   placeholder="BRAINTREE_ENV" class="form-control set-settings" id="brain_tree_env">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">{{__('BRAINTREE MERCHANT ID')}}</label>
            <input type="text" name="brain_tree_merchant_id"  value="{{ $settings->brain_tree_merchant_id ?? ''}}"
                   placeholder="BRAINTREE_MERCHANT_ID" class="form-control set-settings" id="brain_tree_merchant_id">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">{{__('BRAINTREE PUBLIC KEY')}}</label>
            <input type="text" name="brain_tree_public_key" value="{{ $settings->brain_tree_public_key ?? ''}}"
                   placeholder="BRAINTREE_PUBLIC_KEY" class="form-control set-settings" id="brain_tree_public_key">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="name">{{__('BRAINTREE PRIVATE KEY')}}</label>
            <input type="text" name="brain_tree_private_key" value="{{ $settings->brain_tree_private_key ?? ''}}"
                   placeholder="BRAINTREE_PRIVATE_KEY" class="form-control set-settings" id="brain_tree_private_key">
            <div class="valid-feedback">
                {{__('Looks good!')}}
            </div>
        </div>
    </div>
</div>
