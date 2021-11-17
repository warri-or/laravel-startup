@extends('auth.layout.app',['title'=>'Login'])
@section('content')
    @php($settings = __options(['logo_settings']))
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-pattern">
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

                    <form class="mt-4" action="{{ url('two-factor-challenge') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="code">{{__('Code')}}</label>
                            <input class="form-control" type="text" id="code" required="" placeholder="Code" name="code">
                            @if($errors->first('code'))
                                <span class="text-danger">{{$errors->first('code')}}</span> @endif
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button data-style="zoom-in" class="btn btn-primary btn-block" type="submit"> {{__('Submit')}} </button>
                        </div>

                    </form>

                    <form class="mt-4" action="{{ url('two-factor-challenge') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="recovery_code">{{__('Enter your recovery code')}}</label>
                            <input class="form-control" type="text" id="recovery_code" required="" placeholder="Code" name="recovery_code">
                            @if($errors->first('recovery_code'))
                                <span class="text-danger">{{$errors->first('recovery_code')}}</span> @endif
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button data-style="zoom-in" class="btn btn-primary btn-block" type="submit"> {{__('Submit')}} </button>
                        </div>

                    </form>

                </div> <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
    </div>
@endsection
