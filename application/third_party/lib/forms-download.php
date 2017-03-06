<?php

    require_once(ABSPATH . '/lib/forms-common.php' );
    require_once(ABSPATH . '/lib/forms-form-repository.php');	
	require_once(ABSPATH . '/lib/forms-html-utils.php');
	require_once(ABSPATH . '/lib/forms-utils.php');
	require_once(ABSPATH . '/lib/forms-settings.php');
		
    $formView = new FormViewModel();
	$form_themes = array();
	
	if(!isNullOrEmpty($_GET["id"]) && is_numeric($_GET["id"])){
	   $id=$_GET["id"];
	   $formRepo  = new FormRepository;
       $fileObj = $formRepo->getFileFieldValueObject($id);
		
	   if(isset($fileObj)){
		   
		   if($fileObj->IsSavedInCloud){
			   $s3 = new S3(Settings::AWS_ACCESS_KEY, Settings::AWS_SECRET_KEY); 
			   $s3Obj = $s3->getObject(Settings::AWS_BUCKET, $fileObj->SaveName);
			   
			   header("Content-Type: {$s3Obj->headers['type']}");
			   header("Content-Disposition: attachment; filename=\"" . $fileObj->SaveName . "\"");
			   echo $s3Obj->body;			   
		   }else{
				$fullPath =  $fileObj->SavePath . $fileObj->SaveName;				
		
				if ($fd = fopen ($fullPath, "r")) {
					$fsize = filesize($fullPath);
					$path_parts = pathinfo($fullPath);
					$ext = strtolower($path_parts["extension"]);
					switch ($ext) {
						case "pdf":
							header("Content-type: application/pdf");
							header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
							break;
						// add more headers for other content types here
						default;
							header("Content-type: application/octet-stream");
							header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
							break;
					}
					header("Content-length: $fsize");
					header("Cache-control: private"); //use this to open files directly
					while(!feof($fd)) {
						$buffer = fread($fd, 2048);
						echo $buffer;
					}
					
					fclose ($fd);
					exit;
				}else{
					throw new Exception("File not found.");
				}
		   }			
	   }	
	}else{
		setErrorMessage("A valid file ID was not found");
		redirectToErrorPage();
	}
?>