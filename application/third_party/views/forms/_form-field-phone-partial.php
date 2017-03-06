<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<div class="input">
    <ul class="horizontal-list two-field-row entry-form-list">
        <li class="area-code-item">
            <input  id="SubmitFields[<?php echo $field->DomId; ?>][AreaCode]" name="SubmitFields[<?php echo $field->DomId; ?>][AreaCode]" value="<?php echo getFormFieldValue($field, "AreaCode") ?>"  type="text" class="title shorter-field area-code" maxlength="3" />
            -<br />
            <span class="sub-label">Area Code</span> </li>
        <li class="phone-number-item">
            <input  id="SubmitFields[<?php echo $field->DomId; ?>][Number]" name="SubmitFields[<?php echo $field->DomId; ?>][Number]" value="<?php echo getFormFieldValue($field, "Number") ?>"  type="text" class="title shorter-field phone-number" /><br />
            <span class="sub-label">Phone Number</span> </li>
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
