<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required <?php echo outputIfTrue($field->IsRequired,"visible", "hidden"); ?>">*</span>
<?php 
   $fileObj = new FileValueObject();
   $fileObj->FileName = getFormFieldValue($field, "FileName"); 
   $fileObj->SaveName = getFormFieldValue($field, "SaveName");
   $fileObj->IsSavedInCloud = getFormFieldValue($field, "IsSavedInCloud");
   $fieldCSS="";
   $entryExists="";
?>
<div class="input">

<?php if(!isNullOrEmpty($fileObj->FileName)): ?>
  <ul class="horizontal-list file-name-list">
    <li class="name-item"><a href="javascript:void(0);"><?php echo $fileObj->FileName ?></a></li>
	<li class="delete-item"><a href="javascript:void(0);" data-domid="<?php echo $field->DomId; ?>" class="image-icon-link delete-red-icon delete-file-link"></a></li>
  </ul>
<?php 
   $fieldCSS="hide";    
?>   
<?php endif;?>

<input   id="SubmitFields[<?php echo $field->DomId; ?>][Filepicker]" name="SubmitFields[<?php echo $field->DomId; ?>][Filepicker]" type="file" class="title file-picker-field-<?php echo $field->DomId; ?> <?php echo $fieldCSS; ?>"  />
<input   id="SubmitFields[<?php echo $field->DomId; ?>][Filename]" name="SubmitFields[<?php echo $field->DomId; ?>][Filename]" type="hidden" class="file-name-field-<?php echo $field->DomId; ?>" value="<?php echo $fileObj->FileName; ?>"  />
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
