<?php  //Hidden field values for all properties that get posted to the server ?>
<input id="field-prop-${domid}" type="hidden" 
       value='${jsonObject}' 
	   data-value-type="OBJECT" 
	   data-field-id=""
	   data-field-type="${fieldType}"
	   data-field-order="${order}"
	   data-sub-channel="sub-properties-${domid}" 	   
	   name="Fields[${domid}][Properties]"	   />