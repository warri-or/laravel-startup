@if(isset($messages) && !empty($messages[0]))
    <h4 class="header-title">{{__('My Messages')}}</h4>
    <hr>
    @foreach($messages as $index=>$message)
        @if($message->sender == \Illuminate\Support\Facades\Auth::user()->id)
            <a href="javascript:void(0);" class="text-body show_message {{isset($load_type) && $load_type == 'initial' && $index == 0 ? 'first_message' : ''}}" data-message-id="{{$message->id}}">
                <div class="media border-radius-1 {{isset($load_type) && $load_type == 'initial' && $index == 0 ? 'bg-soft-success' : ''}} p-2">
                    <img src="{{!empty($message->receiver_image) && asset(get_image_path().'/'.$message->receiver_image)}}" onerror ='this.src="{{adminAsset('images/users/avatar.png')}}"' class="mr-2 rounded-circle" height="42"/>
                    <div class="media-body">
                        <h5 class="mt-0 mb-1 auction_seen font-15">
                            {{$message->receiver_name}}
                        </h5>
                        <p>{{$message->last_message}}</p>
                    </div>
                </div>
            </a>
        @else
            <a href="javascript:void(0);" class="text-body show_message {{isset($load_type) && $load_type == 'initial' && $index == 0 ? 'first_message' : ''}}" data-message-id="{{$message->id}}">
                <div class="media border-radius-1 {{isset($load_type) && $load_type == 'initial' && $index == 0 ? 'bg-soft-success' : ''}} p-2">
                    <img src="{{!empty($message->sender_image) && asset(get_image_path().'/'.$message->sender_image)}}" onerror ='this.src="{{adminAsset('images/users/avatar.png')}}"' class="mr-2 rounded-circle" height="42"/>
                    <div class="media-body">
                        <h5 class="mt-0 mb-1 auction_seen font-15">
                            {{$message->sender_name}}
                        </h5>
                        <p>{{$message->last_message}}</p>
                    </div>
                </div>
            </a>
        @endif
    @endforeach
@endif

@if(isset($more_people))
    <h4 class="mt-2">{{__('More People')}}</h4>
    <hr>
    <div id="search_people">
        @foreach($more_people as $people)
            <a href="javascript:void(0);" class="text-body show_more_people" data-user-id="{{$people->id}}">
                <div class="media border-radius-1 p-2">
                    <img src="{{!empty($message->sender_image) && asset(get_image_path().'/'.$people->profile_photo_path)}}" onerror ='this.src="{{adminAsset('images/users/avatar.png')}}"' class="mr-2 rounded-circle" height="42"/>
                    <div class="media-body">
                        <h5 class="mt-0 mb-1 auction_seen font-15">
                            {{$people->name}}
                        </h5>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endif

