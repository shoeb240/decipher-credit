
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Customer_model extends CI_Model {

        public function __construct(){
          $this->load->database();
        }
        
        public function get_customers(){
           $query = $this->db->get('customer');
           return json_encode($query->result_array());
        }

	
	public function get_customerid_fromuserid($user_id)
	{

		$this->db->where('userID', $user_id);		
		$query = $this->db->get('customerUsers');
		$row = $query->result_array();
		if(count($row) > 0)		
			return $row[0]["custID"];
		else 
			return "-1";
		
	}
        
        public function setCustomer($data) {
            $this->db->insert('customer', $data);
            return $this->db->insert_id();
        }
	
}

