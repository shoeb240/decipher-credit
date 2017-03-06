<?php
    
	require_once(ABSPATH . '/lib/forms-common.php' );
    require_once(ABSPATH . '/lib/forms-form-repository.php');	
	require_once(ABSPATH . '/lib/forms-html-utils.php');
	require_once(ABSPATH . '/lib/forms-utils.php');
	require_once(ABSPATH . '/lib/forms-settings.php');
		
    
	if(isset($_GET["c"]) && !isNullOrEmpty($_GET["c"])){
	   
	   if (strtolower($_GET["c"]) == "redirecturl"){
		   $url = "";
		   if(!isNullOrEmpty($_GET["formid"])){
			   $url = getFormRedirectPage($_GET["formid"]);		       			      
		   }		   
		   Utils::outputJson(array("url" => $url)); 
	   }
	}else if (isset($_GET["d"]) && !isNullOrEmpty($_GET["d"])){
		 $items = Utils::getBindingDictionaries($_GET["d"]);
		 Utils::outputJson($items);
	}else if (isset($_GET["mask"]) && !isNullOrEmpty($_GET["mask"])){
		 $mask = Utils::getInputMasks($_GET["mask"]);
		 Utils::outputJson($mask);
	}
?>