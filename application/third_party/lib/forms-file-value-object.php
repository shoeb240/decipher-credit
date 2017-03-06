<?php 

    if(!class_exists("Utils"))require_once(ABSPATH . '/lib/forms-utils.php');
	if(!class_exists("S3"))require_once(ABSPATH . '/lib/S3.php');
	if(!class_exists("Settings"))require_once(ABSPATH . '/lib/forms-settings.php');
	
    class FileValueObject
    {
        public $FileName;
        public $SavePath;
        public $SaveName;
        public $Extension;
        public $IsSavedInCloud;
		public $IsImage;
		public $TempName;
		public $IsExistingFile;
		
		function __construct(){
		
		}
		
		public static function createFromJsonObject($encoded_object)
		{		
		   $fileObj = new FileValueObject();	
		   if(isset($encoded_object))
		   {		   
			   $fileObj->FileName=$encoded_object->FileName;
			   $fileObj->SavePath=$encoded_object->SavePath;
			   $fileObj->SaveName=$encoded_object->SaveName;
			   $fileObj->Extension=$encoded_object->Extension;
			   $fileObj->IsSavedInCloud=$encoded_object->IsSavedInCloud;
			   $fileObj->IsImage=$encoded_object->IsImage;		   
		   }
		   return $fileObj;
		}

        public function imageViewPath()
        {
           if ($this != null)
           {
		      if($this->IsSavedInCloud){
                return  Utils::strFormat("http://{0}.s3.amazonaws.com/{1}", Settings::AWS_BUCKET, $this->SaveName);
			  }else{
			    return rootUrl() . '/'. Settings::FILE_SAVE_PATH . $this->SaveName;
			  }
           }
           
           return "";
        }		
    }

?>