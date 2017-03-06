<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<div class="input">
    <ul class="horizontal-list three-field-row">
        <li class="month-item">
            <?php monthSelectList(strFormat("SubmitFields[{0}][Month]",$field->DomId), "shorter-field", getFormFieldValue($field, "Month")); ?><br/>            
			<span class="sub-label">Month</span>
        </li>
        <li class="day-item">
		<?php daySelectList(strFormat("SubmitFields[{0}][Day]",$field->DomId), "shorter-field", getFormFieldValue($field, "Day")); ?><br/>
      <span class="sub-label">Day</span>
        </li>
        <li class="year-item">
		<?php yearSelectListRange(strFormat("SubmitFields[{0}][Year]",$field->DomId), "shorter-field birth-year", $field->MinimumAge, $field->MaximumAge, getFormFieldValue($field, "Year")); ?><br/>
           <span class="sub-label">Year</span>
        </li>
    </ul>
	
  <?php
     if ($field->isEditMode())
     {
       include(ABSPATH . "/views/forms/_form-field-properties-partial.php");
     }
     
     if (!empty($field->Errors))
     {
       echo "<span class='field-validation-error'>" . $field->Errors ."</span>";
     }
  ?>
</div>
<a href="javascript:void(0);" title="<?php echo $field->HelpText; ?>" class="help-icon-1 help-icon <?php echo outputIfIs($field->HelpText, "", "hide"); ?> w-tip">
  <img src="<?php echo spacerImage(); ?>" alt="help" />
</a>

   <?php
      if ($field->isEditMode())
      {
         include(ABSPATH . "/views/forms/_form-field-settings-template.php");
      }
   ?>
