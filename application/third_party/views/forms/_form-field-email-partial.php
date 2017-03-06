<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<div class="input">
  <input  id="SubmitFields[<?php echo $field->DomId; ?>][Email]" name="SubmitFields[<?php echo $field->DomId; ?>][Email]" type="text" value="<?php echo getFormFieldValue($field)?>" <?php echo isNullOrEmpty($field->Hint) ? "" : "placeholder='" . $field->Hint ."'"  ; ?>  maxlength="<?php $field->MaxCharacters?>" title="eg. someone@example.com" class="title watermarked" />  
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
