<a class="nav-link dropdown-toggle waves-effect waves-light show_new_notification" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
    <i class="fe-bell noti-icon"></i>
    <span class="badge badge-danger rounded-circle noti-icon-badge" id="count_notification">{{countUnreadNotification()}}</span>
</a>
<div class="dropdown-menu dropdown-menu-right dropdown-lg">
    <div class="dropdown-item noti-title">
        <h5 class="m-0">
            <span class="float-right">
                <a href="javascript:void(0);" class="text-dark clear-all-notification">
                    <small>{{__('Clear All')}}</small>
                </a>
            </span>{{__('Notification')}}
        </h5>
    </div>

    <div class="show_notification custom-scrollbar-css">

    </div>

    <a href="{{route('viewAllNotifications')}}" class="dropdown-item text-center text-primary notify-item notify-all">
        {{__('View all')}}
        <i class="fe-arrow-right"></i>
    </a>
</div>

<script src="https://js.pusher.com/3.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.8.1/echo.iife.min.js"></script>

<script>
    Pusher.logToConsole = true;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        wsHost: window.location.hostname,
        wsPort: 6020,
        key: 'test',
        forceTLS: false,
        disableStats: true,
        enabledTransports: ['ws', 'wss']
    });
    Pusher.logToConsole = true;
    Echo.channel('admin_notification').listen('.admin_event', (response) => {
        // notifyIconUpdate();
        // makeToast(response.body, response.title);
        console.log(response);
        console.log('working')
    });

    $(document).on('click','.show_new_notification',function (){
        makeAjax("{{route('showNewNotification')}}").done(function (response){
            let new_notifications = response.data.new_notifications;
            let show_new_notifications = new_notifications.map(function (item){
                let body = JSON.parse(item.body);
                let user_image = "{{asset(get_image_path('user'))}}"+"/"+body.user_image;
                let default_image = "{{adminAsset('images/users/avatar.png')}}";
                let active_status = item.status == 0 ? 'make-notification-read active': '';
                return `<a href="javascript:void(0);" class="dropdown-item notify-item ${active_status}" data-id="${item.id}">
                            <div class="notify-icon">
                                <img src="${user_image}" class="img-fluid rounded-circle" alt="" onerror='this.src="${default_image}"'/>
                            </div>
                            <p class="notify-details">${body.username}</p>
                            <p class="text-muted mb-0 user-msg">
                                <small>${body.title}</small>
                            </p>
                        </a>`;
            }).join(' ');
            console.log(show_new_notifications);
            $('.show_notification').html(show_new_notifications);
        })
    });

    $(document).on('click','.clear-all-notification',function (){
        makeAjax("{{route('clearAllNotification')}}").done(function(response){
            if (response.success == true){
                Toast.fire({type: 'success', text: response.message});
                $('.show_notification').html('');
                $('#count_notification').html('0');
            }else{
                Toast.fire({type: 'warning', text: response.message});
            }
        })
    })

    $(document).on('click','.make-notification-read',function (){
        let data = {
            id : $(this).data('id')
        };
        let this_item = $(this);
        makeAjaxPost(data,"{{route('makeNotificationRead')}}").done(function(response){
            if (response.success == true){
                this_item.removeClass('active');
                notifyIconUpdate('decrement');
            }
        })
    })

    function callPusher(){
        Pusher.logToConsole = true;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            wsHost: window.location.hostname,
            wsPort: 6020,
            wssPort: 443,
            key: 'test',
            cluster: 'mt1',
            encrypted: false,
            disableStats: true
        });
    }

    function callTriggeredNotification(channel){
        Pusher.logToConsole = true;
        Echo.channel(channel).listen('.client-event', (response) => {
            notifyIconUpdate();
            makeToast(response.body, response.title);
        });
    }

    function makeToast(title, body) {
        toastr.success(title, body);
        toastr.options.timeOut = 3000;
        toastr.options.fadeOut = 3000;
    }

    function notifyIconUpdate(type='increment') {
        let count = $('#count_notification').html() == '' ? 0 : $('#count_notification').html();
        let new_count = parseInt(count);
        if (type == 'increment'){
             new_count = new_count + 1;
        }else {
             new_count = new_count - 1;
        }

        $('#count_notification').html(new_count);
        $('#count_notification').show();

    }
</script>
