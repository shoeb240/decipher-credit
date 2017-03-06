<script id="form-field-phone-template" type="text/x-jquery-tmpl">
<label data-sub-channel="sub-label-${id}" class="label editable">
    Click to edit</label>
    <span class="required hidden">*</span>
<div class="input">
    <ul class="horizontal-list two-field-row entry-form-list">
        <li class="area-code-item">
            <input type="text" class="title shorter-field area-code" maxlength="3" />
            -<br />
            <span class="sub-label">Area Code</span> </li>
        <li class="phone-number-item">
            <input type="text" class="title shorter-field phone-number" /><br />
            <span class="sub-label">Phone Number</span> </li>
    </ul>
   <?php include(ABSPATH . "/views/forms/_form-field-properties.php"); ?>
</div>
<a href="javascript:void(0);" class="help-icon-1 help-icon hide w-tip">
  <img src="<?php spacerImage(); ?>" alt="help" />
</a>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>