<?php
   
	require_once(ABSPATH . '/lib/forms-common.php' );
    require_once(ABSPATH . '/lib/forms-form-repository.php');	
	require_once(ABSPATH . '/lib/forms-html-utils.php');
	require_once(ABSPATH . '/lib/forms-utils.php');
	require_once(ABSPATH . '/lib/forms-settings.php');
	
	$formsAdded = 0;
	$errorCount = 0;
	$templatesPath = ABSPATH . Settings::DEFAULT_TEMPLATES_PATH;
	$templateFiles = Utils::getFiles($templatesPath);
	$msg = "";
	$responseObj = new stdclass;
	$responseObj->isajax = isset($_GET["is-ajax"]);
	
	foreach($templateFiles as $file){
		$fileJson = file_get_contents($templatesPath . "/" . $file);
		$formData = json_decode($fileJson, true);
		
		foreach($formData["templates"] as $formObject){
			
			try{
				$formRepo = new FormRepository();
				$count = $formRepo->InsertFormObject($formObject);			
				$msg = $msg . "The template " . $formObject["Title"] . " was succesfully added. <br/>";
			}catch(Exception $e){
				$msg = $msg . "The template " . $formObject["Title"] . " failed with the message: " . $e->getMessage();
			}
			$formsAdded = $formsAdded + $count;
		}
	}
	
	// Uncomment the $longMsg for debugging
	//$longMsg = $formsAdded > 0 ? $msg . "<br />" . $formsAdded . " new templates were added." : "No new templates were added";
	$msg = $formsAdded > 0 ? $formsAdded . " new template(s) were added." : "No new templates were added";
	setSuccessMessage($msg);
	
	if ($responseObj->isajax === true){
		$responseObj->message = $msg;
		$responseObj->success = true;
		$responseObj->url = rootUrl() . '/index.php';
		Utils::outputJson((array)$responseObj); 
	}else{
		header('Location:'. rootUrl() . '/index.php'); 
	}
	
?>