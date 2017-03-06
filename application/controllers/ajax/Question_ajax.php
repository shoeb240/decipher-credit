<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_ajax extends CI_Controller {


	public function __construct()
	{
		parent::__construct();

		$this->load->model('ion_auth_model');
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login');
		}
		
		$this->load->model('questions_model');
                $this->load->model('customersectionquestions_model');
	}

	public function GetQuestionContent()
	{
		if(isset($_POST['question_id']))
		{
			$question_id = $_POST['question_id'];
			
			$all_questions_html = "";
			
				if($question_id != '')
				{
						
						
					$question = json_decode($this->questions_model->get_question($question_id));
						
					//print_r($question);
					
					if(count($question)> 0)
					{
						
						
							$question_content =   $question[0]->{'content'};  //json_decode($this->questions_model->get_question($question->objID));
								
                                                        $all_questions_html .=  "<div name='outer' onclick=\"javascript: showQuestionAttribute('".$question[0]->{'id'}."', 'indp');\" class = 'outer' id = 'indp_".$question[0]->{'id'}."' value='".$question[0]->{'id'}."'  >" .  $question_content . "</div>";
												
					}

					//print_r($all_questions_html);

				}
			
			echo $all_questions_html;
		}

	}
        
        public function GeQuestionContentOnly()
	{
		if(isset($_POST['question_id']) && !empty($_POST['question_id']))
		{
                        $question_content = '';
			
                        $question = json_decode($this->questions_model->get_question($_POST['question_id']));
                        //print_r($question);

                        if(!empty($question))
                        {
                            $question_content =   $question[0]->{'content'};  //json_decode($this->questions_model->get_question($question->objID));
                            preg_match_all("/(<label.*?>.*?<\/label>)/", $question_content, $original_matches);
                            $question_content = implode(' ', $original_matches[0]);
                        }
			
			echo $question_content;
		}

	}
        
        public function GeCustQuestionContentOnly()
	{
		if(isset($_POST['question_uid']) && !empty($_POST['question_uid']))
		{
                    $question_content = '';

                    $question = json_decode($this->customersectionquestions_model->get_customerquestion($_POST['question_uid']));
                    //print_r($question);

                    if(!empty($question))
                    {
                        $question_content =   $question->{'content'};  //json_decode($this->questions_model->get_question($question->objID));
                        preg_match_all("/(<label.*?>.*?<\/label>)/", $question_content, $original_matches);
                        $question_content = implode(' ', $original_matches[0]);
                    }

                    echo $question_content;
		}

	}
        
        public function GetAnswerblob()
        {
            $results_uuid = $this->input->post('uuid');
            $this->load->model('applications_model');
            $answerblob = $this->applications_model->get_answerblob($results_uuid);
            
            echo json_encode($answerblob);
        }
        
        public function GetSectionsQuestions()
        {
            $application_id = $this->input->post('application_id');
            $this->load->model('applications_model');
            $answerblob = $this->applications_model->get_section_questions_by_appid($application_id);
            
            echo json_encode($answerblob);
        }
        
        private function getHandlerClass($application_question_uuid)
        {
            $this->load->model('handlers_model');
            
            $query = $this->db->get_where('applicationQuestions', array('uuid' => $application_question_uuid));
            $application_question = $query->row_array();
            $handler_id = $application_question['outputType'];
            
            $handler_data = json_decode($this->handlers_model->get_handlerDataById($handler_id));
            $handler_file_name = $handler_data[0]->handler;
            $class_name = substr($handler_file_name,0, strlen($handler_file_name) - 4 ) ;// 4 is ext length 
            
            return $class_name;
        }
        
        private function getInputData($application_question_uuid)
        {
            $this->db->select('answerblob');
            $this->db->where('questionID', $application_question_uuid);
            $this->db->where('dsource', 0);
            $query = $this->db->get('applicationResults');
            $result = $query->row_array();
            $input_data = unserialize($result['answerblob']);
            
            return $input_data;
        }
        
        public function RerunHandler()
        {
            $application_question_uuid = $this->input->post('question_id');
            
            $class_name = $this->getHandlerClass($application_question_uuid);

            $input_data = $this->getInputData($application_question_uuid);
            
            $handler_obj = new $class_name($application_question_uuid);
            $handler_obj->setvalues($input_data);

            $handler_obj->rerunit();

            echo json_encode(array('response' => 'ok'));
        }
        
        public function RescoreHandler()
        {
            $application_question_uuid = $this->input->post('question_id');
            
            $class_name = $this->getHandlerClass($application_question_uuid);

            $input_data = $this->getInputData($application_question_uuid);
            
            $handler_obj = new $class_name($application_question_uuid);
            $handler_obj->setvalues($input_data);

            $handler_obj->rescore();

            echo json_encode(array('response' => 'ok'));
        }
        
        public function SaveKillevel()
        {
            $response = false;
            
            $killlevel = $this->input->post('killlevel');
            $qid = $this->input->post('qid');
            
            $this->load->model('applications_model');
            $ok = $this->applications_model->updateKilllevel($killlevel, $qid);
            
            if (!empty($ok)) {
                $response = true;
            }
            
            echo  json_encode(array('response' => $response));
        }

}
