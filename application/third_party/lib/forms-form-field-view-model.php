<?php


    	
	require_once(ABSPATH . '/lib/forms-constants.php');
	require_once(ABSPATH . '/lib/forms-address-view-model.php');
	require_once(ABSPATH . '/lib/forms-file-value-object.php');
	require_once(ABSPATH . '/lib/forms-settings.php');
	
    class FormFieldViewModel
    {   
		public $Id;
        public $Label;
        public $FieldType;
        public $IsRequired;
        public $MaxCharacters;
        public $HoverText;
        public $Hint;
        public $SubLabel;
        public $Size;
        public $Columns;
        public $Rows;
        public $Options;
        public $SelectedOption;
        public $Validation;
        public $Order;
        public $DateAdded;
        public $Text;
        public $HelpText;
        public $DomId;
        public $MinimumAge;
        public $MaximumAge;
        public $Mode;
        public $Errors;
        public $InputValue;
        public $MaxFileSize;
        public $MinFileSize;
        public $ValidFileExtensions;
		
		//extended properties (ie. all properties added after version 1.0)
		public $ShowTime;
		public $TimeFormat;
		public $IsToFromDate;
		public $Language;
		public $PreviousText;
		public $NextText;
		public $ShowPrevious;
		public $ShowNext;
		public $Alignment;
		public $Url;
		public $AltText;
		public $MultiSelect;
		public $Content;
		public $WizardStep;
		public $Dictionary;
		public $Css;
		public $OptionsAlignment;
		public $TextMode;
		public $InputMask;
		public $MinNumber;
		public $MaxNumber;		
		
		//extended properties -- Will store extended property json object
		public $ExtendedProperties;
		
		//extended properties -- comma delimited list of extended properties, add every new property to this list
		// don't forget to initialize it in createDefaultForJSON()
		public $ExtendedPropertyList="MinNumber,MaxNumber,InputMask,TextMode,OptionsAlignment,Css,Dictionary,Content,ShowTime,TimeFormat,IsToFromDate,Language,PreviousText,NextText,ShowPrevious,ShowNext,WizardStep,Alignment,Url,AltText,MultiSelect";
		
        
        public static function initialize()
        {
            return new FormFieldViewModel();
        }

        public static function createFromObject($field)
        {
            return self::createFromObjectWithMode($field, Constants::FORM_FIELD_MODE_EDIT);
        }

        public static function createFromObjectWithMode($field, $mode, $loadExtended=true)
        {
            if (isset($field))
            {
				$formFieldView = new FormFieldViewModel();                
                
                $formFieldView->DomId = $field["DomId"];
                $formFieldView->Id = $field["ID"];
				$formFieldView->FieldType = $field["FieldType"];
                $formFieldView->Label = empty($field["Label"]) && !strtolower($formFieldView->FieldType) == "captcha" ? "Click to edit" : $field["Label"];
                $formFieldView->Text = $field["Text"];                
                $formFieldView->IsRequired = $field["IsRequired"] == "0" ? "false" : "true";
                $formFieldView->MaxCharacters = $field["MaxChars"];
                $formFieldView->HoverText = $field["HoverText"];
                $formFieldView->Hint = $field["Hint"];
                $formFieldView->SubLabel = $field["SubLabel"];
                $formFieldView->Size = $field["Size"];
                $formFieldView->Columns = $field["Columns"];
                $formFieldView->Rows = $field["Rows"];
                $formFieldView->Options = $field["Options"];
                $formFieldView->SelectedOption = $field["SelectedOption"];
                $formFieldView->HelpText = $field["HelpText"];
                $formFieldView->Validation = $field["Validation"];
                $formFieldView->Order = $field["Order"];
                $formFieldView->MinimumAge = $field["MinimumAge"];
                $formFieldView->MaximumAge = $field["MaximumAge"];
                $formFieldView->Mode = $mode;
                $formFieldView->MaxFileSize = $field["MaxFilesizeInKb"];
                $formFieldView->MinFileSize = $field["MinFilesizeInKb"];
                $formFieldView->ValidFileExtensions=$field["ValidFileExtensions"];
                $formFieldView->DateAdded = $field["DateAdded"];
				$formFieldView->InputValue = null;
								
				if ($loadExtended==true){
					try{
						// set extended properties
						$extendedArray = explode(",", $formFieldView->ExtendedPropertyList);
						$formFieldView->ExtendedProperties = json_decode($field["ExtendedProperties"], true);
						foreach($extendedArray as $prop){
							
							if(is_array($formFieldView->ExtendedProperties) && array_key_exists($prop, $formFieldView->ExtendedProperties)){
								$value = $formFieldView->ExtendedProperties[$prop];							
								$formFieldView->$prop = $value;
							}
							
						}
					}catch(Exception $e){
						throw new Exception("Unable to set extended properties: " . $e);
					}
				}
				
				return $formFieldView;
                
            }
			
			//return  default instance
            return self::initialize();
        }
		
		public static function createDefaultForJSON()
        {
			$formFieldView = new FormFieldViewModel();                
			
			$formFieldView->DomId = '${id}';
			$formFieldView->Id = '${fieldid}';
			$formFieldView->Label = Constants::CLICK_TO_EDIT;
			$formFieldView->Text = Constants::CLICK_TO_EDIT;
			$formFieldView->FieldType = '${fieldType}';
			$formFieldView->IsRequired = false;
			$formFieldView->MaxCharacters = Constants::DEFAULT_MAX_CHARACTERS;
			$formFieldView->HoverText = "";
			$formFieldView->Hint = "";
			$formFieldView->SubLabel = "";
			$formFieldView->Size = "";
			$formFieldView->Columns = Constants::DEFAULT_MAX_COLUMNS;
			$formFieldView->Rows = Constants::DEFAULT_MAX_ROWS;
			$formFieldView->Options = Constants::DEFAULT_OPTIONS;
			$formFieldView->SelectedOption = Constants::DEFAULT_SELECTED_OPTION;
			$formFieldView->HelpText = "";
			$formFieldView->Validation = "";
			$formFieldView->Order = '${order}';
			$formFieldView->MinimumAge = Constants::DEFAULT_MINIMUM_AGE;
			$formFieldView->MaximumAge = Constants::DEFAULT_MAXIMUM_AGE;			
			$formFieldView->MaxFileSize = Constants::DEFAULT_MAX_FILE_SIZE_IN_KB;
			$formFieldView->MinFileSize = Constants::DEFAULT_MIN_FILE_SIZE_IN_KB;
			$formFieldView->ValidFileExtensions=Constants::DEFAULT_FILE_EXTENSIONS;
			$formFieldView->InputValue = null;
			
			$formFieldView->ShowTime=false;
			$formFieldView->TimeFormat=Constants::DEFAULT_TIME_FORMAT;
			$formFieldView->IsToFromDate=false;
			$formFieldView->Language=Constants::DEFAULT_LANGUAGE;
			
			$formFieldView->PreviousText=Constants::DEFAULT_PREVIOUS_TEXT;
			$formFieldView->NextText=Constants::DEFAULT_NEXT_TEXT;
			$formFieldView->ShowPrevious=true;
			$formFieldView->ShowNext=true;			
			$formFieldView->WizardStep=1;			
			
			$formFieldView->Url=rootUrl() . Constants::DEFAULT_IMAGE_PATH;			
			$formFieldView->Alignment="Left";			
			$formFieldView->AltText=Constants::DEFAULT_IMAGE_DESCRIPTION;			
			$formFieldView->MultiSelect=false;
			$formFieldView->Content=Constants::DEFAULT_TEXT;			
			$formFieldView->Dictionary="Null";
			$formFieldView->Css="";
			$formFieldView->OptionsAlignment="Vertical";						
			$formFieldView->TextMode="Text";	
			$formFieldView->InputMask="";	
			$formFieldView->MinNumber=0;	
			$formFieldView->MaxNumber=100;	
			
			return $formFieldView;			
        }
		
		public static function getPropertiesAsDictionary()
		{
			$formView = new FormFieldViewModel();
			$props = array();
			foreach ($formView as $prop => $value) {
				$props[strtolower($prop)] = $prop;
			}
			
			return $props;
		}

		public function isEditMode()
		{
           return strtolower($this->Mode) == "edit";
		}	

		public function submittedValue($form, $files=null)
        {
            $fType = ucwords(strtolower($this->FieldType));
            $value = "";
			
            switch (strtoupper($this->FieldType))
            {
                case "EMAIL":
                    $value = Utils::submittedFieldValue($form, $this->DomId, ucwords($fType));
                    break;
                case "ADDRESS":
                    $address = new AddressViewModel();                    
                    $address->Address1 = trim(Utils::submittedFieldValue($form, $this->DomId, "StreetAddress"));
                    $address->Address2 =  Utils::submittedFieldValue($form, $this->DomId, "StreetAddress2");
                    $address->City = trim(Utils::submittedFieldValue($form, $this->DomId, "City"));
                    $address->State = Utils::submittedFieldValue($form, $this->DomId, "State");
                    $address->ZipCode = Utils::submittedFieldValue($form, $this->DomId, "ZipCode");
                    $address->Country = trim(Utils::submittedFieldValue($form, $this->DomId, "Country"));
                    

                    if ( (!isset($address->Address1) || empty($address->Address1)) && 
					     (!isset($address->City) || empty($address->City)) && 
						 (!isset($address->Country) || empty($address->Country) || $address->Country == "Select Country"))
                    {
                        $value = "";
                    }
                    else
                    {
                        $value = json_encode($address);
                    }
                    break;
                case "BIRTHDAYPICKER":
                    $day = Utils::submittedFieldValue($form, $this->DomId, "Day");
                    $month = Utils::submittedFieldValue($form, $this->DomId, "Month");
                    $year = Utils::submittedFieldValue($form, $this->DomId, "Year");

                    if (empty($day) && empty($month) && empty($year))
                    {
                        $value = "";
                    }
                    else
                    {
                        if (checkdate($month, $day, $year))
                        {
                            $dateString = Utils::strFormat("{0}-{1}-{2}", $year, $month, $day);
							$value = date_format(date_create($dateString), "m-d-Y"); 					      
                        }
                        else
                        {
                            $value = "";
                        }
                    }
                    break;
                case "CHECKBOX":
					$selectedValueCollection = Utils::submittedFieldCollection($form, $this->DomId, ucwords($fType));
				    if(isset($selectedValueCollection)){						
						foreach($selectedValueCollection as $key=>$val){
							$value = $value . $val . ",";
						}						
					}
					if (!isNullOrEmpty($value)){
                       $value = rtrim($value, ",");
					}
                    break;
                case "PHONE":
                    $area = Utils::submittedFieldValue($form, $this->DomId, "AreaCode");
                    $number = Utils::submittedFieldValue($form, $this->DomId, "Number");
                    if (empty($area) && empty($number))
                    {
                        $value = "";
                    }
                    else
                    {
                        $value = Utils::strFormat("{0}-{1}", $area, $number);
                    }
                    break;
                case "DROPDOWNLIST":
					if (Utils::isBool($this->MultiSelect)){
						$selectedValueCollection = Utils::submittedFieldCollection($form, $this->DomId, ucwords($fType));
						if(isset($selectedValueCollection)){						
							foreach($selectedValueCollection as $key=>$val){
								$value = $value . $val . ",";
							}						
						}
						if (!isNullOrEmpty($value)){
						   $value = rtrim($value, ",");
						}

					}else{
						$value = Utils::submittedFieldValue($form, $this->DomId, ucwords($fType));
					}
                    break;
                case "RADIOBUTTON":
                    $value = Utils::submittedFieldValue($form, $this->DomId, ucwords($fType));
                    break;
                case "FULLNAME":
                    $fName = Utils::submittedFieldValue($form, $this->DomId, "FirstName");
                    $lName = Utils::submittedFieldValue($form, $this->DomId, "LastName");
                    $initials = Utils::submittedFieldValue($form, $this->DomId, "Initials");
                    if (empty($fName) && empty($lName))
                    {
                        $value = "";
                    }
                    else
                    {
						$nameObj = new stdclass();
						$nameObj->FirstName = $fName;
						$nameObj->Initials=$initials;
						$nameObj->LastName = $lName;
                        $value = json_encode($nameObj);
                    }
                    break;
                case "TEXTAREA":
                    $value = Utils::submittedFieldValue($form, $this->DomId, ucwords($fType));
                    break;
                case "TEXTBOX":
                    $value = Utils::submittedFieldValue($form, $this->DomId, ucwords($fType));
                    break;
                case "FILEPICKER":  
                    $file = Utils::submittedFileValue($files, $this->DomId, ucwords($fType));									
                    $value = $file;
					
                    if (isset($file) && (((int)$file["size"]) > 0 || !isNullOrEmpty($file["filename"])))
                    {						
					    $fileName = $file["name"];
                        $fileSize = (int)$file["size"];
						$filePartArray = explode(".", $fileName);
						$extension = end($filePartArray);						

                        $valueObject = new FileValueObject();                        
                        $valueObject->FileName=$fileName;
                        $valueObject->SaveName = Utils::guid() . "." . $extension;
                        $valueObject->SavePath = ABSPATH . "/" . Settings::FILE_SAVE_PATH;
                        $valueObject->IsSavedInCloud = Settings::USE_CLOUD_STORAGE;
                        $valueObject->Extension=$extension;
						$valueObject->TempName=$file['tmp_name'];
						$valueObject->IsExistingFile=!isNullOrEmpty($file["filename"]);
						
						$info = getimagesize($file['tmp_name']);
						$valueObject->IsImage = !($info === FALSE);
												
                        $value = json_encode($valueObject);
                    }else{
						$value = ""; 
					}
                    break;
				case "DATEPICKER":
				    $language = Utils::submittedFieldValue($form, $this->DomId, "Language");
					$format = Utils::submittedFieldValue($form, $this->DomId, "TimeFormat");
					$isToFromDate = Utils::isBool(Utils::submittedFieldValue($form, $this->DomId, "IsToFromDate"));
					
					$date1 = Utils::submittedFieldValue($form, $this->DomId, "Date1");
					$hour1 = Utils::submittedFieldValue($form, $this->DomId, "Hour1");
					$minute1 = Utils::submittedFieldValue($form, $this->DomId, "Minute1");
					$ampm1 =  $format == "24" ? "" : Utils::submittedFieldValue($form, $this->DomId, "AMPM1");
					
					$dateVal = new stdClass();
					$dateVal->Language = $language;
					$dateVal->IsToFromDate = $isToFromDate;
					$dateVal->Date1 = $date1;					
					$dateVal->Hour1 = $hour1;
					$dateVal->Minute1 = $minute1;
					$dateVal->Ampm1 = $ampm1;
					
					if($isToFromDate){
						$date2 = Utils::submittedFieldValue($form, $this->DomId, "Date2");
						$hour2 = Utils::submittedFieldValue($form, $this->DomId, "Hour2");
						$minute2 = Utils::submittedFieldValue($form, $this->DomId, "Minute2");
						$ampm2 = $format == "24" ? "" :  Utils::submittedFieldValue($form, $this->DomId, "AMPM2");
												
						$dateVal->Date2 = $date2;
						$dateVal->Hour2 = $hour2;
						$dateVal->Minute2 = $minute2;
						$dateVal->Ampm2 = $ampm2;											
					}
					
					if((!$isToFromDate && $date1 == "") || ($isToFromDate && ($date1 == "" || $date2 == ""))){
						$value = "";
					}else{
						$value = json_encode($dateVal);	
					}					
					
					break;	

            }

            return $value;
        }	
		
		public function submittedValueIsValid($form, $files)
        {
            $fType =  ucwords($this->FieldType);
            $value = "";
            switch (strtoupper($fType))
            {
                case "EMAIL":
                    $value = Utils::submittedFieldValue($form, $this->DomId, ucwords($fType));
                    if (empty($value)) { return true; }
                    return filter_var($value, FILTER_VALIDATE_EMAIL);
                case "ADDRESS":
                    return true;
                case "PHONE":
                    $area = Utils::submittedFieldValue($form, $this->DomId, "AreaCode");
                    $number = Utils::submittedFieldValue($form, $this->DomId, "Number");
                    if (empty($area) && empty($number))
                    {
                        return true;
                    }
                    else if ((empty($area) && !empty($number)) || (!empty($area) && empty($number)))
                    {
                        return false;
                    }
                    else
                    {
                        return is_numeric($area) && is_numeric($number);
                    }
                case "BIRTHDAYPICKER":
                    $day = Utils::submittedFieldValue($form, $this->DomId, "Day");
                    $month = Utils::submittedFieldValue($form, $this->DomId, "Month");
                    $year = Utils::submittedFieldValue($form, $this->DomId, "Year");

                    if (empty($day) && empty($month) && empty($year))
                    {
                        return true;
                    }

                    return checkdate(intval($month), intval($day), intval($year));			    
                case "FILEPICKER":
                    $file = Utils::submittedFileValue($files, $this->DomId, ucwords($fType));
                    $maxSize = $this->MaxFileSize * 1024;
                    $minSize = $this->MinFileSize * 1024;
                    $validExtensions = $this->ValidFileExtensions;
					
					if (isset($file) && !isNullOrEmpty($file["filename"])){
						return true; // a previously uploaded file exists -- continue.
					}
					
                    if (isset($file) && ((int)$file["size"]) > 0)
                    {
						$fileSize = (int)$file["size"];
						$fileParts = explode(".", $file["name"]);
                        $extension = end($fileParts);
                        // check filesize is within range of Max and Min
                        if (!($fileSize >= $minSize && $fileSize <= $maxSize))
                        {
                            return false;
                        }

                        // check file extension is valid
                        if (!empty($validExtensions))
                        {
                            $validExtensionArr = explode(",", $validExtensions);
                            $isValidExt = false;
                            foreach ($validExtensionArr as $ext )
                            {
                                $updatedExt = trim($ext);
                                if (!(strpos($ext, ".") === 0))
                                {
                                    $updatedExt = "." . $ext;
                                }

                                if (strtolower(str_replace(".", "",$updatedExt)) == strtolower(str_replace(".", "",$extension)))
                                {
                                    $isValidExt = true;
                                }
                            }

                            return $isValidExt;
                        }
                    }
					// add new case statement for any special validation you need done

                    return true;
				case "DATEPICKER":
				    $language = Utils::submittedFieldValue($form, $this->DomId, "Language");
					$isTwoDateMode = Utils::isBool(Utils::submittedFieldValue($form, $this->DomId, "IsToFromDate"));
					$format = Utils::submittedFieldValue($form, $this->DomId, "TimeFormat");
										
					$date1 = Utils::submittedFieldValue($form, $this->DomId, "Date1");
					$hour1 = Utils::submittedFieldValue($form, $this->DomId, "Hour1");
					$minute1 = Utils::submittedFieldValue($form, $this->DomId, "Minute1");
					$ampm1 = $format == "24" ? "" : " " . Utils::submittedFieldValue($form, $this->DomId, "AMPM1");					
					
					$timeString = Utils::strFormat("{0}:{1}{2}", $hour1, $minute1, $ampm1);
					$fromTime = strtotime($timeString);
					
					
					if($isTwoDateMode){
						$date2 = Utils::submittedFieldValue($form, $this->DomId, "Date2");
						$hour2 = Utils::submittedFieldValue($form, $this->DomId, "Hour2");
						$minute2 = Utils::submittedFieldValue($form, $this->DomId, "Minute2");
						$hour2 = intval($hour2) < 10 ? "0" . $hour2 : $hour2;
						$minute2 = intval($minute2) < 10 ? "0" . $minute2 : $minute2;
						$ampm2 = $format == "24" ? "" : " " . Utils::submittedFieldValue($form, $this->DomId, "AMPM2");
						 
						$timeString = Utils::strFormat("{0}:{1}{2}", $hour2, $minute2, $ampm2);
						$toTime = strtotime($timeString);
						
						if($date1==$date2 && $fromTime > $toTime){							
							return false;
						}
					}				
					
					return true;
            }

            return true;
        }
		
		
		public function validationId()
        {
            return Utils::strFormat("{0}-{1}", strtolower($this->FieldType), strtolower($this->Id));
        }

        public function setFieldErrors()
        {
            $this->Errors = Utils::strFormat("Invalid entry submitted for {0}", $this->Label);
            if ($this->FieldType == "FILEPICKER")
            {
                $this->Errors = $this->Errors .= Utils::strFormat(", file must be betweeen {0}kb and {1}kb large ",$this->MinFileSize, $this->MaxFileSize);
                if (!empty($this->ValidFileExtensions))
                {
                    $this->Errors = $this->Errors .= Utils::strFormat(" and have the extensions {0}.", $this->ValidFileExtensions);
                }
                else {
                    $this->Errors = $this->Errors .= ".";
                }
            }		
			
			if ($this->FieldType == "DATEPICKER"){
				if (Utils::isBool($this->IsToFromDate)){
					$this->Errors = $this->Errors .= ", end-date must be after the start-date.";
				}
			}
			
			if ($this->FieldType == "CAPTCHA"){
				$this->Errors =  "ReCaptcha was not validated.";				
			}
			
        }	

    public function submittedFieldName()
    { 
       return Utils::submittedFieldName($this->DomId, ucwords($this->FieldType));
    }		
}

?>