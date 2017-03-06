<?php
class Sectionsquestions_model extends CI_Model {

        public function __construct(){
          $this->load->database();
        }

        public function get_questionsPerSection($id=0){
           $query= null;
           if($id> 0) {
              $query = $this->db->get_where('secobjXref',array("secID" => $id));
           }else{
              $query = $this->db->get('secobjXref');
           }
           return json_encode($query->result_array());
        } // Need to depricate it
        
        
        public function get_section_questions($sec_id, $returnJson = true)
        {
        
        	// need to use join as IN query will not give proper order
        	 
        	$this->db->select('questions.*, secobjXref.order');
        	$this->db->from('questions');
        	$this->db->join('secobjXref', 'questions.id = secobjXref.objID');
        	$this->db->where("secID", $sec_id);        	
        	$this->db->order_by("order asc");
        	$query = $this->db->get();
                
        	//$query =  $this->db->get_where('questions', " ID IN (Select objID from secobjxref where secID = ".$sec_id.")");
        	//$query = $this->db->get('questions');
                if ($returnJson) {
                    return json_encode($query->result_array());
                } else {
                    return $query->result_array();
                }
        }
        
        public function get_no_section_questions($sec_id)
        {
        	$query =  $this->db->get_where('questions', " ID NOT IN (Select objID from secobjXref where secID = ".$sec_id.")");
        	return json_encode($query->result());
        }
        
        public function insert_SectionObjReference($data)
        {        
        		
        	$this->db->insert_batch('secobjXref',$data);
        }
        
        public function updateSectionQuestions($section_id,  $secXrefdata_array)
        {
        	$this->db->trans_start(); // we are going to delete
        	$query =$this->db->delete('secobjXref', array("secID"=>$section_id));
        	$this->db->insert_batch('secobjXref',$secXrefdata_array);
        	$this->db->trans_complete();
        
        }
        
        public function get_section_handlers_by_secid($sec_arr)
        {
            if (empty($sec_arr)) {
                return array();
            }
            
            $this->db->select('Distinct(q.outputType) as question_handler');
            $this->db->from('questions q');
            $this->db->join('secobjXref as cx', 'cx.objID = q.id');
            $this->db->where_in("cx.secID", $sec_arr);
            $query = $this->db->get();

            $res_arr = $query->result_array();

            $ret_arr = array();
            foreach($res_arr as $each) {
                $ret_arr[] = $each['question_handler'];
            }

            return $ret_arr;
        }
      

}//end model

