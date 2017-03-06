<?php

class Person extends Basehandler 
{

    private $_question_data;
    private $owner_officer;
    private $street_address;
    private $state;
    private $post_code;
    private $country;
    private $ssn;
    private $drivers_license;
    private $date_of_birth;
    private $title;
    private $owner_percentage;
    private $phone;
    
    private $fields = array
    		(
    		"text-1470943843051" => "owner_officer",
    		 "text-1470943902656" => "street_address",
    		 "text-1470943940783" => "state",
    		 "text-1470943985327" => "post_code",
    		 "text-1470944036366" => "country",	
    		 "text-1470944091743" => "ssn",
    		 "text-1470944131494"=> "drivers_license",
    		 "date-1470944196343" => "date_of_birth",
    		 "text-1470944232581" =>"title",
    		 "text-1470944233829" => "owner_percentage",
    		 "text-1470944330774" => "phone"    		
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
        $this->load->model('Microbilt_API_peoplesearchsvc_model');

        $ptype=new PersonInfo_Type();
        $pname = new PersonName_Type();
        $pname->FullName = $this->owner_officer;
        $pcontact=new ContactInfo_Type();
        $pcontact->PhoneNum = $this->phone;            
        $paddr = new PostAddr_Type();
        $paddr->PostalCode = $this->post_code;
        $paddr->StateProv = $this->state;
        //$paddr->Addr1 = $this->street_address;
        $paddr->StreetName = $this->street_address;
        $pIDinfo = new TINInfo_Type();
        $pIDinfo->TINType = "SSN";
        $pIDinfo->TaxId = $this->ssn;

        $apiresults = $this->Microbilt_API_peoplesearchsvc_model->baseSearch($ptype, $pname, $pcontact, $paddr, $pIDinfo);       
        log_message("DEBUG", "API RESULTS");
        if (!empty($apiresults->GetReportResult->Subject)) {
            
          log_message("DEBUG", "GOT API RESULT IN HANLDER");
            
            $ind = 1;
            foreach($apiresults->GetReportResult->Subject as $row){
                if (empty($row)) continue;
                $this->db->set('applicationID', $applicationID);
                $this->db->set('questionID', $this->id);
                $this->db->set('answerblob', serialize($row));
                $this->db->set('dSource', $ind++);
                $this->db->insert('applicationResults');
            }
        } 
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
	}
    
    
    
}
