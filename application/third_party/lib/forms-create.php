<?php

	require_once( ABSPATH . '/lib/forms-form-repository.php' );
	
	$formRepo  = new FormRepository;
    
	// 1. create new form
	$formId = $formRepo->createNew();
	
	// 2. redirect to edit page for that form
	header('Location:'. rootUrl() . '/edit.php?id=' . $formId);   
?>