<?php

 
   require_once( ABSPATH . '/lib/forms-utils.php' );
   require_once( ABSPATH . '/lib/forms-html-utils.php' );
   require_once( ABSPATH . '/lib/forms-form-view-model.php' );
   require_once( ABSPATH . '/lib/forms-form-field-view-model.php' );
   require_once( ABSPATH . '/lib/forms-form-repository.php' );
      
   if ($_SERVER['REQUEST_METHOD']== "POST") {
      $formRepo = new FormRepository();
	        
	  if(isset($_POST["fieldid"])){
		  $form = $formRepo->GetFormByFieldId($_POST["fieldid"]);
		  if (Utils::isLockedFormId($form["ID"])){
			 Utils::outputJson(array("success" => false, "message" => "Unable to delete field. This form is locked for editing.")); 		   
		  }else{
			$formRepo->DeleteField($_POST["fieldid"]);
			Utils::outputJson(array("success" => true, "message" => "Field was deleted.")); 		   
		  }
	  }   
   }else{ 
      Utils::outputJson(array("success" => false, "message" => "Unable to delete field.")); 		   
   }
 
 
 ?>