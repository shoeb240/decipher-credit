<?php
   define("ABSPATH", dirname(__FILE__));
   require_once( ABSPATH . '/lib/forms-view.php' );

    $entryParams = !isNullOrEmpty($formView->EntryID) ? "&entry=" . $formView->EntryID : "";   
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <title>Submit Form: <?php echo $formView->Title; ?></title>
    <script type="text/javascript" src="<?php echo rootUrl() ?>/scripts/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="<?php echo rootUrl() ?>/scripts/jquery.simplemodal.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo rootUrl() ?>/scripts/jquery.tmpl.min.js"></script>
    <link type="text/css" href="<?php echo rootUrl() ?>/content/css/form-builder/forms-modal.css" rel="stylesheet"  />          
    <style type="text/css">
      .menu-links-container{position:absolute;top:0;left:90px;height:45px;width:280px;}
      .menu-links-container ul{width:100%;list-style-type:none;margin:0;padding:0;}
      .menu-links-container li{float:left;width:127px;margin:0;padding:0;}
      .embed-link:link,.embed-link:visited{width:127px;height:45px;display:inline-block;background-image:url(<?php echo rootUrl() ?>/content/images/forms-sprite.png);background-position:-1px -1808px;}
      .embed-link:hover{background-position:-1px -1866px;}
      .home-link:link,.home-link:visited{width:127px;height:45px;display:inline-block;top:0;left:90px;background-image:url(<?php echo rootUrl() ?>/content/images/forms-sprite.png);background-position:-1px -1923px;}      
      .script-container{margin:0 auto;width:580px;}
      .script-text-area{width:565px;height:85px;}
    </style>
</head>
<body>
    <div style="margin:0 auto;width:550px;">
        <iframe id="form-builder-frame"
                src="<?php echo rootUrl() . "/register.php?embed=true&id=" . $formView->Id . "&step=" . $formView->WizardStep . $entryParams; ?>" 
                frameborder="0"                 
                width="550px"                 
                marginheight="0" 
                marginwidth="0"
                scrolling="no"></iframe>
    </div>
    <div class="menu-links-container">
    <ul>
       <li><a href="<?php echo rootUrl() ?>/index.php" id="home-link" class="home-link"></a></li>
       <li><a href="javascript:void(0);" id="embed-link" class="embed-link"></a></li>
    </ul>
    </div>
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
    
</body>

</html>


