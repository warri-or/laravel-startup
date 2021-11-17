@extends('auth.layout.app',['title'=>'Reset password'])
@section('content')
    @php($settings = __options(['logo_settings']))
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-pattern">
                @if(Session::has('message'))
                    <div class="alert alert-success alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        {!! Session::get('message') !!}
                    </div>
                @endif
                @if(Session::has('dismiss'))
                    <div class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        {{Session::get('dismiss')}}
                    </div>
                @endif
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        {{Session::get('success')}}
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
                        <p class="text-muted mb-4 mt-3">{{__('Change your password from here.')}}</p>
                    </div>

                    <form method="post" action="{{ route('changePassword') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="">{{__('Password')}}</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimum 6 character">
                            @if($errors->first('password'))<span class="text-danger">{{$errors->first('password')}}</span> @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="">{{__('Confirm Password')}}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Minimum 6 character">
                            @if($errors->first('password_confirmation'))<span class="text-danger">{{$errors->first('password_confirmation')}}</span> @endif
                        </div>
                        <div class="form-group mb-0 text-center">
                            <input type="hidden" name="remember_token" value="{{ $remember_token ?? '' }}">
                            <button class="btn btn-primary btn-block" type="submit"> {{__('Reset Password ')}}</button>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div>
            <!-- end card -->

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p> <a href="{{route('login')}}" class="text-white-50 ml-1">{{__('Sign In?')}}</a></p>
                </div>
            </div>

        </div>
    </div>
@endsection
