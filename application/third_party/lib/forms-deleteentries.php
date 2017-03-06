<?php

 
	require_once(ABSPATH . '/lib/forms-form-repository.php' );
	require_once(ABSPATH . '/lib/forms-html-utils.php');
			
	try{
		if(!isNullOrEmpty($_POST["selectedEntries"])){
	   	   
			$formRepo  = new FormRepository;      
	   
			foreach($_POST["selectedEntries"] as $entry){	      
				$formRepo->DeleteEntry($entry);
			}
	   
			setSuccessMessage("The selected entries were deleted");
		}			
	}catch(Exception $e) {
			setErrorMessage("An error occured while deleting entries. Try again later.");
	}
	   
	header("Location:" . rootUrl() . "/entries.php?id=" . $_POST["Id"]);		   
?>