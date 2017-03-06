<?php
class Handlers_model extends CI_Model {
public $score;
public $questionID;     /* question ID */
public $applicationID;
public $uuid;
public $dsource;
public $answerblob;

        public function __construct(){
          $this->load->database();
        }
        public function insertApplicationQuestionAnswer(){
        $dbdata = array(
    			'applicationID' => $this->applicationID,
    			'questionID' => $this->questionID,
    			'dsource' => $this->dsource,
                 'answerblob'=>$this->answerblob,
    			
    	);
            
          $this->db->insert('applicationResults', $dbdata);     
          $this->uuid = $this->db->insert_id();
          return $this->uuid;
        }
        
        public function updateApplicationQuestionAnswer(){
        $dbdata = array(
    			'applicationID' => $this->applicationID,
    			'questionID' => $this->questionID,
    			'dsource' => $this->dsource,
                        'answerblob'=>$this->answerblob    			
    	);
        
        $this->db->where(array('uuid' => $this->uuid));
            
          $this->db->update('applicationResults', $dbdata);          
          
        }
        
        
        public function fetchApplicationQuestionAnswer($uuid){
           $this->db->where('uuid', $uuid);        	
           $query = $this->db->get('applicationResults');        	
           return json_encode($query->result_array());
            
            
        }
       
        public function score() {
           $this->score=75;
           return $this->score;
        }// end function

        public function get_handlers(){
           $query = $this->db->get('questionHandlers');
           return json_encode($query->result_array());
        }
        
        public function get_handlers_usage(){
           $this->db->select('qu.*');
           $this->db->select
          ('(select group_concat(DISTINCT(pc.productID)) from productChecklist pc where pc.handlerID = qu.id group by pc.handlerID ) as pref  ');
           $this->db->select
                   ('(select group_concat(DISTINCT(qx.id)) from questions qx where qx.outputType = qu.id ) as qref  ');

           $this->db->from('questionHandlers qu');
           $query = $this->db->get('');
           return json_encode($query->result_array());
        }
        

        public function set_handler($hand_data) {

          $this->db->insert('questionHandlers', $hand_data);          
          return $this->db->insert_id();

      }

      public function update_handler($data,$hand_id)
      {
        $this->db->set($data);
        $this->db->where('id', $hand_id);
        $this->db->update('questionHandlers');
      }

      public function get_handlerDataById($id)
      {
        
        $this->db->where('id', $id);          
        $query = $this->db->get('questionHandlers');          
        
        return json_encode($query->result_array());
      }
  

}//end model


