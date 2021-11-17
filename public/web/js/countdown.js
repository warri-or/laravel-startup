!function (t) {
    t.fn.countdown = function (e, u) {
        var l = t.extend({
            date: null,
            offset: null,
            day: "Day",
            days: "Days",
            hour: "Hour",
            hours: "Hours",
            minute: "Minute",
            minutes: "Minutes",
            second: "Second",
            seconds: "Seconds"
        }, e);
        l.date || t.error("Date is not defined."), Date.parse(l.date) || t.error("Incorrect date format, it should look like this, 12/24/2012 12:00:00.");
        var c = this, h = function () {
            var e = new Date, t = e.getTime() + 6e4 * e.getTimezoneOffset();
            return new Date(t + 36e5 * l.offset)
        }, x = setInterval(function () {
            var e = new Date(l.date) - h();
            if (e < 0) return clearInterval(x), void (u && "function" == typeof u && u());
            var t = 36e5, n = Math.floor(e / 864e5), o = Math.floor(e % 864e5 / t), r = Math.floor(e % t / 6e4),
                i = Math.floor(e % 6e4 / 1e3), s = 1 === n ? l.day : l.days, d = 1 === o ? l.hour : l.hours,
                a = 1 === r ? l.minute : l.minutes, f = 1 === i ? l.second : l.seconds;
            n = 2 <= String(n).length ? n : "0" + n, o = 2 <= String(o).length ? o : "0" + o, r = 2 <= String(r).length ? r : "0" + r, i = 2 <= String(i).length ? i : "0" + i, c.find(".days").text(n), c.find(".hours").text(o), c.find(".minutes").text(r), c.find(".seconds").text(i), c.find(".days_text").text(s), c.find(".hours_text").text(d), c.find(".minutes_text").text(a), c.find(".seconds_text").text(f)
        }, 1e3)
    }
}(jQuery);
