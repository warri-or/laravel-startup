<div class="form-group">
    <label>{{__('Card Type')}}</label> <br>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="Visa" name="card_type" class="custom-control-input" checked value="Visa">
        <label class="custom-control-label" for="Visa">{{__('Visa')}}</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="Master" name="card_type" class="custom-control-input" value="Master">
        <label class="custom-control-label" for="Master">{{__('Master')}}</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="Amex" name="card_type" class="custom-control-input" value="Amex">
        <label class="custom-control-label" for="Amex">{{__('Amex')}}</label>
    </div>
    <hr>
    <div class="form-group">
        <label for="card_name">{{__('Card Name')}}</label>
        <input type="text" class="form-control" id="card_name" name="card_name" placeholder="{{__('Card Name')}}">
    </div>
    <div class="form-group">
        <label for="card_number">{{__('Card Number')}}</label>
        <input type="text" class="form-control" id="card_number" name="card_number" placeholder="{{__('Card Number')}}">
    </div>
    <div class="form-group">
        <label for="expiry_date">{{__('Expiry Date')}}</label>
        <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="{{__('Expiry Date')}}">
    </div>
    <div class="form-group">
        <label for="account_number">{{__('Cvc')}}</label>
        <input type="text" class="form-control" id="cvc" name="cvc" placeholder="{{__('cvc')}}">
    </div>
    <p class="text-danger sub-header mt-2">{{__('Please recheck once again your Payment credentials before saved')}}</p>
</div>
