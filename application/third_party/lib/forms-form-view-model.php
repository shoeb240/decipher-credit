<?php

  	
	require_once(ABSPATH . '/lib/forms-constants.php');
	require_once(ABSPATH . '/lib/forms-form-field-view-model.php');
	
    class FormViewModel
    {        
        public $Id='';
        public $Title;
        public $NotificationEmail;
        public $Slug;
        public $DateAdded;
        public $Fields;
        public $Status;
        public $TabOrder;
        public $ConfirmationMessage;
        public $Entries;
        public $GroupedEntries;
        public $Theme;
        public $Embed;
		public $ColumnNames;
		
		//Helper properties
		public $WizardStep;
		public $NumberOfSteps;
		public $EntryID;
		public $HideSubmitButton;
		
		//Extended properties
		public $AllowSave;
		public $RedirectUrl;
		public $SubmitButtonText;				
		public $IsTemplate;		
		
		// All new properties are 'jsonfied'. Add the to this list to allow them to be automatically updated.
		// Don't forget to add a default value in the "getDefaultExtendedProperties" function
		public $ExtendedPropertyList="AllowSave,RedirectUrl,SubmitButtonText,IsTemplate";
        
        public function HasTheme()
        {            
            return (!isset($this->$theme) || trim($this->$theme)==='');                        
        }    

        public static function initialize()
        {   
            $formView = new FormViewModel(); 
            $formView->Title = Constants::FORM_DEFAULT_TITLE;
            $formView->Status = Constants::FORM_STATUS_DRAFT;
            $formView->TabOrder = 0;
            $formView->Theme="";
            $formView->NotificationEmail="";
            $formView->Fields = array();
			$formView->WizardStep = 1;
		    self::getDefaultExtendedProperties($formView);			
			 
            return $formView;
        }
		
		public static function getDefaultExtendedProperties($formView)
		{			
			$formView->SubmitButtonText = Constants::FORM_DEFAULT_SUBMIT_BUTTON_TEXT;
			$formView->AllowSave =  false;
			$formView->RedirectUrl = "";
			$formView->IsTemplate = false;
		}
		
		
		public static function setExtendedProperties($formView, $props)
		{			
			try{
				// set extended properties
				$extendedArray = explode(",", $formView->ExtendedPropertyList);				
				foreach($extendedArray as $prop){
					
					if(is_array($props) && array_key_exists($prop, $props)){
						$value = $props[$prop];							
						$formView->$prop = $value;
					}					
				}
			}catch(Exception $e){
				throw new Exception("Unable to set extended properties: " . $e);
			}

		}
		
		public function getExtendedPropertiesAsJSONString(){
			$obj = new stdClass();
			try{
				// set extended properties
				$extendedPropertyArray = explode(",", $this->ExtendedPropertyList);				
				foreach($extendedPropertyArray as $prop){
					$obj->$prop = $this->$prop;
				}				
				return json_encode($obj);
			}catch(Exception $e){
				throw new Exception("Unable to set extended properties: " . $e);
			}
		}

        public static function createFromObject($form)
        {
            return self::createFromObjectWithMode($form, Constants::FORM_FIELD_MODE_EDIT);
        }

        public static function createFromObjectWithMode($form, $mode="EDIT", $wizardStep=1, $loadFields=true, $entries=null)
        {
            if (!is_null($form))
            {

               $formView = FormViewModel::createBasicFromObject($form);
			   $formView->WizardStep = $wizardStep;
			   $formBreakCountOnStep=0;
			   $maxStepValue=0;
               if (key_exists("Fields", $form) && count($form["Fields"]) > 0 && $loadFields)
               {                    
					//var_dump("mode:" . $mode);
					foreach($form["Fields"] as $field)
					{
						$formFieldView = FormFieldViewModel::createFromObjectWithMode($field, $mode);
												
						// set the maximum step count
						$maxStepValue = intval($formFieldView->WizardStep) > $maxStepValue ? intval($formFieldView->WizardStep) : $maxStepValue;
						
						if(strtoupper($mode) !="INPUT" || (strtoupper($mode) =="INPUT" && intval($formFieldView->WizardStep)==intval($wizardStep)))
						{							
							if(isset($entries) && array_key_exists($formFieldView->Id, $entries))
							{
								$entryObj = $entries[$formFieldView->Id];
								$formFieldView->InputValue = $entryObj->formatAsViewData();
							}
						
							if(strtoupper($formFieldView->FieldType)=="FORMBREAK"){
								$formBreakCountOnStep++;
							}
							array_push($formView->Fields, $formFieldView);
						}
					}
               }
			   
			   $formView->NumberOfSteps = $maxStepValue;
			   $formView->HideSubmitButton = $formBreakCountOnStep > 0;
               return $formView;
            }
            return self::Initialize();
        }

        public static function createBasicFromObject($form)
        {
            $formView = new FormViewModel();			
            
            $formView->Title = array_key_exists('Title', $form) ? $form["Title"] : "";
            $formView->Id = array_key_exists('ID', $form) ? $form["ID"] : "";
            $formView->DateAdded = array_key_exists('DateAdded', $form) ? $form["DateAdded"] : "";               
            $formView->ConfirmationMessage = array_key_exists('ConfirmationMessage', $form) ? $form["ConfirmationMessage"] : "";
            $formView->Fields = array();
            $formView->Slug = array_key_exists('Slug', $form) ? $form["Slug"] : "";
            $formView->Theme=array_key_exists('Theme', $form) ? $form["Theme"] : "";
            $formView->NotificationEmail = array_key_exists('NotificationEmail', $form) ? trim($form["NotificationEmail"]) : "";
            $formView->Status = array_key_exists('Status', $form) ? $form["Status"] : "";
			$formView->GroupedEntries=array();
			$formView->ColumnNames=array();
			FormViewModel::getDefaultExtendedProperties($formView);
			
			// set extended properties
			$props = array_key_exists('ExtendedProperties', $form) ? $form["ExtendedProperties"] : "";
			if(!isNullOrEmpty($props)){
				$propsObj = json_decode($props,true);
				FormViewModel::setExtendedProperties($formView, $propsObj);				
			}
            
            return $formView;
        }
		
		public function previewUrl()
		{
			 return rootUrl() . "/view.php?id=" . $this->Id;			
   	    }    
		
		public function assignInputValues($form, $wizardstep=1, $files=null)
        {
            if (count($this->Fields) > 0)
            {
                foreach($this->Fields as $field)
                {
					if (intval($field->WizardStep) == intval($wizardstep)){
						$field->InputValue = $field->submittedValue($form, $files);
					}
                }
            }
        }
		
		public function loadGroupedEntries(){
			
			if(isset($this->Entries)){
			   
			   $groupedEntries=array();
			   $entries = array_reverse($this->Entries);
			   $column_names=array();
			   foreach($entries as $entry){	
					
						$entryId = $entry->EntryId;
						
						if (!Utils::isExcludedField($entry->FieldType)){
							$groupedEntries[$entryId][$entry->FieldId] = $entry;	
						}
						
					    if(!array_key_exists($entry->FieldId, $column_names) && !Utils::isExcludedField($entry->FieldType)){
						   $column_names[$entry->FieldId]=$entry->FieldLabel;
						}							
			   }
			   
			   $this->ColumnNames = $column_names;
			   $this->GroupedEntries = $groupedEntries;			   
			
			}
		
		}
		
		function Url()
		{
			$url = rootUrl() . "/register.php?id=" . $this->Id . "&embed=" . $this->Embed;
			return $url;
		}
	}
	
	class FormListViewModel
	{
		public $FormViews;
		public $FormViewTemplates;
		
		function __construct() {
			$this->FormViews = array();
			$this->FormViewTemplates = array();
		}		
	}

?>