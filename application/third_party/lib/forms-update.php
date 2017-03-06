<?php

 
   require_once( ABSPATH . '/lib/forms-utils.php' );
   require_once( ABSPATH . '/lib/forms-html-utils.php' );
   require_once( ABSPATH . '/lib/forms-form-view-model.php' );
   require_once( ABSPATH . '/lib/forms-form-field-view-model.php' );
   require_once( ABSPATH . '/lib/forms-form-repository.php' );
   
   if ($_SERVER['REQUEST_METHOD']== "POST") {
       $formRepo = new FormRepository();
	   $formView = new FormViewModel();
	   $formView = Utils::populateWithPost($formView);
	   $isAutoSave = $_POST['IsAutoSave'] == "true" ? true : false;
	   
	   	   
	   if (!isset($formView->Id))
       {		   
          Utils::outputJson(array ("success" => false, "error" => "Unable to save changes. A valid form was not detected.", "isautosave" => $isAutoSave));
       }

       $form = $formRepo->getByPrimaryKey($formView->Id);

       if (!isset($formView->Fields))
       {
           Utils::outputJson(array("success" => false, "error" => "Unable to detect field values.", "isautosave" => $isAutoSave ));
       }

       if (!empty($formView->NotificationEmail) && !filter_var($formView->NotificationEmail, FILTER_VALIDATE_EMAIL))
       {
           Utils::outputJson(array("success" => false, "error" => "Invalid format for Notification Email.", "isautosave" => $isAutoSave ));
       }
	   
	   if (!Utils::isLockedFormId($formView->Id)){			
	   	   	   
		   try
		   {	   
				$formRepo->update($formView, $form);
			  
				// then if fields were passed in, update them
				if (count($formView->Fields) > 0)
				{
					foreach ($formView->Fields as $key=>$value)
					{

						$domId = (int)$key;
						if ($domId >= 0)
						{
							$fieldType = Utils::formFieldValue($domId, "FieldType");
							$fieldId = Utils::formFieldValue($domId, "Id");
							$minAge = Utils::isInt(Utils::formFieldValue($domId, "MinimumAge"),18);
							$maxAge = Utils::isInt(Utils::formFieldValue($domId, "MaximumAge"),100);

							if ($minAge >= $maxAge)
							{
								$minAge = 18;
								$maxAge = 100;
							}

							
							$fieldView = new FormFieldViewModel();
							
							$fieldView->DomId = (int)$domId;							
							$fieldView->FieldType = strtoupper($fieldType);
							$fieldView->MaxCharacters = Utils::isInt(Utils::formFieldValue($domId, "MaxCharacters"));
							$fieldView->Text = Utils::formFieldValue($domId, "Text");
							$fieldView->Label = Utils::formFieldValue($domId, "Label");
							$fieldView->IsRequired = Utils::isBool(Utils::formFieldValue($domId, "IsRequired"));
							$fieldView->Options = Utils::formFieldValue($domId, "Options");
							$fieldView->SelectedOption = Utils::formFieldValue($domId, "SelectedOption");
							$fieldView->HoverText = Utils::formFieldValue($domId, "HoverText");
							$fieldView->Hint = Utils::formFieldValue($domId, "Hint");
							$fieldView->MinimumAge = $minAge;
							$fieldView->MaximumAge = $maxAge;
							$fieldView->HelpText = Utils::formFieldValue($domId, "HelpText");
							$fieldView->SubLabel = Utils::formFieldValue($domId, "SubLabel");
							$fieldView->Size = Utils::formFieldValue($domId, "Size");
							$fieldView->Columns = Utils::isInt(Utils::formFieldValue($domId, "Columns"),20);
							$fieldView->Rows = Utils::isInt(Utils::formFieldValue($domId, "Columns"), 2);
							$fieldView->Validation = Utils::formFieldValue($domId, "Validation");
							$fieldView->Order = Utils::isInt(Utils::formFieldValue($domId, "Order"),1);
							$fieldView->MaxFileSize = Utils::isInt(Utils::formFieldValue($domId, "MaxFileSize"),5000);
							$fieldView->MinFileSize = Utils::isInt(Utils::formFieldValue($domId, "MinFileSize"), 5);
							$fieldView->ValidFileExtensions = Utils::formFieldValue($domId, "ValidFileExtensions");
							
							// save extended properties
							$fieldView->ExtendedProperties = Utils::formFieldJsonValuesAsString($domId, $fieldView->ExtendedPropertyList);
				  
							if (!empty($fieldId) && is_numeric($fieldId))
							{
								$fieldView->Id = (int)$fieldId;
							}

							$formRepo->updateField($form, $fieldView);
						}
					}
				}

				$fieldOrderById =$formRepo->GetFormFieldDomIds($form["ID"]);

				Utils::outputJson(array("success" => true, "message" => "Your changes were saved.", "isautosave" => $isAutoSave, "fieldids" => $fieldOrderById ));   			
		   }
		   catch(Exception $e)
		   {
				$error = strFormat("Unable to save form {0}",$e->getMessage());
				Utils::outputJson(array ( "success" => false, "error" => $error, "isautosave" => $isAutoSave ));
		   }
	   }else{
		   Utils::outputJson(array ( "success" => true, "error" => "", "isautosave" => $isAutoSave ));
	   }
	   
   }else{
      setErrorMessage("Invalid Request");
	  redirectToErrorPage();
   }


?>