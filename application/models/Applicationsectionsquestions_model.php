<?php
class Applicationsectionsquestions_model extends CI_Model {


	public $applicationID;
	public $id;
	public $secID;
	public $objID;
	public $order;
	public $status;
	public $weighting;
	public $parameterOverride;
	public $uuid;

	public function __construct(){
		$this->load->database();
	}
	
	public function insertApplicationSectionQuestion()
	{
		$data = array(
				'applicationID'=>$this->applicationID,
				'id'=> $this->id,
				'secID' =>$this->secID,
				'objID'=> $this->objID,
				'order'=>$this->order,
				'status'=>$this->status,
				'weighting' =>$this->weighting,
				'parameterOverride'=> $this->parameterOverride 				
				);
		
		$this->uuid = $this->db->insert('applicationSectionQuestionXref',$data);
		
	}
	
	public function updateApplicationSectionQuestion()
	{
		$data = array(
				'applicantID'=>$this->applicantID,
				'id'=> $this->id,
				'secID' =>$this->secID,
				'objID'=> $this->objID,
				'order'=>$this->order,
				'status'=>$this->status,
				'weighting' =>$this->weighting,
				'parameterOverride'=> $this->parameterOverride
		);
		$this->db->where('uuid',$this->uuid);
	
		$this->db->insert('applicationSectionQuestionXref',$data);
	
	}
	
}