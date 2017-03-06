<script id="form-field-fullname-template" type="text/x-jquery-tmpl">
<label data-sub-channel="sub-label-${id}" class="label editable">Click to edit</label>
 <span class="required hidden">*</span>
<div class="input">
  <ul class="horizontal-list three-field-row full-name-row">
  <li>
  <input type="text" class="shorter-field title" /><br />
  <span class="sub-label">First Name</span>
  </li>
  <li>
  <input type="text" class="mini-field title" maxlength="3" /><br />
    <span class="sub-label">Initials</span>
  </li>
  <li>
  <input type="text" class="shorter-field title" /><br />
   <span class="sub-label">Last Name</span>
  </li>
  </ul>
<?php include(ABSPATH . "/views/forms/_form-field-properties.php"); ?>
</div>
<a href="javascript:void(0);" class="help-icon-1 help-icon hide w-tip">
  <img src="<?php spacerImage(); ?>" alt="help" />
</a>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>