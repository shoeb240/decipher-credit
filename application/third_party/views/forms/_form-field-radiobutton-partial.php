<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<div class="input">
<ul class="option-list <?php echo isNullOrEmpty($field->OptionsAlignment) ? "vertical-list" : strtolower($field->OptionsAlignment) . "-list"; ?>">
  <?php 
     
	 $checkedAttribute = "";
	 $fieldOptionArr = explode(",", $field->Options);
	 $checkedOptions=0;
	 $selectedOptions=array();	 
	 
	 foreach( $fieldOptionArr as $option)
	 {
	    if(isTempFormValueSelected($field, $option))
		{		   
		   array_push($selectedOptions, $option);
		   $checkedOptions++;
		}
	 }
	 
     $checkFirst = empty($field->SelectedOption) && $checkedOptions==0;
     $counter = 0;
     

    foreach($fieldOptionArr as $option)
   {   
       echo "<li>";
        if (in_array($option, $selectedOptions))
        {
            $checkedAttribute = "checked=\"checked\"";
        }
        else
        {
            $checkedAttribute = "";
        }

		// no value selected, set default
        if ($checkedOptions==0 && $option==$field->SelectedOption)
        {
            $checkedAttribute = "checked=\"checked\"";
        }
        
		// no value selected, and no default present, just select the first option
        if ($checkFirst && $counter == 0)
        {
            $checkedAttribute = "checked=\"checked\"";
        }
        
        $counter = $counter + 1;
  
		echo strFormat("<input  name='SubmitFields[{0}][Radiobutton]' type='radio' {1} value='{2}' name='radiogroup-{3}'/><label>{2}</label>", $field->DomId, $checkedAttribute, $option, $field->Id);
        echo "</li>";
		
   }
   ?>
   
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