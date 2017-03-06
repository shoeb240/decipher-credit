<?php //Hidden field values for all properties that get posted to the server ?>
<input id="field-prop-<?php echo $field->DomId; ?>" type="hidden" value='<?php echo rawurlencode(json_encode($field)); ?>' 
		data-sub-channel="sub-properties-<?php echo $field->DomId; ?>"  
		data-value-type="OBJECT" 		 
		data-field-id="<?php echo $field->Id; ?>"
	   data-field-type="<?php echo $field->FieldType; ?>"
	   data-field-order="<?php echo $field->Order; ?>"
		name="Fields[<?php echo $field->DomId; ?>][Properties]" />