<?php getFieldErrors($field); ?>
<label data-sub-channel="sub-label-<?php echo $field->DomId; ?>" class="label editable"><?php echo $field->Label; ?></label>
<span class="required">*</span>
<div class="input recaptcha-input">

<?php if ($field->isEditMode()): ?>
  <img src="<?php echo $docRoot; ?>/content/images/recaptcha.png" class="recaptcha" />
<?php else: ?>
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : '<?php echo Settings::RECAPTCHA_THEME; ?>'
 };
 </script>
 <?php 
    if (isNullOrEmpty(Settings::RECAPTCHA_KEY)){
		echo "<span class='field-validation-error'>A recaptcha key has not been set in the forms-constants.php file. <a href='https://developers.google.com/recaptcha/docs/start'>Click here to obtain a key</a></span>";
	}else{
		echo recaptcha_get_html(Settings::RECAPTCHA_KEY); 
	}
?>
<?php endif; ?>
  
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
