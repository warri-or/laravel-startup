@extends('admin.layouts.app',['menu'=>'auction','sub_menu'=>'messaging'])
@section('style')
    <link href="{{adminAsset('css/chat.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <div class="col-md-4 col-xl-4 col-lg-4">
        <div class="card-box">
            <h4 class="header-title mb-2">{{__('Search user')}}</h4>
            <div class="input-icons mb-3">
                <i class="fa fa-search icon"></i>
                <input type="text" name="search_user" id="searchKey" class="input-field form-control" placeholder="{{__('Search')}}">
            </div>
            <div class="row">
                <div class="col">
                    <div class="custom-scrollbar-css" id="messaging-list">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xl-8 col-lg-8 show_message_details">

    </div>

@endsection

@section('script')
    <script src="{{adminAsset('js/notification.js')}}"></script>
    <script>
        $(document).ready(function (){
            getUserMessages(1);
            searchMessage();
        });

        $(document).on('click','.show_message',function (){
            let message_id = $(this).data('message-id');
            let data = {
                message_id : message_id
            }
            $(this).find('.auction_seen_count').hide();
            $(this).find('.auction_seen').addClass('text-muted');
            $('.media').removeClass('bg-soft-success');
            $(this).find('.media').addClass('bg-soft-success');
            add_loader(false);
            makeAjaxPostText(data, "{{route('showMessageDetails')}}").done (function (response) {
                remove_loader();
                $('.show_message_details').html(response);
            });
        });


        function getUserMessages(page){
            const ENDPOINT = "{{ url('/') }}";
            const EVENT_TYPE = "{{ MESSAGING_TYPE_USER }}";

            loadMessageList(page);

            $(document).on('click','.load_more',function () {
                page++;
                loadMessageList(page);
            });

            function loadMessageList(page,load_type='initial') {
                const ROUTE_URL = ENDPOINT + "/get-event-message/"+EVENT_TYPE+'/'+load_type+"?page=" + page;
                makeAjaxText(ROUTE_URL).done(function (response){
                    $('#messaging-list').append(response);
                    let data = {
                        message_id : $('.first_message').data('message-id')
                    }
                    makeAjaxPostText(data, "{{route('showMessageDetails')}}").done (function (response) {
                        $('.show_message_details').html(response);
                    });
                });
            }
        }

        function searchMessage(){
            $(document).on('keyup','#searchKey',function (){
                const search_key = $(this).val();
                const data = {
                    search_key : search_key,
                    event_type : "{{MESSAGING_TYPE_USER}}"
                }
                if (search_key.length > 0){
                    makeAjaxPostText(data,"{{route('getAllMessageList')}}").done(function (response){
                        $('#messaging-list').html(response);
                        showAllMessages();
                    });
                }else {
                    $('#messaging-list').html('')
                    getUserMessages(1);
                }
            });
        }

        function showAllMessages(){
            $('#search_people').on('click','.show_more_people',function (){
                let user_id = $(this).data('user-id');
                let data = {
                    user_id : user_id
                }
                add_loader(false);
                makeAjaxPostText(data, "{{route('showMessageDetails')}}").done (function (response) {
                    remove_loader();
                    $('.show_message_details').html(response);
                });
            });
        }


    </script>

@endsection
