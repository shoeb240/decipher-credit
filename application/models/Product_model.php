
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Product_model extends CI_Model {

        public function __construct(){
          $this->load->database();
        }
        
        public function getProductById($product_id){
            $this->db->where('uuid', $product_id);
            $query = $this->db->get('products');
            return json_encode($query->row_array());
        }
        
        public function get_products(){
            $query = $this->db->get('products');
            return json_encode($query->result_array());
        }

        public function setProduct($data) {
            $this->db->insert('products', $data);
        }
        
        public function updateProduct($data, $product_id)
        {
            $this->db->set($data);
            $this->db->where('uuid', $product_id);
            $this->db->update('products');
        }
        
        public function get_field_types()
        {
            $query = $this->db->get('productFieldtypes');
            return json_encode($query->result_array());
        }
        
        public function getParameterById($parameter_id){
            $this->db->where('uuid', $parameter_id);
            $query = $this->db->get('productParameters');
            return json_encode($query->row_array());
        }
        
        public function setProductParameter($data) {
            $this->db->insert('productParameters', $data);
        }
        
        public function updateProductParameter($data, $parameter_id)
        {
            $this->db->set($data);
            $this->db->where('uuid', $parameter_id);
            $this->db->update('productParameters');
        }
        
        public function getProductHandlers($productID)
        {
            $this->db->select('Distinct(handlerID) as product_handler');
            $this->db->where('productID', $productID);
            $query = $this->db->get('applicationProductChecklist');
            
            $res_arr = $query->result_array();
            
            $ret_arr = array();
            foreach($res_arr as $each) {
                $ret_arr[] = $each['product_handler'];
            }

            return $ret_arr;
        }
	
}

