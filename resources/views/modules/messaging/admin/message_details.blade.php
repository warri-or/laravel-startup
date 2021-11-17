<div class="card ajax-load">
    <div class="card-body py-2 px-3 border-bottom border-light">
        @if(isset($message))
            @if($message->sender == \Illuminate\Support\Facades\Auth::user()->id)
                <div class="media py-1">
                    <img src="{{isset($message->receiver_image) ? asset(get_image_path().'/'.$message->receiver_image ?? '') : ''}}" class="mr-2 rounded-circle" height="36" onerror='this.src="{{adminAsset('images/users/avatar.png')}}"'>
                    <div class="media-body">
                        <h5 class="mt-0 mb-0 font-15">
                            <a href="#" class="text-reset">{{$message->receiver_name ?? ''}}</a>
                        </h5>
                        <p class="mt-1 mb-0 text-muted font-12">
                            <small class="mdi mdi-circle text-success"></small> {{__('Online')}}
                        </p>
                    </div>
                </div>
            @else
                <div class="media py-1">
                    <img src="{{isset($message->sender_image) ? asset(get_image_path().'/'.$message->sender_image ?? '') : ''}}" class="mr-2 rounded-circle" height="36" onerror='this.src="{{adminAsset('images/users/avatar.png')}}"'>
                    <div class="media-body">
                        <h5 class="mt-0 mb-0 font-15">
                            <a href="#" class="text-reset">{{$message->sender_name ?? ''}}</a>
                        </h5>
                        <p class="mt-1 mb-0 text-muted font-12">
                            <small class="mdi mdi-circle text-success"></small> {{__('Online')}}
                        </p>
                    </div>
                </div>
            @endif
        @elseif(isset($user))
            <div class="media py-1">
                <img src="{{isset($user->profile_photo_path) ? asset(get_image_path().'/'.$user->profile_photo_path ?? '') : ''}}" class="mr-2 rounded-circle" height="36" onerror='this.src="{{adminAsset('images/users/avatar.png')}}"'>
                <div class="media-body">
                    <h5 class="mt-0 mb-0 font-15">
                        <a href="#" class="text-reset">{{$user->name ?? ''}}</a>
                    </h5>
                    <p class="mt-1 mb-0 text-muted font-12">
                        <small class="mdi mdi-circle text-success"></small> {{__('Online')}}
                    </p>
                </div>
            </div>
        @endif
    </div>
    <div class="card-body">
        <ul class="conversation-list custom-scrollbar-css" id="conversationListId">
            @include('modules.messaging.admin.conversation_list')
        </ul>
        @include('modules.messaging.admin.message_sending_form')
    </div>
</div>
<script>
    $(document).ready(function (){
        var message_id = '{{$message->id ?? false}}';
        if(message_id){
            const channel_name = 'user_message_'+message_id;
            const event_name = 'user_messaging';
            getUserMessage(channel_name,event_name);
        }
        let count = parseInt("{{$count ?? 0}}");
        $("#conversationListId").scrollTop($("#conversationListId")[0].scrollHeight);
        $('#conversationListId').scroll(function(){
            if ($('#conversationListId').scrollTop() == 0){
                const data ={
                    event_id : "{{$message->event_id ?? ''}}",
                    page : count
                }
               makeAjaxPostText(data,"{{route('loadMessagesByScroll')}}").done(function (response){
                   if (response.success == true){
                       const messages = response.data.message;
                       const message_array = messages.map(function (item){
                          return prepareMessageConversation(item);
                       }).join('');

                       count ++;
                       $('#conversationListId').prepend(message_array);
                   }
               });
            }
        });
    })
    submitOperation(messageResponse,'chat-send');
    function messageResponse(response,this_form){
        this_form.find('#message').val('');
    }

    function getUserMessage($channel_name,$event_name){
        receiveNotification($channel_name,$event_name,appendUserMessage)
    }

    function appendUserMessage(response){
        const message_body = response.body.message_details_single;
        const last_message = prepareMessageConversation(message_body);
        $('#conversationListId').append(last_message);
        $('#conversationListId').scrollTop($('#conversationListId')[0].scrollHeight);
    }

    function prepareMessageConversation(item){
        const type = item.sender == {{\Illuminate\Support\Facades\Auth::user()->id}} ? '' : 'odd';
        const image = "{{asset(get_image_path().'/')}}"+item.sender_image;
        const default_image = "{{adminAsset('images/users/avatar.png')}}";
        const name = item.sender_name;
        const message = item.message;

        return `<li class="clearfix ${type}">
                           <div class="chat-avatar">
                               <img src="${image}" class="rounded" onerror='this.src="${default_image}"' />
                           </div>
                           <div class="conversation-text">
                               <div class="ctext-wrap">
                                   <i>${name}</i>
                                   <p>${message}</p>
                               </div>
                           </div>
                       </li>`;
    }

</script>



