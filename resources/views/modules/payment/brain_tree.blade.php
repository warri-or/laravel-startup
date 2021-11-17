<div class="text-center">
    <input type="hidden" name="payment_type" value="{{PAYMENT_PURPOSE_1}}" class="payment_type">
    <div class="ajax-load"></div>
    <div id="dropin-container"></div>
    <button id="submit-button" class="btn btn-info btn-sm">{{__('Request payment method')}}</button>
</div>
<script>
    $(document).ready(function (){
        brainTreeOperationCall();
        add_loader();
    });

    function brainTreeOperationCall() {
        $.getScript("https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js", function() {
            let button = document.querySelector('#submit-button');
            braintree.dropin.create({
                authorization: "{{Braintree\ClientToken::generate()}}",
                container: '#dropin-container'
            }, function (createErr, instance) {
               remove_loader();
                button.addEventListener('click', function () {
                    instance.requestPaymentMethod(function (err, payload) {
                        var submit_url = "{{route('paymentByBrainTree')}}";
                        var formData = {
                            event_id : 1,
                            payment_type : $('.payment_type').val(),
                            payload : payload
                        };
                        makeAjaxPost(formData,submit_url,null).done(function (response){
                            if (response.success) {
                                swalRedirect("{{route('paymentComplete',['status'=>'completed'])}}",response.message,'success')
                            } else {
                                swalError(response.message);
                            }
                        });
                    });
                });

            });
        });

    }


</script>
