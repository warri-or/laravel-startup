<div class="card-box">
    <h3 class="card-header">{{ __('Two Factor Authentication') }}</h3>
    <p>{{ __('Add additional security to your account using two factor authentication.') }}</p>
    <div class="row">
        <div class="col-md-12">
            <h4>
                @if (! auth()->user()->two_factor_secret)
                    {{ __('You have not enabled two factor authentication.') }}
                    <form method="POST" action="{{url('user/two-factor-authentication')}}">
                        @csrf
                        <button data-style="zoom-in" type="submit" class="btn btn-primary">{{__('Enable')}}</button>
                    </form>
                @else
                    {{ __('You have  enabled two factor authentication.') }}
                    <form method="POST" action="{{url('user/two-factor-authentication')}}">
                        @csrf
                        @method('DELETE')
                        <button data-style="zoom-in" type="submit" class="btn btn-primary">{{__('Disabled')}}</button>
                    </form>
                @endif
            </h4>
            <p>
                {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
            </p>

            @if (auth()->user()->two_factor_secret)
                <div class="mt-5">
                    @if(session('status') == 'two-factor-authentication-enabled')
                        <p>You have enabled two factor authentication . Please follow QR code into your phone</p>
                        {!! auth()->user()->twoFactorQrCodeSvg() !!}

                        <p>Please store these recovery codes in a secure location</p>
                        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                            {{ trim($code) }} <br>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
