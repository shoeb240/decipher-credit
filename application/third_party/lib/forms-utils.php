<?php

require_once(ABSPATH . '/lib/S3.php');
require_once(ABSPATH . '/lib/PHPMailerAutoload.php');
require_once(ABSPATH . '/lib/forms-settings.php');

class Utils
{

	public static function humanizeDate($ts)
	{
	
	    if(!ctype_digit($ts))
           $ts = strtotime($ts);
       
       $diff = time() - $ts;
       if($diff == 0)
           return 'now';
       elseif($diff > 0)
       {
           $day_diff = floor($diff / 86400);
           if($day_diff == 0)
           {
               if($diff < 60) return 'just now';
               if($diff < 120) return '1 minute ago';
               if($diff < 3600) return floor($diff / 60) . ' minutes ago';
               if($diff < 7200) return '1 hour ago';
               if($diff < 86400) return floor($diff / 3600) . ' hours ago';
           }
           if($day_diff == 1) return 'Yesterday';
           if($day_diff < 7) return $day_diff . ' days ago';
           if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
           if($day_diff < 60) return 'last month';
           return date('F Y', $ts);
       }
       else
       {
           $diff = abs($diff);
           $day_diff = floor($diff / 86400);
           if($day_diff == 0)
           {
               if($diff < 120) return 'in a minute';
               if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
               if($diff < 7200) return 'in an hour';
               if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
           }
           if($day_diff == 1) return 'Tomorrow';
           if($day_diff < 4) return date('l', $ts);
           if($day_diff < 7 + (7 - date('w'))) return 'next week';
           if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
           if(date('n', $ts) == date('n') + 1) return 'next month';
           return date('F Y', $ts);
       }
   }
   
   public static function toSlug($text)
   {
		 // replace non letter or digits by -
         $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
         
         // trim
         $text = trim($text, '-');
         
         // transliterate
         $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
         
         // lowercase
         $text = strtolower($text);
         
         // remove unwanted characters
         $text = preg_replace('~[^-\w]+~', '', $text);
         
         if (empty($text))
         {
           return 'n-a';
         }
         
         return $text;
   }
   
   public static function getFolders($path)
   {
       $directories=array();
	   foreach(scandir($path) as $item)
	   {
		 if (is_dir($path . '/' . $item) && $item != ".." && $item != ".") {
		    array_push($directories, $item);			
		 }		 
	   }
       	   
	   return $directories;
   }
   
   public static function getFiles($path)
   {
       $files=array();
	   foreach(scandir($path) as $item)
	   {
		 if (!is_dir($path . '/' . $item)) {
		    array_push($files, $item);			
		 }		 
	   }
       	   
	   return $files;
   }
   
   public static function monthArray()
   {
      $month_array=array();
	  
	  for($i=1;$i<=12;$i++)	  
	  {
	    $month_array[$i] = date("F",mktime(0,0,0,$i,1,2011));	    
	  }
	  
	  return $month_array;
   }
   
   public static function dayArray()
   {
      $day_array=array();
	  
	  for($i=1;$i<=31;$i++)	  
	  {
	    $day_array[$i] = $i;	    
	  }
	  
	  return $day_array;
   }
   
   public static function yearArray()
   {
      $year_array=array();
	  
      for($i=1; $i <= 82; $i++)
	  {
	    $the_year = (date('Y')-100) - $i;
	    $year_array[$i] = $the_year;	    
	  }
	  
	  return $year_array;
   }
   
   public static function populateWithPost($obj = NULL)
   {
		if(!is_object($obj)) {
			 $obj = new StdClass ();
		}
		 
		foreach ($_POST as $var => $value) {
			 $obj->$var = $value; //here you can add a filter, like htmlentities ...
		}
	   
		return $obj;
   }
   
   public static function outputJson($array)
   {
		header('Content-Type: application/json');
        echo json_encode($array);
   }
   
   public static function formFieldValue($domId, $field)
   {
	   $rawPropertyString = $_POST["Fields"][$domId]["Properties"];
	   $decodedString = rawurldecode($rawPropertyString);
	   $jsonObj = json_decode($decodedString, true);
	   if (array_key_exists($field, $jsonObj)){
		    $fieldValue = $jsonObj[$field];
			$fieldValue = strtolower($field) == "content" ? urldecode($fieldValue) : $fieldValue;
			return $fieldValue;
	   }
	   
	   return null;
   }
   
   public static function formFieldJsonValues($domId, $jsonPropertyList){
	   $jsonPropertyArray = explode(",", $jsonPropertyList);
	   $jsonObject = array();
	   foreach($jsonPropertyArray as $prop){	       
		   $jsonObject[$prop] = Utils::formFieldValue($domId, $prop);
	   }
	   
	   return $jsonObject;
   }
   
   public static function formFieldJsonValuesAsString($domId, $jsonPropertyList){
	   return json_encode(Utils::formFieldJsonValues($domId, $jsonPropertyList));
   }
   
   
   public static function isInt($obj, $altValue=0)
   {
     if(is_numeric($obj))
	 {
	    return (int)$obj;
	 }
	 	 
	 return (int) $altValue;
   }
   
   public static function isBool($obj)
   {
		switch (strtolower($obj)) {
			case ("1"):			
			case ("true"): return true;
			case ("0"):
			case ("false"): 
			default: return false;
		}
   }
   
   public static function submittedFieldValue($form, $domId, $field, $counter=null)
   {       
       $a1 = $form["SubmitFields"];

	   if (array_key_exists($domId, $a1)){
		   $a2 = $a1[$domId];
		   if (array_key_exists($field, $a2)){
			   $a3 = $a2[$field];
			   if (isset($counter)){
				   if (array_key_exists($counter, $a3)){
						$a4 = $a3[$counter];
						return $a4;
				   }else{
					   return null;
				   }		   
			   }
			   return $a3;
		   }
	   }
	   
	   return null;
   }
   
   public static function submittedFieldCollection($form, $domId, $field, $counter=null)
   {       
       $a1 = $form["SubmitFields"];

	   if (array_key_exists($domId, $a1)){
		   $a2 = $a1[$domId];
		   if (array_key_exists($field, $a2)){
			   $a3 = $a2[$field];			   
			   return $a3;
		   }
	   }
	   
	   return null;
   }
   
   public static function submittedFileValue($files, $domId, $field)
   {       
	   $fileObjArray = array();
       $a1 = $files['SubmitFields'];
	   $fileObjArray['name'] = $a1['name'][$domId]['Filepicker'];
	   $fileObjArray['size'] = $a1['size'][$domId]['Filepicker'];
	   $fileObjArray['tmp_name'] = $a1['tmp_name'][$domId]['Filepicker'];
	   $fileObjArray['filename'] = "";
	   
	   if (isset($_POST) && isset($_POST["SubmitFields"]) && array_key_exists($domId,$_POST["SubmitFields"]) && array_key_exists("Filename",$_POST["SubmitFields"][$domId])){
			$fileObjArray['filename'] = $_POST["SubmitFields"][$domId]['Filename']; // this is only set if a previously uploaded file exists
	   }
	   
       return $fileObjArray;
   }
	
   public static function submittedFieldNameByField($field)
   {
       return Utils::submittedFieldName($field->DomId, ucwords($field));
   }

   public static function submittedFieldName($domId, $field)
   {
       return Utils::strFormat("SubmitFields[{0}][{1}]", $domId, $field);
   }
   
   public static function truncateChars($text, $limit, $ellipsis = '...') {
    if( strlen($text) > $limit ) 
        $text = trim(substr($text, 0, $limit)) . $ellipsis; 
    return $text;
  }
  
   public static function strFormat() {
		$args = func_get_args();
		if (count($args) == 0) {
			return;
		}
		
		if (count($args) == 1) {
			return "";
		}
		
		$str = array_shift($args);
		$str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = '.var_export($args, true).'; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];'), $str);
		return $str;
	}
	
	 public static function getFileValueFromJsonObject($value)
     {
         try
         {
             return json_decode($value);
         }
         catch(Exception $e){
             return null;
         }
     }
	 
	 public static function saveImageToCloud($file)
	 {
		$s3 = new S3(Settings::AWS_ACCESS_KEY, Settings::AWS_SECRET_KEY); 		
		$s3->putObjectFile($file->TempName, Settings::AWS_BUCKET, $file->SaveName, S3::ACL_PUBLIC_READ);		  
	 }
	 
	 public static function deleteImageFromCloud($saveName)
	 {
		$s3 = new S3(Settings::AWS_ACCESS_KEY, Settings::AWS_SECRET_KEY); 
		
		$s3->deleteObject(Settings::AWS_BUCKET, $saveName);		  
	 }
	 
	 public static function addValueToDictionary($collection, $key, $value)
	 {
			if (array_key_exists($key, $collection))
            {
                $newKey = "";
                $counter = 2;
                do
                {
                    $newKey = self::strFormat("{1} {0}", $key, $counter);
                    $counter++;

                } while (array_key_exists($newKey, $collection));

               $collection[$newKey] = $value;
            }
            else {
               $collection[$key] = $value;
            }
	 }
	 
	public static function notifyViaEmail($model)
    {        
        $emailBody = self::createEmailBody($model);
        
		$mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = Settings::EMAIL_HOST;  // Specify main and backup server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = Settings::EMAIL_USERNAME;                            // SMTP username
        $mail->Password = Settings::EMAIL_PASSWORD;                           // SMTP password
        
		if(Settings::EMAIL_ENABLE_SSL)
		{
		  $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
		}  
        
        $mail->From = Settings::SENDER_EMAIL;
        $mail->FromName = Settings::SENDER_NAME;
        $mail->addAddress($model->Email);  // Add a recipient
        
        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters        
        $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = self::strFormat("New Submission for form \"{0}\"", $model->FormName);
        $mail->Body    = $emailBody;        
        
		
		return $mail->send();        
    }
	
	public static function createEmailBody($model)
	{
	   $sb="<table style=\"width:800px;\">
             <tr>
              <td colspan=\"2\">
                 You received a new submission " . self::humanizeDate(date('Y-m-d H:i:s')) . " for the form " . $model->FormName . "
              </td>
            </tr>";
	   
	   if(isset($model->Entries) && count($model->Entries) > 0)
	   {
	      foreach($model->Entries as $entry)
		  {
		    $sb = "<tr>
					<td style=\"width:200px;Font-weight:bold;vertical-align:top;\">@entry.Key</td>
					<td>" . $entry->FormatValue(true) . "</td>
				  </tr>";
		  }	      
	   }
	   
	   $sb .= "</table>";
	   
	   return $sb;
	}
	
	public static function limitWithEllipses($s, $max_length)
	{
		if (strlen($s) > $max_length)
		{
		  $s= substr($s,0,$max_length)."...";
		}
		
		return $s;
	}
	
	public static function toUnorderedList($errorlist)
    {
        $sb = "<ul>";
        foreach($errorlist as $str)
        {
            $sb .= Utils::strFormat("<li>{0}</li>", $str);
        }
		
        $sb .= "</ul>";
        return $sb;
    }
	
	public static function guid(){
      if (function_exists('com_create_guid')){
          return com_create_guid();
      }else{
          mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
          $charid = strtoupper(md5(uniqid(rand(), true)));
          $hyphen = chr(45);// "-"
          $uuid = ""// "{"
                  .substr($charid, 0, 8).$hyphen
                  .substr($charid, 8, 4).$hyphen
                  .substr($charid,12, 4).$hyphen
                  .substr($charid,16, 4).$hyphen
                  .substr($charid,20,12)
                  ."";// "}"
          return $uuid;
      }
    }
	
	public static function getBindingDictionaries($fetch_by_key="")
	{
		if (file_exists(ABSPATH . '/lib/dictionaries.xml')) 
		{
			$xml = simplexml_load_file(ABSPATH . '/lib/dictionaries.xml'); 
			$node  = $xml;
			$dictionary_collection = array();
			
			foreach($xml->itemlist as $item){
				$object = new stdClass();
				
				$object->Name = (string)$item->attributes()->name;				
				$object->IsPublic = !isset($item->attributes()->ispublic) ? true : Utils::isBool((string)$item->attributes()->ispublic);
				$object->Items = array();
				
				if (!isNullOrEmpty($fetch_by_key) && $object->Name==$fetch_by_key){
					foreach($item->item as $kvp)
					{					
					    $item_kvp=array();
						$item_kvp["key"]=(string)$kvp->attributes()->key;
						$item_kvp["value"]=(string)$kvp->attributes()->value;
						array_push($object->Items, $item_kvp);						
					}
				}else{
					foreach($item->item as $kvp)
					{
						$object->Items[(string)$kvp->attributes()->key]=(string)$kvp->attributes()->value;
					}
				}
				
				if ($object->Name==$fetch_by_key){
					return $object->Items;
				}				
				
				$dictionary_collection[$object->Name] = $object;				
			}	
			
			//var_dump($dictionary_collection);
			return $dictionary_collection;
			
		} else {
			
		}
	}
	
	public static function getInputMasks($fetch_by_key="")
	{
		if (file_exists(ABSPATH . '/lib/input-masks.xml')) 
		{
			$xml = simplexml_load_file(ABSPATH . '/lib/input-masks.xml'); 
			$node  = $xml;
			$mask_collection = array();
			
			foreach($xml->inputmask as $mask){
				$object = new stdClass();
				
				$object->Name = (string)$mask->attributes()->name;								
				$object->Mask = (string)$mask->attributes()->mask;		
				
				if (!isNullOrEmpty($fetch_by_key) && $object->Name==$fetch_by_key){
					return $object;
				}
				
				$mask_collection[$object->Name] = $object;				
			}	
			
			//var_dump($dictionary_collection);
			return $mask_collection;
			
		} else {
			//Log dictionary file doesn't exist
		}
	}
	
	public static function isExcludedField($fieldType){
		$excludedFields = Constants::FIELDS_EXCLUDED_FROM_OUTPUT;
		$excludedFieldArray = explode(",",$excludedFields);
		$isExcluded = in_array($fieldType, $excludedFieldArray);
		return $isExcluded;
	}
	
	// demo only
	public static function getLockedFormIds(){
		return isNullOrEmpty(Settings::LOCKED_FORM_IDS) ? array() : explode(",", Settings::LOCKED_FORM_IDS);
	}
	
	// demo only
	public static function isLockedFormId($id){		
		$excluded_ids = Utils::getLockedFormIds();
		return in_array($id, $excluded_ids);
	}
	
	
}

?>