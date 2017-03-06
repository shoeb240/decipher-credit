<?php
    
	require_once(ABSPATH . '/lib/forms-common.php' );
    require_once(ABSPATH . '/lib/forms-form-repository.php');	
	require_once(ABSPATH . '/lib/forms-html-utils.php');
	require_once(ABSPATH . '/lib/forms-utils.php');
	require_once(ABSPATH . '/lib/forms-settings.php');
		
    
	if(isset($_GET["id"]) && !isNullOrEmpty($_GET["id"])){
	
		if(isset($_GET["enable"]) && !isNullOrEmpty($_GET["enable"])){
			$id=$_GET["id"];
			$formRepo  = new FormRepository;
			$enable = Utils::isBool($_GET["enable"]);
			$formRepo->updateTemplateProperty($id, $enable);
			Utils::outputJson(array("success" => true));
		}
	}
?>