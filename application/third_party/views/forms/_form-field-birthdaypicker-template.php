<script id="form-field-birthdaypicker-template" type="text/x-jquery-tmpl">
<label data-sub-channel="sub-label-${id}" class="label editable">
    Click to edit</label>
      <span class="required hidden">*</span>
<div class="input">
    <ul class="horizontal-list three-field-row">
        <li>            
			<?php monthSelectList("birthmonth-${id}", "shorter-field"); ?>
			<br/>
			
            <span class="sub-label">Month</span>
        </li>
        <li>        
		<?php daySelectList("birthday-${id}", "shorter-field"); ?>
		<br/>
      <span class="sub-label">Day</span>
        </li>
        <li>            
			<?php yearSelectList("birthyear-${id}", "shorter-field birth-year"); ?>
			<br/>
           <span class="sub-label">Year</span>
        </li>
    </ul>    
	<?php include(ABSPATH . "/views/forms/_form-field-properties.php"); ?>
</div>
<a href="javascript:void(0);" class="help-icon-1 help-icon hide w-tip">
  <img src="<?php spacerImage(); ?>" alt="help" />
</a>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>
