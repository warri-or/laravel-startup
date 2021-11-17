@extends('auth.layout.app',['title'=>'Login'])
@section('content')
        @php($settings = __options(['logo_settings']))
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-pattern">
                @if(Session::has('message'))
                    <div class="alert alert-success alert-dismissible text-center" role="alert">
                        <button data-style="zoom-in" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        {!! Session::get('message') !!}
                    </div>
                @endif
                @if(Session::has('dismiss'))
                    <div data-style="zoom-in" class="alert alert-danger alert-dismissible text-center" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                <div class="card-body p-4">
                    <div class="text-center w-75 m-auto mb-3">
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
                    </div>

                    <form class="mt-4" action="{{ url('user/confirm-password') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="password">{{__('Password')}}</label>
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
                            <button data-style="zoom-in" class="btn btn-primary btn-block" type="submit"> {{__('Confirm Password')}} </button>
                        </div>

                    </form>

                </div> <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
    </div>
@endsection
