<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Template_ajax extends CI_Controller {
	
	
	public function __construct()
	{
		parent::__construct();		
		
		$this->load->model('ion_auth_model');
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login');
		}
                $this->load->model('templates_model');
		$this->load->model('templatessections_model');
		$this->load->model('sectionsquestions_model');
		$this->load->model('sections_model');
		$this->load->model('questions_model');			
		
		
		$this->load->model('customer_model');
		
		$this->load->model('customersectionquestions_model');
		$this->load->model('customertemplatessections_model');
		$this->load->model('customertemplates_model');
		$this->load->model('customersections_model');
		

		
	}
	
	public function GetTemplateContent()
	{
		if(isset($_POST['template_id']))
		{
			$templateid = $_POST['template_id'];
		    $sections =	 json_decode($this->templatessections_model->get_sectionsPerTemplate($templateid));
		   
		    
		   $all_questions_html = "";
		   foreach ($sections as $sec)
		   {
		   	if($sec->sectionKey != '')
		   	{
		   			$sec_data = json_decode($this->sections_model->get_sectionDataById($sec->sectionKey));
		   			
		   			
		   		$questions = json_decode($this->sectionsquestions_model->get_section_questions($sec->sectionKey));
		   			
		   		if(count($questions)> 0)
		   		{
		   			$all_questions_html .= "<div name='section' class='section'><h4 class='section-title'>".$sec_data[0]->description." </h4> ";
		   			foreach ($questions as $question)
		   			{
		   				$question_content =  $question->content; //json_decode($this->questions_model->get_question($question->objID));
		   					
		   				$all_questions_html .=  "<div name='outer' class = 'outer' id = '".$question->id."' value='".$question->id."'  >" .  $question_content . "</div>";
		   			}
		   			$all_questions_html .= "</div>"; // end section
		   		}
		   
		   		//print_r($all_questions_html);
		   
		   	}
		   }
		   echo $all_questions_html;
		   }
		   		   
		   
		}	

		
		
		public function GetCustomerTemplateContent()
		{
			if(isset($_POST['template_id']))
			{
				
				$customer_id =  $this->customer_model->get_customerid_fromuserid($this->ion_auth->get_user_id());
				
				$templateid = $_POST['template_id'];
				$sections =	 json_decode($this->customertemplatessections_model->get_sectionsPerTemplate($customer_id, $templateid));
				 
		
				$all_questions_html = "";
				foreach ($sections as $sec)
				{
					if($sec->sectionKey != '')
					{
						$sec_data = json_decode($this->customersections_model->get_sectionDataByUId($sec->sectionKey));
		
		
						$questions = json_decode($this->customersectionquestions_model->get_customersection_questions($sec->sectionKey,$customer_id));
		
						if(count($questions)> 0)
						{
							$all_questions_html .= "<div name='section' class='section'><h4 class='section-title'>".$sec_data[0]->description." </h4> ";
							foreach ($questions as $question)
							{
								$question_content =  $question->content; //json_decode($this->questions_model->get_question($question->objID));
		
								$all_questions_html .=  "<div name='outer' class = 'outer' id = '".$question->id."' value='".$question->id."'  >" .  $question_content . "</div>";
							}
							$all_questions_html .= "</div>"; // end section
						}
						 
						//print_r($all_questions_html);
						 
					}
				}
				echo $all_questions_html;
			}
			 
			 
			 
		}
                
    public function DeactivateCopiedTemplate()
    {
        $customer_id = $this->input->post('customer_id');
        $template_id = $this->input->post('template_id');
        $status = $this->input->post('status');
        
        if ($customer_id < 0)
        {
            echo json_encode(array('response' => 'failed'));
            return false;
        }
        
        $this->db->where(array("id" => $template_id, "custid" => $customer_id));
        $row = $this->db->get("customerTemplates")->row_array();
        if(!empty($row))
        {
            $data = array('status' => $status);
            $this->db->where('id', $template_id);
            $this->db->where('custid', $customer_id);
            $this->db->update('customerTemplates', $data);
            
            if ($status == 0) {
                $result = "deactivated";
            } else {
                $result = "activated";
            }
        } else {
            $result = "failed";
        }
        
        echo json_encode(array('response' => $result));
    }
                
    public function CopyDecipherTemplate()
    {
        $customer_id = $this->input->post('customer_id');
        $template_id = $this->input->post('template_id');
        $template_data =  json_decode($this->templates_model->get_template_row_by_id($template_id));
        
        if ($customer_id < 0)
        {
            echo json_encode(array('response' => 'failed'));
            return false;
        }
        
        // customerTemplate
        $this->db->where(array("id" => $template_id, "custid" => $customer_id));
        $row = $this->db->get("customerTemplates")->row_array();
        if(empty($row))
        {
            $templ_data = array(
                'custid' => $customer_id,
                'id' => $template_id,
                'TemplateName' => $template_data->TemplateName,
                'status' => $template_data->status
            );
            $customer_template_id =  $this->customertemplates_model->set_customertemplate($templ_data);
            
            $result = "created";
        }
        else 
        {
            $customer_template_id = $row['uuid'];
            
            $result = "duplicate";
        }

        // customerSections
        $orig_section_id_array = json_decode($this->sections_model->get_decipher_sections_by_template_id($template_id));
        $tmp_sec_insert_array = array();
        $sectionOrder = 0;
        foreach($orig_section_id_array as $eachDecipherSection) {

            $origSection = $eachDecipherSection;
            $orig_section_id = $eachDecipherSection->id;
            $orig_section_order = $eachDecipherSection->order;

            $this->db->where(array("id" => $orig_section_id, "custid" => $customer_id));
            $row = $this->db->get("customerSections")->row_array();
            if(!empty($row))
            {
                $custsection_id = $row['uid'];
            } 
            else 
            {
                // Create customer section copied from decipher section
                $customersec_data = array(
                    'uid' => null,
                    'custid' =>  $customer_id,
                    'id' => $orig_section_id,
                    'description' => $origSection->description,
                    'status' => 1,       		
                );
                $custsection_id =  $this->customersections_model->set_customersection($customersec_data);
            }
            
            // customerQuestions
            $original_ques_arr = json_decode($this->sectionsquestions_model->get_section_questions($orig_section_id));
            $insert_array = $this->prepare_customer_questions_data($original_ques_arr, $customer_id);
            $interted_questions =  json_decode($this->customersectionquestions_model->insertCustomerQuestions2($insert_array, $customer_id));
            
            // customerSectionsQuestionsXref
            $insert_array = $this->prepare_customer_section_question_xref_data($interted_questions, $custsection_id, $customer_id);
            if(count($insert_array) > 0) {
                $this->customersectionquestions_model->insert_CustomerSectionObjReference($insert_array);
            }

            // customerTemplatesSectionsXref
            $tmp_sec_insert = $this->prepare_customer_template_section_xref_data($customer_template_id, $custsection_id, $customer_id, $orig_section_order);
            if (!empty($tmp_sec_insert))
            {
                $tmp_sec_insert_array[] = $tmp_sec_insert;
            }
        }
        
        // customerTemplatesSectionsXref
        $this->customertemplatessections_model->insert_custTemplateSecReference($tmp_sec_insert_array);
        
        echo json_encode(array('response' => $result));
        
    }
		
    private function prepare_customer_questions_data($original_ques_arr, $customerid)
    {	
	$insert_array = array();
	foreach($original_ques_arr as $question_data)
	{
            $values["custid"] = $customerid;		 		 
            $values["id"] = $question_data->id;
            $values["des"] = $question_data->des;
            $values["type"] =$question_data->type;
            $values["weight"]= $question_data->weight;
            $values["content"] = $question_data->content;
            $values["outputType"] = $question_data->outputType;
            $values["status"] = $question_data->status;
            $values["attributes"] = $question_data->attributes;
            $values["parameters"] = $question_data->parameters;
                 
            $insert_array[] = $values;
	}
	
	return $insert_array;
    }
    
    private function prepare_customer_section_question_xref_data($new_questions, $customer_sectionid, $customer_id)
    {
        if (empty($new_questions)) {
            return array();
        }
        
        $insert_array = array();
        foreach ($new_questions as $question)
        {
            $this->db->where(array("secID" => $customer_sectionid, "objID" => $question->uid, "custid" => $customer_id));
            $row = $this->db->get("customerSectionsQuestionsXref")->row_array();
            if(empty($row))
            {
                $values = array();
                $values["custid"] = $customer_id;
                $values["objID"] = $question->uid;
                $values["secID"] = $customer_sectionid;
                $values["order"] = 1;//$question->order;
                $values["status"]= 1; //$question->status;
                $insert_array[] = $values;
            }
        }

        return $insert_array;
    }
    
    public function prepare_customer_template_section_xref_data($customer_template_id, $custsection_id, $customer_id, $order)
    {
        $values = array();
        $this->db->where(array("templateKey" => $customer_template_id, "sectionKey" => $custsection_id, "custid" => $customer_id));
        $row = $this->db->get("customerTemplatesSectionsXref")->row_array();
        if(empty($row))
        {
            $values["custid"] = $customer_id;
            $values["templateKey"] = $customer_template_id;
            $values["sectionKey"] = $custsection_id;
            $values["order"] = $order;
            $values["status"]= 1;
            //$values['weighting']= 0;
        }
        
        return $values;
    }
    
    public function getTemplateJsCode()
    {
        $template_id = $this->input->post('template_id');
        
        $code = $this->customertemplates_model->get_embed_code($template_id);
        
        echo json_encode(array('response' => $code));
    }
    
}
?>