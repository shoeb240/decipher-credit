<script id="form-field-captcha-template" type="text/x-jquery-tmpl">
<label data-sub-channel="sub-label-${id}" class="label editable"><?php echo Constants::CLICK_TO_EDIT;?></label>
<span class="required">*</span>
<div class="input">
  <img src="<?php echo $docRoot; ?>/content/images/recaptcha.png" class="recaptcha" />
<?php include(ABSPATH . "/views/forms/_form-field-properties.php"); ?>
</div>
<a href="javascript:void(0);" class="help-icon-1 help-icon hide w-tip">
  <img src="<?php spacerImage(); ?>" alt="help" />
</a>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>