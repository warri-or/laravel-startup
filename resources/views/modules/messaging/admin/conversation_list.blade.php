@if (isset($message_details) && !empty($message_details[0]))
    @foreach($message_details as $message_chat)
        <li class="clearfix @if($message_chat['sender'] != \Illuminate\Support\Facades\Auth::user()->id) odd @endif">
            <div class="chat-avatar">
                <img src="{{asset(get_image_path().'/'.$message_chat['sender_image'])}}" class="rounded" onerror='this.src="{{adminAsset('images/users/avatar.png')}}"' />
            </div>
            <div class="conversation-text">
                <div class="ctext-wrap">
                    <i>{{$message_chat['sender_name']}}</i>
                    <p>
                        {{$message_chat['message']}}
                    </p>
                </div>
            </div>
        </li>
    @endforeach
@endif



