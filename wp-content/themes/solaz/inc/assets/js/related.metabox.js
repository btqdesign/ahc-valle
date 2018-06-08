/**
 * General functions and implements
 */
(function($){
    "use strict"
    var core = {
        _initialized: false,

        init: function() {
            if (this._initialized) return false;
            this._initialized = true;
            var metabox = $('#related-metabox');
            var select = metabox.find('#related-post-select');
            if ( $.fn.select2 ) {
                select.select2();
            }
        },
    };
    $(document).ready(function(){
        core.init();
    });
})(jQuery);