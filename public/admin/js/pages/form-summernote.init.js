!function (n) {
    "use strict";

    function e() {
        this.$body = n("body")
    }

    e.prototype.init = function () {
        n(".summernote-basic").summernote({
            placeholder: "Write something...",
            height: 230,
            callbacks: {
                onInit: function (e) {
                    n(e.editor).find(".custom-control-description").addClass("custom-control-label").parent().removeAttr("for")
                }
            }
        })
    }, n.Summernote = new e, n.Summernote.Constructor = e
}(window.jQuery), function () {
    "use strict";
    window.jQuery.Summernote.init()
}();
