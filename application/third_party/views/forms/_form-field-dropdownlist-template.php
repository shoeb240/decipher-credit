<script id="form-field-dropdownlist-template" type="text/x-jquery-tmpl">
<label data-sub-channel="sub-label-${id}" class="label editable">Click to edit</label>
<span class="required hidden">*</span>
<div class="input">
<select id="field-${id}" class="default">
   <?php foreach(explode(",",Constants::DEFAULT_OPTIONS) as $option): ?>
		<option <?php echo outputIfTrue($option == Constants::DEFAULT_SELECTED_OPTION, "selected='selected'", ""); ?> value="<?php echo $option; ?>"><?php echo $option; ?></option>
   <?php endforeach; ?>		
</select>
<?php include(ABSPATH . "/views/forms/_form-field-properties.php"); ?>
</div>
<a href="javascript:void(0);" class="help-icon-1 help-icon hide w-tip">
  <img src="<?php spacerImage(); ?>" alt="help" />
</a>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>