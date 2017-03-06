<?php

class Salesinvoiceprofile extends Basehandler 
{
 // 162
    private $_question_data;
    private $receivable_gen;
    private $avg_monthly_sale;
    private $avg_invoice_number;
    private $avg_invoice_value;
    private $total_customer;
    private $avg_customer_pm;
    private $avg_collect_days;
    private $write_off_per;
    private $terms_of_sale;
    
    private $fields =
    array(    		    		
    		"text-1470945810204" =>"avg_monthly_sale",
    		"text-1470945867062" => "avg_invoice_number",
    		"text-1470945891157" => "avg_invoice_value",
    		"text-1470945934097" => "total_customer",
    		"text-1470945977137"=> "avg_customer_pm",
    		"text-1470946007138"=> "avg_collect_days",
    		"text-1470946044171"=> "write_off_per",
    		"checkbox-group-1470946075385"=>"receivable_gen",    
    		"text-1470946152443"=>"terms_of_sale" 		
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
