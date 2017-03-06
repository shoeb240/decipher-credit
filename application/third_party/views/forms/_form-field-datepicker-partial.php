<?php	
	$timeValues = getSelectedTimeValues($field);
?>
<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<div id="date-picker-input-<?php echo $field->DomId; ?>"  class="input date-picker-input">
<ul id='date-item-list-container-<?php echo $field->DomId; ?>' data-language="<?php echo $field->Language; ?>" class="vertical-list <?php outputIfTrue(Utils::isBool($field->IsToFromDate), "two-date-mode", ""); ?> <?php outputIfTrue(Utils::isBool($field->ShowTime), "show-time-mode", ""); ?>  <?php outputIfTrue($field->TimeFormat == "24", "twenty-four-hour-mode", ""); ?>">
   <li>
      <!-- begin date 1-->
	   <ul class="horizontal-list selection-fields-list">
        <li>
			<div class="date-picker-date-container">
			   <input id="SubmitFields-<?php echo $field->DomId; ?>-Date1"
					  name="SubmitFields[<?php echo $field->DomId; ?>][Date1]"
					  value = "<?php echo getFormFieldValue($field,"Date1"); ?>"
					  class="date-picker-field datepicker-from-field-<?php echo $field->DomId; ?>" 
					  type="text"  />			  			  
              <a id="date-picker-select-<?php echo $field->DomId; ?>" href="javascript:void(0);" class="image-icon-link datepicker-select-icon-link datepicker-from-select-icon-link-<?php echo $field->DomId; ?>">			     
			  </a>			  
			</div>
			<span class="sub-label">From</span>			
        </li>
        <li class="time-fields">
			<select id="SubmitFields[<?php echo $field->DomId; ?>][Hour1]" name="SubmitFields[<?php echo $field->DomId; ?>][Hour1]" class="hour">
			    <?php 
					for($x=1; $x <= 12; $x++){
						$selectedHHAttribute = $timeValues['hh1'] == $x ? Constants::SELECTED_DROP_DOWN_ATTRIBUTE : "";
						echo strFormat("<option value='{0}' {1}>{2}</option>", $x, $selectedHHAttribute, returnIfTrue($x < 10, "0" . (string)$x, $x));
					}
				?>
			  </select>
			  <select id="SubmitFields[<?php echo $field->DomId; ?>][Minute1]" name="SubmitFields[<?php echo $field->DomId; ?>][Minute1]" class="minute">
			    <?php 
					for($x=0; $x <= 59; $x++){
						$selectedMMAttribute = $timeValues['mm1'] == $x ? Constants::SELECTED_DROP_DOWN_ATTRIBUTE : ""; 
						echo strFormat("<option value='{0}' {1}>{2}</option>", $x, $selectedMMAttribute, returnIfTrue($x < 10, "0" . (string)$x, $x));
					}
				?>
			  </select>
			  <select id="SubmitFields[<?php echo $field->DomId; ?>][AMPM1]" name="SubmitFields[<?php echo $field->DomId; ?>][AMPM1]" class="am-pm-field">
				<option value="AM" <?php outputIfTrue($timeValues['dd1'] == "AM", "selected='selected'", ""); ?>>AM</option>
				<option value="PM" <?php outputIfTrue($timeValues['dd1'] == "PM", "selected='selected'", ""); ?>>PM</option>
			  </select>
      
        </li>       
    </ul>
	  <!-- end date 1-->
   </li>
   <li class="to-date">
     <!-- begin date 2-->
	  <ul class="horizontal-list  selection-fields-list">
        <li>
			<div class="date-picker-date-container">
			   <input id="SubmitFields-<?php echo $field->DomId; ?>-Date2" 
					  value = "<?php echo getFormFieldValue($field,"Date2"); ?>"
					  name="SubmitFields[<?php echo $field->DomId; ?>][Date2]" 
					  class="date-picker-field datepicker-to-field-<?php echo $field->DomId; ?>" type="text"  />			  			  
              <a id="date-picker-select-<?php echo $field->DomId; ?>" 
				 href="javascript:void(0);" 
				 class="image-icon-link datepicker-select-icon-link datepicker-to-select-icon-link-<?php echo $field->DomId; ?>">			     
			  </a>
			</div>				
			<span class="sub-label">To</span>
        </li>
        <li class="time-fields">
			<select id="SubmitFields[<?php echo $field->DomId; ?>][Hour2]" name="SubmitFields[<?php echo $field->DomId; ?>][Hour2]" class="hour">
			    <?php 
					for($x=1; $x <= 12; $x++){
						$selectedHHAttribute = $timeValues['hh2'] == $x ? Constants::SELECTED_DROP_DOWN_ATTRIBUTE : "";
						echo strFormat("<option value='{0}' {1}>{2}</option>", $x, $selectedHHAttribute, returnIfTrue($x < 10, "0" . (string)$x, $x));
					}
				?>
			  </select>
			  <select id="SubmitFields[<?php echo $field->DomId; ?>][Minute2]" name="SubmitFields[<?php echo $field->DomId; ?>][Minute2]" class="minute">
			    <?php 
					for($x=0; $x <= 59; $x++){
						$selectedMMAttribute = $timeValues['mm2'] == $x ? Constants::SELECTED_DROP_DOWN_ATTRIBUTE : ""; 
						echo strFormat("<option value='{0}' {1}>{2}</option>", $x, $selectedMMAttribute, returnIfTrue($x < 10, "0" . (string)$x, $x));
					}
				?>
			  </select>
			  <select id="SubmitFields[<?php echo $field->DomId; ?>][AMPM2]" name="SubmitFields[<?php echo $field->DomId; ?>][AMPM2]" class="am-pm-field">
				<option value="AM" <?php outputIfTrue($timeValues['dd2'] == "AM", "selected='selected'", ""); ?>>AM</option>
				<option value="PM" <?php outputIfTrue($timeValues['dd2'] == "PM", "selected='selected'", ""); ?>>PM</option>
			  </select>
      
        </li>       
    </ul>
	 <!-- end date 2-->
   </li>
   <?php if (!$field->isEditMode()): ?>
   <input id="SubmitFields-<?php echo $field->DomId; ?>-Language"
		  name="SubmitFields[<?php echo $field->DomId; ?>][Language]"			   					  
		  value="<?php echo $field->Language; ?>"
		  type="hidden"  />
   <input id="SubmitFields-<?php echo $field->DomId; ?>-Mode"
		  name="SubmitFields[<?php echo $field->DomId; ?>][IsToFromDate]"			   					  
		  value="<?php echo Utils::isBool($field->IsToFromDate); ?>"
		  type="hidden"  />
	<input id="SubmitFields-<?php echo $field->DomId; ?>-TimeFormat"
		  name="SubmitFields[<?php echo $field->DomId; ?>][TimeFormat]"			   					  
		  value="<?php echo $field->TimeFormat; ?>"
		  type="hidden"  />
    <?php endif;?>
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
