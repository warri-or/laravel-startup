@if (isset($message))
    <div class="row">
        <div class="col">
            <div class="mt-2 bg-light p-3 rounded">
                <form method="post" action="{{route('sendMessage')}}" id="send_message_id" class="send_message_class">
                    <div class="row">
                        <div class="col mb-2 mb-sm-0">
                            <input type="hidden" name="messaging_id" id="messaging_id" value="{{$message->id ?? ''}}">
                            <input type="hidden" name="sender" id="sender" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                            <input type="text" class="form-control border-0" placeholder="Enter your text" required name="message" id="message">
                            <div class="invalid-feedback">
                                {{__('Please enter your messsage')}}
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="btn-group">
                                <a href="#" class="btn btn-light"><i class="fe-paperclip"></i></a>
                                <button type="submit" class="btn btn-dark chat-send btn-block"><i class='fe-send'></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@elseif(isset($user))
    <div class="row">
        <div class="col">
            <div class="mt-2 bg-light p-3 rounded">
                <form method="post" action="{{route('sendMessage')}}" id="send_message_id" class="send_message_class">
                    <div class="row">
                        <div class="col mb-2 mb-sm-0">
                            <input type="hidden" name="messaging_id" id="messaging_id" value="">
                            <input type="hidden" name="sender" id="sender" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                            <input type="hidden" name="receiver" id="receiver" value="{{$user->id}}">
                            <input type="hidden" name="event_type" id="event_type" value="{{MESSAGING_TYPE_USER}}">
                            <input type="hidden" name="event_id" id="event_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                            <input type="text" class="form-control border-0" placeholder="Enter your text" required name="message" id="message">
                            <div class="invalid-feedback">
                                {{__('Please enter your messsage')}}
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="btn-group">
                                <a href="#" class="btn btn-light"><i class="fe-paperclip"></i></a>
                                <button type="submit" class="btn btn-dark chat-send btn-block"><i class='fe-send'></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
