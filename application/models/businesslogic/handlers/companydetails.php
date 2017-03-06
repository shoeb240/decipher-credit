<?php

class Companydetails extends Basehandler
{

    private $legalbusinessform;
    private $formationdate;
    private $formationstate;
    private $fields =  array(
        'text-1470940449615' => 'legalbusinessform',
        'date-1470940501686' => 'formationdate',
    	'select-1470940571254' => 'formationstate'	
    );
   

	public function __construct($id)
	{
	    parent::__construct($id);
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
