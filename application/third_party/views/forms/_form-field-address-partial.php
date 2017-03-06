<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<div class="input">
  <ul class="vertical-list">
  <li>
  <input id="SubmitFields[<?php echo $field->DomId; ?>][StreetAddress]" name="SubmitFields[<?php echo $field->DomId; ?>][StreetAddress]" value="<?php echo getFormFieldValue($field,"StreetAddress"); ?>"  type="text" class="title" /><br />
   <span class="sub-label">Street address</span>
  </li>
  <li>
  <input id="SubmitFields[<?php echo $field->DomId; ?>][StreetAddress2]" name="SubmitFields[<?php echo $field->DomId; ?>][StreetAddress2]" type="text" value="<?php echo getFormFieldValue($field,"StreetAddress2"); ?>"  class="title" /><br />
   <span class="sub-label">Street address 2</span>
  </li>
  <li>
     <ul class="two-field-row entry-form-list horizontal-list">
       <li>
         <input id="SubmitFields[<?php echo $field->DomId; ?>][City]" name="SubmitFields[<?php echo $field->DomId; ?>][City]"  type="text"  value="<?php echo getFormFieldValue($field,"City"); ?>" class="title shorter-field" /><br />
        <span class="sub-label">City</span>
       </li>
       <li>
       <input id="SubmitFields[<?php echo $field->DomId; ?>][State]" name="SubmitFields[<?php echo $field->DomId; ?>][State]"   type="text"  value="<?php echo getFormFieldValue($field,"State"); ?>"  class="shorter-field title" /><br />
        <span class="sub-label">State / Province</span>
       </li>
     </ul>
  </li>
  <li>
    <ul class="two-field-row horizontal-list entry-form-list">
       <li>
       <input id="SubmitFields[<?php echo $field->DomId; ?>][ZipCode]" name="SubmitFields[<?php echo $field->DomId; ?>][ZipCode]"   type="text" class="shorter-field title"  value="<?php echo getFormFieldValue($field,"ZipCode"); ?>"  maxlength="5" /><br />
        <span class="sub-label">zip code</span>
       </li>
       <li>         
		 <?php countrySelectList(strFormat("SubmitFields[{0}][Country]",$field->DomId), "shorter-field", "Select Country", getFormFieldValue($field, "Country")); ?>
		 <br/>
         <span class="sub-label">Country</span>
       </li>
    </ul>
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
