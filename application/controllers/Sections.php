<?php

class sections extends Base {

        public function __construct(){
                parent::__construct();
                $this->load->model('ion_auth_model');
                 if (!$this->ion_auth->logged_in()){
                   redirect('auth/login');
                }
                
                
                $this->load->model('sections_model');
                $this->load->model('sectionsquestions_model');
                $this->load->model('questions_model');
                $this->load->helper('url_helper');
                $this->load->view('templates/head');
        }

        public function index(){
                $data['sections'] = $this->sections_model->get_sections();               
		$this->template->load('default', 'content', $data);
        }

        public function view($sectionID = NULL){
               
                $data['sections'] = $this->sections_model->get_sections_customers();
                $data['questions'] = $this->questions_model->get_questions();
                $this->load->view('sections/view', $data);
        }

        public function create(){ 
        	
        	    $this->load->helper('form');
                $this->load->library('form_validation');
                $data['title'] = 'Create a section item';
                $this->form_validation->set_rules('description', 'description', 'required');
                $this->form_validation->set_rules('qid_list', 'qid_list', 'required');
                if ($this->form_validation->run() === FALSE){
                	$data['questions'] = $this->questions_model->get_questions();
                        $this->load->view('sections/create',$data);
                }else{
                 	$sec_data = array(
    			'description' => $this->input->post('description'),
    			'status' => $this->input->post('status'),
    			'id' => null
    	                );
    	
       $section_id =  $this->sections_model->set_section($sec_data);
       $question_ids = $this->input->post('qid_list');
       
     
       $insert_array = $this->get_questions_data($question_ids,$section_id);
    
       $this->sectionsquestions_model->insert_SectionObjReference($insert_array);
       
       $data["msg"] = "Section Added.";
       redirect("sections/view", "refresh");
//		$this->load->view('sections/success',$data);
    }
}

public function edit($section_id)
{	
	$this->load->helper('form');
	$this->load->library('form_validation');
	
	$this->form_validation->set_rules('description', 'description', 'required');
	$this->form_validation->set_rules('qid_list', 'qid_list', 'required');
	 
	if ($this->form_validation->run() === FALSE)
	{	
	$data["section_questions"] = json_decode($this->sectionsquestions_model->get_section_questions($section_id));
	$data["remaining_questions"] = json_decode($this->sectionsquestions_model->get_no_section_questions($section_id));
	$data["sec_data"] = json_decode($this->sections_model->get_sectionDataById($section_id));
	
	$this->load->view('sections/edit',$data);
	}
	
	else		
	{
		$update_data = array(				
				'description' => $this->input->post('description'),
				'status' => $this->input->post('status')
				
		);
		
		$this->sections_model->update_section($update_data,$section_id);
		
		$question_ids = $this->input->post('qid_list');
		$insert_array = $this->get_questions_data($question_ids,$section_id);
		$this->sectionsquestions_model->updateSectionQuestions($section_id,$insert_array);
		
		$data["msg"] = "Section Updated.";
//		$this->load->view('sections/success',$data);

                redirect("sections/view", "refresh");
	}
	
	
}

private function get_questions_data($question_ids,$section_id)
{
	
	$question_ids = substr($question_ids, 0, strlen($question_ids)-1 ); // remove extra commma from end
		
		
	$question_id_array = explode(",", $question_ids);
		
	$insert_array = array();
	$i=0;
		
	for($i=0; $i< sizeof($question_id_array) ;$i++ )
	{
		$values = array();		
		$values["objID"] = $question_id_array[$i];
		$values["secID"] = $section_id;
		$values["order"] = $i +1;
		$values["status"]= 1;
		$insert_array[$i] = $values;
	}
	
	return $insert_array;
}
 
}
