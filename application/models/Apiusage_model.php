<?php

class Apiusage_model extends CI_Model{
  public $apiservice_key;
  public $idstructure;
  public $query;
 
  public function __construct(){
          $this->load->database();
  }
 
  public function insert(){
      $data = array(
        'uuid' => null,
//        'accessedon'  => null,
        'apikey'  => $this->apiservice_key,
        'accessedBy'=> $this->idstructure,
        'query'=>$this->query
);
      $sql = $this->db->insert('apiusage', $data);

      return $sql;
      }
  
  
}
?>