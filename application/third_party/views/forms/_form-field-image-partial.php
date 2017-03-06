<div class="form-alignable-container <?php echo strtolower($field->Alignment);?>-align-form-element">
<img id="field-<?php echo $field->DomId; ?>"  
	 class="form-img" 
	 src="<?php echo $field->Url; ?>" 
	 alt="<?php echo $field->AltText; ?>" />
</div>	 
 <?php
      if ($field->isEditMode())
      {
	     include(ABSPATH . "/views/forms/_form-field-properties-partial.php");
         include(ABSPATH . "/views/forms/_form-field-settings-template.php");
      }
   ?>