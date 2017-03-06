<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?>&nbsp;&nbsp;</label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<div class="input">
<ul class="option-list  <?php echo isNullOrEmpty($field->OptionsAlignment) ? "vertical-list" : strtolower($field->OptionsAlignment) . "-list"; ?>">
   <?php 
   
   $checkedAttribute = "";  
   $counter = 0;
   $selectedValue = getFormFieldValue($field);
   $selectedValueArray = array();
   if (is_array($selectedValue)){
	  $selectedValueArray = $selectedValue;
	  $selectedValue=null;
   }
   
   if (!isNullOrEmpty($selectedValue)){
	   $selectedValueArray = explode(",", $selectedValue);
   }
   foreach (explode(",",$field->Options) as $option)
   {       
       echo "<li>";       
           if (in_array($option, $selectedValueArray))
           {
               $checkedAttribute = "checked=\"checked\"";
           }
           else {
               $checkedAttribute = "";
           }
           
           echo strFormat("<input id='SubmitFields[{0}][Checkbox][{3}]' name='SubmitFields[{0}][Checkbox][{3}]' {1} type='checkbox' value='{2}' /><label for='SubmitFields[{0}][Checkbox][{3}]'>{2}</label>", $field->DomId, $checkedAttribute, $option, $counter);
       echo "</li>";
	   $counter++ ;
	
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


