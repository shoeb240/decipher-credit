<?php

	require_once( ABSPATH . '/lib/forms-form-repository.php' );
	require_once( ABSPATH . '/lib/forms-html-utils.php' );
	
    $responseObj = new stdclass;
	$responseObj->isajax = isset($_GET["is-ajax"]);
	   
	if(!isNullOrEmpty($_GET["id"]) && is_numeric($_GET["id"])){
	   $id=$_GET["id"];	   
	   $usesTemplate=isset($_GET["uses-template"]);
	   $responseObj->success=true;
	   $formRepo  = new FormRepository;
       $form = $formRepo->getByPrimaryKey($id);
	   
		   
	   if($form == null){	      
	      $responseObj->message = "Could not create a copy. A valid form was not found.";
		  $responseObj->success = false;
		  
		  if ($responseObj->isajax){
			Utils::outputJson((array)$responseObj); 
		  }else{
			setErrorMessage($responseObj->message);
			redirectToErrorPage();
		  }
	   }
	   
	   $formId = $formRepo->CopyForm($form, $usesTemplate);
	   $msg = $usesTemplate ? "A new form was created from the template \"" . $form["Title"] . "\"." : "The form \"" . $form["Title"] . "\" was copied.";
	   setSuccessMessage($msg);
	   $responseObj->url = rootUrl() . '/edit.php?id=' . $formId;
	   // 2. redirect to main page
	   
	   if ($responseObj->isajax){
			Utils::outputJson((array)$responseObj); 
	   }else{
			header('Location:'. $responseObj->url);  
	   }
	   
	}else{		
	  $responseObj->message = "Form Id not found in request";
	  $responseObj->success = false;
	  
	  if ($responseObj->isajax){
		Utils::outputJson((array)$responseObj); 
	  }else{
		setErrorMessage($responseObj->message);
		redirectToErrorPage();
	  }
	   		
	}

?>