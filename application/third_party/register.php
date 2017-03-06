<?php     
   define("ABSPATH", dirname(__FILE__));
   require_once(ABSPATH . '/lib/forms-register.php');	 
 
   $Title = $formView->Title;
   $headerScripts = array("/scripts/form-builder/fbuilder.utils.js", 
						  "/scripts/form-builder/fbuilder.global.js", 
					      "/scripts/form-builder/fbuilder.layout.js", 
						  "/scripts/form-builder/fbuilder.forms-register.js",
						  "/scripts/jquery.inputmask.bundle.min.js",
						  "/scripts/jquery.fs.stepper.js"						   
						  );
						  
   $headerStyles = array("/content/css/form-builder/forms-common.css",
						 "/content/css/form-builder/forms-interface.css",
						 "/content/css/plugins/jquery.fs.stepper.css"							 
						);		

    if(!isNullOrEmpty($formView->Theme))
	{
	   array_push($headerStyles, "/content/css/form-builder/themes/" . $formView->Theme . "/styles.css");
	}

	$formView->Embed=true;
    $context_css = "forms-register";
    $embedLayoutPrefix = $formView->Embed ? "forms-embed-" : "";	
	$data_dictionaries = Utils::getBindingDictionaries();
	$input_masks = Utils::getInputMasks();
	$editableFieldCount=0;
?>

<?php include(ABSPATH . "/views/shared/" . $embedLayoutPrefix . "header.php"); ?>

<?php if (!isset($isRecaptchaSubmitted) || (isset($isRecaptchaSubmitted) && $isRecaptchaSubmitted==false) && !isset($redirectUrl)): ?>

<div class="form-page-container prepend-top span-26">    
    <div class="center-column span-14">
     <div class="inner-container">   
	 <?php 
 	   if (!$formView->Embed)
       {        
          echo "<a href='". rootUrl() . "/index.php' class='image-icon-link home-icon-link'>Home</a>";
       }
	   ?>
	   </div>
       
	   <form method="post" enctype="multipart/form-data" action="<?php getLinkUrl("/actions.php?a=submit-registration"); ?>">
                    
        <?php writeMessages();?>
        <ul id="drop-form" class="vertical-list edit-form drop-form-list entry-form-list">            
			<?php foreach ($formView->Fields as $field): ?>                   				        
						<li id="drop-item-<?php echo $field->DomId; ?>" class="drop-item ui-droppable  <?php echo strtolower($field->FieldType); ?>-control" data-dom-id="<?php echo $field->DomId; ?>" data-control-type="<?php echo strtolower($field->FieldType); ?>">
							<?php include(ABSPATH . "/views/forms/_form-field-". strtolower($field->FieldType) . "-partial.php"); ?>
							 
						</li>
		   <?php $editableFieldCount = !Utils::isExcludedField($field->FieldType) ? $editableFieldCount+1 : $editableFieldCount; ?>				
           <?php endforeach; ?>
        </ul>
            
			<?php if (isset($formView->Fields) && $editableFieldCount > 0 && !$formView->HideSubmitButton) : ?>
            <ul id="submit-button-list" class="vertical-list entry-form-list">
                <li>
                    <label class="label">
                        &nbsp;</label>
                    <div class="input">
                        <input type="submit" class="blue" value="<?php echo $formView->SubmitButtonText; ?>" />
                    </div>
                </li>
            </ul>
            <?php  endif; ?>
			
			<input id="Id" type="hidden" value="<?php echo $formView->Id; ?>" name="Id">
			<input id="SubmitFields[-1][Hidden]" type="hidden" name="SubmitFields[-1][Hidden]">
			<input id="Embed" type="hidden" name="Embed" value="<?php echo $formView->Embed ? "true" : "false"; ?>">
			<input id="WizardStep" type="hidden" name="WizardStep" value="<?php echo $formView->WizardStep; ?>">
			<input id="EntryID" type="hidden" name="EntryID" value="<?php echo $formView->EntryID; ?>">
        
    </div>
   
</div>
<?php
 function initializers(){
	 echo "formsregister.init();";
 }

else: 

   function initializers()
   {	 
     echo "document.location.href =" . $redirectUrl .  " ;";
   }   


endif; ?>

<?php 
clearPostBackData();
include(ABSPATH . "/views/shared/". $embedLayoutPrefix ."footer.php"); 
?>
