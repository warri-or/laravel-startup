<div id="addPaymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <h4 class="modal-title text-center">{{__('Make Payment')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="add_payment_body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light text-dark waves-effect" data-dismiss="modal">{{__('Cancel')}}</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        resetValidation('make-payment')
        submitOperation(function (response){
            if (response.success == true){
                swalSuccess(response.message);
                window.location.reload();
            }else {
                swalError(response.message);
            }
        },'make_payment');
    });


</script>

