var layout = function () {

    function bindHideAd() {
        $('.close-ad-link').live('click', function () {
            $(this).closest('#ad-header').slideUp('fast');
        });
    }
	
    function init() {
        bindHideAd();
    }

    return {
        init: init
    }
} ();