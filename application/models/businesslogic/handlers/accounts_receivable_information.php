<?php

class Accounts_receivable_information extends Basehandler 
{
 // 160
    private $_question_data;
    private $total_receivable_outstanding;
    private $outstanding_30;    
    private $outstanding_60;
    private $outstanding_90;
    private $outstanding_over90;
    
    
    private $fields =
    array(    		    		
    		"text-1470945295872" =>"total_receivable_outstanding",
    		"text-1470945349819" => "outstanding_30",    	
    		"text-1470945401878" => "outstanding_60",
    		"text-1470945463653" => "outstanding_90",
    		"text-1470945492933" => "outstanding_over90"    			
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
   
   	foreach ($questionData as $values) {
   		foreach ($values as $name => $value) {
   			if (!isset($this->fields[$name])) {
   				continue;
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
