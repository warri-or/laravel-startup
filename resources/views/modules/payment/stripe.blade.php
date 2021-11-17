<form role="form" action="{{ route('paymentByStripe') }}" method="post" class="require-validation"
      data-cc-on-file="false"
      data-stripe-publishable-key="{{ $settings->stripe_key ?? '' }}"
      id="payment-form">
    @csrf
    <div class="card-box">
        <div class="row">
            <input type="hidden" name="payment_type" value="{{PAYMENT_PURPOSE_1}}">
            <div class="col-12">
                <div class='form-group'>
                    <label class='control-label'>{{__('Name on Card')}}</label>
                    <input class='form-control' size='4' type='text' required placeholder="Name.">
                </div>
            </div>

            <div class="col-12">
                <div class='form-group'>
                    <label class='control-label'>{{__('Card Number')}}</label>
                    <input autocomplete='off' class='form-control card-number' size='20' type='text' placeholder="**** **** **** ****" required>
                </div>
            </div>

            <div class="col-4 text-center">
                <div class="form-group cvc">
                    <label class='control-label'>{{__('CVC Number')}}</label>
                    <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' required>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="form-group expiration">
                    <label class='control-label'>{{__('Expiration Month')}}</label>
                    <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' required>
                </div>

            </div>
            <div class="col-4 text-center">
                <div class="form-group expiration">
                    <label class='control-label'>{{__('Expiration Year')}}</label>
                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' required>
                </div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary btn-block" type="submit"><i class="fab fa-cc-stripe"></i> {{__('Pay Now')}}</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    var $form = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form         = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
                'input[type=text]', 'input[type=file]',
                'textarea'].join(', '),
            $inputs       = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid         = true;
        $errorMessage.addClass('hide');

        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });

        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }

    });
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.append("<input type='hidden' name='stripe_response' value='" + JSON.stringify(response) + "'/>");
            $form.get(0).submit();
        }
    }
</script>
