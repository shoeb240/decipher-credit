<?php

    require_once(ABSPATH . '/lib/forms-common.php' );
    require_once(ABSPATH . '/lib/forms-form-repository.php');	
	require_once(ABSPATH . '/lib/forms-html-utils.php');
	require_once(ABSPATH . '/lib/forms-utils.php');
	require_once(ABSPATH . '/lib/forms-settings.php');
		
    $formView = new FormViewModel();
	$form_themes = array();
	
	if(!isNullOrEmpty($_GET["id"]) && is_numeric($_GET["id"])){
	   $id=$_GET["id"];
	   $formRepo  = new FormRepository;
       $form = $formRepo->getByPrimaryKey($id);
		   
	   if($form == null){	      
		  setErrorMessage("A valid form was not found.");
		  redirectToErrorPage();		  
	   }   
	   
	   $formView = FormViewModel::createFromObject($form);
	   $formView->Entries = $formRepo->GetRegistrantObjectsByForm($id);
	   $formView->loadGroupedEntries();
	}else{
		setErrorMessage("Cannot find form for invalid Id");
		redirectToErrorPage();
	}
?>