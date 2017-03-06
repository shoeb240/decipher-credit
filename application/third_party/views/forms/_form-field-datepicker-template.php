<script id="form-field-datepicker-template" type="text/x-jquery-tmpl">
<label data-sub-channel="sub-label-${id}" class="label editable">
    Click to edit</label>
      <span class="required hidden">*</span>
<div id="date-picker-input-${id}" class="input date-picker-input">
    <ul  id="date-item-list-container-${id}" class="vertical-list" data-language-prefix="">
   <li>
      <!-- begin date 1-->
	   <ul class="horizontal-list selection-fields-list">
        <li>
			<div class="date-picker-date-container">
			   <input id="SubmitFields[${id}][Date1]" class="date-picker-field date-picker-from-field-${id}" type="text"  />			  			  
              <a id="date-picker-select-${id}" href="javascript:void(0);" class="image-icon-link datepicker-select-icon-link">			     
			  </a>			  
			</div>
			<span class="sub-label">From</span>			
        </li>
        <li class="time-fields">
			<select id="SubmitFields[${id}][Hour1]" class="hour">
			    <?php 
					for($x=1; $x <= 12; $x++){
						echo strFormat("<option value='{0}'>{1}</option>",$x, returnIfTrue($x < 10, "0" . (string)$x, $x));
					}
				?>
			  </select>
			  <select id="SubmitFields[${id}][Minute1]" class="minute">
			    <?php 
					for($x=0; $x <= 59; $x++){
						echo strFormat("<option value='{0}'>{1}</option>",$x, returnIfTrue($x < 10, "0" . (string)$x, $x));
					}
				?>
			  </select>
			  <select id="SubmitFields[${id}][AMPM1]" class="am-pm-field">
				<option value="AM">AM</option>
				<option value="PM">PM</option>
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
			   <input id="SubmitFields[${id}][Date2]" class="date-picker-field date-picker-to-field-${id}" type="text"  />			  			  
              <a id="date-picker-select-${id}" href="javascript:void(0);" class="image-icon-link datepicker-select-icon-link">			     
			  </a>
			</div>				
			<span class="sub-label">To</span>
        </li>
        <li class="time-fields">
			<select id="SubmitFields[${id}][Hour2]">
			    <?php 
					for($x=1; $x <= 12; $x++){
						echo strFormat("<option value='{0}'>{1}</option>",$x, returnIfTrue($x < 10, "0" . (string)$x, $x));
					}
				?>
			  </select>
			  <select id="SubmitFields[${id}][Minute2]">
				<?php 
					for($x=0; $x <= 59; $x++){
						echo strFormat("<option value='{0}'>{1}</option>",$x, returnIfTrue($x < 10, "0" . (string)$x, $x));
					}
				?>
			  </select>
			  <select id="SubmitFields[${id}][AMPM2]" class="am-pm-field">
				<option value="AM">AM</option>
				<option value="PM">PM</option>
			  </select>
      
        </li>       
    </ul>
	 <!-- end date 2-->
   </li>
</ul>    
	<?php include(ABSPATH . "/views/forms/_form-field-properties.php"); ?>
</div>
<a href="javascript:void(0);" class="help-icon-1 help-icon hide w-tip">
  <img src="<?php spacerImage(); ?>" alt="help" />
</a>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>
