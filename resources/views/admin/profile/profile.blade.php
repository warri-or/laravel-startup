@extends('admin.layouts.app',['menu'=>'settings','sub_menu'=>'profileSettings','title'=>__('Profile settings')])
@section('style')
    <link href="{{adminAsset('libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="col-lg-4 col-xl-4">
        @include('admin.profile.profile_card')
        @include('admin.profile.password_settings')
    </div>
    <div class="col-lg-8 col-xl-8">

        <div class="card-box">
            <ul class="nav nav-pills navtab-bg nav-justified">
                <li class="nav-item">
                    <a href="#profileSettings" data-toggle="tab" aria-expanded="true" class="nav-link active"><i class="fa fa-user-edit"></i> &nbsp;{{__('Profile Settings')}}</a>
                </li>
                <li class="nav-item">
                    <a href="#addressSettings" data-toggle="tab" aria-expanded="false" class="nav-link"><i class="fa fa-address-book"></i> &nbsp;{{__('Address Settings')}}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="profileSettings">
                    @include('admin.profile.basic_settings')
                </div>
                <div class="tab-pane" id="addressSettings">
                    @include('admin.profile.address_settings')
                </div>

            </div>
        </div>
{{--        @include('admin.profile.two-factor-authentication-form')--}}
    </div>
@endsection

@section('script')
    <script src="{{adminAsset('libs/flatpickr/flatpickr.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            submitOperation(submitResponse, 'submit_basic');
            submitOperation(submitResponse, 'submit_address');
            submitOperation(submitPasswordResponse, 'submit_password');
            function submitResponse(response, this_form){
                if (response.success == true) {
                    swalRedirect("{{Request::url()}}",response.message,'success');
                } else {
                    swalError(response.message);
                }
            }
            function submitPasswordResponse(response, this_form){
                if (response.success == true) {
                    swalRedirect("{{Request::url()}}",response.message,'success');
                } else {
                    swalError(response.message);
                }
            }
        });
    </script>
@endsection
