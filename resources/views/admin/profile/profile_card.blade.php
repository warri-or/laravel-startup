<div class="card-box text-center">
    <img src="{{getUserAvatar(\Illuminate\Support\Facades\Auth::user())}}" class="rounded-circle avatar-lg img-thumbnail"
         alt="profile-image">
    <h4 class="mb-0">{{$profile->name ?? ''}}</h4>
    <div class="text-left mt-3">
        <p class="text-muted mb-2 font-13"><strong>{{__('Full Name :')}}</strong> <span class="ml-2">{{$profile->name ?? ''}}</span></p>
        @if(isset($profile->phone))
            <p class="text-muted mb-2 font-13"><strong>{{__('Mobile :')}}</strong><span class="ml-2">{{$profile->phone}}</span></p>
        @endif
        <p class="text-muted mb-2 font-13"><strong>{{__('Email :')}}</strong> <span class="ml-2 ">{{$profile->email}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('Balance :')}}</strong> <span class="ml-2 ">{{getMoney($profile->balance)}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('BTC Balance :')}}</strong> <span class="ml-2 ">{{$profile->btc_balance}} {{__('BTC')}}</span></p>
    </div>
</div>
