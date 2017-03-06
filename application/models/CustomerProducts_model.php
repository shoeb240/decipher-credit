<?php

class CustomerProducts_model extends CI_Model{
    public $product;
    public $customer;
 
  public function __construct(){
          $this->load->database();
  }
  public function get_products(){
            $query = $this->db->get('customerProducts');
            $this->db->where('custuomerid', $this->customer);
            return json_encode($query->result_array());
        }
        
        public function update_checklist_item($id, $status){
             $this->db->set('status', $status);
             $this->db->where("uuid", $id);
             $this->db->update('customerProductChecklist');
        }
        
  public function get_checklist(){
       $this->db->select('PC.*');
       $this->db->select('QH.*');
       $this->db->select('PD.description');
       

       $this->db->from('customerProductChecklist PC');
      if($this->product){
      $this->db->where('productID',$this->product);
      }
      $this->db->where('customerID', $this->customer);
      $this->db->join('questionHandlers QH', 'QH.id = PC.handlerID', 'left');
      $this->db->join('products PD', 'PD.uuid = PC.productID');
//      $this->db->join('productChecklist PL', 'PL.uuid = PC.checklistID');
      

//$this->db->join('comments', 'comments.id = blogs.id');
       
       $query = $this->db->get(); 
 
        return json_encode($query->result_array());

  }      
  
  public function safeInsertProducts(){
    $sql = "insert into customerProducts  select $this->customer, uuid, description from products where uuid not in (select productID from customerProducts where  customerID = $this->customer)";
  $this->db->query($sql);
  return $this->db->affected_rows();
  }
  
  public function safeInsertChecklistProduct(){
//
//insert into  `customerProductChecklist` 
//select null, 1,productID,uuid,'a',sorder,handlerID, 0 from productChecklist 
//where productID = 1 and uuid not in 
//(select checklistID from customerProductChecklist where productID = 1 and customerID = 1)      
  $sql = "insert into  `customerProductChecklist` select null, $this->customer,productID,uuid,'a',sorder,handlerID, 0 from productChecklist where productID = $this->product and uuid not in (select checklistID from customerProductChecklist where productID = $this->product and customerID = $this->customer) ";
  $this->db->query($sql);
  return $this->db->affected_rows();
  }
  
  public function safeInsertChecklistAllProducts(){
//
//insert into  `customerProductChecklist` 
//select null, 1,productID,uuid,'a',sorder,handlerID, 0 from productChecklist 
//where productID = 1 and uuid not in 
//(select checklistID from customerProductChecklist where productID = 1 and customerID = 1)      
  $sql = "insert into  `customerProductChecklist` select null, $this->customer,productID,uuid,'a',sorder,handlerID, 0 from productChecklist where productID = $this->product and uuid not in (select checklistID from customerProductChecklist where productID = $this->product and customerID = $this->customer) ";
  $this->db->query($sql);
  return $this->db->affected_rows();
  }
  
  
  
}
