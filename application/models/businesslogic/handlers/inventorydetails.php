<?php
class Inventorydetails extends Basehandler 
{
    private $_question_data;
    private $date;
    private $inventory_dollar_amount;
    private $inventory_pledged;
    
    private $fields =
    array(
    		"date-1470940891104" => "date",
    		"text-1470940929500" =>"inventory_dollar_amount",
    		"radio-group-1470941020884" => "inventory_pledged"
    );
    
    
    

    public function __construct($id)
    {//        log_message("DEBUG", "inventory details handler called");
            parent::__construct($id);
    }

 
   
    public function load_api_data()
    {
        // No API Call
    }

    public function calculatescore() 
    {
        $score = 50;
    
/*        
        $parametersObj = $this->getApplicationQuestionParameters();
        $dArr = date_diff(new DateTime(date("Y-m-d")), new DateTime(date("Y-m-d", strtotime($this->date))));
        if ($dArr->y < $parametersObj->max_year) {
            $score += 30;
        } else {
            $score += 0;
        }
        
        if ($this->text >= $parametersObj->min_amount) {
            $score += 20;
        } else {
            $score += 0;
        }
  */      
        return $score;
    }

    public function accept()
    {
        
            $response = new stdClass();
            $response->reason="ok";
            $response->fname="";
            $response->ok=true;
        
//        log_message("DEBUG", "inventory details accept called");
        if (strtotime($this->date) === false || !is_numeric($this->text) 
                || !in_array($this->radio_group, array('Yes', 'No'))
        ) {
            $response->reason="failed";
            $response->fname=$this->date;
            $response->ok=true;
        }
            return json_encode($response);
        
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
