@extends('admin.layouts.app',['menu'=>'home','sub_menu'=>'home'])
@section('content')
    <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card-box">
            <div class="row">
                @if($status == 'completed')
                    <div class="col-md-12">
                        <div class="text-center">
                            <p class="text-muted mb-1 text-truncate text-success">Payment Completed</p>
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="text-center">
                            <p class="text-muted mb-1 text-truncate text-success">Payment Failed</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{adminAsset('libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
    <script src="{{adminAsset('libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
@endsection

