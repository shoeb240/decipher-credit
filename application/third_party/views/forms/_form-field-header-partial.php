<h2 data-sub-channel="sub-text-<?php echo $field->DomId ?>" class="default editable"><?php echo $field->Text; ?></h2>

 <?php
      if ($field->isEditMode())
      {
	     include(ABSPATH . "/views/forms/_form-field-properties-partial.php");
         include(ABSPATH . "/views/forms/_form-field-settings-template.php");
      }
   ?>