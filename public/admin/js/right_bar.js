/**
 * RightBar
 * @param {*} $
 */
!function ($) {
    'use strict';

    var RightBar = function () {
        this.body = $('body'),
            this.window = $(window)
    };

    /**
     * Select the option based on saved config
     */
    RightBar.prototype.selectOptionsFromConfig = function() {
        var self = this;

        var config = self.layout.getConfig();

        if (config) {
            $('input[type=radio][name=color-scheme-mode][value=' + config.mode + ']').prop('checked', true);

            $('input[type=radio][name=menus-position][value=' + config.menuPosition + ']').prop('checked', true);

            $('input[type=radio][name=leftsidebar-color][value=' + config.sidebar.color + ']').prop('checked', true);
            $('input[type=radio][name=leftsidebar-size][value=' + config.sidebar.size + ']').prop('checked', true);
            $('input[type=checkbox][name=leftsidebar-user]').prop('checked', config.sidebar.showuser);

            $('input[type=radio][name=topbar-color][value=' + config.topbar.color + ']').prop('checked', true);
        }
    },

        /**
         * Toggles the right sidebar
         */
        RightBar.prototype.toggleRightSideBar = function() {
            var self = this;
            self.body.toggleClass('right-bar-enabled');
            self.selectOptionsFromConfig();
        },

        /**
         * Initilizes the right side bar
         */
        RightBar.prototype.init = function() {
            var self = this;

            // right side-bar toggle
            $(document).on('click', '.right-bar-toggle', function () {
                self.toggleRightSideBar();
            });

            $(document).on('click', 'body', function (e) {
                if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
                    return;
                }

                if ($(e.target).closest('.left-side-menu, .side-nav').length > 0 || $(e.target).hasClass('button-menu-mobile')
                    || $(e.target).closest('.button-menu-mobile').length > 0) {
                    return;
                }

                $('body').removeClass('right-bar-enabled');
                $('body').removeClass('sidebar-enable');
                return;
            });

            // overall color scheme
            $('input[type=radio][name=color-scheme-mode]').change(function () {
                self.layout.changeMode($(this).val());
            });

            // menus-position
            $('input[type=radio][name=menus-position]').change(function () {
                self.layout.changeMenuPositions($(this).val());
            });

            // left sidebar color
            $('input[type=radio][name=leftsidebar-color]').change(function () {
                self.layout.leftSidebar.changeColor($(this).val());
            });

            // left sidebar size
            $('input[type=radio][name=leftsidebar-size]').change(function () {
                self.layout.leftSidebar.changeSize($(this).val());
            });

            // left sidebar user information
            $('input[type=checkbox][name=leftsidebar-user]').change(function (e) {
                self.layout.leftSidebar.showUser(e.target.checked);
            });

            // topbar
            $('input[type=radio][name=topbar-color]').change(function () {
                self.layout.topbar.changeColor($(this).val());
            });

            // reset
            $('#resetBtn').on('click', function (e) {
                e.preventDefault();
                // reset to default
                self.layout.reset();
                self.selectOptionsFromConfig();
            });
        },

        $.RightBar = new RightBar, $.RightBar.Constructor = RightBar
}(window.jQuery);
