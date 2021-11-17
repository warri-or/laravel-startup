<div class="card">
    @if(!empty($user->nid_picture) && file_exists(get_image_path('user').$user->nid_picture))
        <a href=""><img class="card-img-top" src="{{asset(get_image_path('user').$user->nid_picture)}}" alt="" height="300"></a>
    @else
        <span class="badge badge-danger text-center text-light p-2 font-15">{{__('Nid card not provided yet.')}}</span>
    @endif
    <div class="card-body">
        <p class="card-text">{{__('NID: ')}} {{$user->nid ?? 'XXXXXXXXXXXX'}}</p>
        <p class="card-text">{{__('TIN: ')}} {{$user->tin ?? 'XXXXXXXXXXXX'}}</p>
    </div>
</div>
