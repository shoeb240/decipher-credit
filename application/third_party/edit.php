<?php
   
   define("ABSPATH", dirname(__FILE__));
   require_once( ABSPATH . '/lib/forms-common.php' );
   require_once( ABSPATH . '/lib/forms-edit.php' );
   
   
  
   $Title = "Edit Form";
   $headerScripts = array("/scripts/form-builder/fbuilder.layout.js"						  
						  );
						  
   $headerStyles = array("/content/css/form-builder/forms-common.css",
						 "/content/css/form-builder/forms-interface.css",						 
						 "/content/css/plugins/jquery.fs.stepper.css"						 
						);		
	
	$footerScripts = array("/scripts/form-builder/fbuilder.forms.js",						   
						   "/scripts/jquery.jeditable.min.js",
						   "/scripts/jquery.inputmask.bundle.min.js",
						   "/scripts/jquery.fs.stepper.js",
						   "/scripts/jquery.elastic.source.js",
						   "/scripts/tinymce/tinymce.min.js"
						  );	

    $context_css = "forms-edit";			
	
	$data_dictionaries = Utils::getBindingDictionaries();
	$input_masks = Utils::getInputMasks();
   
?>

<?php include(ABSPATH . "/views/shared/forms-header.php"); ?>

<div class="form-page-container prepend-top span-26">   
   <form action="<?php getLinkUrl("/actions.php?a=update"); ?>" data-ajax="true" data-ajax-begin="forms.handleBeginSave" data-ajax-complete="forms.handleSaveCallback" data-ajax-loading="#spinner" data-ajax-method="POST" id="main-form" method="post">    
    

<div class="left-column span-4">              
	   
         <?php customInclude("/views/forms/_FormToolsMenuPartial.php") ?>
	   
    </div>
    <div class="center-column span-14">
        <div class="inner-container">        
		<?php include(ABSPATH . "/views/forms/_FormsSubMenuPartial.php") ?>
              <br /><br />
            <ul class="horizontal-list title-list">
                <li class="form-info title-info">
                    <h2 class="form-editable form-title" data-sub-channel="sub-title-0"><?php echo $formView->Title ?></h2>                        
                </li>                
            </ul>
            <div id="message" class="clear"></div>
            <?php writeMessages();?>
        </div>
        <div class="form-area">            		    
            <ul id="drop-form" class="vertical-list edit-form drop-form-list entry-form-list ">
              <?php if (count($formView->Fields) > 0): ?>
              
                   <?php foreach ($formView->Fields as $field): ?>                   				       
						<li id="drop-item-<?php echo $field->DomId;?>" class="drop-item ui-droppable <?php echo strtolower($field->FieldType); ?>-control <?php echo isNullOrEmpty($field->Css) ? '' : $field->Css; ?>" data-dom-id="<?php echo $field->DomId;?>" data-control-type="<?php echo strtolower($field->FieldType); ?>">							
							<?php include(ABSPATH . "/views/forms/_form-field-". strtolower($field->FieldType) . "-partial.php") ?>							
						</li>
						
						<?php
						/*
						<!--place test template here -->
						<li id="drop-item-<?php echo $field->DomId;?>" class="drop-item ui-droppable" data-dom-id="<?php echo $field->DomId;?>" data-control-type="<?php echo strtolower($field->FieldType); ?>">							
						  <?php include(ABSPATH . "/views/forms/_form-field-my-test-template-partial.php")?>
						</li>
						*/
						?>
                   <?php endforeach; ?>
			
			<?php else: ?>
						<li class="prompt-item">
						<div class="add-fields-prompt rounded-5 shadow-2">
							Drag Form Fields from the left side-bar into this space to begin building your form
						</div>
						<br /><br />
						</li>
              <?php endif; ?>
            </ul>
            <ul id="submit-button-list" class="vertical-list entry-form-list">
              <li>
                <label class="label">&nbsp;</label>
                <div class="input">
                  <input type="submit" value="Save Changes" class="save-button green"  />
                  <br /><br />
                </div>
              </li>
            </ul>
        </div>
    </div>
    <div class="right-column span-7 last">
       <?php tip("Active fields on your form can be edited in the box below.","tip wide-tip") ?><br />
	   <div id="property-editor-container">
      <div id="form-property-container">
        <?php include(ABSPATH . "/views/forms/_form-property-editor-partial.php") ?>
      </div>
      <div id="field-property-container" class="hide">
      
	  <?php include(ABSPATH . "/views/forms/_form-field-property-editor-partial.php") ?>
      </div>
	  </div>	  
    </div>     

<input id="Id" type="hidden" value="<?php echo $formView->Id; ?>" name="Id" data-val-number="The field Id must be a number." data-val="true">
<input id="IsTemplate" type="hidden" value="<?php echo $formView->IsTemplate; ?>" name="IsTemplate">
<input id="IsAutoSave" type="hidden" value="false" name="IsAutoSave">
<input id="isAltered" type="hidden" value="0">
<?php //dummy field below to prevent null value for update action dicationary param ?>
<input id="fieldid-prop" type="hidden" value="" name="Fields[-1].Id">                                     
<?php //dictionary of all available properties ?>
<input id="field-attribute-dictionary" type="hidden" value="<?php echo rawurlencode(json_encode(FormFieldViewModel::getPropertiesAsDictionary())); ?>" />
<input id="field-json-object" type="hidden" value="<?php echo rawurlencode(json_encode(FormFieldViewModel::createDefaultForJSON())); ?>" />
</form>
</div>

<div id="autosave-container" class="autosave-container rounded-5 shadow-2 hide">
   <?php createSpinner("auto-save",false) ?> &nbsp;&nbsp;Auto-saving
</div>
<?php include(ABSPATH . "/views/forms/_FormEmbedPartial.php") ?>

<!--Register tools here-->
<?php include(ABSPATH . "/views/forms/_form-field-header-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-textbox-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-textarea-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-dropdownlist-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-checkbox-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-radiobutton-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-fullname-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-email-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-address-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-phone-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-birthdaypicker-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-prompt-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-filepicker-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-datepicker-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-captcha-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-formbreak-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-image-template.php"); ?>
<?php include(ABSPATH . "/views/forms/_form-field-paragraph-template.php"); ?>

<!-- single instance permitted template -->
<script id="single-instance-permitted-template" type="text/x-jquery-tmpl">
  <div id="modal-content" style="display:none;">
			<div id="modal-title">Warning</div>
			<div class="close"><a href="#" class="simplemodal-close">x</a></div>
			<div id="modal-data">
               <div class="script-container">
				<span class="large">The ${controlType} control can only have one instance on the form.</span>
				</div>
                <p><button class="simplemodal-close">Close</button> <span>(or press ESC or click the overlay)</span></p>
			</div>
    </div>
    
</script>

<?php 
   function initializers()
   {	 
     echo "forms.init();";
   }   
?>

<?php include(ABSPATH . "/views/shared/forms-footer.php"); ?>

