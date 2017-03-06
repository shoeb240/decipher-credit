<script id="form-field-checkbox-template" type="text/x-jquery-tmpl">
<label data-sub-channel="sub-label-${id}" class="label editable">Click to edit</label>
  <span class="required hidden">*</span>
<div class="input">
  <ul class="option-list vertical-list">
  <li>
  <input type="checkbox" value="Option 1" /><label>Option 1</label>
  </li>
  <li>
  <input type="checkbox" value="Option 2" /><label>Option 2</label> 
  </li>
  </ul>
<?php include(ABSPATH . "/views/forms/_form-field-properties.php"); ?>
</div>
<a href="javascript:void(0);" class="help-icon-1 help-icon hide w-tip">
  <img src="<?php spacerImage(); ?>" alt="help" />
</a>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>