<div class="form-alignable-container <?php echo strtolower($field->Alignment);?>-align-form-element">
<span id="field-<?php echo $field->DomId; ?>" class="form-paragraph-container paragraph-editable" data-sub-channel="sub-content-<?php echo $field->DomId; ?>">
   <?php echo isNullOrEmpty($field->Content) ? "[empty paragraph]" : $field->Content; ?>
</span> 	 
</div>
   <?php
      if ($field->isEditMode())
      {
		 include(ABSPATH . "/views/forms/_form-field-properties-partial.php");
         include(ABSPATH . "/views/forms/_form-field-settings-template.php");
      }
   ?>


