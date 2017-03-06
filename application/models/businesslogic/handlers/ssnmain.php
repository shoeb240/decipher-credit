<?php
class ssnmain extends Basehandler
{


	public  $ssn = "ssn"; // note that this name is same as name of input
	
	private $fields = array	
			(
			 "ssn" =>"ssn"		
			);
	
	
	public function __construct($id)
	{
		parent::__construct($id);
			
	}

	
	
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
        return 50;
    }

	public function accept()
    {
            $response = new stdClass();
            $response->reason="baddy";
            $response->fname="mynamne";
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
	}
	

}
