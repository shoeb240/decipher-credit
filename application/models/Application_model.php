<?php
class Application_model extends CI_Model {
	
	
	public $id;
	public $applicant;
	public $templateID;
	public $templateName;
	public $createdBy;
	public $submittedBy;
	public $status;
	public $workflowState;

	public function __construct(){
		$this->load->database();
	}
	
	
	/*
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 */
	
	
	public function insertApplication()
	{

			$dbdata = array(
					'applicant' => $this->applicant,
					'templateID' => $this->templateID,
					'templateName' => $this->templateName,
					'createdBy'=>$this->createdBy,
					'submittedBy'=>$this->submittedBy,
					'status'=>$this->status,
					'workflowState'=>$this->workflowState
			);
			
			$this->db->insert('applicationTemplate', $dbdata);
			$this->id = $this->db->insert_id();			
			
	}

	public function updateApplication()
	{
		
		$dbdata = array(
				'submittedBy'=>$this->submittedBy,
				'status'=>$this->status,
				'workflowState'=>$this->workflowState
		);
		$this->db->where('id',$this->id);
		$this->db->insert('applicationTemplate', $dbdata);		
	}
	
	public  function startTransaction()
	{
		$this->db->trans_start();
	
	}
	
	public  function endTransaction()
	{
		$this->db->trans_complete();
	
	}
	
	public function beginTransaction()
	{
		
		$this->db->trans_begin();
	}
	
	public function rollbackTransaction()
	{
		
		$this->db->trans_rollback();
	}
	
	public function commitTransaction()
	{
		
		$this->db->trans_commit();
	}
	
	
	public function getSavedApplication($application_id)
	{
		$query = "select aq.*, sq.SecID, aseq.description as sectionname  from applicationQuestions aq
					inner join applicationSectionQuestionXref sq on sq.applicationID = aq.applicationID 
					and sq.id = aq.id inner join applicationSections aseq
					on sq.SecID = aseq.uid  
					inner join applicationTemplatesSectionsXref ts on ts.applicationID = aq.applicationID
					and ts.id = sq.secID where aq.applicationID = ".$application_id."
					order by ts.order, sq.order";
		$out = $this->db->query($query);
		$result = $out->result();
	
	}
	
	
	
	
}