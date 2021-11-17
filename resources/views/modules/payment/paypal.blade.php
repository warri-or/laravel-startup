<form class="paypal_payment_class" id="paypal_payment_id" action="{{ route('paymentByPaypal') }}" method="post">
    @csrf
    <div class="card-box">
        <div class="">
            <div class="row">
                <input type="hidden" name="payment_type" value="{{PAYMENT_PURPOSE_1}}">
                <div class="col-12 text-center">
                    <button class="btn btn-primary btn-block submit_paypal_payment" type="submit"><i class="fab fa-paypal"></i> {{__('Pay With Paypal')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>

