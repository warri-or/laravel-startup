<div class="left-side-menu">
    <div class="h-100" >
        <div class="sidebar-content">
            <div class="sidebar-icon-menu h-100" data-simplebar>
                <!-- LOGO -->
                @if(\Illuminate\Support\Facades\Auth::user()->default_module_id == MODULE_SUPER_ADMIN)
                    <a href="{{route('superAdminHome')}}" class="logo">
                        <span>
                            <img src="{{isset($settings->app_logo_small) && !empty($settings->app_logo_small) ?  asset(get_image_path('settings').'/'.$settings->app_logo_small) : adminAsset('images/logo-sm-dark.png')}}" alt="" height="50">
                        </span>
                    </a>
                @elseif(\Illuminate\Support\Facades\Auth::user()->default_module_id == MODULE_USER_ADMIN)
                    <a href="{{route('adminHome')}}" class="logo">
                        <span>
                            <img src="{{isset($settings->app_logo_small) && !empty($settings->app_logo_small) ?  asset(get_image_path('settings').'/'.$settings->app_logo_small) : adminAsset('images/logo-sm-dark.png')}}" alt="" height="50">
                        </span>
                    </a>
                @endif

                <nav class="nav flex-column" id="two-col-sidenav-main">
                    {!! mainMenuAppend('#product-management', __('Product Management'), 'fas fa-boxes fa-2x', $menu, 'auctions', [MODULE_SUPER_ADMIN, MODULE_USER_ADMIN, MODULE_USER]) !!}
                    {!! mainMenuAppend('#user-management', 'User Management', 'fas fa-users fa-2x', $menu, 'user', [MODULE_SUPER_ADMIN, MODULE_USER_ADMIN]) !!}
                    {!! mainMenuAppend('#settings', 'Settings', 'fa fa-cogs fa-2x', $menu, 'settings') !!}
                </nav>
            </div>
            <!--- Sidemenu -->
            <div class="sidebar-main-menu">
                <div id="two-col-menu" class="h-100" data-simplebar>
                    @if(check_module_permission(MODULE_SUPER_ADMIN)|| check_module_permission(MODULE_USER_ADMIN) || check_module_permission(MODULE_USER))
                        <div class="twocolumn-menu-item @if(!empty($menu) && $menu == 'auctions') d-block @endif" id="product-management">
                            @include('admin.includes.left_menus.product_management')
                        </div>
                    @endif
                    @if(check_module_permission(MODULE_SUPER_ADMIN)|| check_module_permission(MODULE_USER_ADMIN))
                        <div class="twocolumn-menu-item @if(!empty($menu) && $menu == 'user') d-block @endif" id="user-management">
                            @include('admin.includes.left_menus.user_management')
                        </div>
                    @endif
                    <div class="twocolumn-menu-item @if(!empty($menu) && $menu == 'settings') d-block @endif" id="settings">
                        @include('admin.includes.left_menus.settings')
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

