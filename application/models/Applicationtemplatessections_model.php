<?php
class Applicationtemplatessections_model extends CI_Model {

public $uuid;
public $applicationID;
public $id;
public $templateKey;
public $sectionKey;
public $order;
public $weighting;


public function __construct(){
	$this->load->database();
}

 public function insertApplicationTemplateSection()
 {
 	$data = array
 			(
 			'applicationID' => $this->applicationID,
 			'id' => $this->id,
 			 'templateKey' => $this->templateKey,
 			 'sectionKey' => $this->sectionKey,
 			 'order' => $this->order,
 			 'weighting' =>$this->weighting
 			);
 	   
 	$this->uuid = $this->db->insert('applicationTemplatesSectionsXref',$data); 	 	
 } 
	
 public function updateApplicationTemplateSection()
 {
 	$data = array
 	(
 			'applicationID' => $this->applicationID,
 			'id' => $this->id,
 			'teplateKey' => $this->templateKey,
 			'sectionKey' => $this->sectionKey,
 			'order' => $this->order,
 			'weighting' =>$this->weighting
 	);
 	$this->db->where('uuid',$this->uuid); 
 	
 	$this->db->update('applicationTemplatesSectionsXref',$data);
 }
 
 
 
	
}