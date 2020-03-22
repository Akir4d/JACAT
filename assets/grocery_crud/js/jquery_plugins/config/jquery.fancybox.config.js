$(function () {
    //Fancybox Hack https://github.com/fancyapps/fancybox/issues/1100#issuecomment-462074860 to add Rotate
    var RotateImage = function (instance) {
        this.instance = instance;

        this.init();
    };

    $.extend(RotateImage.prototype, {
        $button_left: null,
        $button_right: null,
        transitionanimation: true,

        init: function () {
            var self = this;
            self.$button_right = $('<button data-rotate-right class="fancybox-button fancybox-button--rotate" title="">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
                    '  <path d="M11.074,9.967a4.43,4.43,0,1,1-4.43-4.43V8.859l5.537-4.43L6.644,0V3.322a6.644,6.644,0,1,0,6.644,6.644Z" transform="translate(10.305 1) rotate(30)"/>' +
                    '</svg>' +
                    '</button>')
                    .prependTo(this.instance.$refs.toolbar)
                    .on('click', function (e) {
                        self.rotate('right');
                    });
            self.$button_left = $('<button data-rotate-left class="fancybox-button fancybox-button--rotate" title="">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
                    '  <path d="M11.074,6.644a4.43,4.43,0,1,0-4.43,4.43V7.752l5.537,4.43-5.537,4.43V13.289a6.644,6.644,0,1,1,6.644-6.644Z" transform="translate(21.814 15.386) rotate(150)"/>' +
                    '</svg>' +
                    '</button>')
                    .prependTo(this.instance.$refs.toolbar)
                    .on('click', function (e) {
                        self.rotate('left');
                    });


        },

        rotate: function (direction) {
            var self = this;
            var image = self.instance.current.$image[0];
            var angle = parseInt(self.instance.current.$image.attr('data-angle')) || 0;

            if (direction == 'right') {
                angle += 90;
            } else {
                angle -= 90;
            }

            if (!self.transitionanimation) {
                angle = angle % 360;
            } else {
                $(image).css('transition', 'transform .3s ease-in-out');
            }

            self.instance.current.$image.attr('data-angle', angle);

            $(image).css('webkitTransform', 'rotate(' + angle + 'deg)');
            $(image).css('mozTransform', 'rotate(' + angle + 'deg)');
        }
    });

    $(document).on('onInit.fb', function (e, instance) {
        if (!!instance.opts.rotate) {
            instance.Rotate = new RotateImage(instance);
        }
    });

    if ($('.image-thumbnail').length > 0) {
        $('.image-thumbnail').fancybox({
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 600,
            'speedOut': 200,
            'rotate': true,
            'buttons': [
                "zoom",
                "share",
                "slideShow",
                "fullScreen",
                "download",
                "thumbs",
                "close"
            ]
        });
    }
});	