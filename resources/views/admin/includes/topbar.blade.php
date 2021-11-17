<div class="navbar-custom">
    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-right mb-0">
            <li class="dropdown notification-list">
                @include('admin.includes.notifications')
            </li>
            <li class="dropdown notification-list">
                <a href="javascript:void(0);" class="nav-link right-bar-toggle nav-user">
                    <img src="{{getUserAvatar(\Illuminate\Support\Facades\Auth::user())}}" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ml-1"> {{\Illuminate\Support\Facades\Auth::user()->name ?? ''}} <i class="mdi mdi-chevron-down"></i> </span>
                </a>
            </li>
        </ul>

        @if(\Illuminate\Support\Facades\Auth::user()->default_module_id == MODULE_SUPER_ADMIN)
            <div class="logo-box">
                <a href="{{route('superAdminHome')}}" class="logo logo-dark text-center">
                    <span class="logo-sm"><img src="{{isset($settings->app_logo_small) && !empty($settings->app_logo_small) ? asset(get_image_path('settings').'/'.$settings->app_logo_small) : adminAsset('images/logo-light.png') }}" alt="" height="50"></span>
                    <span class="logo-lg"><img src="{{isset($settings->app_logo_large) && !empty($settings->app_logo_large) ? asset(get_image_path('settings').'/'.$settings->app_logo_large) : adminAsset('images/logo-dark.png') }}" alt="" height="50"></span>
                </a>
                <a href="{{route('superAdminHome')}}" class="logo logo-light text-center">
                    <span class="logo-sm"><img src="{{isset($settings->app_logo_small) && !empty($settings->app_logo_small) ? asset(get_image_path('settings').'/'.$settings->app_logo_small) : adminAsset('images/logo-light.png') }}" alt="" height="50"></span>
                    <span class="logo-lg"><img src="{{isset($settings->app_logo_large) && !empty($settings->app_logo_large) ? asset(get_image_path('settings').'/'.$settings->app_logo_large) : adminAsset('images/logo-dark.png') }}" alt="" height="50"></span>
                </a>
            </div>
        @elseif(\Illuminate\Support\Facades\Auth::user()->default_module_id == MODULE_USER_ADMIN)
            <div class="logo-box">
                <a href="{{route('adminHome')}}" class="logo logo-dark text-center">
                    <span class="logo-sm"><img src="{{isset($settings->app_logo_small) && !empty($settings->app_logo_small) ? asset(get_image_path('settings').'/'.$settings->app_logo_small) : adminAsset('images/logo-light.png') }}" alt="" height="50"></span>
                    <span class="logo-lg"><img src="{{isset($settings->app_logo_large) && !empty($settings->app_logo_large) ? asset(get_image_path('settings').'/'.$settings->app_logo_large) : adminAsset('images/logo-dark.png') }}" alt="" height="50"></span>
                </a>
                <a href="{{route('adminHome')}}" class="logo logo-light text-center">
                    <span class="logo-sm"><img src="{{isset($settings->app_logo_small) && !empty($settings->app_logo_small) ? asset(get_image_path('settings').'/'.$settings->app_logo_small) : adminAsset('images/logo-light.png') }}" alt="" height="50"></span>
                    <span class="logo-lg"><img src="{{isset($settings->app_logo_large) && !empty($settings->app_logo_large) ? asset(get_image_path('settings').'/'.$settings->app_logo_large) : adminAsset('images/logo-dark.png') }}" alt="" height="50"></span>
                </a>
            </div>
        @endif

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>
            <li>
                <!-- Mobile menu toggle (Horizontal Layout)-->
                <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>
</div>
