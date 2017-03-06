<script id="form-field-image-template" type="text/x-jquery-tmpl">
<div class="form-alignable-container left-align-form-element">
<img id="field-${id}" 
     class="form-img" 
	 src="<?php echo rootUrl() . Constants::DEFAULT_IMAGE_PATH; ?>" 
	 alt="<?php echo Constants::DEFAULT_IMAGE_DESCRIPTION; ?>" />
</div>	 
<?php include(ABSPATH . "/views/forms/_form-field-properties.php") ?>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php") ?>
</script>