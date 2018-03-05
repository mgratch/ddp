(function($){

    DifferentLogo = {
        init: function()
        {
            this._bind();
        },

        _bind: function()
        {
            if( $('header.fl-builder-content').length != 0 )
            {
                if( $(window).width() > 767 )
                    this._doScroll();

                $(window).resize(function(){
                    if( $(window).width() > 767 ){
                        DifferentLogo._doScroll();
                    }
                });
            }
        },

        _doScroll: function()
        {
            var hdElm 	= $('header.fl-builder-content');
            var headerH = hdElm.height();

            $(window).on('scroll', function(event){
                var st = $(this).scrollTop();
                if (st > headerH){
                    hdElm.addClass('fl-do-scroll');
                } else {
                    hdElm.removeClass('fl-do-scroll');
                }
            });
        }
    };

    $(function(){
        DifferentLogo.init();
    });

})(jQuery);