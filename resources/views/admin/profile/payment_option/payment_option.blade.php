@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'','title'=>__('Password settings')])
@section('style')
    <link href="{{adminAsset('libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12 col-xs-12">
        @include('admin.profile.payment_option.payment_option_add')
    </div>
    <div class="col-lg-8 col-xl-8 col-md-6 col-sm-12 col-xs-12">
        @include('admin.profile.payment_option.payment_option_list')
    </div>
@endsection
@section('script')
    <script src="{{adminAsset('libs/mohithg-switchery/switchery.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var data_url = "{{route('paymentOption')}}";
            var delete_url = "{{route('deletePaymentOption')}}";
            var edit_url = "{{route('editPaymentOption')}}";
            var data_column = [
                {"data": "payment_type"},
                {"data": "account_info"},
                {"data": "active"},
                {"data": "action", orderable: false, searchable: false}
            ];
            renderDataTable($('#payment_option_list'), data_url, data_column);
            submitOperation(function(response, this_form){
                if (response.success === true) {
                    this_form.trigger("reset");
                    swalSuccess(response.message);
                    renderDataTable($('#payment_option_list'),data_url,data_column);
                } else {
                    swalError(response.message);
                }
            }, 'basic_submit');

            deleteOperation(deleteResponse,'delete_item',delete_url);
            editOperation(editResponse,edit_url);
            function editResponse(){
                submitOperation(submitResponse, 'submit_basic');
            }

            function deleteResponse(response){
                if(response.success == false) {
                    swalError(response.message);
                } else {
                    swalSuccess(response.message);
                    renderDataTable($('#payment_option_list'),data_url,data_column);
                }
            }

            $(document).on('change','.status_change',function (){
                let status_data = {
                    id : $(this).data('id'),
                    user_id : $(this).data('user-id'),
                    status:$(this).data('status')
                }
                let status_change_url = "{{route('userPaymentStatusChange')}}";
                swalConfirm("{{__('Do you really want to change this?')}}").then(function (s) {
                    if(s.value){
                        makeAjaxPost(status_data,status_change_url).done(function (response){
                            if (response.success == true){
                                swalSuccess(response.message);
                            }else {
                                swalError(response.message);
                            }
                        });
                    }
                    renderDataTable($('#payment_option_list'), data_url, data_column);
                });
            });
        });

    </script>

@endsection
