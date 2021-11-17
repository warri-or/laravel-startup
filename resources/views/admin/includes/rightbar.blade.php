<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="p-3">
            <img src="{{getUserAvatar(\Illuminate\Support\Facades\Auth::user())}}" class="rounded avatar-xxl img-thumbnail" alt="profile-image" id="profile_image">
            <h4 class="">{{\Illuminate\Support\Facades\Auth::user()->name ?? ''}}</h4>
            <h5 class="">{{\Illuminate\Support\Facades\Auth::user()->email ?? ''}}</h5>
            <hr/>
            <h5><a href="{{ route('profile') }}" class="text-dark"> <i class="fe-user"></i> {{__('Profile Settings')}} </a></h5>
            <h5><a href="{{ route('profile') }}" class="text-dark"> <i class="fe-lock"></i> {{__('Password Change')}} </a></h5>
            <hr/>
            <h5>
                <div class="py-2 border-t border-theme-40 dark:border-dark-3">
                    <a href="{{ route('logout') }}" class="text-danger"> <i class="fa fa-sign-out-alt"></i> Logout </a>
                </div>
            </h5>
        </div>
    </div> <!-- end slimscroll-menu-->
</div>

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
