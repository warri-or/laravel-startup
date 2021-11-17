!function ($) {
    "use strict";
    var Components = function () { };

    //initializing tooltip
    Components.prototype.initTooltipPlugin = function () {
        $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip()
    },

    //initializing popover
    Components.prototype.initPopoverPlugin = function () {
        $.fn.popover && $('[data-toggle="popover"]').popover()
    },

    //initializing toast
    Components.prototype.initToastPlugin = function() {
        $.fn.toast && $('[data-toggle="toast"]').toast()
    },

    //initializing form validation
    Components.prototype.initFormValidation = function () {
        $(".needs-validation").on('submit', function (event) {
            $(this).addClass('was-validated');
            if ($(this)[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
            return true;
        });
    },

    // Counterup
    Components.prototype.initCounterUp = function() {
        var delay = $(this).attr('data-delay')?$(this).attr('data-delay'):100; //default is 100
        var time = $(this).attr('data-time')?$(this).attr('data-time'):1200; //default is 1200
        $('[data-plugin="counterup"]').each(function(idx, obj) {
            $(this).counterUp({
                delay: delay,
                time: time
            });
        });
    },

    Components.prototype.initTippyTooltips = function () {
        if($('[data-plugin="tippy"]').length > 0)
            tippy('[data-plugin="tippy"]');
    },

    Components.prototype.initShowPassword = function () {
        $("[data-password]").on('click', function() {
            if($(this).attr('data-password') == "false"){
                $(this).siblings("input").attr("type", "text");
                $(this).attr('data-password', 'true');
                $(this).addClass("show-password");
            } else {
                $(this).siblings("input").attr("type", "password");
                $(this).attr('data-password', 'false');
                $(this).removeClass("show-password");
            }
        });
    },

    Components.prototype.initMultiDropdown = function () {
        $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            var $subMenu = $(this).next(".dropdown-menu");
            $subMenu.toggleClass('show');

            return false;
        });
    },

    //initilizing
    Components.prototype.init = function () {
        this.initTooltipPlugin();
        this.initPopoverPlugin();
        this.initToastPlugin();
        this.initFormValidation();
        this.initCounterUp();
        this.initTippyTooltips();
        this.initShowPassword();
        this.initMultiDropdown();
    },

    $.Components = new Components,
        $.Components.Constructor = Components

}(window.jQuery),

function ($) {
    'use strict';

    var App = function () {
        this.$body = $('body'),
            this.$window = $(window)
    };

    /**
     * Initlizes the controls
     */
    App.prototype.initControls = function () {
        /*----------Preloader---------*/
        $(window).on('load', function () {
            $('#status').delay(200).fadeOut();
            $('#preloader').delay(200).fadeOut('slow');
        });
        /*----------Full Screen---------*/
        $('[data-toggle="fullscreen"]').on("click", function (e) {
            e.preventDefault();
            $('body').toggleClass('fullscreen-enable');
            if (!document.fullscreenElement && /* alternative standard method */ !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        });
        document.addEventListener('fullscreenchange', exitHandler );
        document.addEventListener("webkitfullscreenchange", exitHandler);
        document.addEventListener("mozfullscreenchange", exitHandler);
        function exitHandler() {
            if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
                console.log('pressed');
                $('body').removeClass('fullscreen-enable');
            }
        }
    },

    //initilizing
    App.prototype.init = function () {
        $.Components.init();
        this.initControls();

        // init layout
        this.layout = $.LayoutThemeApp;
        this.rightBar = $.RightBar;
        this.rightBar.layout = this.layout;
        this.layout.rightBar = this.rightBar;

        this.layout.init();
        this.rightBar.init(this.layout);
    },

    $.App = new App,
        $.App.Constructor = App;

    $.App.init();
}(window.jQuery);
Waves.init();
