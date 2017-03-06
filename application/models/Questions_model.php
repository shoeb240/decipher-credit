<?php
class Questions_model extends CI_Model {

        public function __construct(){
          $this->load->database('');
        }

        public function get_questions(){
           $query = $this->db
               ->select('q.*, qh.handler')
               ->from('questions as q')
               ->join('questionHandlers as qh', 'qh.id = q.outputType', 'left')
               ->get();
           return json_encode($query->result_array());
        }

        public function get_question($question_id){
        	$query = $this->db->get_where('questions',array("id" => $question_id));
        	return json_encode($query->result_array());
        }

        public function get_question_row($question_id){
        	$query = $this->db->get_where('questions',array("id" => $question_id));
        	return json_encode($query->row_array());
        }


        public function set_question() {

            log_message('debug', "set question");
            $data = array(
                'des' => $this->input->post('des'),
                'type' => $this->input->post('type'),
                'weight' => $this->input->post('weight'),
                'content' => $this->input->post('content'),
                'outputType' => $this->input->post('outputType'),
                'status' => $this->input->post('status'),
                'parameters' => $this->input->post('parameters'),
                'id' => null
            );

            error_log("about to do insert");
            return $this->db->insert('questions', $data);

       }

        public function update_qustion($data, $id)
        {
            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->update('questions');
        }

        public function get_output_types()
        {
            $query = $this->db->get('questionHandlers');
            return $query->result_array();
        }

        public function get_statuses()
        {
            $query = $this->db->get('statuses');
            return $query->result_array();
        }




}//end model

