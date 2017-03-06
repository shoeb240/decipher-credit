<?php
class Applicationsections_model extends CI_Model {


	public $uid;
	public $applicantID;
	public $id;
	public $description;	
	public $status;	

	public function __construct(){
		$this->load->database();
	}
	
	// make sure  to initialize membmers first
	public function insertApplicationSection()
	{
		
		$data = array(
				    'applicantID' => $this->applicantID,
					'id' => $this->id,
				    'description' => $this->description,
				    'status' => $this->status				
				);		
			 $this->db->insert('applicationSections',$data);	
			 $this->uid =  $this->db->insert_id();
	}
	// make sure  to initialize membmers first
	public function updateApplicationSection()
	{
		
		$data = array(
				'applicantID' => $this->applicantID,
				'id' => $this->id,
				'description' => $this->description,
				'status' => $this->status
		);
		
		$this->db->where("uid",$this->uid);
		$this->db->update('applicationSections',$data);
		
	}
	
	
	
	
	
	
}