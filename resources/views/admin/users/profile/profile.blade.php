@extends('admin.layouts.app',['menu'=>'users','sub_menu'=>'users','title'=>__('User Details')])
@section('content')
    <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12 col-xs-12">
        @include('admin.users.profile.profile_card')
    </div>
    <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12 col-xs-12">
        @include('admin.users.profile.address_card')
    </div>
    <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12 col-xs-12">
        @include('admin.users.profile.nid_card')
    </div>
@endsection

@section('script')

@endsection
