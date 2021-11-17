@extends('admin.layouts.app')
@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="error-text-box">
                        <svg viewBox="0 0 600 200">
                            <!-- Symbol-->
                            <symbol id="s-text">
                                <text text-anchor="middle" x="50%" y="50%" dy=".35em">403!</text>
                            </symbol>
                            <!-- Duplicate symbols-->
                            <use class="text" xlink:href="#s-text"></use>
                            <use class="text" xlink:href="#s-text"></use>
                            <use class="text" xlink:href="#s-text"></use>
                            <use class="text" xlink:href="#s-text"></use>
                            <use class="text" xlink:href="#s-text"></use>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="mt-0 mb-2">{{__('Whoops! Permission denied')}} </h3>
                        <p class="text-muted mb-3">{{__('It\'s looking like you may have taken a wrong turn.You have no permission of this page.Do you want to go to dashboard ?')}}</p>
                        @if(\Illuminate\Support\Facades\Auth::user()->default_module_id == MODULE_USER_ADMIN)
                            <a href="{{route('adminHome')}}" class="btn btn-success waves-effect waves-light">{{__('Back to Dashboard')}}</a>
                        @elseif(\Illuminate\Support\Facades\Auth::user()->default_module_id == MODULE_USER)
                            <a href="{{route('productManagerHome')}}" class="btn btn-success waves-effect waves-light">{{__('Back to Dashboard')}}</a>
                        @elseif(\Illuminate\Support\Facades\Auth::user()->default_module_id == MODULE_PRODUCTION_MANAGEMENT)
                            <a href="" class="btn btn-success waves-effect waves-light">Back to Dashboard</a>
                        @elseif(\Illuminate\Support\Facades\Auth::user()->default_module_id == MODULE_CRM_MANAGEMENT))
                             <a href="" class="btn btn-success waves-effect waves-light">Back to Dashboard</a>
                        @endif
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->


        </div> <!-- container -->

    </div> <!-- content -->
@endsection
