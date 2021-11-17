@php($settings = __options(['payment_settings']))
@if(isset($settings->payment_method))
    @if($settings->payment_method == 'stripe')
        <div class="stripe-payment">
            @include('admin.auction.add_product.price.payment.stripe')
        </div>
    @elseif($settings->payment_method == 'brain_tree')
        <div class="braintree-payment">
            @include('admin.auction.add_product.price.payment.brain_tree')
        </div>
    @elseif($settings->payment_method == 'paypal')
        <div class="paypal-payment">
            @include('admin.auction.add_product.price.payment.paypal')
        </div>
    @endif
@endif
