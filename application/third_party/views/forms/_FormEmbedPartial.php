<script id="embed-script-template" type="text/x-jquery-tmpl">
        <iframe id="form-builder-frame"
                src='<?php echo rootUrl() . "/register.php?embed=true&id=" . $formView->Id; ?>'
                height="${height}"
                frameborder="0"
                width="550px"                 
                marginheight="0" 
                marginwidth="0"
                scrolling="no">
		</iframe>       
 </script>
    <div id="modal-content" style="display:none;">
			<div id="modal-title">Copy Embed Script</div>
			<div class="close"><a href="#" class="simplemodal-close">x</a></div>
			<div id="modal-data">
               <div class="script-container">
				<textarea id="embed-script" class="script-text-area" rows="5" cols="10"></textarea>
				</div>
                <p><button class="simplemodal-close">Close</button> <span>(or press ESC or click the overlay)</span></p>
			</div>
    </div>

    <div id="script-holder" style="display:none;"></div>

    <script type="text/javascript">

        $(document).ready(function () {

            $('#embed-link').live('click', function () {
                $('#modal-content').modal({
                    overlayId: 'overlay',
                    containerId: 'container',
                    closeHTML: null,
                    minHeight: 80,
                    opacity: 65,
                    position: ['25%', '25%'],
                    overlayClose: true,
                    onShow: function (d) {
                        loadScript();
                    }
                });
            });

            $('#embed-script').live('focus', function () {
                $(this).select();
            });

            $('#form-builder-frame').load(function () {
                if ($('#form-builder-frame').length > 0) {
                    var frame = $('#form-builder-frame');
                    var formHeight = frame.contents().find('.form-page-container').height() + 30;
                    frame.attr('height', formHeight);
                }
            });


            function loadScript() {
                var formHeight;

                if ($('.form-page-container').length > 0) {
                    formHeight = $('.form-page-container').height();
                } else {
                    var frame = $('#form-builder-frame');
                    frame.src = frame.src;
                    formHeight = frame.contents().find('.form-page-container').height();
                }

                var data = [{ height: formHeight}];
                var script = $('#embed-script-template').tmpl(data);
                $('#script-holder').html('');
                $('#script-holder').append(script);
                $('#embed-script').val($('#script-holder').html());
            }

        });
</script>