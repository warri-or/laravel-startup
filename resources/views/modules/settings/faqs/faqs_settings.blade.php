@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'faqsSettings'])
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12">
        @include('modules.settings.faqs.faq_lists')
    </div>
    @include('modules.settings.faqs.faq_add_edit')
@endsection
@section('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            var data_url = "{{route('faqsSettings')}}";
            var delete_url = "{{route('deleteFaqsItem')}}";
            let order_route = "{{route('order')}}"+"?table=faqs"+"&column=order";
            var data_column =  [
                {"data": "order", visible: false},
                {"data": "move"},
                {"data": "question"},
                {"data": "answer"},
                {"data": "status"},
                {"data": "action",orderable: false, searchable: false}
            ];
            renderOrderAbleDataTable($('#faqs_table'),data_url,data_column,order_route);

            $(document).on('click','#create_faq',function (){
                clearFaqs();
                $('#faq-modal').modal('show');
            });

            $(document).on('click','.edit_item',function (){
                let data = {
                    id : $(this).data('id')
                }
                makeAjaxPostText(data,"{{route('getFaqItemById')}}",null).done(function (response){
                    $('#question').val(response.question);
                    $('#answer').val(response.answer)
                    $('.status').val(response.status);
                    $('#id').val(response.id);
                    $('#faq-modal').modal('show');
                });
            });

            $(document).on('click','.close_modal',function (){
                clearFaqs();
                $(this).closest('.modal').modal('hide');
            })

            submitOperation(submitResponse, 'submit_basic');
            deleteOperation(deleteResponse,'delete_item',delete_url);

            function submitResponse(response, this_form){
                if (response.success == true) {
                    this_form.removeClass('was-validated');
                    clearFaqs();
                    $('.modal').modal('hide');
                    swalSuccess(response.message);
                    renderOrderAbleDataTable($('#faqs_table'),data_url,data_column,order_route);
                } else {
                    swalError(response.message);
                }
            }

            function deleteResponse(response){
                if(response.success == false) {
                    swalError(response.message);
                } else {
                    swalSuccess(response.message);
                    renderOrderAbleDataTable($('#faqs_table'),data_url,data_column,order_route);
                }
            }

            function clearFaqs(){
                $('#question').val('');
                $('#answer').val('')
                $('.status').val('');
                $('#id').val('');
            }

        });

    </script>
@endsection
