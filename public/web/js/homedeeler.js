function countDownEndAuction(className='auction_end') {
    $('.'+className).each(function (){
        let counter_id = $(this).attr('id');
        let endDate = $(this).data('value');
        if(endDate.length > 0 && typeof endDate == 'string'){
            let counterElement = document.querySelector("#"+counter_id);
            let myCountDown = new ysCountDown(endDate, function (remaining, finished) {
                let message = "";
                if (finished) {
                    message = "Expired";
                } else {
                    var re_days = remaining.totalDays;
                    var re_hours = remaining.hours;
                    message += re_days + "d  : ";
                    message += re_hours + "h  : ";
                    message += remaining.minutes + "m  : ";
                    message += remaining.seconds + "s";
                }
                counterElement.textContent = message;
            });
        }

    });
}
