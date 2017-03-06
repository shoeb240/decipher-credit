<?php
class Customeruser_model extends CI_Model {

        public function __construct()        {
          $this->load->database();
        }

        public function get_customers(){
           $query = $this->db->get('customer');
           return $query->result_array();
        }
        
        public function get_customers_by_users(){
           $this->db->select('customer.*, customerUsers.userID');
           $this->db->from('customer');
           $this->db->join('customerUsers', 'customer.id = customerUsers.custID', 'left');
           $this->db->order_by('customer.id');
           $query = $this->db->get();
           
           return $query->result_array();
        }
        
        public function get_customer_for_user($userID){
            $this->db->select('customerUsers.custID');
            $this->db->from('customerUsers');
            $this->db->where('userID', $userID);
            $this->db->limit(1); // 
            //his is a bad hack for now because we need a way to define the relationship to multiple companies
            $query = $this->db->get();
           
           return $query->result_array();
        }
        
        public function get_customerDataById($id)
        {
        	
        	$this->db->where('id', $id);        	
        	$query = $this->db->get('customer');        	
        	
        	return $query->result_array();
        }

       public function set_customer($cust_data) {

          $this->db->insert('customer', $cust_data);          
          return $this->db->insert_id();

      }

       public function set_customer_link($cust_data) {

       	  $doesLinkExist = $this->db->get_where('customerUsers', $cust_data)->row_array();
       	  
       	  if(!isset($doesLinkExist['uuid']))
       	  {
	          $this->db->insert('customerUsers', $cust_data);          
	          return $this->db->insert_id();
	      }
	      else
	      {
	      	  return false;
	      }

      }
      
      public function set_customer_link_batch($cust_data, $userID) {
            $this->db->trans_start();
            
            $this->db->where('userID', $userID);
            $this->db->delete('customerUsers');

            if (!empty($cust_data)) {
                $this->db->insert_batch('customerUsers', $cust_data);          
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE){
                return false;
            }
            return true;
      }
      
      public function update_customer($data,$cust_id)
      {
      	$this->db->set($data);
      	$this->db->where('id', $cust_id);
      	$this->db->update('customer');
      }

}