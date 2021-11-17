<div class="ajax-load">
    <div class="text-center mb-3">
        <h4>{{__('Total Charge: ')}} <span id="btc_price_show"></span> BTC</h4>
    </div>
    <div class="card-box text-center">
        <input type="hidden" name="auction_id" class="auction_id_payment" value="{{$auction_id}}">
        <input type="hidden" name="live_start_time" class="live_start_time_payment" value="{{$live_start_time}}">
        <input type="hidden" name="live_duration" class="live_duration_payment" value="{{$live_duration}}">
        <input type="hidden" name="amount" class="amount" value="{{$live_charge}}">
        <input type="hidden" name="amount_in_btc" class="amount_in_btc" value="">
        <input type="hidden" name="payment_type" value="{{PAYMENT_TYPE_LIVE_CHARGE}}" class="payment_type">
        <button class="btn btn-primary" id="btc_payment_submit" data-style="zoom-in">{{__('Pay With BTC Balance')}}</button>
        <button class="btn btn-info" id="add_btc_balance">{{__('Add BTC Balance')}}</button>
    </div>
    <div class="card-box text-center" id="btc_address_show">

    </div>
</div>

<script>
    $(document).on('click','#btc_payment_submit',function (){
        Ladda.bind(this);
        let load = $(this).ladda();
        let data = {
            auction_id : $('.auction_id_payment').val(),
            live_start_time : $('.live_start_time_payment').val(),
            live_duration : $('.live_duration_payment').val(),
            amount : $('.amount').val(),
            amount_in_btc : $('.amount_in_btc').val(),
            payment_type : $('.payment_type').val()
        }
        makeAjaxPostText(data,"{{route('liveChargePaymentWithBtcBalance')}}",load).done(function (response){
            if (response.success == true){
                swalRedirect("{{route('editAuction',['slug'=>$auction->slug])}}",response.message,'success')
            }else {
                swalError(response.message);
            }
        });
    });

    $(document).on('click','#add_btc_balance',function (){
        Ladda.bind(this);
        let load = $(this).ladda();
        let data = {
            auction_id : "{{$auction_id}}",
            type : "{{LIVE_AUCTION_CHARGE_PAYMENT}}",
        }
        makeAjaxPostText(data,"{{route('generateCoinPaymentAddress')}}",load).done(function (response){
            $('#btc_address_show').html(response);
        });
    })

</script>
