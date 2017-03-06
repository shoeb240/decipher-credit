<?php
class Customertemplatessections_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}

	public function get_sectionsPerTemplate($cust_id,$template_key ){
		$query= null;
		
			$this->db->order_by("order");
			$query = $this->db->get_where('customerTemplatesSectionsXref',array("templateKey" => $template_key,"custid" => $cust_id));
		
		
		return json_encode($query->result_array());
	}
	
	public function get_section_not_in_template($id)
	{
		$this->db->where("uid NOT IN ( Select sectionKey  from customerTemplatesSectionsXref where templateKey = ".$id."  )");
		$query = $this->db->get('customerSections');
		return json_encode($query->result_array());		
	}

	public function insert_custTemplateSecReference($data)
	{
            if (empty($data)) {
                return false;
            }
            $this->db->insert_batch('customerTemplatesSectionsXref',$data);
	}
	
	
	public function updateTemplateSections($template_id,  $secXrefdata_array)
	{
		$this->db->trans_start(); // we are going to delete
		$query =$this->db->delete('customerTemplatesSectionsXref', array("templateKey"=>$template_id));
		$this->db->insert_batch('customerTemplatesSectionsXref',$secXrefdata_array);
		$this->db->trans_complete();
	
	}
	
	public function getCustomerTemplateSecXrefbyUID($template_id,$section_id)
	{
		
		$this->db->select('customerSections.*');
		$this->db->select('ctsx.sectionKey, ctsx.order, ctsx.weighting');
		$this->db->from(' customerSections');
		$this->db->join('customerTemplatesSectionsXref as ctsx', ' customerSections.custid = ctsx.custid and customerSections.uid = ctsx.sectionKey');
		$this->db->where("ctsx.templateKey", $template_id);
		$this->db->where("ctsx.sectionKey", $section_id);
		$this->db->where("customerSections.uid", $section_id);
		$query = $this->db->get();
		return json_encode($query->result_array());
		
	}
	

}//end model