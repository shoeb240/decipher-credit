<?php

 
   require_once( ABSPATH . '/lib/forms-utils.php' );
   require_once( ABSPATH . '/lib/forms-html-utils.php' );
   require_once( ABSPATH . '/lib/forms-form-view-model.php' );
   require_once( ABSPATH . '/lib/forms-form-repository.php' );
   
   
   if ($_SERVER['REQUEST_METHOD']== "GET") {
      $formRepo = new FormRepository();
      $formView = new FormViewModel();
      $form = $formRepo->getByPrimaryKey($_GET["id"]);
	  $embed = isset($_GET["embed"]);    
      
      if (isset($form))
      {
        $formView = FormViewModel::createFromObject($form);
        $formView->Embed = $embed;          
		setSuccessMessage($formView->ConfirmationMessage);          
		
      }else{
	    setErrorMessage("Invalid operation");
	  }
   }else{
      setErrorMessage("Invalid request");
   }

?>