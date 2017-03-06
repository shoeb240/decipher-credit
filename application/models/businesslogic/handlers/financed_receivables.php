<?php

class Financed_receivables extends Basehandler 
{
 // 160
    private $_question_data;
    private $finance_receivable;
    private $finance_provider;    
    private $agreement_doc;
    
    private $fields =
    array(    		    		
    		"radio-group-1470942532305" =>"finance_receivable",
    		"text-1470942601275" => "finance_provider",    
    		"file-1470942668865" =>	"agreement_doc"				
    );
    
    
     
    public function __construct($id)
    {
//        log_message("DEBUG", "person handler called");
            parent::__construct($id);
   }
    
    /*
     * This function will map name of html element to value
     * 
     * */
  
public function setvalues($questionData)
   {
   	$this->questionData = $questionData;
   // print_r($questionData);
   	
   	
   	foreach ($questionData as $values) {
   		foreach ($values as $name => $value) {
   			if (!isset($this->fields[$name])) {
   				continue;
   			}
   			
   			if(strcasecmp($this->fields[$name], "agreement_doc") == 0) // We know it is going to be a file
   			{
   				$file_array = $value;
   				//print_r($file_array);
   				
   				$fileName = $file_array["name"];
   				$tmpName = $file_array["tmp_name"];
   				$size = $file_array["size"];
   				$fileType = $file_array["type"];
   				$error = $file_array["error"];
   				parent::setFileObj($fileName, $tmpName, $size, $fileType);   
							
   			}
   
   			$this->{$this->fields[$name]} = $value;
   		}
   	}
   }
  
    public function load_api_data()
    {
      
    }

    public function calculatescore() 
    {
        $score = 50;
        
        return $score;
    }

    public function accept()
    {
        log_message("DEBUG", "PESON ACCEPT CALLED");
            $response = new stdClass();
            $response->reason="ok";
            $response->fname="";
            $response->ok=true;
            return json_encode($response);
    }
    
public function getValues()
	{
	
		$values = array();
		
		foreach ($this->fields as $field_name => $member_name)
		{
			$values[$field_name] = 	 $this->{$member_name};
		}
		return $values;
		
		//return $this->questionData;
	}
    
    
    
}
