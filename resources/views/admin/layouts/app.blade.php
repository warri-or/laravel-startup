<!DOCTYPE html>
<html lang="en">
@php($settings = __options(['site_settings', 'logo_settings', 'social_settings']))
@php($menu = isset($menu) && !empty($menu) ? $menu : '')
@php($sub_menu = isset($sub_menu) && !empty($sub_menu)  ? $sub_menu : '')

<head>
    <meta charset="utf-8"/>
    <title>
        {{$settings->app_title ?? env('APP_NAME')}}
        @if (trim($__env->yieldContent('title')))
            :: @yield('title')
        @endif
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="laraframe" content="{{ csrf_token() }}"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{isset($settings->favicon_logo) && !empty($settings->favicon_logo) ? asset(get_image_path('settings').'/'.$settings->favicon_logo) :  adminAsset('images/favicon.png')}}">

    @include('admin.includes.header_asset')
</head>

<body data-layout-mode="{{$settings->layout ?? 'two-column'}}" {{--detached--}}
data-layout='{"mode": "{{$settings->theme ?? 'light'}}",
                      "menuPosition": "{{$settings->menu_position ?? 'fixed'}}",
                      "sidebar": {
                          "color": "{{$settings->sidebar_theme ?? 'light'}}" {{--gradient | Brand | dark | light--}}
                      },
                      "topbar": {"color": "{{$settings->theme_topbar ?? 'light'}}"}
       }' class="px-0">
<div id="wrapper">
    @include('admin.includes.topbar')
    <!-- ========== Left Sidebar Start ========== -->
    @include('admin.includes.leftsidebar')
    <!-- Left Sidebar End -->

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="" id="preloader">
                    <div id="status">
                        <div class="spinner-grow avatar-lg text-secondary"></div>
                    </div>
                </div>
                <div class="row py-3">

                    @yield('content')
                </div>
            </div>
        </div>
        @include('admin.includes.footer')
    </div>
</div>
<!-- END wrapper -->

<!-- Right Sidebar -->
@include('admin.includes.rightbar')
<!-- /Right-bar -->
@include('admin.includes.footer_asset')

</body>
</html>
