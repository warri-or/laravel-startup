@extends('auth.layout.app',['title'=>'Forget password'])
@section('content')
    @php($settings = __options(['logo_settings']))
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-pattern">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-body p-4">

                    <div class="text-center w-75 m-auto">
                        <div class="auth-logo">
                            <a href="" class="logo logo-dark text-center">
                                <span class="logo-lg">
                                    <img src="{{isset($settings->app_logo_large) && !empty($settings->app_logo_large) ? asset(get_image_path('settings').'/'.$settings->app_logo_large) : adminAsset('images/logo-sm.png') }}" alt="" height="22">
                                </span>
                            </a>

                            <a href="" class="logo logo-light text-center">
                                <span class="logo-lg">
                                    <img src="{{isset($settings->app_logo_large) && !empty($settings->app_logo_large) ? asset(get_image_path('settings').'/'.$settings->app_logo_large) : adminAsset('images/logo-sm.png') }}" alt="" height="22">
                                </span>
                            </a>
                        </div>
                        <p class="text-muted mb-4 mt-3">{{__('Enter your email address and we\'ll send you an email with instructions to reset your password.')}}</p>
                    </div>

                    <form action="{{ route('password.email') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="emailaddress">{{__('Email address')}}</label>
                            <input class="form-control" type="email" id="emailaddress" placeholder="Enter your email" name="email">
                            @if($errors->first('email'))<span class="text-danger">{{$errors->first('email')}}</span> @endif
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block" type="submit"> {{__('Reset Password ')}}</button>
                        </div>

                    </form>
                </div> <!-- end card-body -->
            </div>
            <!-- end card -->

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p> <a href="{{route('login')}}" class="text-white-50 ml-1">{{__('Sign In?')}}</a></p>
                    {{--                    <p class="text-white-50">Don't have an account? <a href="auth-register.html" class="text-white ml-1"><b>Sign Up</b></a></p>--}}
                </div>
            </div>

        </div>
    </div>
@endsection

