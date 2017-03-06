<?php
   
	require_once(ABSPATH . '/lib/forms-common.php' );
    require_once(ABSPATH . '/lib/forms-form-repository.php');	
	require_once(ABSPATH . '/lib/forms-html-utils.php');
	require_once(ABSPATH . '/lib/forms-utils.php');
	require_once(ABSPATH . '/lib/forms-settings.php');
	
	$templatesOnly=isset($_GET["templatesOnly"]) ? strtolower($_GET["templatesOnly"]) : false;
	$format = isset($_GET["format"]) ? strtolower($_GET["format"]) : "json";
	$excludeTemplates = isset($_GET["excludeTemplates"]) ? strtolower($_GET["excludeTemplates"]) : false;
	$formId = isset($_GET["formid"]) ? strtolower($_GET["formid"]) : null;
	$exportFileName = $templatesOnly ? "form-templates.json" : "forms.json";
	
	if ($format != "json" && $format != "xml"){
		$format = "json";
	}
	
	$formRepo = new FormRepository();
	
	$templates = $formRepo->fetchRawFormsForExport($templatesOnly);
	
	if($format == 'json') {
		header('Content-disposition: attachment; filename=' . $exportFileName);
		header('Content-type: application/json');
		echo json_encode(array('templates'=>$templates));		
	}
?>