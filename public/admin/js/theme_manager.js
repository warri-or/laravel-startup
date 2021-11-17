
/**
 * Layout and theme manager
 * @param {*} $
 */

!function ($) {
    'use strict';

    // Layout and theme manager

    var LayoutThemeApp = function () {
        this.body = $('body'),
            this.window = $(window),
            this.config = {},
            // styles
            this.defaultBSStyle = $("#bs-default-stylesheet");
            this.darkBSStyle = $("#bs-dark-stylesheet");
            this.defaultAppStyle = $("#app-default-stylesheet");
            this.darkAppStyle = $("#app-dark-stylesheet");
    };

    /**
     * Preserves the config in memory
     */
    LayoutThemeApp.prototype._saveConfig = function(newConfig) {
        this.config = $.extend(this.config, newConfig);
        // NOTE: You can make ajax call here to save preference on server side or localstorage as well
    },

        /**
         * Update the config for given config
         * @param {*} param
         * @param {*} config
         */
        LayoutThemeApp.prototype.updateConfig = function(param, config) {
            var newObj = {};
            if (typeof config === 'object' && config !== null) {
                var originalParam = this.config[param];
                newObj[param] = $.extend(originalParam, config);
            } else {
                newObj[param] = config;
            }
            this._saveConfig(newObj);
        }

    /**
     * Loads the config - takes from body if available else uses default one
     */
    LayoutThemeApp.prototype.loadConfig = function() {
        var bodyConfig = JSON.parse(this.body.attr('data-layout') ? this.body.attr('data-layout') : '{}');

        var config = $.extend({}, {
            mode: "light",
            menuPosition: 'fixed',
            sidebar: {
                color: "light",
                size: "default",
                showuser: false
            },
            topbar: {
                color: "light"
            }
        });
        if (bodyConfig) {
            config = $.extend({}, config, bodyConfig);
        }
        return config;
    },

        /**
         * Apply the config
         */
        LayoutThemeApp.prototype.applyConfig = function() {
            // getting the saved config if available
            this.config = this.loadConfig();

            // activate menus
            this.leftSidebar.init();
            this.topbar.init();

            this.leftSidebar.parent = this;
            this.topbar.parent = this;


            // mode
            this.changeMode(this.config.mode);

            // menu position
            this.changeMenuPositions(this.config.menuPosition);

            // left sidebar
            var sidebarConfig = $.extend({}, this.config.sidebar);
            this.leftSidebar.changeColor(sidebarConfig.color);
            this.leftSidebar.changeSize(sidebarConfig.size);
            this.leftSidebar.showUser(sidebarConfig.showuser);

            // topbar
            var topbarConfig = $.extend({}, this.config.topbar);
            this.topbar.changeColor(topbarConfig.color);
        },

        /**
         * Toggle dark or light mode
         * @param {*} mode
         */
        LayoutThemeApp.prototype.changeMode = function(mode) {
            // sets the theme
            switch (mode) {
                case "dark": {
                    this.defaultBSStyle.attr("disabled", true);
                    this.defaultAppStyle.attr("disabled", true);
                    this.darkBSStyle.attr("disabled", false);
                    this.darkAppStyle.attr("disabled", false);

                    this.leftSidebar.changeColor("dark");
                    this._saveConfig({ mode: mode, sidebar: $.extend({}, this.config.sidebar, { color: 'dark' }) });
                    break;
                }
                default: {
                    this.defaultBSStyle.attr("disabled", false);
                    this.defaultAppStyle.attr("disabled", false);

                    this.darkBSStyle.attr("disabled", true);
                    this.darkAppStyle.attr("disabled", true);
                    this.leftSidebar.changeColor("light");
                    this._saveConfig({ mode: mode, sidebar: $.extend({}, this.config.sidebar, { color: 'light' }) });
                    break;
                }
            }

            this.rightBar.selectOptionsFromConfig();
        }

    /**
     * Changes menu positions
     */
    LayoutThemeApp.prototype.changeMenuPositions = function(position) {
        this.body.attr("data-layout-menu-position", position);
    }

    /**
     * Clear out the saved config
     */
    LayoutThemeApp.prototype.clearSavedConfig = function() {
        this.config = {};
    },

        /**
         * Gets the config
         */
        LayoutThemeApp.prototype.getConfig = function() {
            return this.config;
        },

        /**
         * Reset to default
         */
        LayoutThemeApp.prototype.reset = function() {
            this.clearSavedConfig();
            this.applyConfig();
        },

        /**
         * Init
         */
        LayoutThemeApp.prototype.init = function() {
            this.leftSidebar = $.LeftSidebar;
            this.topbar = $.Topbar;

            this.leftSidebar.parent = this;
            this.topbar.parent = this;

            // initilize the menu
            this.applyConfig();
        },

        $.LayoutThemeApp = new LayoutThemeApp, $.LayoutThemeApp.Constructor = LayoutThemeApp
}(window.jQuery);

