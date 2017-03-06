<!DOCTYPE html>
<html>
    <head>
        <title>Email Builder</title>

        <link href="<?php echo base_url('public/emailbuilder/mosaico-material.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('public/emailbuilder/vendor/notoregular/stylesheet.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('public/emailbuilder/vendor/evol.colorpicker.min.css'); ?>" rel="stylesheet">

        <script src="<?php echo base_url('public/emailbuilder/vendor/knockout.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/jquery-ui.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/jquery.ui.touch-punch.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/load-image.all.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/canvas-to-blob.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/jquery.iframe-transport.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/jquery.fileupload.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/jquery.fileupload-process.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/jquery.fileupload-image.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/jquery.fileupload-validate.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/knockout-jqueryui.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/evol.colorpicker.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/vendor/tinymce.min.js'); ?>"></script>
        <script src="<?php echo base_url('public/emailbuilder/mosaico.min.js'); ?>"></script>

        <script>
            $(function() {
                if (Mosaico.isCompatible()) {
                    var ok = Mosaico.init({
                        titleToken: "Email Builder",
                        imgProcessorBackend: "<?php echo site_url(); ?>/emailbuilder/image/",
                        emailProcessorBackend: "<?php echo site_url(); ?>/emailbuilder/email/",
                        fileuploadConfig: {
                            url: "<?php echo site_url(); ?>/emailbuilder/upload/"
                        }
                    });

                    if (!ok) {
                        console.log("Missing initialization hash.");
                    }
                } else {
                    console.log("Mosaico is not compatible with the browser.");
                }
            });
        </script>
    </head>
    <body class="mo-standalone">

    </body>
</html>
