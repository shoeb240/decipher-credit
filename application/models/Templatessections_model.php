<?php
class Templatessections_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}

	public function get_sectionsPerTemplate($id=0){
		$query= null;
		if($id> 0) {
			
			$this->db->order_by("order");
			$query = $this->db->get_where('templsecXref',array("templateKey" => $id));
		}else{
			$query = $this->db->get('templsecXref');
		}
		return json_encode($query->result_array());
	}
	
	public function get_section_not_in_template($id)
	{
		$this->db->where("ID NOT IN ( Select sectionKey  from templsecXref where templateKey = ".$id."  )");
		$query = $this->db->get('sections');
		return json_encode($query->result_array());		
	}

	public function insert_TemplateSceceference($data)
	{
		$this->db->insert_batch('templsecXref',$data);
	}
	
	
	public function updateTemplateSections($template_id,  $secXrefdata_array)
	{
		$this->db->trans_start(); // we are going to delete
		$query =$this->db->delete('templsecXref', array("templateKey"=>$template_id));
		$this->db->insert_batch('templsecXref',$secXrefdata_array);
		$this->db->trans_complete();
	
	}

}//end model