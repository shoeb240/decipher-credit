<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<div class="input">
<select id="SubmitFields[<?php echo $field->DomId; ?>][Dropdownlist]" <?php echo outputIfTrue(Utils::isBool($field->MultiSelect), "multiple='true'", ""); ?> 
        name="SubmitFields[<?php echo $field->DomId; ?>][Dropdownlist]<?php echo outputIfTrue(Utils::isBool($field->MultiSelect), "[]", ""); ?>" 
		class="default <?php echo outputIfTrue(Utils::isBool($field->MultiSelect), "multi-select-mode", ""); ?>">
<?php 
   $data_collection = array();
   $option_item_format = "<option {0} value='{1}' />{2}</option>";
   $has_dictionary = !isNullOrEmpty($field->Dictionary) && strtolower($field->Dictionary) != 'null';   
   if ($has_dictionary && array_key_exists($field->Dictionary, $data_dictionaries)){	  
	  $data_collection = $data_dictionaries[$field->Dictionary]->Items;
   }else{
	  $data_collection = array();
	  foreach(explode(",",$field->Options) as $option){		  
		  $data_collection[$option]=$option;		  		  
	  }
   }   
   
   
	   $selectedAttribute = "";  
	   $counter = 0;
	   $selectedValue = getFormFieldValue($field);
	   $selectedValueArray = array();
	   if (is_array($selectedValue)){
		  $selectedValueArray = $selectedValue;
		  $selectedValue=null;
	   }
	   
	   if (!isNullOrEmpty($selectedValue)){
		   $selectedValueArray = explode(",", $selectedValue);
	   }else{
		   array_push($selectedValueArray, $field->SelectedOption);
	   }
	   
	   foreach ($data_collection as $key=>$value)
	   {   
		   if (in_array($key, $selectedValueArray))
		   {
			   $selectedAttribute = "selected=\"selected\"";
		   }
		   else{
			   $selectedAttribute = "";
		   }		   
		   
		   echo strFormat($option_item_format, $selectedAttribute, $key, $value);		   
		   $counter++ ;
		
	   }
   	   
   
      
   
 ?>
</select>
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