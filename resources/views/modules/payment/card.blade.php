<div class="text-center mb-3">
    <h6>{{__('Total Charge ')}}: </h6>
</div>
<div class="text-center card_payment_btn mb-3">
    <button class="btn btn-primary" id="pay_with_card">{{__('Pay With Card')}}</button>
</div>
<div class="text-center ajax-load mb-3" id="card_payment_body">

</div>

<script>
    $(document).on('click','#pay_with_card',function (){
        Ladda.bind(this);
        let load = $(this).ladda();
        add_loader();
        let data = {
            auction_id : "{{$auction_id}}",
            live_start_time : "{{$live_start_time}}",
            live_duration : "{{$live_duration}}",
            total_charge : "{{$live_charge}}"
        }
        makeAjaxPostText(data,"{{route('loadAuctionPaymentBody')}}",load).done(function (response){
            $('#card_payment_body').html(response);
            $('.card_payment_btn').addClass('d-none');
            remove_loader();
        })
    })
</script>

