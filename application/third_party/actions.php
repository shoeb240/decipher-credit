<?php 
	
	define("ABSPATH", dirname(__FILE__));
    require_once(ABSPATH . '/lib/forms-common.php' );
	require_once(ABSPATH . '/lib/forms-form-repository.php' );
	require_once(ABSPATH . '/lib/forms-html-utils.php' );
	    
	if(isset($_GET["a"])){
	   $action=$_GET["a"];	   
       $filePath = ABSPATH . '/lib/forms-' . str_replace(".php","",$action) . '.php';
	   $isAutoSave = isset($_POST['IsAutoSave']) && $_POST['IsAutoSave'] == "true" ? true : false;
		if (file_exists($filePath) && is_readable($filePath)) 
		{
			require_once(ABSPATH . '/lib/forms-' . $action . '.php' );
		}
		else
		{
			$error = 'A file "' . $filePath . '", required to perform an action was not found or is not readable';
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			   Utils::outputJson(array("success" => false, "error" => $error, "isautosave" => $isAutoSave ));
			}else{
			   throw new Exception($error);
			}
		}
	   
	}else{
		setErrorMessage("Cannot find a valid action");
		redirectToErrorPage();
	}
	

?>