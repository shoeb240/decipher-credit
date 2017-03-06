<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<div class="input">
  <ul class="horizontal-list three-field-row full-name-row">
  <li>
  <input  id="SubmitFields[<?php echo $field->DomId; ?>][FirstName]" name="SubmitFields[<?php echo $field->DomId; ?>][FirstName]" type="text" value="<?php echo getFormFieldValue($field, "FirstName"); ?>" class="shorter-field title first-name" /><br />
  <span class="sub-label">First Name</span>
  </li>
  <li>
  <input  id="SubmitFields[<?php echo $field->DomId; ?>][Initials]" name="SubmitFields[<?php echo $field->DomId; ?>][Initials]" type="text" value="<?php echo getFormFieldValue($field, "Initials"); ?>" class="mini-field title middle-initial" maxlength="3" /><br />
    <span class="sub-label">Initials</span>
  </li>
  <li>
  <input  id="SubmitFields[<?php echo $field->DomId; ?>][LastName]" name="SubmitFields[<?php echo $field->DomId; ?>][LastName]" type="text" value="<?php echo getFormFieldValue($field, "LastName"); ?>" class="shorter-field title last-name" /><br />
   <span class="sub-label">Last Name</span>
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
