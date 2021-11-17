<div class="text-center">
    <div class="radio radio-info form-check-inline">
        <input type="radio" id="card_payment" value="card_payment" name="payment_type" class="check_payment_type" checked>
        <label for="card"> {{__('Card')}} </label>
    </div>
    <div class="radio radio-info form-check-inline">
        <input type="radio" id="btc_payment" value="btc_payment" name="payment_type" class="check_payment_type">
        <label for="btc"> {{__('BTC')}} </label>
    </div>
</div>
<div class="card_payment">
    @include('modules.payment.card')
</div>
<div class="btc_payment d-none">
    @include('modules.coin_payment')
</div>
<script>
    $(document).on('change','.check_payment_type',function (){
        if ($(this).val() == 'card_payment'){
            $('.card_payment').removeClass('d-none');
            $('.btc_payment').addClass('d-none');
        }else {
            $('.btc_payment').removeClass('d-none');
            $('.card_payment').addClass('d-none');
            if ($('.amount_in_btc').val().length == 0){
                add_loader();
                let data = {
                    price : $('.amount').val()
                }
                makeAjaxPostText(data,"{{route('convertPriceToBtcPrice')}}").done(function (response){
                    if (response.success == true){
                        $('.amount_in_btc').val(response.data.btc_price);
                        $('#btc_price_show').html(response.data.btc_price);
                        remove_loader();
                    }else {
                        swalError(response.message);
                        remove_loader();
                    }
                })
            }
        }
    })
</script>
