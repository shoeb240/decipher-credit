<?php

class Requested_loan_amount extends Basehandler 
{
 // 163
    private $_question_data;
    private $requested_financing_amount;
    private $loan_purpose;
    
    
    private $fields =
    array(    		    		
    		"text-1470946309930" =>"requested_financing_amount",
    		"text-1470946331240" => "loan_purpose",    		
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
