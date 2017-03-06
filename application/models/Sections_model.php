<?php
class Sections_model extends CI_Model {

         public function __construct()        {
          $this->load->database();
        }
        
        public function get_sections($publicOnly=false){
            if ($publicOnly) {
                $this->db->where('sections.visibility', 1);
            }
            $query = $this->db->get('sections');
            return json_encode($query->result_array());
        }

        public function get_sections_customers(){
           $this->db->select('sections.*, customer.nameLast');
           $this->db->from('sections');
           $this->db->join('customer', 'sections.owner = customer.id', 'left');
           $this->db->order_by('sections.id');
           $query = $this->db->get();
           return json_encode($query->result_array());
        }
        
        public function get_only_decipher_sections(){
            $this->db->select('s.id d_id, s.description d_description, s.status d_status');
            $this->db->from('sections as s');
            $this->db->join('customerSections as cs', 's.id = cs.id', 'left');
            $this->db->where('cs.uid is null');
            $this->db->where('s.visibility', 1);
            $query = $this->db->get();

            return json_encode($query->result_array());
        }
        
        public function get_only_decipher_sections_having_questions(){
            $this->db->select('s.id d_id, s.description d_description, s.status d_status');
            $this->db->from('sections as s');
            $this->db->join('secobjXref as sox', 's.id = sox.secID');
            $this->db->join('customerSections as cs', 's.id = cs.id', 'left');
            $this->db->where('cs.uid is null');
            $this->db->where('s.visibility', 1);
            $this->db->group_by('sox.secID');
            $query = $this->db->get();

            return json_encode($query->result_array());
        }
        
        public function get_sectionDataById($id)
        {
        	
        	$this->db->where('id', $id);        	
        	$query = $this->db->get('sections');        	
        	
        	return json_encode($query->result_array());
        }
        
        public function getSectionRowDataById($id)
        {
            $this->db->where('id', $id);        	
            $query = $this->db->get('sections');        	

            return $query->row_array();
        }

        public function get_decipher_sections_by_template_id($template_id){
            $this->db->select('s.*, tsx.order');
            $this->db->from('sections as s');
            $this->db->join('templsecXref as tsx', 's.id = tsx.sectionKey');
            $this->db->where('tsx.templateKey', $template_id);
            $query = $this->db->get();

            return json_encode($query->result_array());
        }
        
        public function get_decipher_sections($customer_id){
            $this->db->select('s.*, tsx.templateKey');
            $this->db->from('sections as s');
            $this->db->join('templsecXref as tsx', 'tsx.sectionKey = s.id');
            $this->db->join('customerTemplates as ct', 'tsx.templateKey = ct.id', 'left');
            $this->db->where('ct.custId is null');
            $this->db->order_by('s.id');
           
            $query = $this->db->get();
            $setion_arr = $query->result_array();
           
            $section_ret = array();
            foreach($setion_arr as $i => $section) {
                $section_ret[$section['templateKey']][] = $section;
            }
            
           return $section_ret;
        }

       public function set_section($sec_data) {

          $this->db->insert('sections', $sec_data);          
          return $this->db->insert_id();

      }
      
      public function update_section($data,$sec_id)
      {
      	$this->db->set($data);
      	$this->db->where('id', $sec_id);
      	$this->db->update('sections');
      }
      


}//end model


