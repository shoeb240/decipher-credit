<?php
class Templates_model extends CI_Model {

        public function __construct(){
          $this->load->database();
        }

        public function get_templates(){
        	
           $this->db->select('templates.*, customer.nameLast');
           $this->db->from('templates');
           $this->db->join('customer', 'templates.owner = customer.id', 'left');
           $this->db->order_by('templates.id');
           $query = $this->db->get();

           return json_encode($query->result_array());
        }

public function get_template_byid($id)
{
	$this->db->where("id",$id);	
	$query = $this->db->get('templates');
	return json_encode($query->result_array());
}
        

      public function set_template($templ_data) {	
    
       $this->db->insert('templates', $templ_data);
       return $this->db->insert_id();

      }

    public function update_template($data,$template_id)
      {
      	$this->db->set($data);
      	$this->db->where('id', $template_id);
      	$this->db->update('templates');
      }

}//end modell

