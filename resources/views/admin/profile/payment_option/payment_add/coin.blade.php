<div class="form-group">
    <label>{{__('Coin Type')}}</label> <br>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="BTC" name="coin_type" class="custom-control-input" checked value="BTC">
        <label class="custom-control-label" for="BTC">{{__('BTC')}}</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" id="ETHEREUM" name="coin_type" class="custom-control-input" value="ETHEREUM">
        <label class="custom-control-label" for="ETHEREUM">{{__('ETHEREUM')}}</label>
    </div>
    <hr>
    <div class="form-group">
        <label for="coin_address">{{__('Coin Address')}}<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="coin_address" name="coin_address" placeholder="{{__('Coin Address')}}">
    </div>
    <p class="text-danger sub-header mt-2">{{__('Please recheck once again your Payment credentials before saved')}}</p>
</div>
