<div class="card-box text-center">
    <h4 class="font-13 text-uppercase">{{__('Address')}}</h4>
    <hr>
    <div class="text-left mt-3">
        <p class="text-muted mb-2 font-13"><strong>{{__('Country :')}}</strong> <span class="ml-2">{{$user->country ?? ''}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('City :')}}</strong><span class="ml-2">{{$user->city ?? '--'}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('State :')}}</strong> <span class="ml-2 ">{{$user->state ?? ''}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('Post Code :')}}</strong> <span class="ml-2 ">{{$user->post_code ?? ''}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('Address :')}}</strong> <span class="ml-2 ">{{$user->address ?? ''}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('Secondary Address :')}}</strong> <span class="ml-2 ">{{$user->address_secondary ?? ''}}</span></p>
    </div>
</div> <!-- end card-box -->

