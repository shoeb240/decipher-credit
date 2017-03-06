<?php

class DesignTemplates extends Base {

	
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
            
                $data['templates'] =  $this->customertemplates_model->get_customertemplates($this->customer_id);
                $this->load->view('design/design_templateview.php', $data);
        }
        public function credentials(){
            
            
        }


    public function create() 
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title'] = 'Create a Template item';

        $data['customersectiondata'] = $this->getCustomerSectionsContent();
        $data['deciphersectiondata'] = $this->getDecipherSectionsContent();
        $data['questions'] = $this->questions_model->get_questions();
        $data['products'] = json_decode($this->product_model->get_products());

        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('secid_list', 'secid_list', 'required');
        $this->form_validation->set_rules('product', 'Product', 'required');
        
        if ($this->input->post()) {
            
            $this->selected_product = $this->input->post('product');
                    
            // Decipher section ids of used sections
            $orig_sec_ids = $this->input->post('orig_secid_list');
            $orig_sec_ids = substr($orig_sec_ids, 0, strlen($orig_sec_ids)-1 );
            $orig_section_id_array = explode(",", $orig_sec_ids);
            
            // Customer section ids of used section, for a selected decipher section this id is empty
            $sections_ids = $this->input->post('secid_list');
            $sections_ids = substr($sections_ids, 0, strlen($sections_ids)-1 );
            $section_id_array = explode(",", $sections_ids);

            for($i = 0; $i < sizeof($section_id_array); $i++) {
                if (!empty($section_id_array[$i])) {
                    $this->customer_sec_arr[] = $section_id_array[$i];
                } else {
                    $this->ori_sec_arr[] = $orig_section_id_array[$i];
                }
            }

            $this->form_validation->set_rules('valid_product', 'Product', 'callback_checkValidProduct');
        }
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('design/design_templatecreate',$data);
        } else {
            $modified_questions_arr = json_decode($_POST['attributes_obj'], true);
            
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

            // Update question content modified at attribute panel for Selected Customer Sections
            if (!empty($modified_questions_arr)) {
                $update_data = array();
                foreach($modified_questions_arr as $qindex => $att_sec) {
                    if (strpos($qindex, 'cust') !== false) {
                        $question = array();
                        $question['uid'] = substr($qindex, 5);
                        // Replacing labels in question content
                        $modified_content = urldecode($att_sec);
                        $question_original = json_decode($this->customersectionquestions_model->get_customerquestion($question['uid']));
                        preg_match_all("/(<label.*?>.*?<\/label>)/", $question_original->{'content'}, $original_matches);
                        preg_match_all("/(<label.*?>.*?<\/label>)/", $modified_content, $modified_matches);
                        $question['content'] = str_replace($original_matches[0], $modified_matches[0], $question_original->{'content'});
                        
                        $update_data[] = $question;
                    }
                }
                $this->customersectionquestions_model->updateBatchCustomerQuestion($update_data);
            }
            
            // Selected Decipher Sections: This for loop contains code to copy sections and related question for customer, when customer selects 
            // decipher sections to create template
            //
            // If customer using decipher section, first create the same section for customer at customerSections 
            // Copy decipher section related questions to customeQuestions
            // Use the genrated ids (customerSections, customeQuestions) to create ref at customerSectionsQuestionsXref
            // Finally, use customerSections ids and customerTemplates id to create ref at customerTemplatesSectionsXref.
            for($i = 0; $i < sizeof($section_id_array); $i++) {
                if (!empty($section_id_array[$i])) { // selected customer sections are omitted for the above loop
                    continue; 
                }
                
                $orig_section_id = $orig_section_id_array[$i];
                $origSection = $this->sections_model->getSectionRowDataById($orig_section_id);
                
                $original_ques_arr = $this->sectionsquestions_model->get_section_questions($orig_section_id, false);
                if (empty($original_ques_arr)) {
                    continue;
                }

                // Create customer section copied from decipher section
                $cust_sec_data = array(
                    'uid' => null,
                    'custid' =>  $this->customer_id,
                    'id' => $orig_section_id,
                    'description' => $origSection['description'],
                    'status' => 1,       		
                );
                $cust_sec_id =  $this->customersections_model->set_customersection($cust_sec_data);

                // Create customer questions copied from decipher questions 
                $insert_array = $this->prepare_customer_questions_batch_deci($original_ques_arr, $this->customer_id);
                $interted_questions =  $this->customersectionquestions_model->insertCustomerQuestions($insert_array, $this->customer_id, $modified_questions_arr, 'deci');

                // wgt work. Create customer section and questions xref
                $insert_array = $this->prepare_customer_sec_ques_xref_batch_data($interted_questions, $cust_sec_id, $original_ques_arr);
                $this->customersectionquestions_model->insert_CustomerSectionObjReference($insert_array);

                // Collecting newly created customer section to customer section and customer template xref.
                $section_id_array[$i] = $cust_sec_id;
            }

            // Independent Questions: Create customerQuestions copied from questions
            // Create section and customerSections for each group of independent questions at the template
            // Create xref for the section and questions at customerSectionsQuestionsXref
            // Use customerSections id for customerTemplateSectionXref

            $ques_sec_map = array();
            $ques_block_ids = $this->input->post('ques_block_ids'); // contains only independent ques ids with comma
            $ques_wgt_ids = $this->input->post('ques_wgt_ids');

            if (!empty($ques_block_ids)) {
                $ques_block_sec_name = $this->input->post('ques_block_sec_name');
                foreach($ques_block_ids as $k => $id_list) {
                    $id_list = substr($id_list, 0, strlen($id_list)-1 );
                    $que_id_arr[$k] = explode(',', $id_list);
                    $wgt_list = substr($ques_wgt_ids[$k], 0, strlen($ques_wgt_ids[$k])-1 );
                    $que_wgt_arr[$k] = explode(',', $wgt_list);
                }

                $wgt_ques_map = array();
                foreach($que_id_arr as $l => $each_ques_grp) {
                    // Create customer questions, each group of independent questions on template, (only questions which does not exist at customerQuestion) 
                    // copied from decipher questions
                    $ques_batch_data = $this->prepare_customer_questions_batch_indp($each_ques_grp, $this->customer_id);
                    $interted_cust_ques =  $this->customersectionquestions_model->insertCustomerQuestions($ques_batch_data, $this->customer_id, $modified_questions_arr, 'indp');

                    // Creating section for above questions
                    $sec_data = array(
                        'description' => $ques_block_sec_name[$l],
                        'status' => 1,
                        'id' => null
                    );
                    $orig_section_id =  $this->sections_model->set_section($sec_data);
                    
                    // Create xref for newly created section and related decipher question
                    $sec_ques_xref_batch_data = $this->prepare_sec_ques_xref_data($each_ques_grp, $orig_section_id, $que_wgt_arr[$l]);
                    $this->sectionsquestions_model->insert_SectionObjReference($sec_ques_xref_batch_data);

                    // Create customer section copied from decipher section
                    $cust_sec_data = array(
                        'uid' => null,
                        'custid' =>  $this->customer_id,
                        'id' => $orig_section_id,
                        'description' => $ques_block_sec_name[$l],
                        'status' => 1,       
                    );
                    $cust_sec_id =  $this->customersections_model->set_customersection($cust_sec_data);

                    foreach($each_ques_grp as $m => $each_ques) {
                        $wgt_ques_map[$cust_sec_id][$each_ques] = $que_wgt_arr[$l][$m];
                    }
                    
                    // // wgt work(DONE) Create xref data for newly created customer section and newly created customer questions
                    $original_ques_arr = $this->sectionsquestions_model->get_section_questions($orig_section_id, false);
                    $customer_sec_ques_xref_batch_data = $this->prepare_customer_sec_ques_xref_batch_data($interted_cust_ques, $cust_sec_id, $original_ques_arr, $wgt_ques_map);
                    if(count($customer_sec_ques_xref_batch_data) > 0) {
                        $this->customersectionquestions_model->insert_CustomerSectionObjReference($customer_sec_ques_xref_batch_data);
                    }

                    // Collecting newly created customer section to customer section and customer template xref.
                    $a = implode('~', $each_ques_grp) . '~';
                    $ques_sec_map["{$a}"] = $cust_sec_id;
                }
            }
            
            $sec_wgt_arr = explode(',', $_POST['sec_wgt_list']);
            $insert_array = array();
            $already_taken_sec = array();
            for($i = 0; $i < sizeof($section_id_array); $i++) {
                if (empty($section_id_array[$i])) {
                    continue;
                }
                if (strpos($section_id_array[$i], '~') !== false) {
                    $sec_id = isset($ques_sec_map[$section_id_array[$i]]) ? $ques_sec_map[$section_id_array[$i]] : '';
                } else {
                    $sec_id = $section_id_array[$i];
                }             
                if (empty($sec_id) || in_array($sec_id, $already_taken_sec)) {
                    continue;
                }
                $already_taken_sec[] = $sec_id;
                
                $values = array();
                $values["custid"] = $this->customer_id;
                $values["templateKey"] = $customer_template_id;
                $values["sectionKey"] = $sec_id;
                $values["order"] = $i +1;
                $values["status"]= 1;
                $values["weighting"]= $sec_wgt_arr[$i];
                $insert_array[$i] = $values;
            }
            // wgt work(DONE)
            $this->customertemplatessections_model->insert_custTemplateSecReference($insert_array);

            $data["msg"] = "Template Added";
            $this->load->view('templates/success',$data);  
        }
    }

    private function prepare_sec_ques_xref_data($ori_ques_id_array, $section_id, $each_que_wgt_arr)
    {
            $insert_array = array();
            $i=0;
            for($i=0; $i< sizeof($ori_ques_id_array) ;$i++ )
            {
                    $values = array();		
                    $values["objID"] = $ori_ques_id_array[$i];
                    $values["secID"] = $section_id;
                    $values["order"] = $i +1;
                    $values["status"] = 1;
                    //$values["weighting"] = $each_que_wgt_arr[$i]; // weighting is not needed for decipher silo
                    $insert_array[$i] = $values;
            }

            return $insert_array;
    }

    private function prepare_customer_questions_batch_deci($original_ques_arr, $customerid)
    {	
        $question_id_array = array();
        foreach($original_ques_arr as $tmpQues) {
            $question_id_array[] = $tmpQues['id'];
        }
        
        $insert_array = array();
        $i=0;
        $ques_count = sizeof($question_id_array);
        for($i = 0; $i <  $ques_count; $i++) {
                $values = array();
                $question_id = $question_id_array[$i];
                $question_data = json_decode($this->questions_model->get_question($question_id_array[$i]));

                $values["custid"] = $customerid;		 		 
                $values["id"] = $question_id;
                $values["des"] = $question_data[0]->des;
                $values["type"] =$question_data[0]->type;
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
    
    private function prepare_customer_questions_batch_indp($question_id_array, $customerid)
    {	
        $insert_array = array();
        $i=0;
        for($i = 0; $i < sizeof($question_id_array) ; $i++) {
            $values = array();
            $question_id = $question_id_array[$i];
            $question_data = json_decode($this->questions_model->get_question($question_id_array[$i])); // Need to take this query outside loop and use join query
            if (empty($question_data)) {
                continue;
            }
            
            $values["custid"] = $customerid;		 		 
            $values["id"] = $question_id;
            $values["des"] = $question_data[0]->des;
            $values["type"] =$question_data[0]->type;
            $values["content"] = $question_data[0]->content;
            $values["outputType"] = $question_data[0]->outputType;
            $values["status"] = $question_data[0]->status;
            $values["attributes"] = $question_data[0]->attributes;
            $values["parameters"] = $question_data[0]->parameters;

            $insert_array[$i] = $values;
        }

        return $insert_array;
    }

    private function prepare_customer_sec_ques_xref_batch_data($new_questions, $customer_sec_id, $original_ques_arr, $wgt_ques_map = array())
    {
        if (empty($new_questions)) {
            return false;    
        }
        
        foreach($original_ques_arr as $eachOriginalQues) {
            $originalQuesIdOrdrMap[$eachOriginalQues['id']] = $eachOriginalQues['order'];
        }

        $new_questions = json_decode($new_questions);

        $insert_array = array();
        $i=0;
        if (empty($wgt_ques_map)) {
            $ques_count = sizeof($new_questions);
            $each_weight = round((100 / $ques_count), 2);
        }
        foreach ($new_questions as $k => $question) {
            if (!empty($wgt_ques_map)) {
                $each_weight = $wgt_ques_map[$customer_sec_id][$question->id];
            }
            $values = array();
            $values["custid"] = $this->customer_id;
            $values["secID"] = $customer_sec_id;
            $values["objID"] = $question->uid;
            $values["order"] =   $originalQuesIdOrdrMap[$question->id]; // Order should be maintaned as per user inserted 
            $values["status"] = 1;
            $values["weighting"] = $each_weight;
            $insert_array[$i] = $values;
            $i++;
        }

        return $insert_array;
    }

    public function getCustomerSectionsContent()
    {
        $sections_ref = array();

        $sections =  json_decode($this->customersections_model->get_customersections_having_questions($this->customer_id));
        $sec_indx = 0;
        foreach ($sections as $section)
        {
            $qindx= 0;
            $sections_ref[$sec_indx]["id"] = $section->uid;
            $sections_ref[$sec_indx]["orig_id"] = $section->id;
            $sections_ref[$sec_indx]["description"] = $section->description;
            $sections_ref[$sec_indx]["status"] = $section->status;
            $sec_indx++;
        }

        return $sections_ref;
    }

    public function getDecipherSectionsContent()
    {
            $sections_ref = array();

            $sec_indx = 0;
            $decipherSections =  json_decode($this->sections_model->get_only_decipher_sections_having_questions());
            foreach ($decipherSections as $dSection)
            {
                $sections_ref[$sec_indx]["id"] = '';
                $sections_ref[$sec_indx]["orig_id"] = $dSection->d_id;
                $sections_ref[$sec_indx]["description"] = $dSection->d_description;
                $sections_ref[$sec_indx]["status"] = $dSection->d_status;
                $sec_indx++;
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
        
        $data['title'] = 'Create a Template item';

        $data['customersectiondata'] = $this->getCustomerSectionsContent();
        $data['deciphersectiondata'] = $this->getDecipherSectionsContent();
        $data['questions'] = $this->questions_model->get_questions();
        $data['products'] = json_decode($this->product_model->get_products());

        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('secid_list', 'secid_list', 'required');
        $this->form_validation->set_rules('product', 'Product', 'required');
        
        if ($this->input->post()) {
            
            $this->selected_product = $this->input->post('product');
                    
            // Decipher section ids of used sections
            $orig_sec_ids = $this->input->post('orig_secid_list');
            $orig_sec_ids = substr($orig_sec_ids, 0, strlen($orig_sec_ids)-1 );
            $orig_section_id_array = explode(",", $orig_sec_ids);
            
            // Customer section ids of used section, for a selected decipher section this id is empty
            $sections_ids = $this->input->post('secid_list');
            $sections_ids = substr($sections_ids, 0, strlen($sections_ids)-1 );
            $section_id_array = explode(",", $sections_ids);

            for($i = 0; $i < sizeof($section_id_array); $i++) {
                if (!empty($section_id_array[$i])) {
                    $this->customer_sec_arr[] = $section_id_array[$i];
                } else {
                    $this->ori_sec_arr[] = $orig_section_id_array[$i];
                }
            }

            $this->form_validation->set_rules('valid_product', 'Product', 'callback_checkValidProduct');
        }
        
        if ($this->form_validation->run() === FALSE)
        {

            $sections_ref = array();
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
                    $sections_ref[$sec_indx]["questions"] = $questions;
                    $sec_indx++;
                }

            }

            $data["templ_sectiondata"] =  $sections_ref;
            $customer_template = json_decode($this->customertemplates_model->get_customertemplate_byid($template_id));

            $data["templatename"]= $customer_template[0]->TemplateName;
            $data["status"] = $customer_template[0]->status;
            $data["product_id"] = $customer_template[0]->productID;
            $data["template_id"] =$template_id;
            
            $data['customersectiondata'] = $this->getCustomerSectionsContentEdit();
            $data['deciphersectiondata'] = $this->getDecipherSectionsContentEdit();
            $data['questions'] = $this->questions_model->get_questions();
            $data['products'] = json_decode($this->product_model->get_products());

            $this->load->view('design/design_template_edit',$data);
        }
        else 
        {

            $modified_questions_arr = json_decode($_POST['attributes_obj'], true);
            
            $templ_data = array(
                'TemplateName' => $this->input->post('description'),
                'productID' => $this->input->post('product'),
                'status' => $this->input->post('status'),					
            );
            $this->customertemplates_model->update_customertemplate($templ_data, $template_id);

            unset($templ_data['productID']); 

            $orig_template = json_decode($this->customertemplates_model->get_customertemplate_byid($template_id));
            $orig_template_id = $orig_template[0]->id;
            $this->templates_model->update_template($templ_data, $orig_template_id);
            

            // Update question content modified at attribute panel for Selected Customer Sections
            if (!empty($modified_questions_arr)) {
                $update_data = array();
                foreach($modified_questions_arr as $qindex => $att_sec) {
                    if (strpos($qindex, 'cust') !== false) {
                        $question = array();
                        $question['uid'] = substr($qindex, 5);
                        // Replacing labels in question content
                        $modified_content = urldecode($att_sec);
                        $question_original = json_decode($this->customersectionquestions_model->get_customerquestion($question['uid']));
                        preg_match_all("/(<label.*?>.*?<\/label>)/", $question_original->{'content'}, $original_matches);
                        preg_match_all("/(<label.*?>.*?<\/label>)/", $modified_content, $modified_matches);
                        $question['content'] = str_replace($original_matches[0], $modified_matches[0], $question_original->{'content'});
                        
                        $update_data[] = $question;
                    }
                }
                $this->customersectionquestions_model->updateBatchCustomerQuestion($update_data);
            }
            
            // Selected Decipher Sections: This for loop contains code to copy sections and related question for customer, when customer selects 
            // decipher sections to create template
            //
            // If customer using decipher section, first create the same section for customer at customerSections 
            // Copy decipher section related questions to customeQuestions
            // Use the genrated ids (customerSections, customeQuestions) to create ref at customerSectionsQuestionsXref
            // Finally, use customerSections ids and customerTemplates id to create ref at customerTemplatesSectionsXref.
            for($i = 0; $i < sizeof($section_id_array); $i++) {
                if (!empty($section_id_array[$i])) { // selected customer sections are omitted for the above loop
                    continue; 
                }
                
                $orig_section_id = $orig_section_id_array[$i];
                $origSection = $this->sections_model->getSectionRowDataById($orig_section_id);
                
                $original_ques_arr = $this->sectionsquestions_model->get_section_questions($orig_section_id, false);
                if (empty($original_ques_arr)) {
                    continue;
                }

                // Create customer section copied from decipher section
                $cust_sec_data = array(
                    'uid' => null,
                    'custid' =>  $this->customer_id,
                    'id' => $orig_section_id,
                    'description' => $origSection['description'],
                    'status' => 1,       		
                );
                $cust_sec_id =  $this->customersections_model->set_customersection($cust_sec_data);

                // Create customer questions copied from decipher questions 
                $insert_array = $this->prepare_customer_questions_batch_deci($original_ques_arr, $this->customer_id);
                $interted_questions =  $this->customersectionquestions_model->insertCustomerQuestions($insert_array, $this->customer_id, $modified_questions_arr, 'deci');

                // wgt work. Create customer section and questions xref
                $insert_array = $this->prepare_customer_sec_ques_xref_batch_data($interted_questions, $cust_sec_id, $original_ques_arr);
                $this->customersectionquestions_model->insert_CustomerSectionObjReference($insert_array);

                // Collecting newly created customer section to customer section and customer template xref.
                $section_id_array[$i] = $cust_sec_id;
            }

            // Independent Questions: Create customerQuestions copied from questions
            // Create section and customerSections for each group of independent questions at the template
            // Create xref for the section and questions at customerSectionsQuestionsXref
            // Use customerSections id for customerTemplateSectionXref

            $ques_sec_map = array();
            $ques_block_ids = $this->input->post('ques_block_ids'); // contains only independent ques ids with comma
            $ques_wgt_ids = $this->input->post('ques_wgt_ids');

            if (!empty($ques_block_ids)) {
                $ques_block_sec_name = $this->input->post('ques_block_sec_name');
                foreach($ques_block_ids as $k => $id_list) {
                    $id_list = substr($id_list, 0, strlen($id_list)-1 );
                    $que_id_arr[$k] = explode(',', $id_list);
                    $wgt_list = substr($ques_wgt_ids[$k], 0, strlen($ques_wgt_ids[$k])-1 );
                    $que_wgt_arr[$k] = explode(',', $wgt_list);
                }

                $wgt_ques_map = array();
                foreach($que_id_arr as $l => $each_ques_grp) {
                    // Create customer questions, each group of independent questions on template, (only questions which does not exist at customerQuestion) 
                    // copied from decipher questions
                    $ques_batch_data = $this->prepare_customer_questions_batch_indp($each_ques_grp, $this->customer_id);
                    $interted_cust_ques =  $this->customersectionquestions_model->insertCustomerQuestions($ques_batch_data, $this->customer_id, $modified_questions_arr, 'indp');

                    // Creating section for above questions
                    $sec_data = array(
                        'description' => $ques_block_sec_name[$l],
                        'status' => 1,
                        'id' => null
                    );
                    $orig_section_id =  $this->sections_model->set_section($sec_data);
                    
                    // Create xref for newly created section and related decipher question
                    $sec_ques_xref_batch_data = $this->prepare_sec_ques_xref_data($each_ques_grp, $orig_section_id, $que_wgt_arr[$l]);
                    $this->sectionsquestions_model->insert_SectionObjReference($sec_ques_xref_batch_data);

                    // Create customer section copied from decipher section
                    $cust_sec_data = array(
                        'uid' => null,
                        'custid' =>  $this->customer_id,
                        'id' => $orig_section_id,
                        'description' => $ques_block_sec_name[$l],
                        'status' => 1,       
                    );
                    $cust_sec_id =  $this->customersections_model->set_customersection($cust_sec_data);

                    foreach($each_ques_grp as $m => $each_ques) {
                        $wgt_ques_map[$cust_sec_id][$each_ques] = $que_wgt_arr[$l][$m];
                    }
                    
                    // // wgt work(DONE) Create xref data for newly created customer section and newly created customer questions
                    $original_ques_arr = $this->sectionsquestions_model->get_section_questions($orig_section_id, false);
                    $customer_sec_ques_xref_batch_data = $this->prepare_customer_sec_ques_xref_batch_data($interted_cust_ques, $cust_sec_id, $original_ques_arr, $wgt_ques_map);
                    if(count($customer_sec_ques_xref_batch_data) > 0) {
                        $this->customersectionquestions_model->insert_CustomerSectionObjReference($customer_sec_ques_xref_batch_data);
                    }

                    // Collecting newly created customer section to customer section and customer template xref.
                    $a = implode('~', $each_ques_grp) . '~';
                    $ques_sec_map["{$a}"] = $cust_sec_id;
                }
            }
            
            $sec_wgt_arr = explode(',', $_POST['sec_wgt_list']);
            $insert_array = array();
            $already_taken_sec = array();
            for($i = 0; $i < sizeof($section_id_array); $i++) {
                if (empty($section_id_array[$i])) {
                    continue;
                }
                if (strpos($section_id_array[$i], '~') !== false) {
                    $sec_id = isset($ques_sec_map[$section_id_array[$i]]) ? $ques_sec_map[$section_id_array[$i]] : '';
                } else {
                    $sec_id = $section_id_array[$i];
                }             
                if (empty($sec_id) || in_array($sec_id, $already_taken_sec)) {
                    continue;
                }
                $already_taken_sec[] = $sec_id;
                
                $values = array();
                $values["custid"] = $this->customer_id;
                $values["templateKey"] = $template_id;
                $values["sectionKey"] = $sec_id;
                $values["order"] = $i +1;
                $values["status"]= 1;
                $values["weighting"]= $sec_wgt_arr[$i];
                $insert_array[$i] = $values;
            }
            $this->customertemplatessections_model->updateTemplateSections($template_id, $insert_array);

            $data["msg"] = "Template Added";
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
        
    public function getCustomerSectionsContentEdit()
    {
        $sections_ref = array();

        $sections =  json_decode($this->customersections_model->get_customersections_having_questions_except($this->customer_id, 12));
        $sec_indx = 0;
        foreach ($sections as $section)
        {
            $qindx= 0;
            $sections_ref[$sec_indx]["id"] = $section->uid;
            $sections_ref[$sec_indx]["orig_id"] = $section->id;
            $sections_ref[$sec_indx]["description"] = $section->description;
            $sections_ref[$sec_indx]["status"] = $section->status;
            $sec_indx++;
        }

        return $sections_ref;
    }

    public function getDecipherSectionsContentEdit()
    {
            $sections_ref = array();

            $sec_indx = 0;
            $decipherSections =  json_decode($this->sections_model->get_only_decipher_sections_having_questions());
            foreach ($decipherSections as $dSection)
            {
                $sections_ref[$sec_indx]["id"] = '';
                $sections_ref[$sec_indx]["orig_id"] = $dSection->d_id;
                $sections_ref[$sec_indx]["description"] = $dSection->d_description;
                $sections_ref[$sec_indx]["status"] = $dSection->d_status;
                $sec_indx++;
            }
            return $sections_ref;
    }
	

}
