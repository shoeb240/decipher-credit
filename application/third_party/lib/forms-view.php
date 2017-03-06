<?php	

 
    require_once(ABSPATH . '/lib/forms-common.php' );
    require_once(ABSPATH . '/lib/forms-form-repository.php');	
	require_once(ABSPATH . '/lib/forms-html-utils.php');
	require_once(ABSPATH . '/lib/forms-utils.php');
	require_once(ABSPATH . '/lib/forms-settings.php');
	
	
    $formView = new FormViewModel();
	
	if(!isNullOrEmpty($_GET["id"]) && is_numeric($_GET["id"])){
	   $id=$_GET["id"];
	   $formRepo  = new FormRepository;
       $form = $formRepo->getByPrimaryKey($id);
		   
	   if($form == null){	      
		  setErrorMessage("A valid form was not found.");
		  redirectToErrorPage();
	   }
	   
	   $form["Fields"]=$formRepo->GetFieldsByFormId($form["ID"]);
	   $formView = FormViewModel::createFromObjectWithMode($form,"INPUT",1, false);	   
	   	   
	   if(isset($_GET["step"]) && is_numeric($_GET["step"])){
		   $formView->WizardStep = intval($_GET["step"]);
	   }
	   
	   $hasEntryId = isset($_GET["entry"]) && !isNullOrEmpty($_GET["entry"]) && $formRepo->ValidEntryExists($_GET["entry"]);
	   $entryId = $hasEntryId ? $_GET["entry"] : "";
	   $formView->EntryID = $entryId;
	}else{
		setErrorMessage("Cannot find form for invalid Id");
		redirectToErrorPage();
	}
	
?>