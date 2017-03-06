<?php 


if(!class_exists("Utils"))require_once(ABSPATH . '/lib/forms-utils.php');

	$ViewData= array();

    function humanizeDate($date)
    {
	   return Utils::humanizeDate($date);	
    } 
	
	function outputHumanizedDate($date)
	{
	   echo humanizeDate($date);
	}
		
	function customInclude($path){
	   include(ABSPATH. $path);
	}
	
	function includeTemplate($templatePath, $mode="PHP", $field=Null)
	{
	   include(ABSPATH. $templatePath);
	}
	
	function rootUrl()
	{
		$pageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
		$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$fullurl =  rtrim($protocol . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], "/");
		$details = parse_url($fullurl);		
		$path = isset($details["path"]) ? $details["path"] : "";
		$pathWithNoPageName = str_replace($pageName, "", $path);
		$docRoot = $protocol . $_SERVER['HTTP_HOST'] . $pathWithNoPageName;
		return rtrim($docRoot, "/");
	}
	
	function spinner()
	{
	   createSpinner("spinner");
	}
	
	function createSpinner($id, $hide = true)
    {
        $hideCss = $hide ? "hide" : "";
        echo "<img class='spinner " . $hideCss . "' id='" . $id . "' src='" . rootUrl() . "/content/images/spinner.gif' alt='loader' />";
    }
	
	function getLinkUrl($path, $queryTokens=array())
	{
	   echo returnLinkUrl($path, $queryTokens);
	}
	
	function returnLinkUrl($path, $queryTokens=array()){
		$fullPath = rootUrl() . $path;
		$queryString="";
		
		// add debug param to url if debug is set in settings file
		if (defined('Settings::DEBUG')) {				
			if(Settings::DEBUG){
				$queryTokens["XDEBUG_SESSION_START"]=true;			
			}
		}
		
		if(isset($queryTokens) && count($queryTokens) > 0){
		    $queryString .= "";
			foreach($queryTokens as $key => $value){
			     $queryString .= $key . "=" . $value . "&" ;
			}
			
			if(strpos($fullPath, "?")==false && strlen($queryString) > 0){
				$fullPath = $fullPath . "?";
			}else{
				$fullPath = $fullPath . "&";
			}
			
			$queryString = rtrim($queryString, "&");
		}
		
		return $fullPath . $queryString;
	}
	
	function outputIfFalse($condition, $output_value)
	{
	   if(!$condition)
	   {
	      echo $output_value;
	   }
	}
	
	function outputIfTrue($condition, $output_value, $else_output="")
	{
	   echo returnIfTrue($condition, $output_value, $else_output);
	}
	
	function returnIfTrue($condition, $output_value, $else_output="")
	{
	   if($condition === true || Utils::isBool($condition))
	   {
	      return $output_value;
	   }else{
		  return $else_output;
	   }
	}	
	
	function strFormat() {
	  $args = func_get_args();
		if (count($args) == 0) {
			return;
		}
		
		if (count($args) == 1) {
			return $args[0];
		}
		
		$str = array_shift($args);
		$str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = '.var_export($args, true).'; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];'), $str);
		return $str;
	}
	
	function setInfoMessage($message)
	{
	   setMessage("info",$message);
	}
	
	function setErrorMessage($message)
	{
		setMessage("error",$message);
	}
	
	function setSuccessMessage($message)
	{
		setMessage("success",$message);
	}
	
	function setMessage($messageType, $message)
	{
	   $_SESSION[$messageType] = $message;
	}
	
	function writeMessages($css="")
	{
		$sb = "";
        $errors  = isset($_SESSION["error"]) ? $_SESSION["error"] : "";
        $success = isset($_SESSION["success"]) ? $_SESSION["success"] : "";
        $info    = isset($_SESSION["info"]) ? $_SESSION["info"] : "";
        $notice  = isset($_SESSION["notice"]) ? $_SESSION["notice"] : "";

        if (!isNullOrEmpty($errors))
        {
              $sb .=  strFormat("<div class=\"error clear {0}\">", $css);
              $sb .= $errors;
              $sb .= "</div>";
        }
        if (!isNullOrEmpty($success))
        {
              $sb .= strFormat("<div class=\"success clear {0}\">", $css);
              $sb .= $success;
              $sb .= "</div>";
        }

        if (!isNullOrEmpty($info))
        {
              $sb .= strFormat("<div class=\"info clear {0}\">", $css);
              $sb .= $info;
              $sb .= "</div>";
        }

        if (!isNullOrEmpty($notice))
        {
              $sb .= strFormat("<div class=\"notice clear {0}\">", $css);
              $sb .= $notice;
              $sb .= "</div>";
        }            

		$_SESSION["error"]=NULL;
		$_SESSION["notice"]=NULL;
		$_SESSION["success"]=NULL;
		$_SESSION["notice"]=NULL;			
        echo $sb;
	}
	
	function getFormRedirectPage($formid)
	{
		$redirect="";
		if(isset($_SESSION["form-redirect-page-" . $formid])){
			$redirect = $_SESSION["form-redirect-page-" . $formid];
			$_SESSION["form-redirect-page-" . $formid]=null;
		}
		return $redirect;
	}
	
	function setFormRedirectPage($formid, $url)
	{
		$_SESSION["form-redirect-page-" . $formid]=$url;		
	}
	
	
	// Function for basic field validation (present and neither empty nor only white space)
	function isNullOrEmpty($question){
		return (!isset($question) || (is_string($question) && trim($question)===''));
	}

	function redirectToErrorPage()
	{
	  header('Location:' . rootUrl() .  '/error.php');   
	}
	
	 function tip($text, $css = "tip")
     {
        echo strFormat("<div class=\"{0}\">{1}</div>", $css, $text);
     }

	 function spacerImage()
     {
         echo rootUrl() . "/content/images/spacer.gif";
     }
	 
	 function countrySelectList($id, $class, $first_item="", $selected_item="")
     {
	    selectList(Constants::$COUNTRIES_ARRAY, $id, $class, $first_item, $selected_item);
	 }
	 
	 function selectList($array, $id, $class, $first_item="", $selected_item="")
	 {
	    $sb = strFormat("<select id='{0}' name='{0}' class='{1}'>", $id, $class);		
				
		$sb .= getSelectListOptions($array, $first_item, $selected_item);
		$sb .= "</select>";
		
		echo $sb;
	 }
	 
	 function getSelectListOptions($array, $first_item="", $selected_item="")
	 {
		$sb = strFormat("<option id=''>{0}</option>", $first_item);		
		foreach($array as $key=>$value)
		{
		    $selected_attribute="";
		    if($key == $selected_item)
			{
				$selected_attribute .= "selected='selected'";
			}
		    $sb .= strFormat("<option value='{0}' {1}>{2}</option>",$key, $selected_attribute, $value);
		}		
		return $sb;
	 }
	 
	 
	 function monthSelectList($id, $class, $selected="")
	 {
	    selectList(Utils::monthArray(), $id, $class, "", $selected);
	 }
	 
	 function daySelectList($id, $class, $selected="")
	 {
	    selectList(Utils::dayArray(), $id, $class, "", $selected);
	 }
	 
	 function yearSelectList($id, $class, $selected="")
	 {		  
	    selectList(Utils::yearArray(), $id, $class, "", $selected);
	 }
	 
	 function yearSelectListRange($id, $class, $minAge, $maxAge, $selected="")
	 {	     
		 $year_array=array();
		  
		  for($i= (int)$minAge; $i <= (int)$maxAge; $i++)
		  {
			$the_year = date('Y') - $i;
			$year_array[$the_year] = $the_year;	    
		  }
		  
	    selectList($year_array, $id, $class, "", $selected);
	 }
	 
	 function getFormFieldValue($fieldView, $fieldType = "", $returnIfNull = "")
     {
		    $ViewData=null;
	        if (isset($_SESSION['submitted-values']))
			{				
				$ViewData = $_SESSION['submitted-values'];
			}
			else if (!isNullOrEmpty($fieldView->InputValue))
			{
				$ViewData = $fieldView->InputValue;									
			}

            return extractFormFieldValue($ViewData, $fieldView, $fieldType, $returnIfNull);
     }
	 
	 function extractFormFieldValue($viewDataObject, $fieldView, $fieldType = "", $returnIfNull = "")
     {
	        if (isNullOrEmpty($fieldView->Errors)){
				getFieldErrors($fieldView);
			}
				
			if (isset($viewDataObject)){
				$field_identifier=$fieldType;	
						
				if(empty($fieldType)){
					$field_identifier = ucfirst(strtolower($fieldView->FieldType));
				}				
								
				if(array_key_exists('SubmitFields', $viewDataObject))
				{
					if (array_key_exists($fieldView->DomId, $viewDataObject['SubmitFields']))
					{
						if (array_key_exists($field_identifier, $viewDataObject['SubmitFields'][$fieldView->DomId]))
						{
							$item = $viewDataObject['SubmitFields'][$fieldView->DomId][$field_identifier];
				
							if (isset($item) && !empty($item))
							{
								return $item;						
							}
						}
					}
				}
			
			}

            return $returnIfNull;
     }
	 
	 function insertValuesIntoTempData($form)
     {
			$ViewData;			
            foreach ($form as $key=>$value)
            {
                $ViewData[$key] = $value;
            }
			
			$_SESSION['submitted-values'] = $ViewData;
     }
	 
	 function addFieldError($field, $error)
	 {		 
		$_SESSION['field-errors'][$field->DomId] = $error;
	 }
	 
	 function getFieldErrors($field)
	 {
		 
		 if (isset($_SESSION['field-errors'])){
			 $errors = $_SESSION['field-errors'];
					 
			 if(isset($errors)){
				 if(array_key_exists($field->DomId, $errors)){
					$error =  $errors[$field->DomId];
					$field->Errors = $error;
					return $error;
				 }
			 }
		 }		 
		 return "";
	 }
	 
	 function clearPostBackData(){
		 
		 if (isset($_SESSION['field-errors'])){
			$_SESSION['field-errors'] = NULL;
		 }
		 
		 if (isset($_SESSION['submitted-values'])){
			$_SESSION['submitted-values']=NULL;
		 }
	 }
	 
	 function multiArrayKeyExists( $needle, $haystack ) { 

		foreach ( $haystack as $key => $value ) { 

			if ( $needle == $key ) 
				return true; 

			if ( is_array( $value ) ){ 
				if ( multiArrayKeyExists( $needle, $value ) == true ) 
					return true; 
				else 
					continue; 
			}

		}

		return false; 
	}
	 
	 function outputIfIs($target, $matchValue, $valueToOutput, $elseOutput = "")
     {
        if ($target == $matchValue)
        {
            return $valueToOutput;
        }

        return $elseOutput;
     }
	 
	 function isTempFormValueSelected($field, $value)
     {	             
        $selectedValue = getFormFieldValue($field, ucfirst(strtolower($field->FieldType)));   		 
		return trim($selectedValue) == trim($value);
     }
	 
	 function isAnyTempFormValueSelected($field)
     {
		 $ViewData=null;
		 if (isset($_SESSION['submitted-values']))
		 {
			// TODO: add more defensive checks
			$submittedData=$_SESSION['submitted-values']['SubmitFields'];			
		 }
		 else if (isset($field->InputValue))
		 {
			 $submittedData=$field->InputValue['SubmitFields'];
		 }
		 
		 if (isset($submittedData)){
			$ViewData = $submittedData[$field->DomId][ucfirst(strtolower($field->FieldType))];
			return isset($ViewData);
		 }
		 
		 return false;
     }
	 
	 function getSelectedTimeValues($field){
		 
		 $selectedHours1=getFormFieldValue($field,"Hour1");
		 $selectedMinutes1=getFormFieldValue($field,"Minute1"); 
		 $selectedDD1=getFormFieldValue($field,"AMPM1");
		 		 
		 $selectedHours2=getFormFieldValue($field,"Hour2");
		 $selectedMinutes2=getFormFieldValue($field,"Minute2"); 
		 $selectedDD2=getFormFieldValue($field,"AMPM2");
		 
		 
		 $dateValues = array();
		 $dateValues['hh1'] = date('g');
		 $dateValues['mm1'] = date('i');
		 $dateValues['dd1'] = date('A');
		 
		 $dateValues['hh2'] = date('g');
		 $dateValues['mm2'] = date('i');
		 $dateValues['dd2'] = date('A');
		 
		 if (isset($selectedHours1) && !isNullOrEmpty($selectedHours1)){
			$dateValues['hh1'] = $selectedHours1;	
		 }
		 
		 if (isset($selectedMinutes1) && !isNullOrEmpty($selectedMinutes1)){
			$dateValues['mm1'] = $selectedMinutes1;	
		 }
		 
		 if (isset($selectedDD1) && !isNullOrEmpty($selectedDD1)){
			$dateValues['dd1'] = $selectedDD1;	
		 }
		 
		 if (isset($selectedHours2) && !isNullOrEmpty($selectedHours2)){
			$dateValues['hh2'] = $selectedHours2;	
		 }
		 
		 if (isset($selectedMinutes2) && !isNullOrEmpty($selectedMinutes2)){
			$dateValues['mm2'] = $selectedMinutes2;	
		 }
		 
		 if (isset($selectedDD2) && !isNullOrEmpty($selectedDD2)){
			$dateValues['dd2'] = $selectedDD2;	
		 }
		 
		 return $dateValues;
	 }
	 
	

?>