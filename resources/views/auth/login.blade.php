@extends('auth.layout.app',['title'=>'Login'])
@section('content')
        @php($settings = __options(['logo_settings','social_login_settings']))
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark">
                <div class="card-body p-4">
                    <div class="text-center w-75 m-auto mb-3">
                        <div class="auth-logo">
                            <a href="{{url('/')}}" class="logo logo-dark text-center">
                                <span class="logo-lg">
                                    <img src="{{isset($settings->app_logo_large) && !empty($settings->app_logo_large) ? asset(get_image_path('settings').'/'.$settings->app_logo_large) : adminAsset('images/logo-light.png') }}" alt="" height="35">
                                </span>
                            </a>

                            <a href="{{url('/')}}" class="logo logo-light text-center">
                                <span class="logo-lg">
                                    <img src="{{isset($settings->app_logo_large) && !empty($settings->app_logo_large) ? asset(get_image_path('settings').'/'.$settings->app_logo_large) : adminAsset('images/logo-dark.png') }}" alt="" height="35">
                                </span>
                            </a>
                        </div>
                    </div>

                    <form class="my-4" novalidate action="{{ route('postLogin') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="text-light" for="emailaddress">{{__('Email address')}}</label>
                            <input class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email" name="email">
                            @if($errors->first('email'))
                                <span class="text-danger">{{$errors->first('email')}}</span> @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="text-light" for="password">{{__('Password')}}</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password">
                                <div class="input-group-append" data-password="false">
                                    <div class="input-group-text">
                                        <span class="password-eye font-12"></span>
                                    </div>
                                </div>
                            </div>
                            @if($errors->first('password'))
                                <span class="text-danger">{{$errors->first('password')}}</span> @endif
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button data-style="zoom-in" class="btn btn-pink btn-block text-light" type="submit"> {{__('Log In')}} </button>
                        </div>
                    </form>
                    @include('auth.social_login')
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible text-center" role="alert">
                            <button data-style="zoom-in" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            {!! Session::get('message') !!}
                        </div>
                    @endif
                    @if(Session::has('dismiss'))
                        <div class="alert alert-danger alert-dismissible text-center" role="alert">
                            <button data-style="zoom-in" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            {{Session::get('dismiss')}}
                        </div>
                    @endif
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible text-center" role="alert">
                            <button data-style="zoom-in" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            {{Session::get('success')}}
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <p>
                            <a href="{{route('forgetPassword')}}" class="text-white-50 ml-1">{{__('Forgot your password?')}}</a>
                        </p>
                    </div>
                </div>

            </div>
            <!-- end card -->
        </div>
    </div>
@endsection
