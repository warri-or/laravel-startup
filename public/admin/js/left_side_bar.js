/**
 * LeftSidebar
 * @param {*} $
 */
!function ($) {
    'use strict';

    var LeftSidebar = function () {
        this.body = $('body'),
            this.window = $(window)
    };

    /**
     * Reset the theme
     */
    LeftSidebar.prototype._reset = function () {
        this.body.removeAttr('data-sidebar-color');
        this.body.removeAttr('data-sidebar-size');
        this.body.removeAttr('data-sidebar-showuser');
    },

        /**
         * Changes the color of sidebar
         * @param {*} color
         */
        LeftSidebar.prototype.changeColor = function (color) {
            this.body.attr('data-sidebar-color', color);
            this.parent.updateConfig("sidebar", {"color": color});
        },

        /**
         * Changes the size of sidebar
         * @param {*} size
         */
        LeftSidebar.prototype.changeSize = function (size) {
            this.body.attr('data-sidebar-size', size);
            this.parent.updateConfig("sidebar", {"size": size});
        },

        /**
         * Toggle User information
         * @param {*} showUser
         */
        LeftSidebar.prototype.showUser = function (showUser) {
            this.body.attr('data-sidebar-showuser', showUser);
            this.parent.updateConfig("sidebar", {"showuser": showUser});
        },

        /**
         * Initilizes the menu
         */
        LeftSidebar.prototype.initMenu = function () {
            var self = this;

            var layout = $.LayoutThemeApp.getConfig();
            var sidebar = $.extend({}, layout ? layout.sidebar : {});
            var defaultSidebarSize = sidebar.size ? sidebar.size : 'default';

            // resets everything
            this._reset();

            // Left menu collapse
            $('.button-menu-mobile').on('click', function (event) {
                event.preventDefault();
                var sidebarSize = self.body.attr('data-sidebar-size');
                if (self.window.width() >= 993) {
                    if (sidebarSize === 'condensed') {
                        self.changeSize(defaultSidebarSize);
                    } else {
                        self.changeSize('condensed');
                    }
                } else {
                    self.changeSize(defaultSidebarSize);
                    self.body.toggleClass('sidebar-enable');
                }
            });

            // sidebar - main menu
            if ($("#side-menu").length) {
                var navCollapse = $('#side-menu li .collapse');

                // open one menu at a time only
                navCollapse.on({
                    'show.bs.collapse': function (event) {
                        var parent = $(event.target).parents('.collapse.show');
                        $('#side-menu .collapse.show').not(parent).collapse('hide');
                    }
                });

                // activate the menu in left side bar (Vertical Menu) based on url
                $("#side-menu a").each(function () {
                    var pageUrl = window.location.href.split(/[?#]/)[0];
                    if (checkActiveUrl(pageUrl, this.href)) {
                        $(this).addClass("active");
                        $(this).parent().addClass("menuitem-active");
                        $(this).parent().parent().parent().addClass("show");
                        $(this).parent().parent().parent().parent().addClass("menuitem-active"); // add active to li of the current link

                        var firstLevelParent = $(this).parent().parent().parent().parent().parent().parent();
                        if (firstLevelParent.attr('id') !== 'sidebar-menu')
                            firstLevelParent.addClass("show");

                        $(this).parent().parent().parent().parent().parent().parent().parent().addClass("menuitem-active");

                        var secondLevelParent = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent();
                        if (secondLevelParent.attr('id') !== 'wrapper')
                            secondLevelParent.addClass("show");

                        var upperLevelParent = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent();
                        if (!upperLevelParent.is('body'))
                            upperLevelParent.addClass("menuitem-active");
                    }
                });
            }


            // handling two columns menu if present
            var twoColSideNav = $("#two-col-sidenav-main");
            if (twoColSideNav.length) {
                var twoColSideNavItems = $("#two-col-sidenav-main .nav-link");
                var sideSubMenus = $(".twocolumn-menu-item");

                var nav = $('.twocolumn-menu-item .nav-second-level');
                var navCollapse = $('#two-col-menu li .collapse');

                // open one menu at a time only
                navCollapse.on({
                    'show.bs.collapse': function () {
                        var nearestNav = $(this).closest(nav).closest(nav).find(navCollapse);
                        if (nearestNav.length)
                            nearestNav.not($(this)).collapse('hide');
                        else
                            navCollapse.not($(this)).collapse('hide');
                    }
                });

                twoColSideNavItems.on('click', function (e) {
                    var target = $($(this).attr('href'));

                    if (target.length) {
                        e.preventDefault();

                        twoColSideNavItems.removeClass('active');
                        $(this).addClass('active');

                        sideSubMenus.removeClass("d-block");
                        target.addClass("d-block");

                        // showing full sidebar if menu item is clicked
                        $.LayoutThemeApp.leftSidebar.changeSize('default');
                        return false;
                    }
                    return true;
                });

                // activate menu with no child
                var pageUrl = window.location.href.split(/[?#]/)[0];
                twoColSideNavItems.each(function () {
                    //if (this.href == pageUrl) {
                    if (checkActiveUrl(pageUrl, this.href)) {
                        console.log('ok');
                        $(this).addClass('active');
                    }
                });


                // activate the menu in left side bar (Two column) based on url
                $("#two-col-menu a").each(function () {
                    if (checkActiveUrl(pageUrl, this.href)) {
                        $(this).addClass("active");
                        $(this).parent().addClass("menuitem-active");
                        $(this).parent().parent().parent().addClass("show");
                        $(this).parent().parent().parent().parent().addClass("menuitem-active"); // add active to li of the current link

                        var firstLevelParent = $(this).parent().parent().parent().parent().parent().parent();
                        if (firstLevelParent.attr('id') !== 'sidebar-menu')
                            firstLevelParent.addClass("show");

                        $(this).parent().parent().parent().parent().parent().parent().parent().addClass("menuitem-active");

                        var secondLevelParent = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent();
                        if (secondLevelParent.attr('id') !== 'wrapper')
                            secondLevelParent.addClass("show");

                        var upperLevelParent = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent();
                        if (!upperLevelParent.is('body'))
                            upperLevelParent.addClass("menuitem-active");

                        // opening menu
                        var matchingItem = null;
                        var targetEl = '#' + $(this).parents('.twocolumn-menu-item').attr("id");
                        $("#two-col-sidenav-main .nav-link").each(function () {
                            if ($(this).attr('href') === targetEl) {
                                matchingItem = $(this);
                            }
                        });
                        if (matchingItem) matchingItem.trigger('click');
                    }
                });
            }
        },

        /**
         * Initilize the left sidebar size based on screen size
         */
        LeftSidebar.prototype.initLayout = function () {
            // in case of small size, activate the small menu
            if ((this.window.width() >= 768 && this.window.width() <= 1028) || this.body.data('keep-enlarged')) {
                this.changeSize('condensed');
            } else {
                this.changeSize('default');
            }
        },

        /**
         * Initilizes the menu
         */
        LeftSidebar.prototype.init = function () {
            var self = this;
            this.initMenu();
            this.initLayout();

            // on window resize, make menu flipped automatically
            this.window.on('resize', function (e) {
                e.preventDefault();
                self.initLayout();
            });
        },
        $.LeftSidebar = new LeftSidebar,
        $.LeftSidebar.Constructor = LeftSidebar
}(window.jQuery);
