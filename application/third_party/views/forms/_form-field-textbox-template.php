<script id="form-field-textbox-template" type="text/x-jquery-tmpl">
<label data-sub-channel="sub-label-${id}" class="label editable">Click to edit</label>
<span class="required hidden">*</span>
<div class="input">
<input id="des" type="text" class="title"  />
<?php include(ABSPATH . "/views/forms/_form-field-properties.php"); ?>
</div>
<a href="javascript:void(0);" class="help-icon-1 help-icon hide w-tip">
  <img src="<?php spacerImage(); ?>" alt="help" />
</a>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>