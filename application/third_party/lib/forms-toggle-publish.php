<?php

   require_once(ABSPATH . '/lib/forms-common.php' );
   require_once( ABSPATH . '/lib/forms-utils.php' );
   require_once( ABSPATH . '/lib/forms-html-utils.php' );
   require_once( ABSPATH . '/lib/forms-form-view-model.php' );
   require_once( ABSPATH . '/lib/forms-form-field-view-model.php' );
   require_once( ABSPATH . '/lib/forms-form-repository.php' );
   

	if (isset($_GET["id"]) && isset($_GET["to_on"]))
    {		   
		$formRepo = new FormRepository();
        $fields = $formRepo->GetFieldsByFormId($_GET["id"]);
		$toOn =  strtolower($_GET["to_on"]) == "true" ? true : false;
		$id = $_GET["id"];
		if(count($fields) > 0)
		{
			$status = $toOn ? "PUBLISHED" : "DRAFT";
            $formRepo->UpdateStatus($id, $status);
            if ($toOn)
            {
                setSuccessMessage("This registration form has been published and is now live");
            }
            else
            {
                setSuccessMessage("This registration form is now offline");
            }
		}else{
		    setErrorMessage("Cannot publish form until fields have been added.");
		}
		
		header('Location:' . rootUrl() .  '/edit.php?id=' . $_GET["id"] ); 
		exit();
    }else{
		setErrorMessage("Invalid form id provided.");
		header('Location:' . rootUrl() .  '/index.php');
		exit();
	}
	
	
   
	   	 
	   
  


?>