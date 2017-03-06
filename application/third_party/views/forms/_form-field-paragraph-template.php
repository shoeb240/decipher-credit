<script id="form-field-paragraph-template" type="text/x-jquery-tmpl">
<div class="form-alignable-container left-align-form-element">
<span id="field-${id}" class="form-paragraph-container paragraph-editable" data-sub-channel="sub-content-${id}">
  [Click to edit] <?php echo Constants::DEFAULT_TEXT; ?>
</span> 	 
</div>
<?php include(ABSPATH . "/views/forms/_form-field-properties.php") ?>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>