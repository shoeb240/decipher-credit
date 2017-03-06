<?php

class Products_model extends CI_Model{
 
  public function __construct(){
          $this->load->database();
  }
 
  public function getList(){
 //select pt.*, (select group_concat(DISTINCT(pc.handlerID)) from productChecklist pc where pc.productID = pt.uuid) from products pt
              $this->db->select('pt.*');
//              $this->db->select('(select group_concat(DISTINCT(pc.handlerID)) from productChecklist pc where pc.productID = pt.uuid) as href');
              $this->db->select('coalesce((select group_concat(DISTINCT(pc.handlerID)) from productChecklist pc where pc.productID = pt.uuid), " ") as href');
//  select coalesce((select group_concat(DISTINCT(pc.handlerID)) from productChecklist pc where pc.productID = 1),' ')            
              $this->db->from('products pt');
              $query = $this->db->get('');
              return json_encode($query->result_array());
           
      }
      
 public function getListB(){
      $query = $this->db->get('products');
           return json_encode($query->result_array());
      }
 
      
      public function checkList($prod=null){
      if($prod){
      $this->db->where('productID',$prod);
      }
      
      $query =$this->db->get('productChecklist');
      $this->db->join('questionHandlers', 'id = handlerID');
           return json_encode($query->result_array());
      
      
      }
      
      public function cl2($prod=null){
       $this->db->select('PC.*');
       $this->db->select('QH.*');
       $this->db->select('PD.description');
       

       $this->db->from('productChecklist PC');
      if($prod){
      $this->db->where('productID',$prod);
      }
      $this->db->join('questionHandlers QH', 'QH.id = PC.handlerID', 'left');
      $this->db->join('products PD', 'PD.uuid = PC.productID');
      

//$this->db->join('comments', 'comments.id = blogs.id');
       
       $query = $this->db->get();   

        return json_encode($query->result_array());

}
      
        
}
?>