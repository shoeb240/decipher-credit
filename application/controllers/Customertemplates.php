<?php

class Customertemplates extends Base {

	
	private $customer_id;
        private $customer_sec_arr;
        private $ori_sec_arr;
        private $selected_product;
        
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
                $this->load->model('customer_model');
                
                $this->load->model('customersectionquestions_model');
                $this->load->model('customertemplatessections_model');
                $this->load->model('customertemplates_model');                                
                $this->load->model('customersections_model');
                
                $this->load->model('product_model');
                
                $this->customer_id =  $this->customer_model->get_customerid_fromuserid($this->ion_auth->get_user_id());
                
                $this->load->helper('url_helper');
                $this->load->view('templates/head');
        }

        
        public function index()
        {
                $data['templates'] = $this->customertemplates_model->get_customertemplates($this->customer_id);
                $this->load->view('templates/index', $data);
        }

        public function view($slug = NULL)
        {
                $data['customer_id'] = $this->customer_id;
                $data['templates'] =  $this->customertemplates_model->get_customertemplates($this->customer_id);
                $this->load->view('customer/customer_templateview.php', $data);
        }
        public function credentials(){
            
            
        }
        
        public function customer_view($slug = NULL)
        {
            $data['customer_id'] = $this->customer_id;
            $data['templates'] = $this->templates_model->get_deciher_templates($this->customer_id);
            $data['sections'] = $this->customersections_model->get_template_customersections($this->customer_id);
            $data['decipher_sections'] = $this->sections_model->get_decipher_sections($this->customer_id);
            
            $this->load->view('templates/customer-view', $data);
        }


    public function create() 
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['title'] = 'Create a Template item';
        $data['sectiondata'] = $this->getSectionsContent();
        $data['products'] = json_decode($this->product_model->get_products());
        
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('secid_list', 'secid_list', 'required');
        $this->form_validation->set_rules('product', 'Product', 'required');
        
        if (!empty($this->input->post())) {
            
            $this->selected_product = $this->input->post('product');
            
            $orig_sec_ids = $this->input->post('orig_secid_list');
            $nvps = json_decode($orig_sec_ids);
            
            $orig_section_id_array = array();
            foreach($nvps as $entry){
                array_push($orig_section_id_array, $entry->orig_id);
                if (!empty($entry->section)) {
                    $this->customer_sec_arr[] = $entry->section;
                } else {
                    $this->ori_sec_arr[] = $entry->orig_id;
                }
            }
            
            $this->form_validation->set_rules('valid_product', 'Product', 'callback_checkValidProduct');
        }
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('customer/customer_templatecreate',$data);
        } else {
            // create decipher template
            $templ_data = array(
                'TemplateName' => $this->input->post('description'),
                'status' => $this->input->post('status'),
                'owner' => $this->customer_id,
                'visibility' =>0,
                'id' => null
            );
            $template_id =  $this->templates_model->set_template($templ_data);

            // Create customer template
            $templ_data = array(
                'custid' => $this->customer_id,
                'id' => $template_id,
                'TemplateName' => $this->input->post('description'),
                'productID' => $this->input->post('product'),
                'status' => $this->input->post('status')
            );
            $customer_template_id =  $this->customertemplates_model->set_customertemplate($templ_data);

            $section_id_array = array();
            foreach($nvps as $entry){
             array_push($section_id_array, $entry->section);

            }
            // This for loop contains code to copy sections and related question for customer
            //
            // If customer using decipher section, first create the same section for customer at customerSections 
            // Copy decipher section related questions to customeQuestions
            // Use the genrated ids (customerSections, customeQuestions) to create ref at customerSectionsQuestionsXref
            // Finally, use customerSections ids and customerTemplates id to create ref at customerTemplatesSectionsXref.
//            for($i = 0; $i < sizeof($section_id_array); $i++) {
            for($i = 0; $i < sizeof($nvps); $i++) {
                if (!empty($nvps[$i]->section)) {
                    continue; 
                }

                $orig_section_id = $orig_section_id_array[$i];
                $origSection = $this->sections_model->getSectionRowDataById($orig_section_id);

                // Create customer section copied from decipher section
                $customersec_data = array(
                    'uid' => null,
                    'custid' =>  $this->customer_id,
                    'id' => $orig_section_id,
                    'description' => $origSection['description'],
                    'status' => 1,       		
                );
                $custsection_id =  $this->customersections_model->set_customersection($customersec_data);
                $original_ques_arr = $this->sectionsquestions_model->get_section_questions($orig_section_id, false);
                $insert_array = $this->get_customer_questions_data($original_ques_arr, $this->customer_id);

                // Create customer questions copied from decipher questions
                $interted_questions =  $this->customersectionquestions_model->insertCustomerQuestions($insert_array, $this->customer_id);
                $insert_array = $this->get_customer_section_xrefdata($interted_questions, $custsection_id, $original_ques_arr);
                if(count($insert_array) > 0) {
                    $this->customersectionquestions_model->insert_CustomerSectionObjReference($insert_array);
                }

                // Collecting newly created customer section to customer section and customer template xref.
                $section_id_array[$i] = $custsection_id;
            }

            $insert_array = array();
            $i=0;
//            for($i = 0; $i < sizeof($section_id_array); $i++) {
            for($i = 0; $i < sizeof($nvps); $i++) {
                if (empty($section_id_array[$i])) {
                    continue;
                }
                $values = array();
                $values["custid"] = $this->customer_id;
                $values["templateKey"] = $customer_template_id;
                $values["sectionKey"] = $section_id_array[$i]; //$nvps[$i]->section;
                $values["order"] = $i +1;
                $values["status"]= 1;
                $values['weighting']= $nvps[$i]->weight;
                $insert_array[$i] = $values;
            }
            $this->customertemplatessections_model->insert_custTemplateSecReference($insert_array);

            $data["msg"] = "Template Added";
            $this->load->view('templates/success',$data);
        }
    }

    private function get_customer_questions_data($original_ques_arr, $customerid)
    {	
        foreach($original_ques_arr as $tmpQues) {
            $question_id_array[] = $tmpQues['id'];
        }
        
        $insert_array = array();
        $i=0;
        for($i = 0; $i < sizeof($question_id_array) ; $i++) {
                $values = array();
                $question_id = $question_id_array[$i];
                $question_data = json_decode($this->questions_model->get_question($question_id_array[$i]));

                $values["custid"] = $customerid;		 		 
                $values["id"] = $question_id;
                $values["des"] = $question_data[0]->des;
                $values["type"] =$question_data[0]->type;
                $values["weight"]= $question_data[0]->weight;
                $values["content"] = $question_data[0]->content;
                $values["outputType"] = $question_data[0]->outputType;
                $status = $question_data[0]->status;
                $values["status"] = $status;
                $attributes =  $question_data[0]->attributes;
                $values["attributes"] = $attributes;
                $values["parameters"] = $question_data[0]->parameters;
                
                $insert_array[$i] = $values;
        }

        return $insert_array;
    }

    private function get_customer_section_xrefdata($new_questions, $customer_sectionid, $original_ques_arr)
    {
        foreach($original_ques_arr as $eachOriginalQues) {
            $originalQuesIdOrdrMap[$eachOriginalQues['id']] = $eachOriginalQues['order'];
        }

        $new_questions = json_decode($new_questions);

        $insert_array = array();
        $i=0;
        foreach ($new_questions as $question) {
            $values = array();
            $values["custid"] = $this->customer_id	;
            $values["objID"] = $question->uid;
            $values["secID"] = $customer_sectionid;
            $values["order"] =   $originalQuesIdOrdrMap[$question->id]; // Order should be maintaned as per user inserted 
            $values["status"]= 1;
            $insert_array[$i] = $values;
            $i++;
        }

        return $insert_array;
    }

public function getSectionsContent()
{
	
	$sections_ref = array();
	
	//$sections =  json_decode($this->customersections_model->get_customersections($this->customer_id));
        $sections =  json_decode($this->customersections_model->get_customersections_having_questions($this->customer_id));
	$sec_indx = 0;
	foreach ($sections as $section)
	{
	
		//$questions = json_decode($this->customersectionquestions_model->get_customersection_questions($section->uid,$this->customer_id));
		//if(count($questions) > 0)
		//{
			$qindx= 0;
//			$question_array = array();
			$sections_ref[$sec_indx]["id"] = $section->uid;
			$sections_ref[$sec_indx]["orig_id"] = $section->id;
			$sections_ref[$sec_indx]["description"] = $section->description;
			$sections_ref[$sec_indx]["status"] = $section->status;
			
                    /*foreach ($questions as $question)
                    {
                            $question_content = $question->content; // json_decode($this->questions_model->get_question($question->objID));


                            $question_array[$qindx] = $question_content;
                            $qindx++;
                    }
                    $sections_ref[$sec_indx]["questions"] = $question_array;*/
                    $sec_indx++;
		//}
	}
        
        $decipherSections =  json_decode($this->sections_model->get_only_decipher_sections());
        foreach ($decipherSections as $dSection)
	{
            //$questions = json_decode($this->customersectionquestions_model->get_customersection_questions($section->uid,$this->customer_id));
            //if(count($questions) > 0)
            //{
                //$qindx= 0;
                $sections_ref[$sec_indx]["id"] = '';
                $sections_ref[$sec_indx]["orig_id"] = $dSection->d_id;
                $sections_ref[$sec_indx]["description"] = $dSection->d_description;
                $sections_ref[$sec_indx]["status"] = $dSection->d_status;
                $sec_indx++;
            //}
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
                $this->form_validation->set_rules('product', 'Product', 'required');
                
                if (!empty($this->input->post())) {
            
                    $this->selected_product = $this->input->post('product');
                    
                    $section_ids = $this->input->post('orig_secid_list');
                    $nvps = json_decode($section_ids);
                    $section_id_array = array();
                    foreach($nvps as $entry){
                        array_push($section_id_array, $entry->section);
                        if (!empty($entry->section)) {
                            $this->customer_sec_arr[] = $entry->section;
                        } else {
                            $this->ori_sec_arr[] = $entry->orig_id;
                        }
                    }

                    $this->form_validation->set_rules('valid_product', 'Product', 'callback_checkValidProduct');
                }
                
		if ($this->form_validation->run() === FALSE)
		{
		
		  $sections_ref = array();
		  $remaining_sections = array();
		  $customer_id = $this->customer_id;
		  
		  $sections_per_template =	json_decode($this->customertemplatessections_model->get_sectionsPerTemplate($this->customer_id, $template_id));
		  
		  $sec_indx = 0;
		  foreach($sections_per_template as $temp_section)
		  {		  	
		  	
		  	$section_json = json_decode($this->customersections_model->get_sectionDataByUId($temp_section->sectionKey));
		  	$questions = json_decode($this->customersectionquestions_model->get_customersection_questions($temp_section->sectionKey,$customer_id));
		  	
		  	
		  	
		  	$section = $section_json[0];
		  	if(count($questions) > 0)
		  	{
		  		$qindx= 0;
		  		$question_array = array();
		  		$sections_ref[$sec_indx]["id"] = $section->uid;
		  		$sections_ref[$sec_indx]["orig_id"] = $section->id;
		  		$sections_ref[$sec_indx]["description"] = $section->description;
		  		$sections_ref[$sec_indx]["status"] = $section->status;
		  		$sections_ref[$sec_indx]["weight"] = $temp_section->weighting;
		  			
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
		  
		  
		  
		  $remaining_system_sections =	json_decode($this->customertemplatessections_model->get_section_not_in_template($template_id));
		  
		  $sec_indx = 0;
		  foreach($remaining_system_sections as $section)
		  {
		  	//$questions = json_decode($this->sectionsquestions_model->get_section_questions($section->id));		
		  	$questions = json_decode($this->customersectionquestions_model->get_customersection_questions($section->uid,$customer_id));
		  	
		  	if(count($questions) > 0)
		  	{
		  		$qindx= 0;
		  		$question_array = array();
		  		$remaining_sections[$sec_indx]["id"] = $section->uid;
		  		$remaining_sections[$sec_indx]["orig_id"] = $section->id;
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
		  $template_data = json_decode($this->customertemplates_model->get_customertemplate_byid($template_id));
		  
		  $data["templatename"]= $template_data[0]->TemplateName;
		  $data["status"] = $template_data[0]->status;
                  $data["product_id"] = $template_data[0]->productID;
		  $data["template_id"] =$template_id;
                  
                  $data['products'] = json_decode($this->product_model->get_products());
		  
		  $this->load->view('customer/customer_templateedit',$data);
		}
		
		else 
		{
			
			
			
			
			
			$templ_data = array(
					'TemplateName' => $this->input->post('description'),
                                        'productID' => $this->input->post('product'),
					'status' => $this->input->post('status'),					
			);
			 $this->customertemplates_model->update_customertemplate($templ_data,$template_id);
			
			unset($templ_data['productID']); 
			 
			 
			 $template_data = json_decode($this->customertemplates_model->get_customertemplate_byid($template_id));
			 
			 $orig_template_id = $template_data[0]->id;
			 
			 $this->templates_model->update_template($templ_data,$orig_template_id);
			 
			 
			 
			 //$orig_sections_ids = $this->input->post('orig_secid_list');
			 
			 //echo $orig_sections_ids;
			  
			/* $orig_sections_ids = substr($orig_sections_ids, 0, strlen($orig_sections_ids)-1 );
			  
			  
			 $section_id_array = explode(",", $orig_sections_ids);
			  
			 $insert_array = array();
			 $i=0;
			  
			 for($i=0; $i< sizeof($section_id_array) ;$i++  )
			 {
			 	$values = array();
			 	$values["templateKey"] = $orig_template_id;
			 	$values["sectionKey"] = $section_id_array[$i];
			 	$values["order"] = $i +1;
			 	$values["status"]= 1;
			 	
			 	$insert_array[$i] = $values;
			 }
			  
			 $this->templatessections_model->updateTemplateSections($orig_template_id, $insert_array);*/
			 
			 
			 
//			 $sections_ids = $this->input->post('secid_list');
			 
			// echo "<br/>".$sections_ids;
			 	
//			 $sections_ids = substr($sections_ids, 0, strlen($sections_ids)-1 );
			 	
			 	
//			 $section_id_array = explode(",", $sections_ids);
                         
            /*
            // Took above for product verification work
            $section_ids = $this->input->post('orig_secid_list');
            $nvps = json_decode($section_ids);
            $section_id_array = array();
            foreach($nvps as $entry){
             array_push($section_id_array, $entry->section);

            }*/
                         
                         
			 	
			 	
			 $insert_array = array();
			 $i=0;
			 	
//			 for($i=0; $i< sizeof($section_id_array) ;$i++  )
			 for($i=0; $i< sizeof($nvps) ;$i++  )
			 {
			 	$values = array();
			 	$values["templateKey"] = $template_id;
			 	$values["sectionKey"] = $nvps[$i]->section;
			 	$values["order"] = $i +1;
			 	$values["status"]= 1;
			 	$values["custid"]= $this->customer_id;
			 	$values["weighting"]= $nvps[$i]->weight;
			 	$insert_array[$i] = $values;
			 }
			 	
			 $this->customertemplatessections_model->updateTemplateSections($template_id, $insert_array);
			 	
			 
			 
			 
			 
			 $data["msg"] = "Template Updated";
			 $this->load->view('templates/success',$data);
			
		}
		
		
	}
        
        public function checkValidProduct()
        {
            $ques_handlers_cust = $this->customersectionquestions_model->get_customersection_handlers_by_secid($this->customer_sec_arr);
            $ques_handlers_orig = $this->sectionsquestions_model->get_section_handlers_by_secid($this->ori_sec_arr);
            $available_handlers = array_unique(array_merge($ques_handlers_cust, $ques_handlers_orig));
            
            $this->load->model('product_model');         
            $product_handlers = $this->product_model->getProductHandlers($this->selected_product);
            
            $arr_diff = array_diff($product_handlers, $available_handlers);
            if (empty($arr_diff)) {
                return true;
            } 
            
            $this->form_validation->set_message('checkValidProduct', 'Invalid %s');
            return false;
        }
	

}
