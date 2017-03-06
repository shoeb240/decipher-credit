<?php
class Fileobj
{

	public $fileName;
	public $tmpName;
	public $size;
	public $fileType;
	public $file_content;

	public function __construct()
	{
		
	}
	
	public function setValues($fileName,$tmpName, $size, $fileType)
	{

		$this->fileName = $fileName;
		$this->tmpName = $tmpName;
		$this->size = $size;
		$this->fileType = $fileType;
			
		//print_r($tmpName);
			
		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$this->file_content  = $content;
		fclose($fp);
			
	}

}
?>