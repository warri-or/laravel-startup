<div class="card-box text-center">
    <img src="{{getUserAvatar($user)}}" class="rounded-circle avatar-xxl img-thumbnail"
         alt="profile-image">
    <h4 class="mb-0">{{$user->name ?? ''}}</h4>
    <p class="text-muted mb-0">{{ROLES[$user->role]}}</p>
    <p class="text-muted">{{__('Balance: ')}} {{$user->balance}}</p>
    <div class="text-left mt-3">
        <h4 class="font-13 text-uppercase">{{__('About :')}}</h4>
        <hr>
        <p class="text-muted mb-2 font-13"><strong>{{__('Full Name :')}}</strong> <span class="ml-2">{{$user->name ?? ''}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('Mobile :')}}</strong><span class="ml-2">{{$user->phone ?? '--'}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('Email :')}}</strong> <span class="ml-2 ">{{$user->email ?? ''}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('Date of birth :')}}</strong> <span class="ml-2 ">{{$user->date_of_birth ?? 'DD-MM-YYYY'}}</span></p>
        <p class="text-muted mb-2 font-13"><strong>{{__('Timezone :')}}</strong> <span class="ml-2 ">{{$user->time_zone ?? ''}}</span></p>
    </div>
</div> <!-- end card-box -->
