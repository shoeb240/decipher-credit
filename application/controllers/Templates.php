<?php

class templates extends Base {

        public function __construct()
        {
                parent::__construct();
                 $this->load->model('ion_auth_model');
                if (!$this->ion_auth->logged_in()){
                  redirect('auth/login');
                }
 
                $this->load->model('templates_model');
                $this->load->model('sections_model');
                $this->load->model('sectionsquestions_model');
                $this->load->model('templatessections_model');
                $this->load->model('questions_model');
                
                $this->load->helper('url_helper');
                $this->load->view('templates/head');
        }

        public function index()
        {
        }

        public function view($slug = NULL)
        {
            
                $data['templates'] = $this->templates_model->get_templates();
                $this->load->view('templates/view', $data);
        }
        public function credentials(){
            
            
        }


  public function create() 
{
      

    $this->load->helper('form');
    $this->load->library('form_validation');

    $data['title'] = 'Create a Template item';
    
    $data['sectiondata'] = $this->getSectionsContent();
 
    $this->form_validation->set_rules('description', 'description', 'required');
    $this->form_validation->set_rules('secid_list', 'secid_list', 'required');
    if ($this->form_validation->run() === FALSE)
    {
        $this->load->view('templates/create',$data);

    }
    else
    {
    	$templ_data = array(
    			'TemplateName' => $this->input->post('description'),
    			'status' => $this->input->post('status'),
    			'id' => null
    	);
        $template_id =  $this->templates_model->set_template($templ_data);
        
        $sections_ids = $this->input->post('secid_list');
         
        $sections_ids = substr($sections_ids, 0, strlen($sections_ids)-1 );
         
         
        $section_id_array = explode(",", $sections_ids);
         
        $insert_array = array();
        $i=0;
         
        for($i=0; $i< sizeof($section_id_array) ;$i++  )
        {
        	$values = array();
        	$values["templateKey"] = $template_id;        	
        	$values["sectionKey"] = $section_id_array[$i];
        	$values["order"] = $i +1;
        	$values["status"]= 1;
        	$insert_array[$i] = $values;
        }
         
        $this->templatessections_model->insert_TemplateSceceference($insert_array);
        
        $data["msg"] = "Template Added";
        $this->load->view('templates/success',$data);  
      }
}

public function getSectionsContent()
{
	
	$sections_ref = array();
	
	$sections =  json_decode($this->sections_model->get_sections(true));
	$sec_indx = 0;
	
	foreach ($sections as $section)
	{
	
		$questions = json_decode($this->sectionsquestions_model->get_section_questions($section->id));
		if(count($questions) > 0)
		{
			$qindx= 0;
			$question_array = array();
			$sections_ref[$sec_indx]["id"] = $section->id;
			$sections_ref[$sec_indx]["description"] = $section->description;
			$sections_ref[$sec_indx]["status"] = $section->status;
			
		foreach ($questions as $question)
		{
			$question_content = $question->content; // json_decode($this->questions_model->get_question($question->objID));
			
			
			$question_array[$qindx] = $question_content;
			$qindx++;
		}
		$sections_ref[$sec_indx]["questions"] = $question_array;
		$sec_indx++;
		}
	}
	
	
	
	return $sections_ref;
	
}

	public function edit($template_id)
	{
            if (!$this->ion_auth->logged_in()){
         	  redirect('auth/login', 'refresh');
               }

		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('description', 'description', 'required');
		$this->form_validation->set_rules('secid_list', 'secid_list', 'required');
		if ($this->form_validation->run() === FALSE)
		{
		
		  $sections_ref = array();
		  $remaining_sections = array();
		  
		  $sections_per_template =	json_decode($this->templatessections_model->get_sectionsPerTemplate($template_id));
		  
		  $sec_indx = 0;
		  foreach($sections_per_template as $temp_section)
		  {		  	
		  	$questions = json_decode($this->sectionsquestions_model->get_section_questions($temp_section->sectionKey));
		  	$section_json = json_decode($this->sections_model->get_sectionDataById($temp_section->sectionKey));
		  	$section = $section_json[0];
		  	if(count($questions) > 0)
		  	{
		  		$qindx= 0;
		  		$question_array = array();
		  		$sections_ref[$sec_indx]["id"] = $section->id;
		  		$sections_ref[$sec_indx]["description"] = $section->description;
		  		$sections_ref[$sec_indx]["status"] = $section->status;
		  			
		  		foreach ($questions as $question)
		  		{
		  			$question_content = $question->content;  //json_decode($this->questions_model->get_question($question->objID));
		  				
		  				
		  			$question_array[$qindx] = $question_content;
		  			$qindx++;
		  		}
		  		$sections_ref[$sec_indx]["questions"] = $question_array;
		  		$sec_indx++;
		  	}
		  	
		  }
		  
		  
		  
		  $remaining_system_sections =	json_decode($this->templatessections_model->get_section_not_in_template($template_id));
		  
		  $sec_indx = 0;
		  foreach($remaining_system_sections as $section)
		  {
		  	$questions = json_decode($this->sectionsquestions_model->get_section_questions($section->id));		  
		  	if(count($questions) > 0)
		  	{
		  		$qindx= 0;
		  		$question_array = array();
		  		$remaining_sections[$sec_indx]["id"] = $section->id;
		  		$remaining_sections[$sec_indx]["description"] = $section->description;
		  		$remaining_sections[$sec_indx]["status"] = $section->status;
		  		 
		  		foreach ($questions as $question)
		  		{
		  			$question_content = $question->content;  //json_decode($this->questions_model->get_question($question->objID));
		  
		  
		  			$question_array[$qindx] = $question_content;
		  			$qindx++;
		  		}
		  		$remaining_sections[$sec_indx]["questions"] = $question_array;
		  		$sec_indx++;
		  	}
		  	 
		  }
		  
		  $data["templ_sectiondata"] =  $sections_ref;
		  $data["remaining_sections"] = $remaining_sections;		  
		  $template_data = json_decode($this->templates_model->get_template_byid($template_id));
		  
		  $data["templatename"]= $template_data[0]->TemplateName;
		  $data["status"] = $template_data[0]->status;
		  $data["template_id"] =$template_id;
		  
		  $this->load->view('templates/edit',$data);
		}
		
		else 
		{
			$templ_data = array(
					'TemplateName' => $this->input->post('description'),
					'status' => $this->input->post('status'),					
			);
			 $this->templates_model->update_template($templ_data,$template_id);
			 
			 
			 
			 $sections_ids = $this->input->post('secid_list');
			  
			 $sections_ids = substr($sections_ids, 0, strlen($sections_ids)-1 );
			  
			  
			 $section_id_array = explode(",", $sections_ids);
			  
			 $insert_array = array();
			 $i=0;
			  
			 for($i=0; $i< sizeof($section_id_array) ;$i++  )
			 {
			 	$values = array();
			 	$values["templateKey"] = $template_id;
			 	$values["sectionKey"] = $section_id_array[$i];
			 	$values["order"] = $i +1;
			 	$values["status"]= 1;
			 	$insert_array[$i] = $values;
			 }
			  
			 $this->templatessections_model->updateTemplateSections($template_id, $insert_array);
			 
			 $data["msg"] = "Template Updated";
			 $this->load->view('templates/success',$data);
			
		}
		
		
	}
	

}
