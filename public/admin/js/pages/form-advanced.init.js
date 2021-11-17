!function (t) {
    "use strict";
    function e() {
    }
    e.prototype.initSelect2 = function () {
        t('[data-toggle="select2"]').select2()
    },
    e.prototype.initMaxLength = function () {
        t("input#defaultconfig").maxlength({
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        }), t("input#thresholdconfig").maxlength({
            threshold: 20,
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        }), t("input#alloptions").maxlength({
            alwaysShow: !0,
            separator: " out of ",
            preText: "You typed ",
            postText: " chars available.",
            validate: !0,
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        }), t("textarea#textarea").maxlength({
            alwaysShow: !0,
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        }), t("input#placement").maxlength({
            alwaysShow: !0,
            placement: "top-left",
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        })
    },
    e.prototype.initSelectize = function () {
        t("#selectize-tags").selectize({
            persist: !1,
            createOnBlur: !0,
            create: !0
        }), t("#selectize-select").selectize({
            create: !0,
            sortField: {field: "text", direction: "asc"},
            dropdownParent: "body"
        }), t("#selectize-maximum").selectize({maxItems: 3}), t("#selectize-links").selectize({
            theme: "links",
            maxItems: null,
            valueField: "id",
            searchField: "title",
            options: [{id: 1, title: "Coderthemes", url: "https://coderthemes.com/"}, {
                id: 2,
                title: "Google",
                url: "http://google.com"
            }, {id: 3, title: "Yahoo", url: "http://yahoo.com"}],
            render: {
                option: function (e, a) {
                    return '<div class="option"><span class="title">' + a(e.title) + '</span><span class="url">' + a(e.url) + "</span></div>"
                }, item: function (e, a) {
                    return '<div class="item"><a href="' + a(e.url) + '">' + a(e.title) + "</a></div>"
                }
            },
            create: function (e) {
                return {id: 0, title: e, url: "#"}
            }
        }), t("#selectize-confirm").selectize({
            delimiter: ",", persist: !1, onDelete: function (e) {
                return confirm(1 < e.length ? "Are you sure you want to remove these " + e.length + " items?" : 'Are you sure you want to remove "' + e[0] + '"?')
            }
        }), t("#selectize-optgroup").selectize({sortField: "text"}), t("#selectize-programmatic").selectize({
            options: [{
                class: "mammal",
                value: "dog",
                name: "Dog"
            }, {class: "mammal", value: "cat", name: "Cat"}, {
                class: "mammal",
                value: "horse",
                name: "Horse"
            }, {class: "mammal", value: "kangaroo", name: "Kangaroo"}, {
                class: "bird",
                value: "duck",
                name: "Duck"
            }, {class: "bird", value: "chicken", name: "Chicken"}, {
                class: "bird",
                value: "ostrich",
                name: "Ostrich"
            }, {class: "bird", value: "seagull", name: "Seagull"}, {
                class: "reptile",
                value: "snake",
                name: "Snake"
            }, {class: "reptile", value: "lizard", name: "Lizard"}, {
                class: "reptile",
                value: "alligator",
                name: "Alligator"
            }, {class: "reptile", value: "turtle", name: "Turtle"}],
            optgroups: [{value: "mammal", label: "Mammal", label_scientific: "Mammalia"}, {
                value: "bird",
                label: "Bird",
                label_scientific: "Aves"
            }, {value: "reptile", label: "Reptile", label_scientific: "Reptilia"}],
            optgroupField: "class",
            labelField: "name",
            searchField: ["name"],
            render: {
                optgroup_header: function (e, a) {
                    return '<div class="optgroup-header">' + a(e.label) + ' <span class="scientific">(' + a(e.label_scientific) + ")</span></div>"
                }
            }
        }), t("#selectize-optgroup-column").selectize({
            options: [{id: "avenger", make: "dodge", model: "Avenger"}, {
                id: "caliber",
                make: "dodge",
                model: "Caliber"
            }, {id: "caravan-grand-passenger", make: "dodge", model: "Caravan Grand Passenger"}, {
                id: "challenger",
                make: "dodge",
                model: "Challenger"
            }, {id: "ram-1500", make: "dodge", model: "Ram 1500"}, {
                id: "viper",
                make: "dodge",
                model: "Viper"
            }, {id: "a3", make: "audi", model: "A3"}, {id: "a6", make: "audi", model: "A6"}, {
                id: "r8",
                make: "audi",
                model: "R8"
            }, {id: "rs-4", make: "audi", model: "RS 4"}, {id: "s4", make: "audi", model: "S4"}, {
                id: "s8",
                make: "audi",
                model: "S8"
            }, {id: "tt", make: "audi", model: "TT"}, {
                id: "avalanche",
                make: "chevrolet",
                model: "Avalanche"
            }, {id: "aveo", make: "chevrolet", model: "Aveo"}, {
                id: "cobalt",
                make: "chevrolet",
                model: "Cobalt"
            }, {id: "silverado", make: "chevrolet", model: "Silverado"}, {
                id: "suburban",
                make: "chevrolet",
                model: "Suburban"
            }, {id: "tahoe", make: "chevrolet", model: "Tahoe"}, {
                id: "trail-blazer",
                make: "chevrolet",
                model: "TrailBlazer"
            }],
            optgroups: [{$order: 3, id: "dodge", name: "Dodge"}, {$order: 2, id: "audi", name: "Audi"}, {
                $order: 1,
                id: "chevrolet",
                name: "Chevrolet"
            }],
            labelField: "model",
            valueField: "id",
            optgroupField: "make",
            optgroupLabelField: "name",
            optgroupValueField: "id",
            lockOptgroupOrder: !0,
            searchField: ["model"],
            plugins: ["optgroup_columns"],
            openOnFocus: !1
        }), t(".selectize-close-btn").selectize({
            plugins: ["remove_button"],
            persist: !1,
            create: !0,
            render: {
                item: function (e, a) {
                    return '<div>"' + a(e.text) + '"</div>'
                }
            },
            onDelete: function (e) {
                return confirm(1 < e.length ? "Are you sure you want to remove these " + e.length + " items?" : 'Are you sure you want to remove "' + e[0] + '"?')
            }
        }), t(".selectize-drop-header").selectize({
            sortField: "text",
            hideSelected: !1,
            plugins: {dropdown_header: {title: "Language"}}
        })
    },
    e.prototype.initSwitchery = function () {
        t('[data-plugin="switchery"]').each(function (e, a) {
            new Switchery(t(this)[0], t(this).data())
        })
    },
    e.prototype.initMultiSelect = function () {
        0 < t('[data-plugin="multiselect"]').length && t('[data-plugin="multiselect"]').multiSelect(t(this).data())
    },
    e.prototype.initTouchspin = function () {
        var n = {};
        t('[data-toggle="touchspin"]').each(function (e, a) {
            var i = t.extend({}, n, t(a).data());
            t(a).TouchSpin(i)
        })
    },
    e.prototype.init = function () {
        // this.initSelect2(),
        this.initMaxLength(),
        // this.initSelectize(),
        this.initSwitchery(),
        this.initMultiSelect(),
        this.initTouchspin()
    }, t.FormAdvanced = new e, t.FormAdvanced.Constructor = e
}(window.jQuery),

function () {
    "use strict";
    window.jQuery.FormAdvanced.init();
}();
