function callEcho(){
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
}

function receiveNotification(channel_name,event_name,callback){
    Echo.channel(channel_name).listen('.'+event_name, (response) => {
        callback(response);
    });
}

function triggerNotification(channel_name,event_name,data,){
    let pusher = new Pusher('test', {
        wsHost: window.location.hostname,
        wsPort: 6020,
        forceTLS: false,
        disableStats: true,
        enabledTransports: ['ws', 'wss']
    });
    let channel = pusher.subscribe(channel_name);
    channel.bind("pusher:subscription_succeeded", () => {
        var triggered = channel.trigger(event_name,data);
    });
}
