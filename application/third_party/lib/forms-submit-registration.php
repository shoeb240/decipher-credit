<?php

	require_once(ABSPATH . '/lib/forms-utils.php' );
	require_once(ABSPATH . '/lib/forms-html-utils.php' );
	require_once(ABSPATH . '/lib/forms-form-view-model.php' );
	require_once(ABSPATH . '/lib/forms-form-field-view-model.php' );
	require_once(ABSPATH . '/lib/forms-form-field-value-view-model.php' );
	require_once(ABSPATH . '/lib/forms-notification-email-view-model.php' );
	require_once(ABSPATH . '/lib/forms-form-repository.php' );	
	require_once(ABSPATH . '/lib/ReCaptcha/RequestParameters.php');	
	require_once(ABSPATH . '/lib/recaptchalib.php');	
	   
	ob_start();
   
	if ($_SERVER['REQUEST_METHOD']== "POST") {
		$formRepo = new FormRepository();
		$submittedFormView = new FormViewModel();
		$submittedFormView = Utils::populateWithPost($submittedFormView);		

		$errors = array();
		$form= $_POST;
		$files = $_FILES;
		$formObj = $formRepo->getByPrimaryKey($_POST["Id"]);
		$formObj["Fields"] = $formRepo->GetFieldsByFormId($_POST["Id"]);
		
		$formView = FormViewModel::createFromObjectWithMode($formObj, "INPUT", intval($submittedFormView->WizardStep));				
		$formView->Embed = isset($_POST["embed"]) && $_POST["embed"]=="true" ? true : false;	 
		$formView->assignInputValues($form, $formView->WizardStep, $files);
		
		$isNewEntry = !isset($_POST["EntryID"]);
		insertValuesIntoTempData($form);

        if (count($formView->Fields) > 0)
        {
            // first validate fields
			$hasErrors = false;
			$isRecaptchaValid=true;
			$isRecaptchaSubmitted=false;
			// validate captcha
			if (isset($_POST["recaptcha_response_field"])){
				$isRecaptchaSubmitted=true;				
				$captcha_response = recaptcha_check_answer (Settings::RECAPTCHA_SECRET,
															$_SERVER["REMOTE_ADDR"],
															$_POST["recaptcha_challenge_field"],
															$_POST["recaptcha_response_field"]);

				if (!$captcha_response->is_valid){
					// invalid captcha response										
					$isRecaptchaValid=false;					
				}
			}
			
            foreach ($formView->Fields as $field)
            {
				if (intval($field->WizardStep) == intval($formView->WizardStep))
				{
					$valId = $field->validationId();				
					if (!$field->submittedValueIsValid($form, $files) || ($field->FieldType == "CAPTCHA" && !$isRecaptchaValid))
					{
						$field->setFieldErrors();
						array_push($errors, $field->Errors);
						addFieldError($field, $field->Errors);
						$hasErrors=true;					
					}

					//$value = $field->submittedValue($form, $files);  //TODO: This seems redundant, commenting out until deemed necessarry
					if (Utils::isBool($field->IsRequired) && empty($field->InputValue))
					{
						$field->Errors = Utils::strFormat("{0} is a required field", $field->Label);
						array_push($errors, $field->Errors);
						addFieldError($field, $field->Errors);
						$hasErrors=true;                    
					}
				}
            }
			
			if ($hasErrors){
				go_to_errors($errors, $formObj, $formView);
			}


            //then insert values
			$validEntryExists = !$isNewEntry && $formRepo->ValidEntryExists($_POST["EntryID"]);
            $entryId = !$isNewEntry && $validEntryExists ? $_POST["EntryID"] : Utils::guid();
            $notificationView = new NotificationEmailViewModel();
            $notificationView->FormName = $formView->Title;
            $notificationEntries = array();
			$valueString='';
			$updateFieldArray=array();
			$excludeFromUpdate=false;
            foreach ($formView->Fields as $field)
            {
				if (intval($field->WizardStep) == intval($formView->WizardStep) && strtoupper($field->FieldType) != "FORMBREAK")
				{
					$value = $field->submittedValue($form, $files);

					//if it's a file, save it to hard drive
					if ($field->FieldType == "FILEPICKER" && !empty($value))
					{ 
						$fileValueObject = Utils::getFileValueFromJsonObject($value);
						if (!$fileValueObject->IsExistingFile){
							if (isset($fileValueObject))
							{
								if (Settings::USE_CLOUD_STORAGE)
								{
									Utils::saveImageToCloud($fileValueObject);
								}
								else
								{
									$savePath = ABSPATH . "/" . Settings::FILE_SAVE_PATH . $fileValueObject->SaveName;
									move_uploaded_file($fileValueObject->TempName, $savePath);								
								}
							}
						}else{
							$excludeFromUpdate=true;
						}						
					}
					
					if (!Utils::isExcludedField($field->FieldType) && !$excludeFromUpdate){
						Utils::addValueToDictionary($notificationEntries, $field->Label, new FormFieldValueViewModel($field->FieldType, $value));
						$notificationView->Entries = $notificationEntries;
						$valueString = $valueString . $formRepo->CreateFieldValueInsertString($field, $value, $entryId) . ',';						
						array_push($updateFieldArray, $field);
					}					
				}	
            }
			
			$_SESSION['submitted-values']=null;
			
			if (count($updateFieldArray) > 0){
				$valueString = rtrim($valueString, ",");			
				$formRepo->ClearExistingValues($entryId, $updateFieldArray);
				$formRepo->InsertFieldValues($valueString);
			}
			$nextStep = intval($formView->WizardStep) + 1;
			if (intval($formView->WizardStep) < intval($formView->NumberOfSteps)){
				header("Location:" . rootUrl() . "/register.php?id=" . $formObj["ID"] . "&embed=" . $formView->Embed . "&step=" . $nextStep . "&entry=" . $entryId);
			}else{
				//send notification
				if (!empty($formView->NotificationEmail) && Settings::ENABLE_NOTIFICATION)
				{
					$notificationView->Email = $formView->NotificationEmail;
					Utils::notifyViaEmail($notificationView);
				}
				$_SESSION['submitted-values']=NULL;
				setSuccessMessage($formView->ConfirmationMessage);
				setFormRedirectPage($formView->Id, $formView->RedirectUrl);
				header("Location:" . rootUrl() . "/confirmation.php?id=" . $formObj["ID"] . "&embed=" . $form["Embed"]);
			}
			exit();
						
        }	
	}
		
		
	function go_to_errors($errors, $formObj, $formView)
	{
		setErrorMessage(Utils::toUnorderedList($errors));
		header("Location:" . rootUrl() . "/register.php?id=" . $formObj["ID"] . "&embed=" . $formView->Embed . "&step=" . $formView->WizardStep);
		exit();
	}
?>
