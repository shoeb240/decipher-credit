<?php
class Applicationquestions_model extends CI_Model {


	public $applicationID;
	public $id;
	public $des;
	public $content;
	public $serialContent;
	public $outputType;
	public $attributes;
	public $parameters;
	public $status;
	public $uuid;
	public $blobContent;

	public function __construct(){
		$this->load->database();
	}
	
	
	
	public function insertApplicationQuestion()
	{
	  $data = array(
	  		'applicationID' => $this->applicationID,
	  		'id' => $this->id,
	  		'des' => $this->des,
	        'content'=>$this->content,
	  		'serialContent'=> $this->serialContent,
	  		'outputType'=>$this->outputType,
	  		'attributes' => $this->attributes,
	  		'parameters' => $this->parameters,
	  		'status'=>$this->status,	
	  		'blobContent' => $this->blobContent 		
	  		);	  	
	  
	  $this->db->insert('applicationQuestions', $data);
	  $this->uuid = $this->db->insert_id();
	 	
	}
	
	public function updateApplicationQuestions()
	{
		
		$data = array(
				'applicationID' => $this->applicationID,
				'id' => $this->id,
				'des' => $this->des,
				'content'=>$this->content,
				'serialContent'=> $this->serialContent,
				'outputType'=>$this->outputType,
				'attributes' => $this->attributes,
				'parameters' => $this->parameters,
				'status'=>$this->status,
				'blobContent' => $this->blobContent
				
		);
		
		$this->db->where('uuid',$this->uuid);
		 
		$this->db->update('applicationQuestions', $data);
			
	}
	
	public function getApplicationQuestion($questionid)
	{
		$this->db->where('uuid',$questionid);
		
		$query = $this->db->get('applicationQuestions');		 
		$res = $query->result_array();
		//print_r($res);
		
		$this->uuid = $questionid;
		$this->applicationID = $res[0]["applicationID"];
		$this->id =  $res[0]["id"];
		$this->des = $res[0]["des"];
		$this->content = $res[0]["content"];
		$this->serialContent = $res[0]["serialContent"];
		$this->outputType = $res[0]["outputType"];
		$this->attributes = $res[0]["attributes"];
		$this->parameters = $res[0]["parameters"];
		$this->status = $res[0]["status"];
		$this->blobContent = $res[0]["blobContent"];
		
	}
	
	public function getApplicationQuestionAttachment($questionid)
	{
		
		$this->db->select('blobContent');
		$this->db->from('applicationQuestions');
		$this->db->where('uuid',$questionid);		
		$query = $this->db->get();
		$res = $query->result_array();	
		return $res;	
	}
	
	
}