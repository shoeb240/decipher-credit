<?php

class Menulist_model extends CI_Model{
    
    public function __construct(){
          $this->load->database('');
    }
        
     public function get_menus($acl = null){
         $this->db->order_by("parent");
         $this->db->order_by("level");
         $this->db->order_by("dorder");
         if($acl == 0){
             $this->db->where_in('access', array(99) );
         } else if($acl == 1){
             $this->db->where_in('access', array(1,99) );
         }else if ($acl == 2) {
             $this->db->where_in('access', array(2,99) );
         } else {
              $this->db->where_in('access', array(0) );
         }
         $query = $this->db->get('menulinks');
         return json_encode($query->result_array());
    }
}
