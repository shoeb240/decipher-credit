(function() {
    // Localize jQuery variable
    var jQuery;

    /******** Load jQuery if not present *********/
    if (window.jQuery === undefined || window.jQuery.fn.jquery !== '1.9.1') {
        var script_tag = document.createElement('script');
        script_tag.setAttribute("type","text/javascript");
        script_tag.setAttribute("src", "http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js");
        if (script_tag.readyState) {
            script_tag.onreadystatechange = function () { // For old versions of IE
                if (this.readyState == 'complete' || this.readyState == 'loaded') {
                    scriptLoadHandler();
                }
            };
        } else {
            script_tag.onload = scriptLoadHandler;
        }
        // Try to find the head, otherwise default to the documentElement
        (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
    } else {
        // The jQuery version on the window is the one we want to use
        jQuery = window.jQuery;
        main();
    }

    /******** Called once jQuery has loaded ******/
    function scriptLoadHandler() {
        // Restore $ and window.jQuery to their previous values and store the
        // new jQuery in our local jQuery variable
        jQuery = window.jQuery.noConflict(true);
        // Call our main function
        main();
    }

    /******** Our main function ********/
    function main() {
        var hash = "<?php echo $hash; ?>";
        var customer_id = "<?php echo $customer_id; ?>";
        var application_id = "<?php echo $application_id; ?>";
        var siteurl = "<?php echo site_url(); ?>/";

        jQuery(document).ready(function($) {
            var iframe = document.createElement("iframe");
            iframe.setAttribute("src", siteurl + "widget/" + customer_id + "/" + application_id);
            iframe.setAttribute("width", "100%");
            iframe.setAttribute("height", "100%");
            iframe.setAttribute("style", "border:none;padding:0;margin:0;vertical-align:bottom;");
            $("div[data-hash='" + hash + "']").append(iframe);
        });
    }
})(); // We call our anonymous function immediately