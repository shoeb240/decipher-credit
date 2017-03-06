<?php


class FormFieldValueViewModel
{
        public $Id;
        public $FieldId;
		public $DomId;
        public $EntryId;
        public $Value;
        public $DateAdded;
        public $UserId;
        public $FieldType;
        public $FieldLabel;
        public $FieldOrder;

		function __construct()
		{
		
		}		

        public static function initialize()
        {
            return new FormFieldValueViewModel;
        }

        public static function createFromObject($model)
        {            
            $valueModel = new FormFieldValueViewModel;
            
			$valueModel->Id = $model["ID"];
			$valueModel->FieldId = $model["FieldId"];
			$valueModel->DomId = $model["DomId"];
			$valueModel->EntryId = $model["EntryId"];
			$valueModel->Value = $model["Value"];
			$valueModel->DateAdded = $model["DateAdded"];

			//field properties                
			$valueModel->FieldType = $model["FieldType"];
			$valueModel->FieldLabel = $model["Label"];
			$valueModel->FieldOrder = $model["Order"];  
				
			return $valueModel;	
        }
		
		
		public function format($stripHtml=false)
        {
            switch ($this->FieldType)
            {
                case "BIRTHDAYPICKER":
                    $dateVal = date('Y-m-d', strtotime(str_replace('-','/',$this->Value)));
					$dateParse = date_parse($dateVal);
					
                    if (!empty($this->Value) && checkdate($dateParse["month"], $dateParse["day"], $dateParse["year"]) )
                    {   					    
						return date('F jS, Y', mktime(0, 0, 0, $dateParse["month"], $dateParse["day"], $dateParse["year"])); 
                    }
                    return $this->Value;
                case "ADDRESS":
                    $address = new AddressViewModel();
                    if (!empty($this->Value) && strlen($this->Value) > 0)
                    {
					    $json_decoded = json_decode($this->Value);
                        $address = AddressViewModel::createFromObject($json_decoded);
                        return $address->Format();
                    }
                    return "--";
                case "CHECKBOX":
                    if (!empty($this->Value) && strlen($this->Value) > 0)
                    {
                        if (!$stripHtml)
                        {
                            $values = explode(",", $this->Value);
                            $sb = "<ul class=\"vertical-list selected-checkbox-list\"";
                            foreach($values as $val)
                            {
                                $sb .= strFormat("<li>{0}</li>", $val);
                            }
                          return $sb;
                        }
                        else
                        {
                            return $this->Value;
                        }
                    }
                    return "";
				case "DATEPICKER":
					
					$jsonObj = json_decode($this->Value);
					
					if(!isNullOrEmpty($jsonObj))
					{	
						$hourVal = intval($jsonObj->Hour1) < 10 ? "0" . $jsonObj->Hour1 : $jsonObj->Hour1;
						$minuteVal = intval($jsonObj->Minute1) < 10 ? "0" . $jsonObj->Minute1 : $jsonObj->Minute1;					
						$value = Utils::strFormat("{0} {1}:{2} {3}", $jsonObj->Date1, $hourVal, $minuteVal, $jsonObj->Ampm1);
						
						if (isset($jsonObj->IsToFromDate) && Utils::isBool($jsonObj->IsToFromDate)){
							$hourVal = intval($jsonObj->Hour2) < 10 ? "0" . $jsonObj->Hour2 : $jsonObj->Hour2;
							$minuteVal = intval($jsonObj->Minute2) < 10 ? "0" . $jsonObj->Minute2 : $jsonObj->Minute2;
							$value .= Utils::strFormat(" - {0} {1}:{2} {3}", $jsonObj->Date2, $hourVal, $minuteVal, $jsonObj->Ampm2);	
						}
						return $value;
					}
					return "";
                case "FILEPICKER":

                    if (!$stripHtml)
                    {
                        if (!empty($this->Value))
                        {
                            $fileValueObject = FileValueObject::createFromJsonObject(json_decode($this->Value));

                            if (!empty($fileValueObject->FileName))
                            {
                              $imagePreviewClass = "";
                              $imagePreviewAttribute = "";
                              $downloadPath = strFormat( rootUrl() . "/actions.php?a=download&id={0}", $this->Id);
                            
							if ($fileValueObject->IsImage)
                            {
                                $imagePreviewClass = "img-tip";
                                $imagePreviewAttribute = Utils::strFormat("data-image-path='{0}'", $fileValueObject->imageViewPath());                                
                            }


                            $sb = "";
                            $sb .= "<ul class='horizontal-list'><li class='file-icon-item'>";
                            $sb .= Utils::strFormat("<a href='{0}' class='{1}' {2}>", $downloadPath, $imagePreviewClass, $imagePreviewAttribute);
                            $sb .= Utils::strFormat("<img src='" . rootUrl() . "/content/images/spacer.gif' class='image-bg fm-file-icon fm-file-{0}-icon' alt='file icon' />", str_replace(".", "", $fileValueObject->Extension));
                            $sb .= "</a>";
                            $sb .= "</li><li class='file-name-item'>";
                            $sb .= Utils::strFormat("<a href='{0}'>{1}</a>", $downloadPath, Utils::limitWithEllipses($fileValueObject->FileName,30));
                            $sb .= "</li></ul>";
                            return $sb;
                            }
                        }

                        return "";
                    }
                    else 
					{
                        if (!empty($this->Value))
                        {
                            $fileValueObject = FileValueObject::createFromJsonObject(json_decode($this->Value));
                            return $fileValueObject->FileName;
                        }
                        else 
                        {
                            return "";
                        }
                    }
					
				case "FULLNAME":
						try{
							$nameValueObject = json_decode($this->Value);
							
							if (!isNullOrEmpty($nameValueObject)){
								$initials="";
								if (property_exists($nameValueObject, "Initials") && !isNullOrEmpty($nameValueObject->Initials)){
									$initials= ' ' . $nameValueObject->Initials . ' ';
								}
								
								if (property_exists($nameValueObject, "FirstName") && property_exists($nameValueObject, "LastName")){
									$fullName = $nameValueObject->FirstName . $initials . $nameValueObject->LastName;
									return $fullName;
								}
							}
						}catch(Exception $e){
							//log exception
						}				
            }

            return $this->Value;
        }

		public function formatAsViewData()
        {
			$base_key = 'SubmitFields';
			$ViewData = array();
			$ViewData[$base_key] = array();
			$ViewData[$base_key][$this->DomId]= array();
			$viewObj = array(); 
            switch ($this->FieldType)
            {
                case "BIRTHDAYPICKER":
                    $dateVal = date('Y-m-d', strtotime(str_replace('-','/',$this->Value)));
					$dateParse = date_parse($dateVal);
					
                    if (!empty($this->Value) && checkdate($dateParse["month"], $dateParse["day"], $dateParse["year"]) )
                    {   					    
					    $viewObj['Month'] = $dateParse["month"];
						$viewObj['Day'] = $dateParse["day"];
						$viewObj['Year'] = $dateParse["year"];
						
					    $ViewData[$base_key][$this->DomId]=$viewObj;		
						return $ViewData;
                    }
                    
                case "ADDRESS":
                    $address = new AddressViewModel();
                    if (!empty($this->Value) && strlen($this->Value) > 0)
                    {
					    $json_decoded = json_decode($this->Value);
                        $address = AddressViewModel::createFromObject($json_decoded);
						$viewObj['StreetAddress'] = $address->Address1;
						$viewObj['StreetAddress2'] = $address->Address2;
						$viewObj['City'] = $address->City;
						$viewObj['State'] = $address->State;
						$viewObj['ZipCode'] = $address->ZipCode;
						$viewObj['Country'] = $address->Country;
                        
						$ViewData[$base_key][$this->DomId]=$viewObj;		
						return $ViewData;
                    }
				case "DATEPICKER":
					
					$jsonObj = json_decode($this->Value);
					
					if(!isNullOrEmpty($jsonObj))
					{	
						$hourVal = intval($jsonObj->Hour1) < 10 ? "0" . $jsonObj->Hour1 : $jsonObj->Hour1;
						$minuteVal = intval($jsonObj->Minute1) < 10 ? "0" . $jsonObj->Minute1 : $jsonObj->Minute1;											
						
						$viewObj['Date1'] = $jsonObj->Date1;
						$viewObj['Hour1'] = $hourVal;
						$viewObj['Minute1'] = $minuteVal;
						$viewObj['AMPM1'] = $jsonObj->Ampm1;
						
						if (isset($jsonObj->IsToFromDate) && Utils::isBool($jsonObj->IsToFromDate)){
							$hourVal = intval($jsonObj->Hour2) < 10 ? "0" . $jsonObj->Hour2 : $jsonObj->Hour2;
						    $minuteVal = intval($jsonObj->Minute2) < 10 ? "0" . $jsonObj->Minute2 : $jsonObj->Minute2;											
							$viewObj['Date2'] = $jsonObj->Date2;
							$viewObj['Hour2'] = $hourVal;
							$viewObj['Minute2'] = $minuteVal;
							$viewObj['AMPM2'] = $jsonObj->Ampm2;
						}
						
						$ViewData[$base_key][$this->DomId]=$viewObj;		
						return $ViewData;
					}
                case "FILEPICKER":
                   
					if (!isNullOrEmpty($this->Value))
					{
						$fileValueObject = FileValueObject::createFromJsonObject(json_decode($this->Value));
						
						$viewObj["SaveName"] = $fileValueObject->SaveName;
						$viewObj["SavePath"] = $fileValueObject->SavePath;
						$viewObj["IsSavedInCloud"] = $fileValueObject->IsSavedInCloud;
						$viewObj["FileName"] = $fileValueObject->FileName;
						
						$ViewData[$base_key][$this->DomId]=$viewObj;		
						return $ViewData;
					}
				case "FULLNAME":		
                    if (!isNullOrEmpty($this->Value))
					{
						try{
							$nameValueObject = json_decode($this->Value);
							
							if (!isNullOrEmpty($nameValueObject)){
								if(property_exists($nameValueObject, "FirstName") && 
								   property_exists($nameValueObject, "Initials") && 
								   property_exists($nameValueObject, "LastName")){
									$viewObj["FirstName"] = $nameValueObject->FirstName;
									$viewObj["Initials"] = $nameValueObject->Initials;
									$viewObj["LastName"] = $nameValueObject->LastName;
									
									$ViewData[$base_key][$this->DomId]=$viewObj;		
									return $ViewData;
								}
							}
						}catch(Exception $e){
							// unable to convert from json
						}
					}              
            }
			
			$viewObj[ucfirst(strtolower($this->FieldType))] = $this->Value;
            
			$ViewData[$base_key][$this->DomId]=$viewObj;		
			return $ViewData;
        }
			
    }
?>