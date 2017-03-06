<?php 		
		$entryParams = !isNullOrEmpty($formView->EntryID) ? "&entry=" . $formView->EntryID : "";   
        $prevUrl = $field->isEditMode() ? "javascript:void(0);" :  rootUrl() . "/register.php?embed=true&id=" . $formView->Id . "&step=" . (intVal($formView->WizardStep)-1) . $entryParams;  
		$prevCss = !$field->isEditMode() && intval($formView->WizardStep) == 1 ? "first-wizard-control" : "";
		$nextCss = !$field->isEditMode() && intval($formView->WizardStep) == intVal($formView->NumberOfSteps )? "last-wizard-control" : "";
   ?>
<div class="input <?php outputIfTrue(Utils::isBool($field->ShowPrevious), "", "hide-previous"); ?> <?php echo $prevCss; ?> <?php echo $nextCss; ?> <?php outputIfTrue(Utils::isBool($field->ShowNext),"", "hide-next"); ?>">
   
    <ul class="horizontal-list entry-form-list wizard-buttons">
        <li class="previous-button-item">
		  <a href="<?php echo $prevUrl;?>">
            <input type="button" class="save-button grey" data-sub-channel="sub-previoustext-<?php echo $field->DomId; ?>" value="<?php echo $field->PreviousText; ?>">
		  </a>
		</li>
		<li class="button-separator-item">
		&nbsp;
		</li>
        <li class="next-button-item">
            <input type="submit" class="save-button blue" data-sub-channel="sub-nexttext-<?php echo $field->DomId; ?>" value="<?php echo $field->NextText; ?>">
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
