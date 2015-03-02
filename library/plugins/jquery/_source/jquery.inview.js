(function ($) {
    function getViewportHeight() {
        var height = window.innerHeight; // Safari, Opera
        var mode = document.compatMode;

        if ( (mode || !$.support.boxModel) ) { // IE, Gecko
            height = (mode == "CSS1Compat") ?
            document.documentElement.clientHeight : // Standards
            document.body.clientHeight; // Quirks
        }

        return height;
    }
    
    
    function view(){
        var vpH = getViewportHeight(),
            scrolltop = (document.documentElement.scrollTop ?
                document.documentElement.scrollTop :
                document.body.scrollTop),
            elems = [];
        
        // naughty, but this is how it knows which elements to check for
        $.each($.cache, function () {
            if (this.events && this.events.inview) {
                elems.push(this.handle.elem);
            }
        });

        if (elems.length) {
            $(elems).each(function () {
                var $el = $(this),
                    top = $el.offset().top,
                    height = $el.height(),
                    inview = $el.data("inview") || false;

                if (scrolltop > (top + height) || scrolltop + vpH < top) {
                    if (inview) {
                        $el.data("inview", false);
                        $el.data("inview_height_top", 0);
                        $el.data("inview_height_center", 0);
                        $el.data("inview_height_botom", 0);
                        $el.trigger("inview", [ false ]);                        
                    }
                } else if (scrolltop < (top + height)) {
                    if (!inview) {
                        $el.data("inview", true);
                        $el.trigger("inview", [ true ]);
                    }
                    $el.data("inview_height_top", scrolltop + vpH - top);
                    $el.data("inview_height_center", scrolltop + vpH - top  - (vpH / 2));
                    $el.data("inview_height_botom", scrolltop - top);
                }
            });
        }
    };
    
    $(window).scroll(view).resize(view).load(view);
    
})(jQuery);