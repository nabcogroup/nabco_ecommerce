
jQuery.widget("custom.stickyNav", {
    options: {
        default: "",
        headerTarget: "",
        alternate: "",
        pullin: {left: 0},
        pullout: {left: -100},
    },
    _create: function () {

        var target = this.element;
        var _self = this;
        var icons = target.find(".icon");

        var previous = null;
        var latest = null;

        //get the latestContainer
        icons.each(function (index) {
            if (jQuery(this).hasClass('active')) {
                latest = jQuery(this).data("container");
            }
        });


        var headerTarget = jQuery("#sticker-title");
        jQuery("#sticker-header").on("click", function () {
            showHideContainer(sticker, true);
        });

        icons.on("click", function (e) {

            var isHide = false;

            //remove active
            icons.removeClass("active");
            jQuery(this).addClass("active");
            var color = jQuery(this).data("color");

            target.removeClass(function (index, className) {
                return (className.match(/(^|\s)bg-\S+/g) || []).join(' ');
            });

            target.addClass("bg-" + color);
            if (latest !== jQuery(this).data("container")) {
                previous = latest;
                latest = jQuery(this).data("container");
            }

            if (jQuery(latest).css("display") === "none") {
                headerTarget.animate(_self.options.pullout);
                var selected = jQuery(this);

                jQuery(previous).fadeOut("slow", function () {
                    jQuery(headerTarget).html("<i class='fa fa-" + selected.data("socialIcon") + "'></i> <span>" + selected.data("title") + "</span>");
                    jQuery(headerTarget).animate(_self.options.pullin);
                    jQuery(latest).fadeIn();
                });
            }
            else {
                isHide = true;
            }

            showHideContainer(sticker, isHide);
        });


        function showHideContainer(sticker, isHide) {
            if (target.hasClass("stk-show") && isHide) {
                target.removeClass("stk-show");
                target.addClass("stk-hide");
            }
            else if (target.hasClass("stk-hide")) {
                target.removeClass("stk-hide");
                target.addClass("stk-show");
            }
        }
    },
    _setOption: function (key, value) {
        // No value passed, act as a getter.
        if (key == 'pullin') {
            this.options.pullin = value;
        }
        else if (key == 'pullout') {
            this.options.pullout = value;
        }
        else {
            this.pullin = {left: 0};
            this.pullout = {left: -100};
        }
    }
});