@extends('admin.layouts.app',['menu'=>'auctions','sub_menu'=>'viewAllNotifications'])
@section('content')
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12 list">
        <div class="card-box">
            <h4 class="header-title">{{__('Notification List')}}</h4>
            <p class="sub-header">
                {{__('Here goes the notification list')}}
            </p>

            <div class="table-responsive">
                <table id="notification_table" class="table table-sm dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th></th>
                        <th>{{__('Image')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Notification')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
            var data_url = "{{route('viewAllNotifications')}}";
            var delete_url = "{{route('deleteNotification')}}";
            var data_column =  [
                {"data": "id", visible: false},
                {"data": "user_image",orderable: false, searchable: false},
                {"data": "username"},
                {"data": "notification"},
                {"data": "action",orderable: false, searchable: false}
            ];
            renderDataTable($('#notification_table'),data_url,data_column);
            deleteOperation(deleteResponse,'delete_item',delete_url);

            function deleteResponse(response){
                if(response.success == false) {
                    swalError(response.message);
                } else {
                    swalSuccess(response.message);
                    renderDataTable($('#notification_table'),data_url,data_column);
                }
            }
        });
    </script>
@endsection
