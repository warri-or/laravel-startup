<div class="card-box">
    <h4 class="header-title"><i class="fa fa-money-bill-wave"></i> {{__('Payment Option Entry')}}</h4>
    <form action="{{route('storePaymentOption')}}" novalidate class="mt-3" method="POST" id="payment_option_form">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{__('Payment Options')}}</label> <br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="bank" name="payment_type" class="custom-control-input payment_option" value="Bank" checked>
                        <label class="custom-control-label" for="bank">{{__('Bank')}}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="card" name="payment_type" class="custom-control-input payment_option" value="Card">
                        <label class="custom-control-label" for="card">{{__('Card')}}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="coin" name="payment_type" class="custom-control-input payment_option" value="Coin">
                        <label class="custom-control-label" for="coin">{{__('Coin')}}</label>
                    </div>
                </div>
                <hr/>
                <div class="payment_option_show for_bank">
                    @include('admin.profile.payment_option.payment_add.bank')
                </div>

                <div class="payment_option_show for_card d-none">
                    @include('admin.profile.payment_option.payment_add.card')
                </div>

                <div class="payment_option_show for_coin d-none">
                    @include('admin.profile.payment_option.payment_add.coin')
                </div>


                <button type="submit" class="btn btn-dark btn-lg basic_submit" data-style="zoom-in"><i class="fa fa-save"></i> {{__('Save')}}</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).on('click','.payment_option',function (){
        let id = $(this).attr('id');
        $('.payment_option_show').addClass('d-none');
        $('.for_'+id).removeClass('d-none');
    })
</script>
