<?php

    require_once(ABSPATH . '/lib/forms-common.php' );
    require_once(ABSPATH . '/lib/forms-form-repository.php');	
	require_once ABSPATH . '/lib/forms-html-utils.php';
	require_once(ABSPATH . '/lib/forms-utils.php');
	require_once(ABSPATH . '/lib/forms-settings.php');
	require_once(ABSPATH . '/lib/ReCaptcha/ReCaptcha.php');
	require_once(ABSPATH . '/lib/recaptchalib.php');
			
	$form_themes = array();
			
	if(!isNullOrEmpty($_GET["id"]) && is_numeric($_GET["id"])){
	   $formRepo  = new FormRepository;
	   
	   $id=$_GET["id"];	   
	   $embed = isset($_GET["embed"]) && $_GET["embed"]=="true" ? true : false;
	   
	   $hasEntryId = isset($_GET["entry"]) && !isNullOrEmpty($_GET["entry"]) && $formRepo->ValidEntryExists($_GET["entry"]);
	   $entryId = $hasEntryId ? $_GET["entry"] : "";
	   
	   
	   $wizardStep=1;
	   if(isset($_GET["step"]) && is_numeric($_GET["step"])){
		   $wizardStep = intval($_GET["step"]);
	   }
	   
	   $form = $formRepo->getByPrimaryKey($id);
		   
	   if($form == null){	      
		  setErrorMessage("A valid form was not found.");
		  redirectToErrorPage();
	   }
	   
	   $entries=null;
	   if ($hasEntryId){
		   $entries = $formRepo->GetEntryValues($id, $entryId);		
	   }
	   
	   $form["Fields"]=$formRepo->GetFieldsByFormId($form["ID"]);
	   $formView = FormViewModel::CreateFromObjectWithMode($form, "INPUT", $wizardStep, true, $entries);
	   $formView->Embed=$embed;   	   
	   $formView->mode = "INPUT";
	   $formView->EntryID=$entryId;	
	   
	}else{
		setErrorMessage("Cannot find form for invalid Id");
		redirectToErrorPage();
	}
?>