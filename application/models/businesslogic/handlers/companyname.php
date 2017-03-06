<?php
class Companyname extends Basehandler 
{

	
	
	private  $lastname;  // Note that this name is same as name of the input or any other html control.
	private $otherNames;
	
	private $fields = 
			array(
			      "cname" => "fullName",
					"text-1470861145163" =>"otherNames"
				  					
				);	
	
	
	public function __construct($id)
	{
		//        log_message("DEBUG", "person handler called");
		parent::__construct($id);
	}
    
        public function load_api_data(){
            
        }
        public function calculatescore() {
            return 98;
            
        }
	public function accept(){
//            log_message("DEBUG", 'HOUSE HANDLER ACCEPT CALLED');
            $response = new stdClass();
            $response->reason="baddy";
            $response->fname="mynamne";
            $response->ok=true;
            return json_encode($response);
  
 //           return true;
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
        
	public function getValues()
	{
	
		$values = array();
		
		foreach ($this->fields as $field_name => $member_name)
		{
			$values[$field_name] = 	 $this->{$member_name};
		}
		return $values;
	}
	
	

}
