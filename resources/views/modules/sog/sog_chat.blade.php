@extends('admin.layouts.app',['menu'=>'auction','sub_menu'=>'messaging'])
@section('style')
    <link href="{{adminAsset('css/chat.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <div class="col-md-4 col-xl-4 col-lg-4">
        <div class="card-box">
            <h4 class="header-title mb-2">{{__('Search user')}}</h4>
            <div class="input-icons mb-3">
                <i class="fa fa-search icon"></i>
                <input type="text" name="search_user" id="searchKey" class="input-field form-control" placeholder="{{__('Search')}}">
            </div>
            <div class="row">
                <div class="col">
                    <div class="custom-scrollbar-css" id="messaging-list">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xl-8 col-lg-8 show_message_details">

    </div>

@endsection

@section('script')


@endsection
