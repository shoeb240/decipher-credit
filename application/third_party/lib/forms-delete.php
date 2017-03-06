<?php

 
	require_once( ABSPATH . '/lib/forms-form-repository.php' );
	require_once( ABSPATH . '/lib/forms-html-utils.php' );
	
    
	if(!isNullOrEmpty($_GET["id"]) && is_numeric($_GET["id"])){
	   $id=$_GET["id"];
	   $formRepo  = new FormRepository;
       $form = $formRepo->getByPrimaryKey($id);
		   
	   if($form == null){	      
		  setErrorMessage("A valid form was not found.");
		  redirectToErrorPage();
	   }
	   
	   if(Utils::isLockedFormId($id)){
		  setErrorMessage("Cannot delete the form \"". $form["Title"] ."\" while it is locked.");
		  header('Location:'. rootUrl() . '/index.php'); 
		  exit();
	   }   
	   
	   $formRepo->DeleteForm($id);
	   
	   setSuccessMessage("The form \"" . $form["Title"] . "\" was deleted.");
	   
	   // 2. redirect to main page
	   header('Location:'. rootUrl() . '/index.php'); 
	   
	}else{
		setErrorMessage("Cannot find form for given Id");
		redirectToErrorPage();
	}
	
	
	   
?>