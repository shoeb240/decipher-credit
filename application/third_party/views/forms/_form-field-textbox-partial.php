<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<div class="input">
<?php 
   $modeCssClass="";
   $inputType="text";
   $textMode="";
   if (!isNullOrEmpty($field->TextMode) ){
	   if (strtolower($field->TextMode) == "number"){
		   $modeCssClass = "stepper-field";
	   }else if (strtolower($field->TextMode) == "password"){
		   $textMode = " data-textmode='password'";
	   }
   }
   
   $inputMaskAttribute = "";
   if(!isNullOrEmpty($field->InputMask)){
	   $modeCssClass = "masked-field";
	   if (array_key_exists($field->InputMask, $input_masks)){
			$inputMaskAttribute = ' data-inputmask="' . $input_masks[$field->InputMask]->Mask . '"';
	   }	   
   }
   
   if (!$field->isEditMode() && strtolower($field->TextMode) == "password" ) {
	   $inputMaskAttribute="";
	   $modeCssClass="";
	   $inputType="password";
   }
   
?>



<input   id="SubmitFields[<?php echo $field->DomId; ?>][Textbox]" 
		 name="SubmitFields[<?php echo $field->DomId; ?>][Textbox]"  
		 type="<?php echo $inputType; ?>" 
		 min="<?php echo isNullOrEmpty($field->MinNumber) ? 0 : $field->MinNumber; ?>"
		 max="<?php echo isNullOrEmpty($field->MaxNumber) ? 100 : $field->MaxNumber; ?>"
		 value="<?php echo getFormFieldValue($field); ?>" 
		 <?php echo isNullOrEmpty($field->Hint) ? "" : " placeholder='" . $field->Hint ."'"  ; ?> 
		 <?php echo $inputMaskAttribute; ?>  
		 title="<?php echo $field->Hint; ?>" 
		 maxlength="<?php echo $field->MaxCharacters; ?>" 
		 <?php echo $textMode; ?>
		 class="title <?php echo $modeCssClass; ?>" />
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