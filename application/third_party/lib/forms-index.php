<?php	

 
	require_once(ABSPATH . '/lib/forms-form-repository.php');
	require_once(ABSPATH . '/lib/forms-html-utils.php' );
	
	$formViews = array();
	try{
		$formRepo  = new FormRepository;
		$formViewsList = $formRepo->getForms(); 
		$db_connection_error = false;
	}catch(PDOException $e){		
		$db_connection_error = true;
		$db_connection_error_message = $e->getMessage();
	}
?>