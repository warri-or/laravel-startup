@if(isset($settings->social_login) && $settings->social_login == ACTIVE)
    <div class="text-center">
        <h5 class="mt-3 text-muted">{{__('Sign in with')}}</h5>
        <ul class="social-list list-inline mt-3 mb-0">
            @if(isset($settings->facebook_login) && $settings->facebook_login == ACTIVE)
                <li class="list-inline-item">
                    <a href="{{url('auth/facebook')}}" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                </li>
            @endif
            @if(isset($settings->google_login) && $settings->google_login == ACTIVE)
                <li class="list-inline-item">
                    <a href="{{url('auth/google')}}" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                </li>
            @endif
            @if(isset($settings->linkedin_login) && $settings->linkedin_login == ACTIVE)
                <li class="list-inline-item">
                    <a href="{{url('auth/linkedin')}}" class="social-list-item border-info text-info"><i class="mdi mdi-linkedin"></i></a>
                </li>
            @endif
            @if(isset($settings->twitter_login) && $settings->twitter_login == ACTIVE)
                <li class="list-inline-item">
                    <a href="{{url('auth/twitter')}}" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                </li>
            @endif
            @if(isset($settings->github_login) && $settings->github_login == ACTIVE)
                <li class="list-inline-item">
                    <a href="{{url('auth/github')}}" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                </li>
            @endif
        </ul>
    </div>
@endif
