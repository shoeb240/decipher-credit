<?php
class Customersections_model extends CI_Model {

         public function __construct()        {
          $this->load->database();
        }

        public function get_customersections($customer_id){
        	
           $this->db->where('custid', $customer_id);
           $query = $this->db->get('customerSections');
            return json_encode($query->result_array());
        }
        
        public function get_decipher_sections($customer_id){
        	
//           $this->db->where('custid', $customer_id);
//           $query = $this->db->get('customerSections');
            $this->db->select('s.*, cs.uid, cs.description as customer_description, cs.status as customer_section_status');
            $this->db->from('sections as s');
            $this->db->join('customerSections as cs', 'cs.id = s.id', 'left');
            $this->db->where('cs.custid', $customer_id);
            $this->db->or_where('cs.custid is null');
            $query = $this->db->get();
            return json_encode($query->result_array());
        }
        
        public function get_template_customersections($customer_id){
            $this->db->select('cs.*, ctsx.templateKey, ctsx.weighting');
            $this->db->from('customerSections cs');
            $this->db->join('customerTemplatesSectionsXref ctsx', 'ctsx.sectionKey = cs.uid');
            $this->db->where('cs.custid', $customer_id);
            $query = $this->db->get();
            $setion_arr = $query->result_array();
           
            $section_ret = array();
            foreach($setion_arr as $i => $section) {
                $section_ret[$section['templateKey']][] = $section;
            }
            
           return $section_ret;
        }
        
        public function get_customersections_questions($customer_id)
        {
            $this->db->select('cq.des, csqx.secID');
            $this->db->from('customerQuestions cq');
            $this->db->join('customerSectionsQuestionsXref csqx', 'csqx.objID = cq.uid');
            $this->db->where('cq.custid', $customer_id);
            $query = $this->db->get();
                        
            $res_arr = $query->result_array();
            $ret_arr = array();
            foreach($res_arr as $each) {
                $ret_arr[$each['secID']][] = $each['des'];
            }
            
            return $ret_arr;
        }
        
        public function get_customersections_having_questions($customer_id)
        {
            $this->db->select('cs.*');
            $this->db->from('customerSections as cs');
            $this->db->join('customerSectionsQuestionsXref as csqx', ' cs.uid = csqx.secID');
            $this->db->where('cs.custid', $customer_id);
            $this->db->group_by('csqx.secID');
            $query = $this->db->get();
                        
            return json_encode($query->result_array());
        }
        
        public function get_customersections_having_questions_except($customer_id, $except_tmpl_id)
        {
            $this->db->select('cs.*');
            $this->db->from('customerSections as cs');
            $this->db->join('customerSectionsQuestionsXref as csqx', ' cs.uid = csqx.secID');
            $this->db->where('cs.custid', $customer_id);
            $this->db->where("cs.uid NOT IN ( Select sectionKey  from customerTemplatesSectionsXref where templateKey = ".$except_tmpl_id."  )");
            $this->db->group_by('csqx.secID');
            $query = $this->db->get();

            return json_encode($query->result_array());
        }
        
        public function get_sectionDataByUId($uid)
        {        	
        	$this->db->where('uid', $uid);        	
        	$query = $this->db->get('customerSections');         	
        	return json_encode($query->result_array());
        }
        
        public function get_customersectionData($custid, $sec_id)
        {
        	$this->db->where('custid', $custid);
        	$this->db->where('uid', $sec_id);        	
        	$query = $this->db->get('customerSections');
        	return json_encode($query->result_array());
        }


       public function set_customersection($sec_data) {

          $this->db->insert('customerSections', $sec_data);          
          return $this->db->insert_id();

      }
      
      
       public function update_section($data,$uid)
      {
      	$this->db->set($data);
      	$this->db->where('uid', $uid);
      	$this->db->update('customerSections');
      }
      
      public function update_customersection($data,$custid,$sec_id)
      {
      	$this->db->set($data);
      	$this->db->where('id', $sec_id);
      	$this->db->where('custid', $custid);
      	
      	$this->db->update('customerSections');
      }
    
}//end model


