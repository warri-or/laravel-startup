<!DOCTYPE html>
<html lang="en">
<head>
    @php($settings = __options(['site_settings', 'logo_settings', 'social_settings']))
    <meta charset="utf-8" />
    <title>{{$settings->app_title ?? env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Brande e compania" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{isset($settings->favicon_logo) && !empty($settings->favicon_logo) ? asset(get_image_path('settings').'/'.$settings->favicon_logo) :  adminAsset('images/favicon.ico')}}">

    <!-- App css -->
    <link href="{{adminAsset('css/bootstrap-saas.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{adminAsset('css/bootstrap-saas-dark.css')}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />

    <link href="{{adminAsset('css/app-saas.css')}}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
    <link href="{{adminAsset('css/app-saas-dark.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />

    <!-- icons -->
    <link href="{{adminAsset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body class="bg-light">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        @yield('content')
    </div>
    <!-- end container -->
</div>
<!-- end page -->


<footer class="footer footer-alt text-white-50">
    <p></p>
</footer>

<!-- Vendor js -->

<!-- App js -->
<script src="{{adminAsset('vendors/jQuery.min.js')}}"></script>
<script src="{{adminAsset('vendors/bootstrap.bundle.min.js')}}"></script>
<script src="{{adminAsset('js/app.js')}}"></script>

</body>
</html>
